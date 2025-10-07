<?php
/**
 * APC Button Block
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render APC Button Block
 */
function apc_render_button_block($attributes, $content) {
    $text = isset($attributes['text']) ? $attributes['text'] : 'Click Here';
    $url = isset($attributes['url']) ? $attributes['url'] : '#';
    $link_target = isset($attributes['linkTarget']) ? $attributes['linkTarget'] : '_self';
    $alignment = isset($attributes['alignment']) ? $attributes['alignment'] : 'left';
    
    // Sanitize attributes
    $text = wp_kses_post($text);
    $url = esc_url($url);
    $link_target = esc_attr($link_target);
    $alignment = sanitize_html_class($alignment);
    
    // Build CSS classes
    $button_classes = "apc-button";
    $wrapper_classes = "apc-button-wrapper text-{$alignment}";
    
    // Build rel attribute for external links
    $rel_attr = '';
    if ($link_target === '_blank') {
        $rel_attr = ' rel="noopener noreferrer"';
    }
    
    // Generate the button HTML
    $output = sprintf(
        '<div class="%s"><a href="%s" class="%s" target="%s"%s>%s</a></div>',
        esc_attr($wrapper_classes),
        $url,
        esc_attr($button_classes),
        $link_target,
        $rel_attr,
        $text
    );
    
    return $output;
}