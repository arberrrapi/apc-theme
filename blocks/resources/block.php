<?php
/**
 * Resources Block Render
 * 
 * @param array $attributes Block attributes
 * @param string $content Block content
 * @return string
 */

function apc_render_resources_block($attributes, $content = '') {
    // Extract attributes with defaults
    $title = isset($attributes['title']) ? $attributes['title'] : 'Latest Resources';
    $posts_per_page = isset($attributes['postsPerPage']) ? $attributes['postsPerPage'] : 4;
    $show_controls = isset($attributes['showControls']) ? $attributes['showControls'] : true;
    $post_type = isset($attributes['postType']) ? $attributes['postType'] : 'post';
    
    ob_start();
    ?>
    <div class="wp-block-apc-resources">
        <div class="resources-container">
            <div class="resources-header">
                <h2><?php echo esc_html($title); ?></h2>
                <?php if ($show_controls) : ?>
                <div class="resources-controls">
                    <button class="resource-arrow resource-prev" onclick="previousResource()">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button class="resource-arrow resource-next" onclick="nextResource()">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="resources-slider">
                <div class="resources-track">
                    <?php
                    // Query for posts based on selected post type
                    $resource_posts = new WP_Query(array(
                        'posts_per_page' => $posts_per_page,
                        'post_status' => 'publish',
                        'post_type' => $post_type
                    ));

                    if ($resource_posts->have_posts()) :
                        while ($resource_posts->have_posts()) : $resource_posts->the_post();
                    ?>
                    <div class="resource-card" data-href="<?php the_permalink(); ?>" onclick="window.location.href='<?php the_permalink(); ?>'">
                        <div class="resource-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/site/resource.jpg" alt="<?php the_title(); ?>" />
                            <?php endif; ?>
                        </div>
                        <div class="resource-tags">
                            <?php
                            if ($post_type === 'qa') {
                                // For Q&A posts, show categories
                                $categories = get_the_terms(get_the_ID(), 'qa_category');
                                if ($categories && !is_wp_error($categories)) {
                                    foreach ($categories as $category) {
                                        echo '<a href="' . get_term_link($category) . '" class="resource-tag">' . esc_html($category->name) . '</a>';
                                    }
                                }
                            } else {
                                // For regular posts, show categories
                                $categories = get_the_category();
                                if ($categories) {
                                    foreach ($categories as $category) {
                                        echo '<a href="' . get_category_link($category->term_id) . '" class="resource-tag">' . esc_html($category->name) . '</a>';
                                    }
                                }
                            }
                            ?>
                        </div>
                        <h4><?php the_title(); ?></h4>
                    </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Fallback content if no posts exist
                        $fallback_resources = get_fallback_resources();
                        foreach ($fallback_resources as $resource) :
                    ?>
                    <div class="resource-card" data-href="<?php echo esc_url($resource['link']); ?>">
                        <div class="resource-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/site/resource.jpg" alt="<?php echo esc_attr($resource['title']); ?>" />
                        </div>
                        <div class="resource-tags">
                            <?php foreach ($resource['tags'] as $tag) : ?>
                                <span class="resource-tag"><?php echo esc_html($tag); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <h4><?php echo esc_html($resource['title']); ?></h4>
                    </div>
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

/**
 * Get fallback resources when no posts exist
 * 
 * @return array Array of fallback resources
 */
function get_fallback_resources() {
    return array(
        array(
            'title' => 'Essential Cloud Security Strategies for Modern Businesses',
            'tags' => array('Cloud Security', 'Best Practices'),
            'link' => '#cloud-security'
        ),
        array(
            'title' => 'How to Choose the Right IT Support Partner for Your Business',
            'tags' => array('IT Support', 'Guide'),
            'link' => '#it-support'
        ),
        array(
            'title' => '2024 Cybersecurity Trends Every Business Should Know',
            'tags' => array('Cybersecurity', 'Trends'),
            'link' => '#cybersecurity'
        ),
        array(
            'title' => 'Complete Guide to Digital Transformation for SMBs',
            'tags' => array('Digital Transformation'),
            'link' => '#digital-transformation'
        )
    );
}
?>