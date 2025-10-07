<?php
/**
 * The front page template file
 * 
 * This template is used when WordPress is set to use a static front page.
 */

get_header(); ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-icons-container">
                <!-- Cloud Solutions Icons -->
                <div class="hero-icons cloud-icons">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon1.png" alt="Cloud Icon 1" class="hero-icon icon-top-left" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon2.png" alt="Cloud Icon 2" class="hero-icon icon-top-right" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon3.png" alt="Cloud Icon 3" class="hero-icon icon-bottom-left" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon4.png" alt="Cloud Icon 4" class="hero-icon icon-bottom-right" />
                </div>

                <!-- Performance Icons -->
                <div class="hero-icons performance-icons">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/performance/icon1.png" alt="Performance Icon 1" class="hero-icon icon-top-right" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/performance/icon2.png" alt="Performance Icon 2" class="hero-icon icon-bottom-left" />
                </div>

                <!-- Processes Icons -->
                <div class="hero-icons processes-icons">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/processes/icon1.png" alt="Processes Icon 1" class="hero-icon icon-top-left" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/processes/icon2.png" alt="Processes Icon 2" class="hero-icon icon-bottom-right" />
                </div>

                <!-- Enterprise Icons -->
                <div class="hero-icons enterprise-icons">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon1.png" alt="Enterprise Icon 1" class="hero-icon icon-top-left" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon2.png" alt="Enterprise Icon 2" class="hero-icon icon-top-right" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon3.png" alt="Enterprise Icon 3" class="hero-icon icon-bottom-left" />
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon4.png" alt="Enterprise Icon 4" class="hero-icon icon-bottom-right" />
                </div>
            </div>

            <div class="hero-text">
                <div class="hero-line"><?php echo get_theme_mod('hero_line_1', 'Using APC for'); ?></div>
                <div class="hero-highlight">
                    <div class="cube-container">
                        <div class="cube">
                            <div class="cube-face"><?php echo get_theme_mod('hero_cube_1', 'cloud solutions'); ?></div>
                            <div class="cube-face"><?php echo get_theme_mod('hero_cube_2', 'improved performance'); ?></div>
                            <div class="cube-face"><?php echo get_theme_mod('hero_cube_3', 'optimizing processes'); ?></div>
                            <div class="cube-face"><?php echo get_theme_mod('hero_cube_4', 'enterprise-grade security'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="hero-line"><?php echo get_theme_mod('hero_line_2', 'in your business'); ?></div>
            </div>
        </div>
    </section>

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
    <?php echo do_blocks('<!-- wp:apc/cta --><!-- /wp:apc/cta -->'); ?>

<?php get_footer(); ?>