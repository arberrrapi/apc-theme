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
    wp_enqueue_style('apc-theme-style', get_stylesheet_uri(), array(), '1.0.2');
    
    // Enqueue Font Awesome Kit
    wp_enqueue_script('font-awesome-kit', 'https://kit.fontawesome.com/1ce2aca7bc.js', array(), null, false);
    wp_script_add_data('font-awesome-kit', 'crossorigin', 'anonymous');
    
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
 * Enqueue Hero Block Assets
 */
function apc_enqueue_hero_block_assets() {
    // Always load on front page, or if block is detected
    if (is_front_page() || (has_blocks() && has_block('apc/hero'))) {
        wp_enqueue_style(
            'apc-hero-style',
            get_template_directory_uri() . '/blocks/hero/style.css',
            array(),
            '1.0.1'
        );
        
        wp_enqueue_script(
            'apc-hero-script',
            get_template_directory_uri() . '/blocks/hero/hero.js',
            array(),
            '1.0.1',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'apc_enqueue_hero_block_assets');

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
require_once get_template_directory() . '/inc/qa-post-type.php';
require_once get_template_directory() . '/inc/sectors-post-type.php';
require_once get_template_directory() . '/inc/class-smileback-api.php';
require_once get_template_directory() . '/inc/smileback-settings.php';
require_once get_template_directory() . '/debug-smileback.php';

/**
 * Enqueue search autocomplete scripts
 */
function apc_enqueue_search_scripts() {
    wp_enqueue_script('jquery');
    
    wp_enqueue_script(
        'apc-search-autocomplete',
        get_template_directory_uri() . '/assets/js/search-autocomplete.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/search-autocomplete.js'),
        true
    );
    
    wp_localize_script('apc-search-autocomplete', 'apcSearch', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('apc_search_nonce'),
        'searchUrl' => home_url('/')
    ));
    
    // Enqueue blog filters script only on blog pages
    if (is_home() || is_category() || is_tag()) {
        wp_enqueue_script(
            'apc-blog-filters',
            get_template_directory_uri() . '/assets/js/blog-filters.js',
            array('jquery'),
            filemtime(get_template_directory() . '/assets/js/blog-filters.js'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'apc_enqueue_search_scripts');

/**
 * AJAX handler for search autocomplete
 */
function apc_ajax_search_posts() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'apc_search_nonce')) {
        wp_die('Security check failed');
    }
    
    $query = sanitize_text_field($_POST['query']);
    
    if (empty($query) || strlen($query) < 2) {
        wp_send_json_error('Query too short');
    }
    
    // Search posts by title only using direct query
    global $wpdb;
    
    $search_term = esc_sql($wpdb->esc_like($query));
    
    $sql = $wpdb->prepare("
        SELECT ID, post_title 
        FROM {$wpdb->posts} 
        WHERE post_type = 'post' 
        AND post_status = 'publish' 
        AND post_title LIKE %s 
        ORDER BY post_title ASC 
        LIMIT 8
    ", "%{$search_term}%");
    
    $posts = $wpdb->get_results($sql);
    $results = array();
    
    if ($posts) {
        foreach ($posts as $post) {
            // Highlight search term in title only
            $title = $post->post_title;
            $title = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $title);
            
            $results[] = array(
                'title' => $title,
                'url' => get_permalink($post->ID)
            );
        }
    }
    
    wp_send_json_success($results);
}
add_action('wp_ajax_apc_search_posts', 'apc_ajax_search_posts');
add_action('wp_ajax_nopriv_apc_search_posts', 'apc_ajax_search_posts');

/**
 * Temporary: Register simple Q&A test block
 */
function apc_register_simple_qa_block() {
    wp_enqueue_script(
        'apc-qa-simple-block',
        get_template_directory_uri() . '/blocks/qa-display/block-simple.js',
        array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'),
        filemtime(get_template_directory() . '/blocks/qa-display/block-simple.js')
    );
}
add_action('enqueue_block_editor_assets', 'apc_register_simple_qa_block');

/**
 * Add APC custom block category
 */
function apc_add_block_categories($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'apc-blocks',
                'title' => __('APC Blocks', 'apc-theme'),
            ),
        )
    );
}
add_filter('block_categories_all', 'apc_add_block_categories', 10, 2);

/**
 * Register Featured About Hero block
 */
function apc_register_featured_about_hero_block() {
    wp_enqueue_script(
        'apc-featured-about-hero-block',
        get_template_directory_uri() . '/blocks/featured-about-hero/index.js',
        array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'),
        filemtime(get_template_directory() . '/blocks/featured-about-hero/index.js')
    );
    
    wp_enqueue_style(
        'apc-featured-about-hero-style',
        get_template_directory_uri() . '/blocks/featured-about-hero/style.css',
        array(),
        filemtime(get_template_directory() . '/blocks/featured-about-hero/style.css')
    );
}
add_action('enqueue_block_editor_assets', 'apc_register_featured_about_hero_block');

