<?php
/**
 * Custom Post Types for APC Theme
 * 
 * @package APC_Theme
 */

/**
 * Register Custom Post Types
 */
function apc_register_custom_post_types() {
    
    // Article Post Type
    register_post_type('article', array(
        'labels' => array(
            'name' => __('Articles', 'apc-theme'),
            'singular_name' => __('Article', 'apc-theme'),
            'add_new' => __('Add New Article', 'apc-theme'),
            'add_new_item' => __('Add New Article', 'apc-theme'),
            'edit_item' => __('Edit Article', 'apc-theme'),
            'new_item' => __('New Article', 'apc-theme'),
            'view_item' => __('View Article', 'apc-theme'),
            'search_items' => __('Search Articles', 'apc-theme'),
            'not_found' => __('No articles found', 'apc-theme'),
            'not_found_in_trash' => __('No articles found in trash', 'apc-theme')
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments'),
        'rewrite' => array('slug' => 'articles')
    ));
    
    // Customer Success Post Type
    register_post_type('customer_success', array(
        'labels' => array(
            'name' => __('Customer Success Stories', 'apc-theme'),
            'singular_name' => __('Customer Success Story', 'apc-theme'),
            'add_new' => __('Add New Story', 'apc-theme'),
            'add_new_item' => __('Add New Customer Success Story', 'apc-theme'),
            'edit_item' => __('Edit Customer Success Story', 'apc-theme'),
            'new_item' => __('New Customer Success Story', 'apc-theme'),
            'view_item' => __('View Customer Success Story', 'apc-theme'),
            'search_items' => __('Search Customer Success Stories', 'apc-theme'),
            'not_found' => __('No customer success stories found', 'apc-theme'),
            'not_found_in_trash' => __('No customer success stories found in trash', 'apc-theme')
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author'),
        'rewrite' => array('slug' => 'customer-success')
    ));
    
    // Video Post Type
    register_post_type('video', array(
        'labels' => array(
            'name' => __('Videos', 'apc-theme'),
            'singular_name' => __('Video', 'apc-theme'),
            'add_new' => __('Add New Video', 'apc-theme'),
            'add_new_item' => __('Add New Video', 'apc-theme'),
            'edit_item' => __('Edit Video', 'apc-theme'),
            'new_item' => __('New Video', 'apc-theme'),
            'view_item' => __('View Video', 'apc-theme'),
            'search_items' => __('Search Videos', 'apc-theme'),
            'not_found' => __('No videos found', 'apc-theme'),
            'not_found_in_trash' => __('No videos found in trash', 'apc-theme')
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author'),
        'rewrite' => array('slug' => 'videos')
    ));
    
    // Whitepaper Post Type
    register_post_type('whitepaper', array(
        'labels' => array(
            'name' => __('Whitepapers', 'apc-theme'),
            'singular_name' => __('Whitepaper', 'apc-theme'),
            'add_new' => __('Add New Whitepaper', 'apc-theme'),
            'add_new_item' => __('Add New Whitepaper', 'apc-theme'),
            'edit_item' => __('Edit Whitepaper', 'apc-theme'),
            'new_item' => __('New Whitepaper', 'apc-theme'),
            'view_item' => __('View Whitepaper', 'apc-theme'),
            'search_items' => __('Search Whitepapers', 'apc-theme'),
            'not_found' => __('No whitepapers found', 'apc-theme'),
            'not_found_in_trash' => __('No whitepapers found in trash', 'apc-theme')
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-media-text',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author'),
        'rewrite' => array('slug' => 'whitepapers')
    ));
}
add_action('init', 'apc_register_custom_post_types');

/**
 * Add custom meta boxes for video and whitepaper post types
 */
function apc_add_content_meta_boxes() {
    // Video URL meta box
    add_meta_box(
        'video_url',
        __('Video URL', 'apc-theme'),
        'apc_video_url_callback',
        'video',
        'normal',
        'high'
    );
    
    // Whitepaper download meta box
    add_meta_box(
        'whitepaper_file',
        __('Whitepaper File', 'apc-theme'),
        'apc_whitepaper_file_callback',
        'whitepaper',
        'normal',
        'high'
    );
    
    // Customer success meta box
    add_meta_box(
        'customer_info',
        __('Customer Information', 'apc-theme'),
        'apc_customer_info_callback',
        'customer_success',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apc_add_content_meta_boxes');

/**
 * Video URL meta box callback
 */
function apc_video_url_callback($post) {
    wp_nonce_field('apc_video_nonce', 'apc_video_nonce_field');
    $video_url = get_post_meta($post->ID, '_video_url', true);
    $video_duration = get_post_meta($post->ID, '_video_duration', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="video_url"><?php _e('Video URL', 'apc-theme'); ?></label></th>
            <td>
                <input type="url" id="video_url" name="video_url" value="<?php echo esc_attr($video_url); ?>" class="regular-text" />
                <p class="description"><?php _e('Enter YouTube, Vimeo, or direct video URL', 'apc-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="video_duration"><?php _e('Duration', 'apc-theme'); ?></label></th>
            <td>
                <input type="text" id="video_duration" name="video_duration" value="<?php echo esc_attr($video_duration); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., 5:30 or 10 minutes', 'apc-theme'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Whitepaper file meta box callback
 */
function apc_whitepaper_file_callback($post) {
    wp_nonce_field('apc_whitepaper_nonce', 'apc_whitepaper_nonce_field');
    $file_url = get_post_meta($post->ID, '_whitepaper_file', true);
    $file_size = get_post_meta($post->ID, '_whitepaper_size', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="whitepaper_file"><?php _e('Download File URL', 'apc-theme'); ?></label></th>
            <td>
                <input type="url" id="whitepaper_file" name="whitepaper_file" value="<?php echo esc_attr($file_url); ?>" class="regular-text" />
                <button type="button" class="button" onclick="openMediaUploader()"><?php _e('Upload File', 'apc-theme'); ?></button>
                <p class="description"><?php _e('Upload or enter URL for the whitepaper PDF', 'apc-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="whitepaper_size"><?php _e('File Size', 'apc-theme'); ?></label></th>
            <td>
                <input type="text" id="whitepaper_size" name="whitepaper_size" value="<?php echo esc_attr($file_size); ?>" class="regular-text" />
                <p class="description"><?php _e('e.g., 2.5 MB', 'apc-theme'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Customer info meta box callback
 */
function apc_customer_info_callback($post) {
    wp_nonce_field('apc_customer_nonce', 'apc_customer_nonce_field');
    $company_name = get_post_meta($post->ID, '_customer_company', true);
    $industry = get_post_meta($post->ID, '_customer_industry', true);
    $logo_url = get_post_meta($post->ID, '_customer_logo', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="customer_company"><?php _e('Company Name', 'apc-theme'); ?></label></th>
            <td>
                <input type="text" id="customer_company" name="customer_company" value="<?php echo esc_attr($company_name); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="customer_industry"><?php _e('Industry', 'apc-theme'); ?></label></th>
            <td>
                <input type="text" id="customer_industry" name="customer_industry" value="<?php echo esc_attr($industry); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="customer_logo"><?php _e('Company Logo', 'apc-theme'); ?></label></th>
            <td>
                <input type="url" id="customer_logo" name="customer_logo" value="<?php echo esc_attr($logo_url); ?>" class="regular-text" />
                <button type="button" class="button" onclick="openMediaUploader('customer_logo')"><?php _e('Upload Logo', 'apc-theme'); ?></button>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function apc_save_content_meta_boxes($post_id) {
    // Video meta
    if (isset($_POST['apc_video_nonce_field']) && wp_verify_nonce($_POST['apc_video_nonce_field'], 'apc_video_nonce')) {
        if (isset($_POST['video_url'])) {
            update_post_meta($post_id, '_video_url', sanitize_url($_POST['video_url']));
        }
        if (isset($_POST['video_duration'])) {
            update_post_meta($post_id, '_video_duration', sanitize_text_field($_POST['video_duration']));
        }
    }
    
    // Whitepaper meta
    if (isset($_POST['apc_whitepaper_nonce_field']) && wp_verify_nonce($_POST['apc_whitepaper_nonce_field'], 'apc_whitepaper_nonce')) {
        if (isset($_POST['whitepaper_file'])) {
            update_post_meta($post_id, '_whitepaper_file', sanitize_url($_POST['whitepaper_file']));
        }
        if (isset($_POST['whitepaper_size'])) {
            update_post_meta($post_id, '_whitepaper_size', sanitize_text_field($_POST['whitepaper_size']));
        }
    }
    
    // Customer success meta
    if (isset($_POST['apc_customer_nonce_field']) && wp_verify_nonce($_POST['apc_customer_nonce_field'], 'apc_customer_nonce')) {
        if (isset($_POST['customer_company'])) {
            update_post_meta($post_id, '_customer_company', sanitize_text_field($_POST['customer_company']));
        }
        if (isset($_POST['customer_industry'])) {
            update_post_meta($post_id, '_customer_industry', sanitize_text_field($_POST['customer_industry']));
        }
        if (isset($_POST['customer_logo'])) {
            update_post_meta($post_id, '_customer_logo', sanitize_url($_POST['customer_logo']));
        }
    }
}
add_action('save_post', 'apc_save_content_meta_boxes');

/**
 * Flush rewrite rules on theme activation for content post types
 */
function apc_flush_content_rewrite_rules() {
    apc_register_custom_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'apc_flush_content_rewrite_rules');