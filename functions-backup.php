<?php
/**
 * Theme Functions - APC Integrated Theme
 * 
 * @package APC_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function apc_theme_setup() {
    // Add theme support for various WordPress features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'apc-theme'),
        'mobile' => __('Mobile Menu', 'apc-theme'),
    ));
}
add_action('after_setup_theme', 'apc_theme_setup');

/**
 * Enqueue styles and scripts
 */
function apc_theme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('apc-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Enqueue custom JavaScript
    wp_enqueue_script('apc-theme-script', get_template_directory_uri() . '/script.js', array(), '1.0.0', true);
    
    // Localize script for AJAX calls
    wp_localize_script('apc-theme-script', 'apc_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('apc_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'apc_theme_scripts');

/**
 * Register widget areas
 */
function apc_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'apc-theme'),
        'id'            => 'footer-widgets',
        'description'   => __('Add widgets here to appear in your footer.', 'apc-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'apc_theme_widgets_init');

/**
 * Gutenberg compatibility for meta boxes
 */
add_filter('use_block_editor_for_post_type', function($use_block_editor, $post_type) {
    if ($post_type === 'page') {
        // Force meta boxes to show in Gutenberg
        add_action('enqueue_block_editor_assets', function() {
            wp_add_inline_script('wp-edit-post', 'wp.data.dispatch("core/edit-post").toggleFeature("showMetaBoxes");');
        });
    }
    return $use_block_editor;
}, 10, 2);

/**
 * Include organized functionality files
 */
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/shortcodes-widgets.php';
require_once get_template_directory() . '/inc/navigation-walkers.php';
require_once get_template_directory() . '/inc/blocks-customizer.php';

/**
 * Add styles for shortcodes and widgets
 */
function apc_services_shortcode_styles() {
    $labels = array(
        'name'                  => _x('Services', 'Post Type General Name', 'apc-theme'),
        'singular_name'         => _x('Service', 'Post Type Singular Name', 'apc-theme'),
        'menu_name'             => __('Services', 'apc-theme'),
        'name_admin_bar'        => __('Service', 'apc-theme'),
        'archives'              => __('Service Archives', 'apc-theme'),
        'attributes'            => __('Service Attributes', 'apc-theme'),
        'parent_item_colon'     => __('Parent Service:', 'apc-theme'),
        'all_items'             => __('All Services', 'apc-theme'),
        'add_new_item'          => __('Add New Service', 'apc-theme'),
        'add_new'               => __('Add New', 'apc-theme'),
        'new_item'              => __('New Service', 'apc-theme'),
        'edit_item'             => __('Edit Service', 'apc-theme'),
        'update_item'           => __('Update Service', 'apc-theme'),
        'view_item'             => __('View Service', 'apc-theme'),
        'view_items'            => __('View Services', 'apc-theme'),
        'search_items'          => __('Search Service', 'apc-theme'),
        'not_found'             => __('Not found', 'apc-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'apc-theme'),
        'featured_image'        => __('Featured Image', 'apc-theme'),
        'set_featured_image'    => __('Set featured image', 'apc-theme'),
        'remove_featured_image' => __('Remove featured image', 'apc-theme'),
        'use_featured_image'    => __('Use as featured image', 'apc-theme'),
        'insert_into_item'      => __('Insert into service', 'apc-theme'),
        'uploaded_to_this_item' => __('Uploaded to this service', 'apc-theme'),
        'items_list'            => __('Services list', 'apc-theme'),
        'items_list_navigation' => __('Services list navigation', 'apc-theme'),
        'filter_items_list'     => __('Filter services list', 'apc-theme'),
    );
    
    $args = array(
        'label'                 => __('Service', 'apc-theme'),
        'description'           => __('APC Services', 'apc-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'            => array('service_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-tools',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type('service', $args);
}
add_action('init', 'apc_register_services_post_type', 0);

/**
 * Register Service Categories Taxonomy
 */
function apc_register_service_categories() {
    $labels = array(
        'name'                       => _x('Service Categories', 'Taxonomy General Name', 'apc-theme'),
        'singular_name'              => _x('Service Category', 'Taxonomy Singular Name', 'apc-theme'),
        'menu_name'                  => __('Categories', 'apc-theme'),
        'all_items'                  => __('All Categories', 'apc-theme'),
        'parent_item'                => __('Parent Category', 'apc-theme'),
        'parent_item_colon'          => __('Parent Category:', 'apc-theme'),
        'new_item_name'              => __('New Category Name', 'apc-theme'),
        'add_new_item'               => __('Add New Category', 'apc-theme'),
        'edit_item'                  => __('Edit Category', 'apc-theme'),
        'update_item'                => __('Update Category', 'apc-theme'),
        'view_item'                  => __('View Category', 'apc-theme'),
        'separate_items_with_commas' => __('Separate categories with commas', 'apc-theme'),
        'add_or_remove_items'        => __('Add or remove categories', 'apc-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'apc-theme'),
        'popular_items'              => __('Popular Categories', 'apc-theme'),
        'search_items'               => __('Search Categories', 'apc-theme'),
        'not_found'                  => __('Not Found', 'apc-theme'),
        'no_terms'                   => __('No categories', 'apc-theme'),
        'items_list'                 => __('Categories list', 'apc-theme'),
        'items_list_navigation'      => __('Categories list navigation', 'apc-theme'),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    
    register_taxonomy('service_category', array('service'), $args);
}
add_action('init', 'apc_register_service_categories', 0);

/**
 * Add FontAwesome Icon Meta Box to Services
 */
function apc_add_service_meta_boxes() {
    add_meta_box(
        'apc_service_icon',
        __('Service Icon', 'apc-theme'),
        'apc_service_icon_callback',
        'service',
        'side',
        'high'
    );
    
    add_meta_box(
        'apc_service_details',
        __('Service Details', 'apc-theme'),
        'apc_service_details_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apc_add_service_meta_boxes');

/**
 * Add Page Subtitle Meta Box - Compatible with both Classic and Gutenberg
 */
function apc_add_page_subtitle_meta_box() {
    add_meta_box(
        'apc-page-subtitle',
        'Page Subtitle',
        'apc_render_page_subtitle_meta_box',
        'page',
        'side',
        'high'
    );
}
add_action('add_meta_boxes_page', 'apc_add_page_subtitle_meta_box');

/**
 * Ensure meta box shows in Gutenberg
 */
function apc_gutenberg_meta_box_compatibility() {
    return true;
}
add_filter('use_block_editor_for_post_type', function($use_block_editor, $post_type) {
    if ($post_type === 'page') {
        // Force meta boxes to show in Gutenberg
        add_action('enqueue_block_editor_assets', function() {
            wp_add_inline_script('wp-edit-post', 'wp.data.dispatch("core/edit-post").toggleFeature("showMetaBoxes");');
        });
    }
    return $use_block_editor;
}, 10, 2);

// Simple test to verify functions are loading
function apc_admin_test_notice() {
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'page') {
        echo '<div class="notice notice-success is-dismissible"><p>APC Theme functions loaded! Page Subtitle meta box should be visible.</p></div>';
    }
}
add_action('admin_notices', 'apc_admin_test_notice');

/**
 * Render Page Subtitle Meta Box
 */
function apc_render_page_subtitle_meta_box($post) {
    // Add nonce field for security
    wp_nonce_field('apc_page_subtitle_meta_box', 'apc_page_subtitle_nonce');
    
    // Get current values
    $subtitle = get_post_meta($post->ID, '_page_subtitle', true);
    $button_text = get_post_meta($post->ID, '_page_button_text', true);
    $button_link_type = get_post_meta($post->ID, '_page_button_link_type', true);
    $button_page_id = get_post_meta($post->ID, '_page_button_page_id', true);
    $button_custom_url = get_post_meta($post->ID, '_page_button_custom_url', true);
    
    // Set defaults
    if (empty($button_link_type)) {
        $button_link_type = 'page';
    }
    
    echo '<table class="form-table">';
    
    // Subtitle field
    echo '<tr>';
    echo '<th><label for="apc_page_subtitle">Subtitle:</label></th>';
    echo '<td>';
    echo '<input type="text" id="apc_page_subtitle" name="apc_page_subtitle" value="' . esc_attr($subtitle) . '" style="width: 100%;" placeholder="Enter page subtitle..." />';
    echo '<p class="description">This subtitle will appear below the main page title.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Button text field
    echo '<tr>';
    echo '<th><label for="apc_page_button_text">Button Text:</label></th>';
    echo '<td>';
    echo '<input type="text" id="apc_page_button_text" name="apc_page_button_text" value="' . esc_attr($button_text) . '" style="width: 100%;" placeholder="Enter button text..." />';
    echo '<p class="description">Leave empty to hide the button.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Button link type
    echo '<tr>';
    echo '<th><label for="apc_page_button_link_type">Button Link Type:</label></th>';
    echo '<td>';
    echo '<select id="apc_page_button_link_type" name="apc_page_button_link_type" style="width: 100%;" onchange="toggleButtonLinkFields()">';
    echo '<option value="page"' . selected($button_link_type, 'page', false) . '>Select Existing Page</option>';
    echo '<option value="custom"' . selected($button_link_type, 'custom', false) . '>Custom URL</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Page selector
    echo '<tr id="page_selector_row" style="' . ($button_link_type == 'custom' ? 'display: none;' : '') . '">';
    echo '<th><label for="apc_page_button_page_id">Select Page:</label></th>';
    echo '<td>';
    wp_dropdown_pages(array(
        'name' => 'apc_page_button_page_id',
        'id' => 'apc_page_button_page_id',
        'selected' => $button_page_id,
        'show_option_none' => '-- Select a page --',
        'option_none_value' => '',
        'class' => 'widefat'
    ));
    echo '</td>';
    echo '</tr>';
    
    // Custom URL field
    echo '<tr id="custom_url_row" style="' . ($button_link_type == 'page' ? 'display: none;' : '') . '">';
    echo '<th><label for="apc_page_button_custom_url">Custom URL:</label></th>';
    echo '<td>';
    echo '<input type="url" id="apc_page_button_custom_url" name="apc_page_button_custom_url" value="' . esc_attr($button_custom_url) . '" style="width: 100%;" placeholder="https://example.com" />';
    echo '<p class="description">Enter a full URL including http:// or https://</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
    
    // Add JavaScript for toggling fields
    echo '<script>
    function toggleButtonLinkFields() {
        var linkType = document.getElementById("apc_page_button_link_type").value;
        var pageRow = document.getElementById("page_selector_row");
        var customRow = document.getElementById("custom_url_row");
        
        if (linkType === "page") {
            pageRow.style.display = "table-row";
            customRow.style.display = "none";
        } else {
            pageRow.style.display = "none";
            customRow.style.display = "table-row";
        }
    }
    </script>';
}

/**
 * Save Page Subtitle Meta Box Data
 */
function apc_save_page_subtitle_meta($post_id) {
    // Check if this is a page
    if (get_post_type($post_id) != 'page') {
        return;
    }
    
    // Verify nonce
    if (!isset($_POST['apc_page_subtitle_nonce']) || !wp_verify_nonce($_POST['apc_page_subtitle_nonce'], 'apc_page_subtitle_meta_box')) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }
    
    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Save subtitle
    if (isset($_POST['apc_page_subtitle'])) {
        update_post_meta($post_id, '_page_subtitle', sanitize_text_field($_POST['apc_page_subtitle']));
    } else {
        delete_post_meta($post_id, '_page_subtitle');
    }
    
    // Save button text
    if (isset($_POST['apc_page_button_text'])) {
        update_post_meta($post_id, '_page_button_text', sanitize_text_field($_POST['apc_page_button_text']));
    } else {
        delete_post_meta($post_id, '_page_button_text');
    }
    
    // Save button link type
    if (isset($_POST['apc_page_button_link_type'])) {
        update_post_meta($post_id, '_page_button_link_type', sanitize_text_field($_POST['apc_page_button_link_type']));
    } else {
        delete_post_meta($post_id, '_page_button_link_type');
    }
    
    // Save page ID (for page link type)
    if (isset($_POST['apc_page_button_page_id'])) {
        update_post_meta($post_id, '_page_button_page_id', intval($_POST['apc_page_button_page_id']));
    } else {
        delete_post_meta($post_id, '_page_button_page_id');
    }
    
    // Save custom URL (for custom link type)
    if (isset($_POST['apc_page_button_custom_url'])) {
        update_post_meta($post_id, '_page_button_custom_url', esc_url_raw($_POST['apc_page_button_custom_url']));
    } else {
        delete_post_meta($post_id, '_page_button_custom_url');
    }
}
add_action('save_post', 'apc_save_page_subtitle_meta');

/**
 * Helper function to get the page button URL
 */
function apc_get_page_button_url($post_id) {
    $link_type = get_post_meta($post_id, '_page_button_link_type', true);
    
    if ($link_type === 'custom') {
        return get_post_meta($post_id, '_page_button_custom_url', true);
    } else {
        $page_id = get_post_meta($post_id, '_page_button_page_id', true);
        if ($page_id) {
            return get_permalink($page_id);
        }
    }
    
    return '';
}

/**
 * Register Page Subtitle for REST API (Gutenberg compatibility)
 */
function apc_register_page_subtitle_rest_field() {
    register_rest_field('page', 'page_subtitle', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], '_page_subtitle', true);
        },
        'update_callback' => function($value, $post) {
            return update_post_meta($post->ID, '_page_subtitle', sanitize_text_field($value));
        },
        'schema' => array(
            'description' => 'Page subtitle',
            'type' => 'string',
            'context' => array('edit'),
        ),
    ));
}
add_action('rest_api_init', 'apc_register_page_subtitle_rest_field');

/**
 * Service Icon Meta Box Callback
 */
function apc_service_icon_callback($post) {
    wp_nonce_field('apc_service_icon_nonce', 'service_icon_nonce');
    
    $icon = get_post_meta($post->ID, '_service_icon', true);
    
    // Popular FontAwesome icons for services
    $popular_icons = array(
        'fa-solid fa-headset' => 'Headset (Support)',
        'fa-solid fa-cloud' => 'Cloud',
        'fa-solid fa-shield-halved' => 'Security Shield',
        'fa-solid fa-network-wired' => 'Network',
        'fa-solid fa-file-contract' => 'Contract',
        'fa-solid fa-database' => 'Database',
        'fa-solid fa-laptop-code' => 'Laptop Code',
        'fa-solid fa-server' => 'Server',
        'fa-solid fa-cog' => 'Settings',
        'fa-solid fa-users' => 'Users',
        'fa-solid fa-rocket' => 'Rocket',
        'fa-solid fa-lock' => 'Lock',
        'fa-solid fa-wifi' => 'WiFi',
        'fa-solid fa-mobile-alt' => 'Mobile',
        'fa-solid fa-desktop' => 'Desktop',
        'fa-solid fa-chart-line' => 'Analytics',
        'fa-solid fa-tools' => 'Tools',
        'fa-solid fa-phone' => 'Phone',
        'fa-solid fa-envelope' => 'Email',
        'fa-solid fa-globe' => 'Globe'
    );
    
    echo '<div class="apc-icon-selector">';
    echo '<label for="service_icon"><strong>' . __('Select Icon:', 'apc-theme') . '</strong></label><br><br>';
    
    echo '<div class="icon-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">';
    foreach ($popular_icons as $icon_class => $label) {
        $checked = ($icon === $icon_class) ? 'checked' : '';
        echo '<div class="icon-option" style="text-align: center; padding: 10px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;">';
        echo '<input type="radio" name="service_icon" value="' . $icon_class . '" id="' . $icon_class . '" ' . $checked . ' style="display: none;">';
        echo '<label for="' . $icon_class . '" style="cursor: pointer; display: block;">';
        echo '<i class="' . $icon_class . '" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>';
        echo '<small>' . $label . '</small>';
        echo '</label>';
        echo '</div>';
    }
    echo '</div>';
    
    echo '<label for="service_custom_icon"><strong>' . __('Or enter custom FontAwesome class:', 'apc-theme') . '</strong></label><br>';
    echo '<input type="text" name="service_custom_icon" id="service_custom_icon" placeholder="e.g., fa-solid fa-star" style="width: 100%; margin: 5px 0;">';
    echo '<small>Visit <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a> for more icons</small>';
    echo '</div>';
    
    // Add some JavaScript for better UX
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('.icon-option').click(function() {
            $('.icon-option').removeClass('selected');
            $(this).addClass('selected');
            $(this).find('input[type="radio"]').prop('checked', true);
        });
        
        // Style selected option
        $('input[name="service_icon"]:checked').closest('.icon-option').addClass('selected');
        
        $('#service_custom_icon').on('input', function() {
            if ($(this).val()) {
                $('input[name="service_icon"]').prop('checked', false);
                $('.icon-option').removeClass('selected');
            }
        });
    });
    </script>
    <style>
    .icon-option.selected {
        background: #0073aa;
        color: white;
    }
    .icon-option:hover {
        background: #f0f0f1;
    }
    .icon-option.selected:hover {
        background: #005a87;
    }
    </style>
    <?php
}

