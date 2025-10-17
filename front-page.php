<?php
/**
 * The front page template file
 * 
 * This template is used when WordPress is set to use a static front page.
 */

get_header(); ?>

    <!-- Hero Section Block -->
    <?php 
    // Check if there's block content for this page
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content(); // This will render all blocks added in the backend
        }
    }
    
    ?>


    <!-- Testimonials Section - Dynamic Block -->
    <?php 
    echo render_testimonials_block(array(
        'title' => get_theme_mod('testimonials_title', 'What Our Clients Say'),
        'subtitle' => get_theme_mod('testimonials_subtitle', 'Real feedback from companies we serve'),
        'statsText' => get_theme_mod('testimonials_stats', 'Trusted by 500+ companies worldwide'),
        'autoSlide' => true,
        'slideInterval' => 20
    )); 
    ?>

    <!-- Resources Section - Dynamic Block -->
    <?php 
    echo apc_render_resources_block(array(
        'title' => get_theme_mod('resources_title', 'Latest Resources'),
        'postsPerPage' => 4,
        'showControls' => true,
        'postType' => 'post'
    )); 
    ?>

    <!-- APC CTA Section Block -->
    <?php echo do_blocks('<!-- wp:apc/cta {"useGravityForm":true,"gravityFormId":"4"} --><!-- /wp:apc/cta -->'); ?>

<?php get_footer(); ?>