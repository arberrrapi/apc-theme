<?php
/**
 * APC Feature Block - Server-side rendering
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render APC Feature Block
 */
function apc_render_feature_block($attributes) {
    $icon_url = $attributes['iconUrl'] ?? '';
    $icon_alt = $attributes['iconAlt'] ?? '';
    $content = $attributes['content'] ?? '<p>Add your feature description here. You can include <strong>bold text</strong>, <em>italic text</em>, and <a href="#">links</a>.</p>';
    $alignment = $attributes['alignment'] ?? 'center';
    
    ob_start();
    ?>
    <div class="apc-feature-block" style="text-align: <?php echo esc_attr($alignment); ?>">
        <?php if (!empty($icon_url)) : ?>
            <div class="feature-icon">
                <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" />
            </div>
        <?php endif; ?>
        
        <div class="feature-content">
            <?php echo wp_kses_post($content); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>