<?php
/**
 * Featured Listing Block Render Function
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Featured Listing block
 */
function apc_render_featured_listing_block($attributes) {
    $title = isset($attributes['title']) ? $attributes['title'] : 'Featured Listings';
    $description = isset($attributes['description']) ? $attributes['description'] : 'Showcase our featured projects and solutions across various industries.';
    $header_image_url = isset($attributes['headerImageUrl']) ? $attributes['headerImageUrl'] : '';
    $header_image_alt = isset($attributes['headerImageAlt']) ? $attributes['headerImageAlt'] : $title;
    $listings = isset($attributes['listings']) ? $attributes['listings'] : array();

    if (empty($listings)) {
        return '';
    }

    ob_start();
    ?>
    <div class="featured-listing-wrapper">
        <div class="container">
            <div class="featured-listing-header">
                <?php if (!empty($title)) : ?>
                    <h2 class="featured-listing-title"><?php echo wp_kses_post($title); ?></h2>
                <?php endif; ?>
                <?php if (!empty($description)) : ?>
                    <p class="featured-listing-description"><?php echo wp_kses_post($description); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($header_image_url)) : ?>
                    <div class="header-image">
                        <img src="<?php echo esc_url($header_image_url); ?>" alt="<?php echo esc_attr($header_image_alt); ?>" />
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="listings-grid">
                <?php foreach ($listings as $index => $listing) : 
                    $listing_title = isset($listing['title']) ? sanitize_text_field($listing['title']) : '';
                    $listing_description = isset($listing['description']) ? $listing['description'] : '';
                    $button_text = isset($listing['buttonText']) ? sanitize_text_field($listing['buttonText']) : 'Learn More';
                    $button_link = isset($listing['buttonLink']) ? esc_url($listing['buttonLink']) : '#';
                    $icon_class = isset($listing['iconClass']) ? sanitize_text_field($listing['iconClass']) : '';
                    
                    // Allow specific HTML tags for rich content
                    $allowed_html = array(
                        'p' => array(
                            'class' => array()
                        ),
                        'br' => array(),
                        'strong' => array(),
                        'b' => array(),
                        'em' => array(),
                        'i' => array(),
                        'u' => array(),
                        'ul' => array(
                            'class' => array()
                        ),
                        'ol' => array(
                            'class' => array()
                        ),
                        'li' => array(
                            'class' => array()
                        ),
                        'a' => array(
                            'href' => array(),
                            'title' => array(),
                            'target' => array(),
                            'class' => array()
                        ),
                        'span' => array(
                            'style' => array(),
                            'class' => array()
                        )
                    );
                    // Decode HTML entities and then sanitize
                    $listing_description = html_entity_decode($listing_description, ENT_QUOTES, 'UTF-8');
                    $listing_description = wp_kses($listing_description, $allowed_html);
                    
                    // Clean up unwanted <br> tags around block elements
                    $listing_description = preg_replace('/<br\s*\/?>\s*<(ul|ol|li|\/ul|\/ol|\/li)/', '<$1', $listing_description);
                    $listing_description = preg_replace('/<\/(ul|ol|li)>\s*<br\s*\/?>/', '</$1>', $listing_description);
                    $listing_description = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/', '<br>', $listing_description);
                    $listing_description = trim($listing_description);
                ?>
                    <div class="listing-card">
                        <?php if (!empty($icon_class)) : ?>
                            <div class="listing-icon">
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($listing_title)) : ?>
                            <h4 class="listing-title"><?php echo esc_html($listing_title); ?></h4>
                        <?php endif; ?>
                        
                        <?php if (!empty($listing_description)) : ?>
                            <div class="listing-description"><?php echo $listing_description; ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($button_text) && !empty($button_link)) : ?>
                            <a href="<?php echo $button_link; ?>" class="listing-button">
                                <?php echo esc_html($button_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>