<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="container">
    <!-- Header Section -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <?php
                // Use custom logo if set, otherwise use site title
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/apc_logo.png" alt="<?php bloginfo('name'); ?> Logo" />
                    </a>
                    <?php
                }
                ?>
            </div>

           

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="<?php echo esc_url(get_theme_mod('remote_support_url', '#remote-support')); ?>" class="action-btn">
                    <i class="fa-solid fa-headset"></i>
                    Remote<br />Support
                </a>
                <a href="<?php echo esc_url(get_theme_mod('client_portal_url', '#client-portal')); ?>" class="action-btn">
                    <i class="fa-solid fa-user"></i>
                    Client<br />Portal
                </a>
            </div>

            <!-- Hamburger Menu Button -->
            <button class="hamburger-menu" aria-label="Toggle navigation">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>

        <!-- Main Navigation (Desktop & Tablet) -->
        <nav class="main-nav">
            <?php
            $primary_menu = wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu',
                'fallback_cb'    => false,
                'walker'         => new APC_Walker_Nav_Menu(),
                'echo'           => false,
            ));
            
            if ($primary_menu) {
                echo $primary_menu;
            } else {
                echo apc_no_menu_message();
            }
            ?>
        </nav>

        <!-- Mobile Navigation -->
        <nav class="mobile-nav">
            <?php
            $mobile_menu = wp_nav_menu(array(
                'theme_location' => 'mobile',
                'container'      => false,
                'menu_class'     => 'mobile-nav-menu',
                'fallback_cb'    => false,
                'walker'         => new APC_Mobile_Walker_Nav_Menu(),
                'echo'           => false,
            ));
            
            if ($mobile_menu) {
                echo $mobile_menu;
            } else {
                echo apc_no_menu_message();
            }
            ?>
            
            <!-- Mobile Action Buttons -->
            <div class="mobile-action-buttons">
                <a href="<?php echo esc_url(get_theme_mod('remote_support_url', '#remote-support')); ?>" class="action-btn mobile-action-btn">
                    <i class="fa-solid fa-headset"></i>
                    <span>Remote Support</span>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('client_portal_url', '#client-portal')); ?>" class="action-btn mobile-action-btn">
                    <i class="fa-solid fa-user"></i>
                    <span>Client Portal</span>
                </a>
            </div>
            
            <!-- Drill panels container (populated by JS) -->
            <div class="mobile-drillpanels" aria-hidden="true">
                <!-- panels are inserted here dynamically -->
            </div>
        </nav>
    </header>

<?php


?>