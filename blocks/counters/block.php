<?php
/**
 * Counters Block
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Counters Block
 */
function apc_render_counters_block($attributes, $content) {
    $columns_count = isset($attributes['columnsCount']) ? $attributes['columnsCount'] : 4;
    
    $output = '<div class="counters-wrapper">';
    $output .= '<div class="counters-container">';
    
    for ($i = 1; $i <= $columns_count; $i++) {
        $counter_number = isset($attributes['counter' . $i . 'Number']) ? $attributes['counter' . $i . 'Number'] : '';
        $counter_subtitle = isset($attributes['counter' . $i . 'Subtitle']) ? $attributes['counter' . $i . 'Subtitle'] : '';
        
        // Sanitize attributes
        $counter_number = sanitize_text_field($counter_number);
        $counter_subtitle = sanitize_text_field($counter_subtitle);
        
        $output .= sprintf(
            '<div class="counter-column">
                <h2 class="counter-number">%s</h2>
                <p class="counter-subtitle">%s</p>
            </div>',
            esc_html($counter_number),
            esc_html($counter_subtitle)
        );
    }
    
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}