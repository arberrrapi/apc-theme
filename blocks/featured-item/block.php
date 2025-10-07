<?php
/**
 * Featured Item Block
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Featured Item Block
 */
function apc_render_featured_item_block($attributes, $content) {
    $name = isset($attributes['name']) ? $attributes['name'] : 'Featured Item';
    $icon = isset($attributes['icon']) ? $attributes['icon'] : 'fa-solid fa-star';
    $description = isset($attributes['description']) ? $attributes['description'] : 'Short description of this featured item.';
    
    // Sanitize attributes
    $name = wp_kses_post($name);
    $icon = sanitize_text_field($icon); // Use sanitize_text_field to preserve spaces
    $description = wp_kses_post($description);
    
    // Generate the featured item HTML
    $output = sprintf(
        '<div class="featured-item-wrapper">
            <div class="featured-item-header">
                <i class="%s"></i>
                <h3 class="featured-item-title">%s</h3>
            </div>
            <p class="featured-item-description">%s</p>
        </div>',
        esc_attr($icon),
        $name,
        $description
    );
    
    return $output;
}