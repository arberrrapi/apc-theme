<?php
/**
 * Shortcodes and Widgets
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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
        $service_short_description = get_post_meta(get_the_ID(), '_service_short_description', true);
        $service_url = get_post_meta(get_the_ID(), '_service_url', true);
        
        $output .= '<div class="service-item">';
        
        // Icon
        if ($atts['show_icon'] === 'true' && $service_icon) {
            $output .= '<div class="service-icon">';
            $output .= '<i class="' . esc_attr($service_icon) . '"></i>';
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
 * Block Shortcodes
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
                $service_short_description = get_post_meta(get_the_ID(), '_service_short_description', true);
                
                echo '<div class="widget-service-item">';
                
                if ($show_icons && $service_icon) {
                    echo '<div class="widget-service-icon">';
                    echo '<i class="' . esc_attr($service_icon) . '"></i>';
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