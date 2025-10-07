<?php
/**
 * APC Featured Content Block - Server-side rendering
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render APC Featured Content Block
 */
function apc_render_featured_content_block($attributes) {
    $title = $attributes['title'] ?? 'Featured Content Title';
    $description = $attributes['description'] ?? 'Add your description here. This content will be displayed alongside your featured image.';
    $button_text = $attributes['buttonText'] ?? 'Learn More';
    $button_link = $attributes['buttonLink'] ?? '';
    $button_page = $attributes['buttonPage'] ?? 0;
    $button_type = $attributes['buttonType'] ?? 'url'; // 'url' or 'page'
    $image_url = $attributes['imageUrl'] ?? '';
    $image_alt = $attributes['imageAlt'] ?? '';
    $reverse_columns = $attributes['reverseColumns'] ?? false;
    
    // Determine the final button URL
    $final_button_url = '';
    if ($button_type === 'page' && !empty($button_page)) {
        $final_button_url = get_permalink($button_page);
    } elseif ($button_type === 'url' && !empty($button_link)) {
        $final_button_url = $button_link;
    }
    
    ob_start();
    ?>
    <div class="apc-featured-content-block">
        <div class="featured-content-container <?php echo $reverse_columns ? 'reverse-columns' : ''; ?>">
            <div class="featured-content-wrapper">
                <!-- Content Column -->
                <div class="featured-content-text">
                    <div class="featured-content-top">
                        <h2 class="featured-title"><?php echo esc_html($title); ?></h2>
                    </div>
                    <div class="featured-content-bottom">
                        <p class="featured-description"><?php echo esc_html($description); ?></p>
                        <?php if (!empty($final_button_url)) : ?>
                            <a href="<?php echo esc_url($final_button_url); ?>" class="featured-btn"><?php echo esc_html($button_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Image Column -->
                <div class="featured-content-image">
                    <?php if (!empty($image_url)) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
                    <?php else : ?>
                        <div class="featured-image-placeholder">
                            <span>No image selected</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>