/**
 * Register the block type with render callback
 */
function apc_register_featured_about_hero_block_type() {
    register_block_type('apc-theme/featured-about-hero', array(
        'render_callback' => function($attributes) {
            ob_start();
            include get_template_directory() . '/blocks/featured-about-hero/render.php';
            return ob_get_clean();
        }
    ));
}
add_action('init', 'apc_register_featured_about_hero_block_type');

/**
 * Enqueue frontend styles for Featured About Hero block
 */
function apc_enqueue_featured_about_hero_frontend_assets() {
    wp_enqueue_style(
        'apc-featured-about-hero-frontend',
        get_template_directory_uri() . '/blocks/featured-about-hero/style.css',
        array(),
        filemtime(get_template_directory() . '/blocks/featured-about-hero/style.css')
    );
}
add_action('wp_enqueue_scripts', 'apc_enqueue_featured_about_hero_frontend_assets');

/**
 * Register Our Team block editor assets
 */
function apc_register_our_team_block() {
    wp_enqueue_script(
        'apc-our-team-script',
        get_template_directory_uri() . '/blocks/our-team/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        filemtime(get_template_directory() . '/blocks/our-team/index.js'),
        true
    );

    wp_enqueue_style(
        'apc-our-team-style',
        get_template_directory_uri() . '/blocks/our-team/style.css',
        array(),
        filemtime(get_template_directory() . '/blocks/our-team/style.css')
    );
}
add_action('enqueue_block_editor_assets', 'apc_register_our_team_block');

/**
 * Register the Our Team block type with render callback
 */
function apc_register_our_team_block_type() {
    register_block_type('apc-theme/our-team', array(
        'render_callback' => function($attributes) {
            ob_start();
            include get_template_directory() . '/blocks/our-team/render.php';
            return ob_get_clean();
        }
    ));
}
add_action('init', 'apc_register_our_team_block_type');

/**
 * Enqueue frontend styles for Our Team block
 */
function apc_enqueue_our_team_frontend_assets() {
    wp_enqueue_style(
        'apc-our-team-frontend',
        get_template_directory_uri() . '/blocks/our-team/style.css',
        array(),
        filemtime(get_template_directory() . '/blocks/our-team/style.css')
    );
}
add_action('wp_enqueue_scripts', 'apc_enqueue_our_team_frontend_assets');

/**
 * Smileback Auto-Refresh Cron
 */

// Schedule automatic refresh
add_action('init', 'smileback_schedule_refresh');
function smileback_schedule_refresh() {
    if (!wp_next_scheduled('smileback_auto_refresh')) {
        $interval = get_option('smileback_refresh_interval', 21600);
        wp_schedule_event(time(), 'smileback_interval', 'smileback_auto_refresh');
    }
}

// Add custom cron schedule
add_filter('cron_schedules', 'smileback_cron_schedules');
function smileback_cron_schedules($schedules) {
    $interval = get_option('smileback_refresh_interval', 21600);
    $schedules['smileback_interval'] = array(
        'interval' => $interval,
        'display' => __('Smileback Refresh Interval')
    );
    return $schedules;
}

// Auto-refresh action
add_action('smileback_auto_refresh', 'smileback_do_auto_refresh');
function smileback_do_auto_refresh() {
    delete_transient('smileback_reviews_data');
    delete_transient('smileback_access_token');
    
    if (class_exists('Smileback_API')) {
        $api = new Smileback_API();
        $api->get_reviews(); // This will refresh cache
    }
}

/**
 * Modify posts per page for blog page
 */
function apc_modify_blog_posts_per_page($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_home()) {
            $query->set('posts_per_page', 12);
        }
    }
}
add_action('pre_get_posts', 'apc_modify_blog_posts_per_page');

/**
 * Adds a '/resources/' prefix to the URLs of default posts.
 */
function add_resources_prefix_to_posts($permalink, $post) {
    // Check if the post type is 'post' before adding the prefix.
    if ('post' === $post->post_type) {
        // Replace the site URL with the site URL + /resources/
        $permalink = home_url('/resources' . '/' . basename($permalink) . '/');
    }
    return $permalink;
}
add_filter('post_link', 'add_resources_prefix_to_posts', 10, 2);

/**
 * Tells WordPress how to understand the new URL structure.
 */
function add_resources_rewrite_rule() {
    // Matches 'resources/any-post-slug' and directs it to the correct post.
    add_rewrite_rule(
        'resources/([^/]+)/?$',
        'index.php?name=$matches[1]',
        'top'
    );
}
add_action('init', 'add_resources_rewrite_rule');