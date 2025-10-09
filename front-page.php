<?php
/**
 * The front page template file
 * 
 * This template is used when WordPress is set to use a static front page.
 */

get_header(); ?>

    <!-- Hero Section Block -->
    <?php 
    echo apc_render_hero_block(array(
        'heroLine1' => get_theme_mod('hero_line_1', 'Using APC for'),
        'heroLine2' => get_theme_mod('hero_line_2', 'in your business'),
        'cubeText1' => get_theme_mod('hero_cube_1', 'cloud solutions'),
        'cubeText2' => get_theme_mod('hero_cube_2', 'improved performance'), 
        'cubeText3' => get_theme_mod('hero_cube_3', 'optimizing processes'),
        'cubeText4' => get_theme_mod('hero_cube_4', 'enterprise-grade security')
    )); 
    ?>

    <!-- What We Do Section -->
    <section class="what-we-do">
        <div class="what-we-do-container">
            <div class="what-we-do-content">
                <div class="what-we-do-text">
                    <div class="section-label"><?php echo get_theme_mod('what_we_do_label', 'What we do'); ?></div>
                    <h2 class="section-title"><?php echo get_theme_mod('what_we_do_title', 'Complexity, Simplified and Secured'); ?></h2>
                </div>
                <div class="what-we-do-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/site/what_we_do.png" alt="What We Do" />
                </div>
            </div>
        </div>
    </section>

    <section class="what-we-do-info">
        <div class="what-we-do-info-container">
            <div class="info-column">
                <div class="info-card">
                    <i class="fa-solid fa-users"></i>
                    <div class="info-content">
                        <h4><?php echo get_theme_mod('info_card_1_title', 'Expert Team'); ?></h4>
                        <p><?php echo get_theme_mod('info_card_1_text', 'Our experienced professionals deliver exceptional results with cutting-edge technology solutions.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="info-column">
                <div class="info-card">
                    <i class="fa-solid fa-shield-halved"></i>
                    <div class="info-content">
                        <h4><?php echo get_theme_mod('info_card_2_title', 'Secure Solutions'); ?></h4>
                        <p><?php echo get_theme_mod('info_card_2_text', 'Enterprise-grade security measures ensure your data and systems remain protected at all times.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="info-column">
                <div class="info-card">
                    <i class="fa-solid fa-rocket"></i>
                    <div class="info-content">
                        <h4><?php echo get_theme_mod('info_card_3_title', 'Fast Implementation'); ?></h4>
                        <p><?php echo get_theme_mod('info_card_3_text', 'Rapid deployment and seamless integration to get your business up and running quickly.'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tailored Solutions Section - Dynamic Block -->
    <?php 
    echo apc_render_tailored_solutions_block(array(
        'title' => get_theme_mod('tailored_title', 'Tailored solutions, for every problem'),
        'description' => get_theme_mod('tailored_description', 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'),
        'maxServices' => 8
    )); 
    ?>

    <!-- IT Challenges Section - Dynamic Block -->
    <?php 
    echo apc_render_it_challenges_block(array(
        'title' => get_theme_mod('challenges_title', 'Solving IT Challenges in every industry, every day.'),
        'description' => get_theme_mod('challenges_description', 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'),
        'challenges' => array() // Use default challenges
    )); 
    ?>

    <!-- Trusted Partners Section - Dynamic Block -->
    <?php 
    echo apc_render_trusted_partners_block(array(
        'title' => get_theme_mod('partners_title', 'Trusted partners'),
        'subtitle' => get_theme_mod('partners_subtitle', 'Working with the best'),
        'backgroundImage' => '',
        'partners' => array() // Use default partners
    )); 
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