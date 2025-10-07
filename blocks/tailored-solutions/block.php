<?php
/**
 * Tailored Solutions Block - Server-side rendering
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Tailored Solutions Block
 */
function apc_render_tailored_solutions_block($attributes) {
    $title = $attributes['title'] ?? 'Tailored solutions, for every problem';
    $description = $attributes['description'] ?? 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.';
    $max_services = $attributes['maxServices'] ?? 8;
    
    // Query services from custom post type
    $services_query = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => $max_services,
        'post_status' => 'publish',
        'orderby' => 'menu_order title',
        'order' => 'ASC'
    ));
    
    ob_start();
    ?>
    <div class="tailored-solutions-block">
        
        <div class="tailored-solutions-container">
            <div class="tailored-content">
                <div class="tailored-text">
                    <h3><?php echo esc_html($title); ?></h3>
                    <p><?php echo esc_html($description); ?></p>
                </div>
                <div class="services-list">
                    <?php
                    if ($services_query->have_posts()) :
                        while ($services_query->have_posts()) : $services_query->the_post();
                            $service_icon = get_post_meta(get_the_ID(), '_service_icon', true);
                            $service_url = get_post_meta(get_the_ID(), '_service_url', true);
                            
                            // Default icon if none set
                            if (empty($service_icon)) {
                                $service_icon = 'fa-solid fa-cog';
                            }
                            
                            // Use service URL if set, otherwise link to service post
                            $link_url = !empty($service_url) ? $service_url : get_permalink();
                            ?>
                            <a href="<?php echo esc_url($link_url); ?>" class="service-item">
                                <span class="service-text"><?php the_title(); ?></span>
                                <i class="<?php echo esc_attr($service_icon); ?>"></i>
                            </a>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback services if no custom services exist
                        $fallback_services = array(
                            array('title' => 'IT Support & Helpdesk', 'icon' => 'fa-solid fa-headset'),
                            array('title' => 'Cloud Infrastructure', 'icon' => 'fa-solid fa-cloud'),
                            array('title' => 'Cyber Security', 'icon' => 'fa-solid fa-shield-halved'),
                            array('title' => 'Network Connectivity', 'icon' => 'fa-solid fa-network-wired'),
                            array('title' => 'Managed Contracts', 'icon' => 'fa-solid fa-file-contract'),
                            array('title' => 'Data Backup & Recovery', 'icon' => 'fa-solid fa-database'),
                            array('title' => 'Software Solutions', 'icon' => 'fa-solid fa-laptop-code'),
                            array('title' => 'Hardware Management', 'icon' => 'fa-solid fa-server')
                        );
                        
                        foreach (array_slice($fallback_services, 0, $max_services) as $service) :
                            ?>
                            <a href="#" class="service-item">
                                <span class="service-text"><?php echo esc_html($service['title']); ?></span>
                                <i class="<?php echo esc_attr($service['icon']); ?>"></i>
                            </a>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}