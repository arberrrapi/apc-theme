<?php
/**
 * APC Image Block Render
 * 
 * @param array $attributes Block attributes
 * @param string $content Block content
 * @return string
 */

function apc_render_image_block($attributes, $content = '') {
    // Extract attributes with defaults
    $image_id = isset($attributes['imageId']) ? intval($attributes['imageId']) : 0;
    $image_url = isset($attributes['imageUrl']) ? $attributes['imageUrl'] : '';
    $image_alt = isset($attributes['imageAlt']) ? $attributes['imageAlt'] : '';
    $image_caption = isset($attributes['imageCaption']) ? $attributes['imageCaption'] : '';

    // If no image is selected, don't render anything
    if (!$image_id || !$image_url) {
        return '';
    }

    // Get additional image data if we have an ID
    $image_data = null;
    if ($image_id) {
        $image_data = wp_get_attachment_image_src($image_id, 'full');
        // Use the actual image URL from WordPress if available
        if ($image_data) {
            $image_url = $image_data[0];
        }
        
        // Get alt text from WordPress if not provided
        if (empty($image_alt)) {
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        }
    }

    ob_start();
    ?>
    <div class="wp-block-apc-image">
        <figure class="apc-image-figure">
            <div class="apc-image-container">
                <div class="apc-image-wrapper">
                    <img 
                        src="<?php echo esc_url($image_url); ?>" 
                        alt="<?php echo esc_attr($image_alt); ?>"
                        <?php if ($image_id): ?>
                            data-image-id="<?php echo esc_attr($image_id); ?>"
                        <?php endif; ?>
                        loading="lazy"
                    />
                </div>
            </div>
            <?php if (!empty($image_caption)): ?>
                <figcaption class="apc-image-caption">
                    <?php echo wp_kses_post($image_caption); ?>
                </figcaption>
            <?php endif; ?>
        </figure>
    </div>
    <?php
    return ob_get_clean();
}
?>