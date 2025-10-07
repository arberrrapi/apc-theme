<?php
/**
 * Smileback API Settings Page
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add settings page to Appearance menu
add_action('admin_menu', 'smileback_add_settings_page');
function smileback_add_settings_page() {
    add_theme_page(
        'Smileback API Settings',
        'Smileback API',
        'manage_options',
        'smileback-settings',
        'smileback_render_settings_page'
    );
}

// Register settings
add_action('admin_init', 'smileback_register_settings');
function smileback_register_settings() {
    register_setting('smileback_settings', 'smileback_client_id');
    register_setting('smileback_settings', 'smileback_client_secret');
    register_setting('smileback_settings', 'smileback_username');
    register_setting('smileback_settings', 'smileback_password');
    register_setting('smileback_settings', 'smileback_review_limit', array('default' => 20));
    register_setting('smileback_settings', 'smileback_refresh_interval', array('default' => 21600)); // 6 hours
}

// Render settings page HTML
function smileback_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Smileback API Settings</h1>
        
        <?php settings_errors(); ?>
        
        <form method="post" action="options.php">
            <?php settings_fields('smileback_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th colspan="2"><h2>API Credentials</h2></th>
                </tr>
                <tr>
                    <th scope="row">Client ID</th>
                    <td>
                        <input type="text" name="smileback_client_id" 
                               value="<?php echo esc_attr(get_option('smileback_client_id')); ?>" 
                               class="regular-text" required />
                        <p class="description">Get from API Credentials page in Smileback</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Client Secret</th>
                    <td>
                        <input type="password" name="smileback_client_secret" 
                               value="<?php echo esc_attr(get_option('smileback_client_secret')); ?>" 
                               class="regular-text" required />
                    </td>
                </tr>
                <tr>
                    <th scope="row">Username (Email)</th>
                    <td>
                        <input type="email" name="smileback_username" 
                               value="<?php echo esc_attr(get_option('smileback_username')); ?>" 
                               class="regular-text" required />
                        <p class="description">Your Smileback account email</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Password</th>
                    <td>
                        <input type="password" name="smileback_password" 
                               value="<?php echo esc_attr(get_option('smileback_password')); ?>" 
                               class="regular-text" required />
                        <p class="description">Your Smileback account password</p>
                    </td>
                </tr>
                
                <tr>
                    <th colspan="2"><h2>Display Settings</h2></th>
                </tr>
                <tr>
                    <th scope="row">Number of Reviews</th>
                    <td>
                        <input type="number" name="smileback_review_limit" 
                               value="<?php echo esc_attr(get_option('smileback_review_limit', 20)); ?>" 
                               min="1" max="100" />
                        <p class="description">Maximum 100</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Refresh Interval</th>
                    <td>
                        <select name="smileback_refresh_interval">
                            <option value="3600" <?php selected(get_option('smileback_refresh_interval'), 3600); ?>>Every Hour</option>
                            <option value="21600" <?php selected(get_option('smileback_refresh_interval'), 21600); ?>>Every 6 Hours</option>
                            <option value="86400" <?php selected(get_option('smileback_refresh_interval'), 86400); ?>>Daily</option>
                        </select>
                        <p class="description">How often to refresh cached reviews</p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Save Settings'); ?>
        </form>
        
        <hr>
        
        <h2>Connection Status</h2>
        <p>
            <button type="button" class="button" id="smileback-test-connection">Test Connection</button>
            <button type="button" class="button" id="smileback-refresh-now">Refresh Reviews Now</button>
        </p>
        <div id="smileback-status"></div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#smileback-test-connection').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).text('Testing...');
                
                $.post(ajaxurl, {
                    action: 'smileback_test_connection',
                    nonce: '<?php echo wp_create_nonce('smileback_test'); ?>'
                }, function(response) {
                    $('#smileback-status').html('<p style="color: ' + 
                        (response.success ? 'green' : 'red') + '">' + 
                        response.data.message + '</p>');
                    btn.prop('disabled', false).text('Test Connection');
                });
            });
            
            $('#smileback-refresh-now').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).text('Refreshing...');
                
                $.post(ajaxurl, {
                    action: 'smileback_refresh_reviews',
                    nonce: '<?php echo wp_create_nonce('smileback_refresh'); ?>'
                }, function(response) {
                    $('#smileback-status').html('<p style="color: ' + 
                        (response.success ? 'green' : 'red') + '">' + 
                        response.data.message + '</p>');
                    btn.prop('disabled', false).text('Refresh Reviews Now');
                });
            });
        });
        </script>
    </div>
    <?php
}

// Test connection AJAX
add_action('wp_ajax_smileback_test_connection', 'smileback_ajax_test_connection');
function smileback_ajax_test_connection() {
    check_ajax_referer('smileback_test', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'Unauthorized'));
    }
    
    $api = new Smileback_API();
    $result = $api->test_connection();
    
    if ($result) {
        wp_send_json_success(array('message' => '✓ Connection successful!'));
    } else {
        wp_send_json_error(array('message' => '✗ Connection failed. Check credentials.'));
    }
}

// Manual refresh AJAX
add_action('wp_ajax_smileback_refresh_reviews', 'smileback_ajax_refresh_reviews');
function smileback_ajax_refresh_reviews() {
    check_ajax_referer('smileback_refresh', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'Unauthorized'));
    }
    
    // Clear cache
    delete_transient('smileback_reviews_data');
    delete_transient('smileback_access_token');
    
    // Fetch fresh data
    $api = new Smileback_API();
    $reviews = $api->get_reviews();
    
    if (!empty($reviews)) {
        wp_send_json_success(array('message' => '✓ Reviews refreshed! Found ' . count($reviews) . ' reviews.'));
    } else {
        wp_send_json_error(array('message' => '✗ Failed to fetch reviews.'));
    }
}
?>