<?php
/**
 * The main template file
 * 
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header(); ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-icons-container">
                <!-- Cloud Solutions Icons -->
                <div class="hero-icons cloud-icons">
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon1.png"
                        alt="Cloud Icon 1"
                        class="hero-icon icon-top-left"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon2.png"
                        alt="Cloud Icon 2"
                        class="hero-icon icon-top-right"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon3.png"
                        alt="Cloud Icon 3"
                        class="hero-icon icon-bottom-left"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/cloud/icon4.png"
                        alt="Cloud Icon 4"
                        class="hero-icon icon-bottom-right"
                    />
                </div>

                <!-- Performance Icons -->
                <div class="hero-icons performance-icons">
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/performance/icon1.png"
                        alt="Performance Icon 1"
                        class="hero-icon icon-top-right"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/performance/icon2.png"
                        alt="Performance Icon 2"
                        class="hero-icon icon-bottom-left"
                    />
                </div>

                <!-- Processes Icons -->
                <div class="hero-icons processes-icons">
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/processes/icon1.png"
                        alt="Processes Icon 1"
                        class="hero-icon icon-top-left"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/processes/icon2.png"
                        alt="Processes Icon 2"
                        class="hero-icon icon-bottom-right"
                    />
                </div>

                <!-- Enterprise Icons -->
                <div class="hero-icons enterprise-icons">
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon1.png"
                        alt="Enterprise Icon 1"
                        class="hero-icon icon-top-left"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon2.png"
                        alt="Enterprise Icon 2"
                        class="hero-icon icon-top-right"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon3.png"
                        alt="Enterprise Icon 3"
                        class="hero-icon icon-bottom-left"
                    />
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/img/enterprise/icon4.png"
                        alt="Enterprise Icon 4"
                        class="hero-icon icon-bottom-right"
                    />
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

    <!-- Tailored Solutions Section -->
    <section class="tailored-solutions">
        <div class="tailored-solutions-container">
            <div class="tailored-content">
                <div class="tailored-text">
                    <h3><?php echo get_theme_mod('tailored_title', 'Tailored solutions, for every problem'); ?></h3>
                    <p><?php echo get_theme_mod('tailored_description', 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'); ?></p>
                </div>
                <div class="services-list">
                    <a href="#it-support" class="service-item">
                        <span class="service-text">IT Support & Helpdesk</span>
                        <i class="fa-solid fa-headset"></i>
                    </a>
                    <a href="#cloud-infrastructure" class="service-item">
                        <span class="service-text">Cloud Infrastructure</span>
                        <i class="fa-solid fa-cloud"></i>
                    </a>
                    <a href="#cyber-security" class="service-item">
                        <span class="service-text">Cyber Security</span>
                        <i class="fa-solid fa-shield-halved"></i>
                    </a>
                    <a href="#network-connectivity" class="service-item">
                        <span class="service-text">Network Connectivity</span>
                        <i class="fa-solid fa-network-wired"></i>
                    </a>
                    <a href="#managed-contracts" class="service-item">
                        <span class="service-text">Managed Contracts</span>
                        <i class="fa-solid fa-file-contract"></i>
                    </a>
                    <a href="#data-backup" class="service-item">
                        <span class="service-text">Data Backup & Recovery</span>
                        <i class="fa-solid fa-database"></i>
                    </a>
                    <a href="#software-solutions" class="service-item">
                        <span class="service-text">Software Solutions</span>
                        <i class="fa-solid fa-laptop-code"></i>
                    </a>
                    <a href="#hardware-management" class="service-item">
                        <span class="service-text">Hardware Management</span>
                        <i class="fa-solid fa-server"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- IT Challenges Section -->
    <section class="it-challenges">
        <div class="it-challenges-container">
            <div class="it-challenges-content">
                <div class="challenges-text">
                    <h2><?php echo get_theme_mod('challenges_title', 'Solving IT Challenges in every industry, every day.'); ?></h2>
                    <p><?php echo get_theme_mod('challenges_description', 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'); ?></p>
                </div>
                <div class="challenges-cards-container">
                    <div class="challenges-card">
                        <h4>Accounting</h4>
                        <p>With accounting and finance practices having moved fully online, there is a growing need for technology support and management through a Managed Service Provider (MSP) with extensive experience. APC is here to meet that need.</p>
                        <a href="#contact" class="challenge-btn">Talk to an expert</a>
                    </div>
                    <div class="challenges-card">
                        <h4>Healthcare</h4>
                        <p>Healthcare organizations require robust, secure, and compliant IT infrastructure. Our specialized solutions ensure patient data protection while maintaining operational efficiency and regulatory compliance.</p>
                        <a href="#contact" class="challenge-btn">Talk to an expert</a>
                    </div>
                    <div class="challenges-card">
                        <h4>Legal</h4>
                        <p>Law firms need secure document management, reliable communication systems, and robust backup solutions. We provide tailored IT services that protect sensitive client information.</p>
                        <a href="#contact" class="challenge-btn">Talk to an expert</a>
                    </div>
                    <div class="challenges-card">
                        <h4>Manufacturing</h4>
                        <p>Manufacturing companies require integrated systems that connect production, inventory, and management processes. Our solutions optimize efficiency while maintaining security.</p>
                        <a href="#contact" class="challenge-btn">Talk to an expert</a>
                    </div>
                    <div class="challenges-card">
                        <h4>Education</h4>
                        <p>Educational institutions need scalable IT infrastructure that supports both in-person and remote learning. We provide solutions that enhance the learning experience.</p>
                        <a href="#contact" class="challenge-btn">Talk to an expert</a>
                    </div>
                    <div class="challenges-card">
                        <h4>Retail</h4>
                        <p>Retail businesses need integrated POS systems, inventory management, and customer data protection. Our solutions help streamline operations and enhance customer experience.</p>
                        <a href="#contact" class="challenge-btn">Talk to an expert</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted Partners Section -->
    <section class="trusted-partners">
        <div class="trusted-partners-container">
            <div class="partners-content">
                <h2><?php echo get_theme_mod('partners_title', 'Trusted partners'); ?></h2>
                <p><strong><?php echo get_theme_mod('partners_subtitle', 'Working with the best'); ?></strong></p>
                <div class="partners-icons">
                    <div class="partner-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/microsoft.png" alt="Microsoft" />
                    </div>
                    <div class="partner-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/cisco.png" alt="Cisco" />
                    </div>
                    <div class="partner-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/sonicwal.png" alt="SonicWall" />
                    </div>
                    <div class="partner-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/fortinet.png" alt="Fortinet" />
                    </div>
                    <div class="partner-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/azure.png" alt="Azure" />
                    </div>
                    <div class="partner-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/partners/Darktrace_logo logo.png" alt="Darktrace" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="testimonials-container">
            <div class="testimonials-header">
                <div class="testimonials-header-left">
                    <h2><?php echo get_theme_mod('testimonials_title', 'Trusted by 200+ clients'); ?></h2>
                    <p><?php echo get_theme_mod('testimonials_csat', 'CSAT 96.4%'); ?></p>
                </div>
                <div class="testimonials-header-right">
                    <p><?php echo get_theme_mod('testimonials_reviews', '194 reviews in 90 days'); ?></p>
                </div>
            </div>
            <div class="testimonials-slider">
                <div class="testimonials-track">
                    <?php
                    // Get testimonials from customizer or use default ones
                    $testimonials = array(
                        array(
                            'text' => 'APC Integrated has transformed our IT infrastructure. Their proactive support and expertise have been invaluable to our business growth.',
                            'author' => 'Sarah J'
                        ),
                        array(
                            'text' => 'Outstanding service and reliability. APC\'s team is always responsive and their solutions are exactly what we needed for our growing company.',
                            'author' => 'Michael C'
                        ),
                        array(
                            'text' => 'The level of professionalism and technical expertise from APC is unmatched. They\'ve become an essential part of our business operations.',
                            'author' => 'Emma R'
                        ),
                        array(
                            'text' => 'APC\'s cloud solutions and security measures have given us peace of mind. Their team is knowledgeable, friendly, and always available.',
                            'author' => 'David T'
                        ),
                        array(
                            'text' => 'Working with APC has been a game-changer. Their proactive monitoring and support have eliminated our IT headaches completely.',
                            'author' => 'Lisa P'
                        )
                    );

                    foreach ($testimonials as $testimonial) :
                    ?>
                    <div class="testimonial-card">
                        <div class="stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="testimonial-text">"<?php echo esc_html($testimonial['text']); ?>"</p>
                        <div class="testimonial-author">
                            <strong><?php echo esc_html($testimonial['author']); ?></strong>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

<?php
// If this is the blog homepage, display posts
if (is_home() && !is_front_page()) {
    if (have_posts()) :
        ?>
        <section class="blog-posts">
            <div class="container">
                <h2>Latest Posts</h2>
                <div class="posts-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article class="post-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="post-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="post-meta">
                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                    <span class="post-author">by <?php the_author(); ?></span>
                                </div>
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>
                
                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('&laquo; Previous'),
                    'next_text' => __('Next &raquo;'),
                ));
                ?>
            </div>
        </section>
        <?php
    endif;
}
?>

<?php get_footer(); ?>