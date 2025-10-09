<?php
/**
 * APC Hero Block
 * 
 * @param array $attributes Block attributes
 */
function apc_render_hero_block($attributes) {
    // Extract attributes with defaults
    $hero_line_1 = isset($attributes['heroLine1']) ? esc_html($attributes['heroLine1']) : 'Using APC for';
    $hero_line_2 = isset($attributes['heroLine2']) ? esc_html($attributes['heroLine2']) : 'in your business';
    $cube_text_1 = isset($attributes['cubeText1']) ? esc_html($attributes['cubeText1']) : 'cloud solutions';
    $cube_text_2 = isset($attributes['cubeText2']) ? esc_html($attributes['cubeText2']) : 'improved performance';
    $cube_text_3 = isset($attributes['cubeText3']) ? esc_html($attributes['cubeText3']) : 'optimizing processes';
    $cube_text_4 = isset($attributes['cubeText4']) ? esc_html($attributes['cubeText4']) : 'enterprise-grade security';
    
    $template_uri = get_template_directory_uri();
    
    ob_start();
    ?>
    <div class="wp-block-apc-hero">
    <section class="hero">
        <div class="hero-container">
            <div class="hero-icons-container">
                <!-- Cloud Solutions Icons -->
                <div class="hero-icons cloud-icons">
                    <img src="<?php echo $template_uri; ?>/assets/img/cloud/icon1.png" alt="Cloud Icon 1" class="hero-icon icon-top-left" />
                    <img src="<?php echo $template_uri; ?>/assets/img/cloud/icon2.png" alt="Cloud Icon 2" class="hero-icon icon-top-right" />
                    <img src="<?php echo $template_uri; ?>/assets/img/cloud/icon3.png" alt="Cloud Icon 3" class="hero-icon icon-bottom-left" />
                    <img src="<?php echo $template_uri; ?>/assets/img/cloud/icon4.png" alt="Cloud Icon 4" class="hero-icon icon-bottom-right" />
                </div>

                <!-- Performance Icons -->
                <div class="hero-icons performance-icons">
                    <img src="<?php echo $template_uri; ?>/assets/img/performance/icon1.png" alt="Performance Icon 1" class="hero-icon icon-top-right" />
                    <img src="<?php echo $template_uri; ?>/assets/img/performance/icon2.png" alt="Performance Icon 2" class="hero-icon icon-bottom-left" />
                </div>

                <!-- Processes Icons -->
                <div class="hero-icons processes-icons">
                    <img src="<?php echo $template_uri; ?>/assets/img/processes/icon1.png" alt="Processes Icon 1" class="hero-icon icon-top-left" />
                    <img src="<?php echo $template_uri; ?>/assets/img/processes/icon2.png" alt="Processes Icon 2" class="hero-icon icon-bottom-right" />
                </div>

                <!-- Enterprise Icons -->
                <div class="hero-icons enterprise-icons">
                    <img src="<?php echo $template_uri; ?>/assets/img/enterprise/icon1.png" alt="Enterprise Icon 1" class="hero-icon icon-top-left" />
                    <img src="<?php echo $template_uri; ?>/assets/img/enterprise/icon2.png" alt="Enterprise Icon 2" class="hero-icon icon-top-right" />
                    <img src="<?php echo $template_uri; ?>/assets/img/enterprise/icon3.png" alt="Enterprise Icon 3" class="hero-icon icon-bottom-left" />
                    <img src="<?php echo $template_uri; ?>/assets/img/enterprise/icon4.png" alt="Enterprise Icon 4" class="hero-icon icon-bottom-right" />
                </div>
            </div>

            <div class="hero-text">
                <div class="hero-line"><?php echo $hero_line_1; ?></div>
                <div class="hero-highlight">
                    <div class="cube-container">
                        <div class="cube">
                            <div class="cube-face"><?php echo $cube_text_1; ?></div>
                            <div class="cube-face"><?php echo $cube_text_2; ?></div>
                            <div class="cube-face"><?php echo $cube_text_3; ?></div>
                            <div class="cube-face"><?php echo $cube_text_4; ?></div>
                        </div>
                    </div>
                </div>
                <div class="hero-line"><?php echo $hero_line_2; ?></div>
            </div>
        </div>
    </section>
    </div>
    <?php
    return ob_get_clean();
}

// Block registration is handled in inc/blocks-customizer.php
?>