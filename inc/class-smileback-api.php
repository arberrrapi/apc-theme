<?php
/**
 * Smileback API Handler
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Smileback_API {
    
    private $base_url = 'https://app.smileback.io/api';
    
    /**
     * Get access token (with automatic caching)
     */
    public function get_access_token() {
        // Check cache first
        $token = get_transient('smileback_access_token');
        if ($token) {
            return $token;
        }
        
        // Get credentials from theme settings
        $client_id = get_option('smileback_client_id');
        $client_secret = get_option('smileback_client_secret');
        $username = get_option('smileback_username');
        $password = get_option('smileback_password');
        
        if (empty($client_id) || empty($client_secret) || empty($username) || empty($password)) {
            return new WP_Error('missing_credentials', 'Smileback API credentials not configured');
        }
        
        // Prepare authorization header
        $auth = base64_encode($client_id . ':' . $client_secret);
        
        // Request access token
        $response = wp_remote_post($this->base_url . '/token/', array(
            'timeout' => 15,
            'headers' => array(
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ),
            'body' => array(
                'grant_type' => 'password',
                'scope' => 'read read_recent',
                'username' => $username,
                'password' => $password
            )
        ));
        
        if (is_wp_error($response)) {
            error_log('Smileback API request error: ' . $response->get_error_message());
            return $response;
        }
        
        $code = wp_remote_retrieve_response_code($response);
        if ($code !== 200) {
            error_log('Smileback API auth failed with code: ' . $code);
            return new WP_Error('auth_failed', 'Authentication failed: ' . $code);
        }
        
        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (empty($body['access_token'])) {
            error_log('Smileback API: No access token in response');
            return new WP_Error('no_token', 'No access token in response');
        }
        
        // Cache token (default 10 hours, but use expires_in if provided)
        $expires = isset($body['expires_in']) ? intval($body['expires_in']) : 36000;
        set_transient('smileback_access_token', $body['access_token'], $expires);
        
        // Store refresh token separately
        if (!empty($body['refresh_token'])) {
            update_option('smileback_refresh_token', $body['refresh_token']);
        }
        
        return $body['access_token'];
    }
    
    /**
     * Get reviews from API
     */
    public function get_reviews() {
        // Check cache first (temporarily disabled for debugging)
        $cache_key = 'smileback_reviews_data';
        // $cached = get_transient($cache_key);
        // if ($cached !== false) {
        //     return $cached;
        // }
        
        // Get access token
        $token = $this->get_access_token();
        if (is_wp_error($token)) {
            error_log('Smileback API auth error: ' . $token->get_error_message());
            return array(); // Return empty array, will use fallback
        }
        
        // Get number of reviews from settings
        $limit = get_option('smileback_review_limit', 20);
        
        // Fetch reviews
        $response = wp_remote_get(
            $this->base_url . '/v3/reviews/recent/?limit=' . $limit,
            array(
                'timeout' => 15,
                'headers' => array(
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                )
            )
        );
        
        if (is_wp_error($response)) {
            error_log('Smileback API request error: ' . $response->get_error_message());
            return array();
        }
        
        $code = wp_remote_retrieve_response_code($response);
        if ($code !== 200) {
            error_log('Smileback API HTTP error: ' . $code);
            // Try to refresh token if 401
            if ($code === 401) {
                delete_transient('smileback_access_token');
            }
            return array();
        }
        
        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        // Debug: Log the actual API response structure
        error_log('Smileback API Response: ' . print_r($body, true));
        
        // Transform API data to match your existing testimonial structure
        $reviews = array();
        if (isset($body['results']) && is_array($body['results'])) {
            foreach ($body['results'] as $item) {
                // Only include 5-star reviews with comments
                if (isset($item['rating']) && $item['rating'] == 5 && !empty($item['comment'])) {
                    // Extract and format contact name (first name + first letter of last name)
                    $contact_name = 'Anonymous';
                    if (isset($item['contact']['name']) && !empty($item['contact']['name'])) {
                        $full_name = trim($item['contact']['name']);
                        $name_parts = explode(' ', $full_name);
                        
                        if (count($name_parts) >= 2) {
                            // First name + first letter of last name
                            $first_name = $name_parts[0];
                            $last_initial = strtoupper(substr($name_parts[count($name_parts) - 1], 0, 1));
                            $contact_name = $first_name . ' ' . $last_initial . '.';
                        } else {
                            // Just use the single name provided
                            $contact_name = $full_name;
                        }
                    }
                    
                    $reviews[] = array(
                        'text' => $item['comment'],
                        'author' => $contact_name,
                        'position' => '', // No company name
                        'rating' => 5
                    );
                }
            }
        }
        
        // If no 5-star reviews found, try all reviews with comments
        if (empty($reviews) && isset($body['results']) && is_array($body['results'])) {
            foreach ($body['results'] as $item) {
                if (!empty($item['comment'])) {
                    // Extract and format contact name (first name + first letter of last name)
                    $contact_name = 'Anonymous';
                    if (isset($item['contact']['name']) && !empty($item['contact']['name'])) {
                        $full_name = trim($item['contact']['name']);
                        $name_parts = explode(' ', $full_name);
                        
                        if (count($name_parts) >= 2) {
                            // First name + first letter of last name
                            $first_name = $name_parts[0];
                            $last_initial = strtoupper(substr($name_parts[count($name_parts) - 1], 0, 1));
                            $contact_name = $first_name . ' ' . $last_initial . '.';
                        } else {
                            // Just use the single name provided
                            $contact_name = $full_name;
                        }
                    }
                    
                    $reviews[] = array(
                        'text' => $item['comment'],
                        'author' => $contact_name,
                        'position' => '', // No company name
                        'rating' => isset($item['rating']) ? intval($item['rating']) : 5
                    );
                }
            }
        }
        
        // Cache for the duration specified in settings
        $cache_duration = get_option('smileback_refresh_interval', 21600);
        set_transient($cache_key, $reviews, $cache_duration);
        
        return $reviews;
    }
    
    /**
     * Test API connection
     */
    public function test_connection() {
        $token = $this->get_access_token();
        if (is_wp_error($token)) {
            return false;
        }
        
        // Try a simple API call to verify token works
        $response = wp_remote_get(
            $this->base_url . '/v3/reviews/recent/?limit=1',
            array(
                'timeout' => 10,
                'headers' => array(
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                )
            )
        );
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $code = wp_remote_retrieve_response_code($response);
        return $code === 200;
    }
    
    /**
     * Clear all cached data (for debugging)
     */
    public function clear_cache() {
        delete_transient('smileback_reviews_data');
        delete_transient('smileback_access_token');
    }
}
?>