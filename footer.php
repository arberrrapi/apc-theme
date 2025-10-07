    <!-- Main Content Area (for future development) -->
    <main>
        <?php
        // This is where the main content will be displayed
        // Content is handled by index.php and other template files
        ?>
    </main>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <!-- Logo Column -->
                <div class="footer-logo-column">
                    <?php
                    // Use custom logo if available, otherwise use default
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <img
                            src="<?php echo get_template_directory_uri(); ?>/assets/img/site/apc-blue_dark.png"
                            alt="<?php bloginfo('name'); ?> Logo"
                            class="footer-logo"
                        />
                        <?php
                    }
                    ?>
                </div>

                <!-- Contact Column with Gradient Border -->
                <div class="footer-contact-column">
                    <div class="contact-content">
                        <div class="contact-row">
                            <div class="contact-text-column">
                                <h3><?php echo get_theme_mod('footer_contact_text', 'Get in touch with one of our expert today.'); ?></h3>
                            </div>
                            <div class="contact-image-column">
                                <img
                                    src="<?php echo get_template_directory_uri(); ?>/assets/img/site/our_expert.png"
                                    alt="Contact Us"
                                    class="contact-image"
                                />
                            </div>
                        </div>
                        <div class="contact-button-row">
                            <button class="footer-expert-btn dark">
                                <?php echo get_theme_mod('footer_button_text', 'Speak to an expert'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Footer Row -->
            <div class="footer-content">
                <!-- IT Health Check Column -->
                <div class="footer-contact-column">
                    <div class="contact-content">
                        <div class="contact-row">
                            <div class="contact-text-column">
                                <h3><?php echo get_theme_mod('footer_health_check_title', 'IT health check'); ?></h3>
                                <p><?php echo get_theme_mod('footer_health_check_text', 'Are there security gaps in your network'); ?></p>
                            </div>
                        </div>
                        <div class="contact-button-row">
                            <button class="footer-expert-btn gradient-border">
                                <span><?php echo get_theme_mod('footer_health_check_button', 'Discover'); ?></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Contract Management Column -->
                <div class="footer-contact-column">
                    <div class="contact-content">
                        <div class="contact-row">
                            <div class="contact-text-column">
                                <h3><?php echo get_theme_mod('footer_contract_title', 'Contract Management'); ?></h3>
                                <p><?php echo get_theme_mod('footer_contract_text', 'Managed Business Mobile & Utility Services'); ?></p>
                            </div>
                        </div>
                        <div class="contact-button-row">
                            <button class="footer-expert-btn gradient-border">
                                <span><?php echo get_theme_mod('footer_contract_button', 'Discover'); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

           

            <!-- Copyright Section -->
            <div class="footer-copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo get_theme_mod('footer_copyright_text', 'All rights reserved.'); ?></p>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>