/**
 * Service Details Meta Box Callback
 */
function apc_service_details_callback($post) {
    wp_nonce_field('apc_service_details_nonce', 'service_details_nonce');
    
    $short_description = get_post_meta($post->ID, '_service_short_description', true);
    $service_url = get_post_meta($post->ID, '_service_url', true);
    $price_range = get_post_meta($post->ID, '_service_price_range', true);
    
    echo '<table class="form-table">';
    
    echo '<tr>';
    echo '<th><label for="service_short_description">' . __('Short Description', 'apc-theme') . '</label></th>';
    echo '<td><textarea name="service_short_description" id="service_short_description" rows="3" style="width: 100%;">' . esc_textarea($short_description) . '</textarea>';
    echo '<p class="description">' . __('Brief description for service cards (recommended: 1-2 sentences)', 'apc-theme') . '</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="service_url">' . __('Service URL', 'apc-theme') . '</label></th>';
    echo '<td><input type="url" name="service_url" id="service_url" value="' . esc_url($service_url) . '" style="width: 100%;">';
    echo '<p class="description">' . __('Link to detailed service page or contact form', 'apc-theme') . '</p></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="service_price_range">' . __('Price Range', 'apc-theme') . '</label></th>';
    echo '<td><select name="service_price_range" id="service_price_range">';
    echo '<option value="">' . __('Select Price Range', 'apc-theme') . '</option>';
    echo '<option value="budget" ' . selected($price_range, 'budget', false) . '>' . __('Budget Friendly', 'apc-theme') . '</option>';
    echo '<option value="standard" ' . selected($price_range, 'standard', false) . '>' . __('Standard', 'apc-theme') . '</option>';
    echo '<option value="premium" ' . selected($price_range, 'premium', false) . '>' . __('Premium', 'apc-theme') . '</option>';
    echo '<option value="enterprise" ' . selected($price_range, 'enterprise', false) . '>' . __('Enterprise', 'apc-theme') . '</option>';
    echo '<option value="custom" ' . selected($price_range, 'custom', false) . '>' . __('Custom Quote', 'apc-theme') . '</option>';
    echo '</select></td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Save Service Meta Box Data
 */
function apc_save_service_meta($post_id) {
    // Check if nonces are set and valid
    if (!isset($_POST['service_icon_nonce']) || !wp_verify_nonce($_POST['service_icon_nonce'], 'apc_service_icon_nonce')) {
        return;
    }
    
    if (!isset($_POST['service_details_nonce']) || !wp_verify_nonce($_POST['service_details_nonce'], 'apc_service_details_nonce')) {
        return;
    }
    
    // Check if user has permission to edit
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Save icon
    $icon = '';
    if (isset($_POST['service_custom_icon']) && !empty($_POST['service_custom_icon'])) {
        $icon = sanitize_text_field($_POST['service_custom_icon']);
    } elseif (isset($_POST['service_icon'])) {
        $icon = sanitize_text_field($_POST['service_icon']);
    }
    update_post_meta($post_id, '_service_icon', $icon);
    
    // Save other details
    if (isset($_POST['service_short_description'])) {
        update_post_meta($post_id, '_service_short_description', sanitize_textarea_field($_POST['service_short_description']));
    }
    
    if (isset($_POST['service_url'])) {
        update_post_meta($post_id, '_service_url', esc_url_raw($_POST['service_url']));
    }
    
    if (isset($_POST['service_price_range'])) {
        update_post_meta($post_id, '_service_price_range', sanitize_text_field($_POST['service_price_range']));
    }
}
add_action('save_post', 'apc_save_service_meta');

/**
 * Add admin styles for better meta box appearance
 */
function apc_admin_styles() {
    global $post_type;
    if ($post_type === 'service') {
        ?>
        <style>
        .apc-icon-selector .icon-grid {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
        }
        </style>
        <?php
    }
}
add_action('admin_head', 'apc_admin_styles');

/**
 * Services Shortcode
 * Usage: [apc_services limit="6" category="cloud-solutions" style="grid"]
 */
function apc_services_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 6,
        'category' => '',
        'style' => 'grid', // grid, list, slider
        'show_icon' => 'true',
        'show_image' => 'true',
        'show_excerpt' => 'true',
        'show_button' => 'true'
    ), $atts, 'apc_services');
    
    $args = array(
        'post_type' => 'service',
        'posts_per_page' => intval($atts['limit']),
        'post_status' => 'publish'
    );
    
    // Add category filter if specified
    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'service_category',
                'field' => 'slug',
                'terms' => $atts['category']
            )
        );
    }
    
    $services = new WP_Query($args);
    
    if (!$services->have_posts()) {
        return '<p>' . __('No services found.', 'apc-theme') . '</p>';
    }
    
    $output = '<div class="apc-services-shortcode services-style-' . esc_attr($atts['style']) . '">';
    
    if ($atts['style'] === 'slider') {
        $output .= '<div class="services-slider-container">';
        $output .= '<div class="services-slider">';
    } else {
        $output .= '<div class="services-' . esc_attr($atts['style']) . '">';
    }
    
    while ($services->have_posts()) {
        $services->the_post();
        
        $service_icon = get_post_meta(get_the_ID(), '_service_icon', true);
        $service_icon_color = get_post_meta(get_the_ID(), '_service_icon_color', true);
        $service_short_description = get_post_meta(get_the_ID(), '_service_short_description', true);
        $service_url = get_post_meta(get_the_ID(), '_service_url', true);
        
        $output .= '<div class="service-item">';
        
        // Icon
        if ($atts['show_icon'] === 'true' && $service_icon) {
            $output .= '<div class="service-icon">';
            $output .= '<i class="' . esc_attr($service_icon) . '" style="color: ' . esc_attr($service_icon_color ?: '#3182ce') . ';"></i>';
            $output .= '</div>';
        }
        
        // Featured Image
        if ($atts['show_image'] === 'true' && has_post_thumbnail()) {
            $output .= '<div class="service-image">';
            $output .= '<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'medium') . '</a>';
            $output .= '</div>';
        }
        
        $output .= '<div class="service-content">';
        $output .= '<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
        
        // Excerpt/Description
        if ($atts['show_excerpt'] === 'true') {
            $output .= '<p>';
            if ($service_short_description) {
                $output .= esc_html($service_short_description);
            } else {
                $output .= wp_trim_words(get_the_excerpt(), 20);
            }
            $output .= '</p>';
        }
        
        // Button
        if ($atts['show_button'] === 'true') {
            $button_url = $service_url ? $service_url : get_the_permalink();
            $button_text = $service_url ? __('Get Started', 'apc-theme') : __('Learn More', 'apc-theme');
            $output .= '<a href="' . esc_url($button_url) . '" class="service-button">' . $button_text . '</a>';
        }
        
        $output .= '</div>'; // .service-content
        $output .= '</div>'; // .service-item
    }
    
    $output .= '</div>'; // .services-grid/.services-list/.services-slider
    
    if ($atts['style'] === 'slider') {
        $output .= '</div>'; // .services-slider-container
        $output .= '<div class="services-slider-nav">';
        $output .= '<button class="slider-prev"><i class="fa-solid fa-chevron-left"></i></button>';
        $output .= '<button class="slider-next"><i class="fa-solid fa-chevron-right"></i></button>';
        $output .= '</div>';
    }
    
    $output .= '</div>'; // .apc-services-shortcode
    
    wp_reset_postdata();
    
    return $output;
}
add_shortcode('apc_services', 'apc_services_shortcode');

