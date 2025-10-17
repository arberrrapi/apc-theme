<?php
/**
 * Blocks and Customizer Settings
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Blocks
 */
function apc_register_blocks() {
    // Include block rendering functions
    require_once get_template_directory() . '/blocks/hero/block.php';
    require_once get_template_directory() . '/blocks/tailored-solutions/block.php';
    require_once get_template_directory() . '/blocks/it-challenges/block.php';
    require_once get_template_directory() . '/blocks/trusted-partners/block.php';
    require_once get_template_directory() . '/blocks/apc-button/block.php';
    require_once get_template_directory() . '/blocks/featured-item/block.php';
    require_once get_template_directory() . '/blocks/counters/block.php';
    require_once get_template_directory() . '/blocks/featured-listing/block.php';
    require_once get_template_directory() . '/blocks/switch-to-apc/block.php';
    require_once get_template_directory() . '/blocks/qa-display/block.php';
    require_once get_template_directory() . '/blocks/testimonials/block.php';
    require_once get_template_directory() . '/blocks/resources/block.php';
    require_once get_template_directory() . '/blocks/apc-cta/block.php';
    require_once get_template_directory() . '/blocks/apc-image/block.php';
    require_once get_template_directory() . '/blocks/apc-featured-content/block.php';
    require_once get_template_directory() . '/blocks/apc-feature-block/block.php';
    
    // Register Hero block
    register_block_type(get_template_directory() . '/blocks/hero', array(
        'render_callback' => 'apc_render_hero_block'
    ));
    
    // Register What We Do block
    register_block_type(get_template_directory() . '/blocks/what-we-do/block.json', array(
        'render_callback' => function($attributes, $content, $block) {
            ob_start();
            include get_template_directory() . '/blocks/what-we-do/render.php';
            return ob_get_clean();
        }
    ));
    
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
    
    // Register APC Button block
    register_block_type(get_template_directory() . '/blocks/apc-button/block.json', array(
        'render_callback' => 'apc_render_button_block'
    ));
    
    // Register Featured Item block
    register_block_type(get_template_directory() . '/blocks/featured-item/block.json', array(
        'render_callback' => 'apc_render_featured_item_block'
    ));
    
    // Register Counters block
    register_block_type(get_template_directory() . '/blocks/counters/block.json', array(
        'render_callback' => 'apc_render_counters_block'
    ));
    
    // Register Featured Listing block
    register_block_type(get_template_directory() . '/blocks/featured-listing/block.json', array(
        'render_callback' => 'apc_render_featured_listing_block'
    ));
    
    // Register Switch to APC block
    register_block_type(get_template_directory() . '/blocks/switch-to-apc/block.json', array(
        'render_callback' => 'apc_render_switch_to_apc_block'
    ));
    
    // Register Q&A Display block
    register_block_type(get_template_directory() . '/blocks/qa-display/block.json', array(
        'render_callback' => 'apc_render_qa_display_block'
    ));
    
    // Register Testimonials block
    register_block_type(get_template_directory() . '/blocks/testimonials/block.json', array(
        'render_callback' => 'render_testimonials_block'
    ));
    
    // Register Resources block
    register_block_type(get_template_directory() . '/blocks/resources/block.json', array(
        'render_callback' => 'apc_render_resources_block'
    ));
    
    // Register APC CTA block
    register_block_type(get_template_directory() . '/blocks/apc-cta/block.json', array(
        'render_callback' => 'apc_render_cta_block'
    ));
    
    // Register APC Image block
    register_block_type(get_template_directory() . '/blocks/apc-image/block.json', array(
        'render_callback' => 'apc_render_image_block'
    ));
    
    // Register APC Featured Content block
    register_block_type(get_template_directory() . '/blocks/apc-featured-content/block.json', array(
        'render_callback' => 'apc_render_featured_content_block'
    ));
    
    // Register APC Feature Block
    register_block_type(get_template_directory() . '/blocks/apc-feature-block/block.json', array(
        'render_callback' => 'apc_render_feature_block'
    ));
}
add_action('init', 'apc_register_blocks');

/**
 * Enqueue APC Image Block Scripts
 */
function apc_enqueue_image_block_scripts() {
    // Only enqueue if we have APC image blocks on the page
    if (has_block('apc/image')) {
        wp_enqueue_script(
            'apc-image-parallax',
            get_template_directory_uri() . '/blocks/apc-image/parallax.js',
            array(),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'apc_enqueue_image_block_scripts');

/**
 * Enqueue Gravity Forms data for block editor
 */
function apc_enqueue_gravity_forms_data() {
    if (is_admin() && class_exists('GFAPI')) {
        $forms = GFAPI::get_forms();
        $form_options = array(
            array('label' => __('Select a form', 'apc-theme'), 'value' => '')
        );
        
        foreach ($forms as $form) {
            $form_options[] = array(
                'label' => $form['title'] . ' (ID: ' . $form['id'] . ')',
                'value' => $form['id']
            );
        }
        
        wp_localize_script('wp-blocks', 'apcGravityForms', $form_options);
    }
}
add_action('enqueue_block_editor_assets', 'apc_enqueue_gravity_forms_data');

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
    $blocks = array('tailored-solutions', 'it-challenges', 'trusted-partners', 'apc-button', 'featured-item', 'counters', 'featured-listing', 'switch-to-apc', 'qa-display', 'testimonials', 'resources');
    
    foreach ($blocks as $block) {
        wp_enqueue_script(
            'apc-' . $block . '-block',
            get_template_directory_uri() . '/blocks/' . $block . '/block.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n', 'wp-api-fetch'),
            filemtime(get_template_directory() . '/blocks/' . $block . '/block.js')
        );
        
        // Enqueue editor styles if they exist
        $editor_css_path = get_template_directory() . '/blocks/' . $block . '/editor.css';
        if (file_exists($editor_css_path)) {
            wp_enqueue_style(
                'apc-' . $block . '-editor',
                get_template_directory_uri() . '/blocks/' . $block . '/editor.css',
                array(),
                '1.0.0'
            );
        }
    }
}
add_action('enqueue_block_editor_assets', 'apc_enqueue_block_editor_assets');

/**
 * Enqueue Frontend Block Assets
 */
function apc_enqueue_frontend_assets() {
    $blocks = array('tailored-solutions', 'it-challenges', 'trusted-partners', 'apc-button', 'featured-item', 'counters', 'featured-listing', 'switch-to-apc', 'qa-display', 'testimonials', 'resources');
    
    foreach ($blocks as $block) {
        wp_enqueue_style(
            'apc-' . $block . '-style',
            get_template_directory_uri() . '/blocks/' . $block . '/style.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'apc_enqueue_frontend_assets');

/**
 * Customizer Settings
 */
function apc_theme_customize_register($wp_customize) {
    // APC Theme Options Section
    $wp_customize->add_section('apc_theme_options', array(
        'title'    => __('APC Theme Options', 'apc-theme'),
        'priority' => 30,
    ));
    
    // Header CTA URLs
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
add_action('customize_register', 'apc_theme_customize_register');

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
            wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
            exit;
        } else {
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
            exit;
        }
    }
}
add_action('init', 'apc_handle_contact_form');

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