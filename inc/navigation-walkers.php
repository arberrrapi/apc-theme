<?php
/**
 * Custom Navigation Walker Classes
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom walker for main navigation menus (Desktop & Tablet)
 */
class APC_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    // Start Level - wraps the list
    public function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            // First level sub-menus are mega menus
            $output .= '<div class="mega-menu"><div class="mega-menu-container">';
        } elseif ($depth === 1) {
            // Second level sub-menus
            $output .= '<ul>';
        }
    }
    
    // End Level
    public function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</div></div>';
        } elseif ($depth === 1) {
            $output .= '</ul>';
        }
    }
    
    // Start Element
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        if ($depth === 0) {
            // Top level items
            $has_children = in_array('menu-item-has-children', $classes);
            $li_class = $has_children ? 'nav-item mega-menu-item' : 'nav-item';
            
            $output .= '<li class="' . $li_class . '">';
            $output .= '<a href="' . esc_url($item->url) . '" class="nav-link">' . esc_html($item->title) . '</a>';
            
        } elseif ($depth === 1) {
            // First sub-level items (mega menu columns)
            $has_children = in_array('menu-item-has-children', $classes);
            
            if ($has_children) {
                $output .= '<div class="mega-menu-column">';
                $output .= '<h4>' . esc_html($item->title) . '</h4>';
            } else {
                $output .= '<div class="mega-menu-column">';
                $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
            }
            
        } elseif ($depth === 2) {
            // Second sub-level items (links within columns)
            $output .= '<li><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
        }
    }
    
    // End Element
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</li>';
        } elseif ($depth === 1) {
            $output .= '</div>';
        }
        // Depth 2 items are closed in start_el
    }
}

/**
 * Custom walker for mobile navigation menus
 */
class APC_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    // Start Level
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="mobile-accordion-panel">';
    }
    
    // End Level
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }
    
    // Start Element
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        
        if ($depth === 0) {
            // Top level items
            if ($has_children) {
                $output .= '<li class="mobile-nav-item mobile-accordion-parent">';
                $output .= '<button class="mobile-accordion-toggle" aria-expanded="false">' . esc_html($item->title) . '</button>';
            } else {
                $output .= '<li class="mobile-nav-item">';
                $output .= '<a href="' . esc_url($item->url) . '" class="mobile-nav-link">' . esc_html($item->title) . '</a>';
            }
        } elseif ($depth === 1) {
            // First sub-level items
            if ($has_children) {
                $output .= '<li class="mobile-accordion-parent">';
                $output .= '<button class="mobile-accordion-toggle" aria-expanded="false">' . esc_html($item->title) . '</button>';
            } else {
                $output .= '<li>';
                $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
            }
        } elseif ($depth === 2) {
            // Second sub-level items
            $output .= '<li><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
        }
    }
    
    // End Element
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}

/**
 * Display message when no menu is set
 */
function apc_no_menu_message() {
    if (current_user_can('edit_theme_options')) {
        return '<div class="no-menu-message"><p>' . __('Please assign a menu to the "Primary Menu" location in', 'apc-theme') . ' <a href="' . admin_url('nav-menus.php') . '">' . __('Appearance > Menus', 'apc-theme') . '</a>.</p></div>';
    }
    return '';
}