/**
 * Add services shortcode styles
 */
function apc_services_shortcode_styles() {
    ?>
    <style>
    /* Services Shortcode Styles */
    .apc-services-shortcode {
        margin: 40px 0;
    }
    
    /* Grid Style */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }
    
    /* List Style */
    .services-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .services-style-list .service-item {
        display: flex;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .services-style-list .service-item:hover {
        transform: translateX(5px);
    }
    
    .services-style-list .service-image {
        flex: 0 0 150px;
    }
    
    .services-style-list .service-image img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .services-style-list .service-content {
        flex: 1;
        padding: 20px;
    }
    
    /* Slider Style */
    .services-slider-container {
        position: relative;
        overflow: hidden;
    }
    
    .services-slider {
        display: flex;
        gap: 20px;
        transition: transform 0.3s ease;
    }
    
    .services-style-slider .service-item {
        flex: 0 0 300px;
    }
    
    .services-slider-nav {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
    
    .slider-prev,
    .slider-next {
        background: var(--accent-blue, #3182ce);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .slider-prev:hover,
    .slider-next:hover {
        background: var(--primary-blue, #1a365d);
    }
    
    /* General Service Item Styles */
    .service-item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        text-align: center;
    }
    
    .services-style-grid .service-item:hover {
        transform: translateY(-5px);
    }
    
    .service-icon {
        padding: 20px;
        font-size: 2.5rem;
    }
    
    .service-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .services-style-grid .service-content,
    .services-style-slider .service-content {
        padding: 20px;
    }
    
    .service-item h3 {
        margin: 0 0 15px 0;
        font-size: 1.2rem;
    }
    
    .service-item h3 a {
        color: var(--primary-blue, #1a365d);
        text-decoration: none;
    }
    
    .service-item h3 a:hover {
        color: var(--accent-blue, #3182ce);
    }
    
    .service-item p {
        margin: 0 0 20px 0;
        color: #666;
        line-height: 1.5;
    }
    
    .service-button {
        display: inline-block;
        padding: 10px 20px;
        background: var(--accent-blue, #3182ce);
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 500;
        transition: background 0.3s ease;
    }
    
    .service-button:hover {
        background: var(--primary-blue, #1a365d);
    }
    
    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr;
        }
        
        .services-style-list .service-item {
            flex-direction: column;
        }
        
        .services-style-list .service-image {
            flex: none;
        }
        
        .services-slider {
            flex-direction: column;
        }
        
        .services-style-slider .service-item {
            flex: none;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'apc_services_shortcode_styles');

/**
 * Helper function to get services for display
 */
function apc_get_services($args = array()) {
    $defaults = array(
        'post_type' => 'service',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_service_icon',
                'compare' => 'EXISTS'
            )
        )
    );
    
    $args = wp_parse_args($args, $defaults);
    return new WP_Query($args);
}

/**
 * Services Widget
 */
class APC_Services_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'apc_services_widget',
            __('APC Services Widget', 'apc-theme'),
            array(
                'description' => __('Display featured services with icons', 'apc-theme')
            )
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Our Services', 'apc-theme');
        $limit = !empty($instance['limit']) ? intval($instance['limit']) : 3;
        $category = !empty($instance['category']) ? $instance['category'] : '';
        $show_icons = isset($instance['show_icons']) ? (bool) $instance['show_icons'] : true;
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        $service_args = array(
            'post_type' => 'service',
            'posts_per_page' => $limit,
            'post_status' => 'publish'
        );
        
        if (!empty($category)) {
            $service_args['tax_query'] = array(
                array(
                    'taxonomy' => 'service_category',
                    'field' => 'slug',
                    'terms' => $category
                )
            );
        }
        
        $services = new WP_Query($service_args);
        
        if ($services->have_posts()) {
            echo '<div class="apc-services-widget">';
            
            while ($services->have_posts()) {
                $services->the_post();
                
                $service_icon = get_post_meta(get_the_ID(), '_service_icon', true);
                $service_icon_color = get_post_meta(get_the_ID(), '_service_icon_color', true);
                $service_short_description = get_post_meta(get_the_ID(), '_service_short_description', true);
                
                echo '<div class="widget-service-item">';
                
                if ($show_icons && $service_icon) {
                    echo '<div class="widget-service-icon">';
                    echo '<i class="' . esc_attr($service_icon) . '" style="color: ' . esc_attr($service_icon_color ?: '#3182ce') . ';"></i>';
                    echo '</div>';
                }
                
                echo '<div class="widget-service-content">';
                echo '<h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>';
                
                if ($service_short_description) {
                    echo '<p>' . esc_html(wp_trim_words($service_short_description, 10)) . '</p>';
                }
                
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            
            wp_reset_postdata();
        } else {
            echo '<p>' . __('No services found.', 'apc-theme') . '</p>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Our Services', 'apc-theme');
        $limit = !empty($instance['limit']) ? $instance['limit'] : 3;
        $category = !empty($instance['category']) ? $instance['category'] : '';
        $show_icons = isset($instance['show_icons']) ? (bool) $instance['show_icons'] : true;
        
        // Get service categories
        $categories = get_terms(array(
            'taxonomy' => 'service_category',
            'hide_empty' => false,
        ));
        ?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'apc-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php _e('Number of services:', 'apc-theme'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="number" step="1" min="1" 
                   value="<?php echo esc_attr($limit); ?>" size="3">
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php _e('Category:', 'apc-theme'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" 
                    name="<?php echo esc_attr($this->get_field_name('category')); ?>">
                <option value=""><?php _e('All Categories', 'apc-theme'); ?></option>
                <?php if (!is_wp_error($categories) && !empty($categories)) : ?>
                    <?php foreach ($categories as $cat) : ?>
                        <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($category, $cat->slug); ?>>
                            <?php echo esc_html($cat->name); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_icons); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_icons')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_icons')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_icons')); ?>"><?php _e('Show service icons', 'apc-theme'); ?></label>
        </p>
        
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit'])) ? intval($new_instance['limit']) : 3;
        $instance['category'] = (!empty($new_instance['category'])) ? sanitize_text_field($new_instance['category']) : '';
        $instance['show_icons'] = !empty($new_instance['show_icons']);
        
        return $instance;
    }
}

/**
 * Register Services Widget
 */
function apc_register_services_widget() {
    register_widget('APC_Services_Widget');
}
add_action('widgets_init', 'apc_register_services_widget');

/**
 * Add widget styles
 */
function apc_widget_styles() {
    ?>
    <style>
    /* Services Widget Styles */
    .apc-services-widget {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .widget-service-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .widget-service-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .widget-service-icon {
        flex: 0 0 auto;
        font-size: 1.5rem;
    }
    
    .widget-service-content {
        flex: 1;
    }
    
    .widget-service-content h4 {
        margin: 0 0 5px 0;
        font-size: 1rem;
        line-height: 1.3;
    }
    
    .widget-service-content h4 a {
        color: var(--primary-blue, #1a365d);
        text-decoration: none;
    }
    
    .widget-service-content h4 a:hover {
        color: var(--accent-blue, #3182ce);
    }
    
    .widget-service-content p {
        margin: 0;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.4;
    }
    </style>
    <?php
}
add_action('wp_head', 'apc_widget_styles');

/**
 * Customizer additions
 */
function apc_theme_customize_register($wp_customize) {
    // Add customizer options here
    $wp_customize->add_section('apc_theme_options', array(
        'title'    => __('APC Theme Options', 'apc-theme'),
        'priority' => 30,
    ));
    
    // Example: Header CTA buttons
    $wp_customize->add_setting('remote_support_url', array(
        'default'           => '#remote-support',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('remote_support_url', array(
        'label'    => __('Remote Support URL', 'apc-theme'),
        'section'  => 'apc_theme_options',
        'type'     => 'url',
    ));
    
    $wp_customize->add_setting('client_portal_url', array(
        'default'           => '#client-portal',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('client_portal_url', array(
        'label'    => __('Client Portal URL', 'apc-theme'),
        'section'  => 'apc_theme_options',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'apc_theme_customize_register');

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

/**
 * Add admin notice styles and menu guidance
 */
function apc_admin_menu_styles() {
    ?>
    <style>
    .no-menu-message {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        padding: 15px;
        margin: 20px 0;
        border-radius: 4px;
        text-align: center;
    }
    
    .no-menu-message p {
        margin: 0;
        color: #856404;
    }
    
    .no-menu-message a {
        color: #0073aa;
        text-decoration: none;
    }
    
    .no-menu-message a:hover {
        text-decoration: underline;
    }
    </style>
    <?php
}
add_action('wp_head', 'apc_admin_menu_styles');

/**
 * Handle contact form submission
 */
function apc_handle_contact_form() {
    if (isset($_POST['apc_nonce']) && wp_verify_nonce($_POST['apc_nonce'], 'apc_contact_form')) {
        
        // Sanitize form data
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $company = sanitize_text_field($_POST['company']);
        $service = sanitize_text_field($_POST['service']);
        $message = sanitize_textarea_field($_POST['message']);
        
        // Prepare email
        $to = get_option('admin_email');
        $subject = 'New Contact Form Submission from ' . get_bloginfo('name');
        $body = "Name: $name\n";
        $body .= "Email: $email\n";
        $body .= "Phone: $phone\n";
        $body .= "Company: $company\n";
        $body .= "Service: $service\n";
        $body .= "Message: $message\n";
        
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        // Send email
        if (wp_mail($to, $subject, $body, $headers)) {
            // Success - you might want to set a success message or redirect
            wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
            exit;
        } else {
            // Error - you might want to set an error message
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
            exit;
        }
    }
}
add_action('init', 'apc_handle_contact_form');

/**
 * Add more customizer options
 */
function apc_theme_customize_register_additional($wp_customize) {
    // Hero Section
    $wp_customize->add_section('apc_hero_section', array(
        'title'    => __('Hero Section', 'apc-theme'),
        'priority' => 31,
    ));
    
    $wp_customize->add_setting('hero_line_1', array(
        'default' => 'Using APC for',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_line_1', array(
        'label'    => __('Hero Line 1', 'apc-theme'),
        'section'  => 'apc_hero_section',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('hero_line_2', array(
        'default' => 'in your business',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_line_2', array(
        'label'    => __('Hero Line 2', 'apc-theme'),
        'section'  => 'apc_hero_section',
        'type'     => 'text',
    ));
    
    // CTA Section
    $wp_customize->add_section('apc_cta_section', array(
        'title'    => __('CTA Section', 'apc-theme'),
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('cta_title', array(
        'default' => 'Partner with us for comprehensive IT',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('cta_title', array(
        'label'    => __('CTA Title', 'apc-theme'),
        'section'  => 'apc_cta_section',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('cta_form_title', array(
        'default' => 'Partner with APC today',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('cta_form_title', array(
        'label'    => __('CTA Form Title', 'apc-theme'),
        'section'  => 'apc_cta_section',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'apc_theme_customize_register_additional');


/**
 * Register Custom Blocks
 */
function apc_register_blocks() {
    // Include block rendering functions
    require_once get_template_directory() . '/blocks/tailored-solutions/block.php';
    require_once get_template_directory() . '/blocks/it-challenges/block.php';
    require_once get_template_directory() . '/blocks/trusted-partners/block.php';
    
    // Register Tailored Solutions block
    register_block_type(get_template_directory() . '/blocks/tailored-solutions/block.json', array(
        'render_callback' => 'apc_render_tailored_solutions_block'
    ));
    
    // Register IT Challenges block
    register_block_type(get_template_directory() . '/blocks/it-challenges/block.json', array(
        'render_callback' => 'apc_render_it_challenges_block'
    ));
    
    // Register Trusted Partners block
    register_block_type(get_template_directory() . '/blocks/trusted-partners/block.json', array(
        'render_callback' => 'apc_render_trusted_partners_block'
    ));
}
add_action('init', 'apc_register_blocks');

/**
 * Add Block Shortcodes
 */
function apc_tailored_solutions_shortcode($atts) {
    $attributes = shortcode_atts(array(
        'title' => 'Tailored solutions, for every problem',
        'description' => 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.',
        'max_services' => 8
    ), $atts);
    
    return apc_render_tailored_solutions_block(array(
        'title' => $attributes['title'],
        'description' => $attributes['description'],
        'maxServices' => (int) $attributes['max_services']
    ));
}
add_shortcode('tailored_solutions', 'apc_tailored_solutions_shortcode');

function apc_it_challenges_shortcode($atts) {
    $attributes = shortcode_atts(array(
        'title' => 'Solving IT Challenges in every industry, every day.',
        'description' => 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'
    ), $atts);
    
    return apc_render_it_challenges_block(array(
        'title' => $attributes['title'],
        'description' => $attributes['description'],
        'challenges' => array() // Use default challenges
    ));
}
add_shortcode('it_challenges', 'apc_it_challenges_shortcode');

function apc_trusted_partners_shortcode($atts) {
    $attributes = shortcode_atts(array(
        'title' => 'Trusted partners',
        'subtitle' => 'Working with the best'
    ), $atts);
    
    return apc_render_trusted_partners_block(array(
        'title' => $attributes['title'],
        'subtitle' => $attributes['subtitle'],
        'backgroundImage' => '',
        'partners' => array() // Use default partners
    ));
}
add_shortcode('trusted_partners', 'apc_trusted_partners_shortcode');

/**
 * Add custom block category
 */
function apc_block_categories($categories, $post) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'apc-blocks',
                'title' => __('APC Blocks', 'apc-theme'),
                'icon' => 'admin-tools',
            ),
        )
    );
}
add_filter('block_categories_all', 'apc_block_categories', 10, 2);

/**
 * Enqueue Block Editor Assets
 */
function apc_enqueue_block_editor_assets() {
    // Tailored Solutions editor script
    wp_enqueue_script(
        'apc-tailored-solutions-block',
        get_template_directory_uri() . '/blocks/tailored-solutions/block.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        '1.0.0'
    );
    
    // IT Challenges editor script
    wp_enqueue_script(
        'apc-it-challenges-block',
        get_template_directory_uri() . '/blocks/it-challenges/block.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        '1.0.0'
    );
    
    // Trusted Partners editor script
    wp_enqueue_script(
        'apc-trusted-partners-block',
        get_template_directory_uri() . '/blocks/trusted-partners/block.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        '1.0.0'
    );
}
add_action('enqueue_block_editor_assets', 'apc_enqueue_block_editor_assets');

/**
 * Enqueue Frontend Block Assets
 */
function apc_enqueue_block_assets() {
    // Tailored Solutions styles
    wp_enqueue_style(
        'apc-tailored-solutions-style',
        get_template_directory_uri() . '/blocks/tailored-solutions/style.css',
        array(),
        '1.0.0'
    );
    
    // IT Challenges styles
    wp_enqueue_style(
        'apc-it-challenges-style',
        get_template_directory_uri() . '/blocks/it-challenges/style.css',
        array(),
        '1.0.0'
    );
    
    // Trusted Partners styles
    wp_enqueue_style(
        'apc-trusted-partners-style',
        get_template_directory_uri() . '/blocks/trusted-partners/style.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'apc_enqueue_block_assets');

/**
 * Clean up old service icon color meta data (run once)
 * This function can be called manually if needed to clean existing data
 */
function apc_cleanup_service_icon_colors() {
    $services = get_posts(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));
    
    foreach ($services as $service) {
        delete_post_meta($service->ID, '_service_icon_color');
    }
    
    wp_send_json_success('Service icon colors cleaned up successfully.');
}

// Uncomment the line below to run the cleanup once, then comment it back
// add_action('wp_ajax_apc_cleanup_colors', 'apc_cleanup_service_icon_colors');
?>