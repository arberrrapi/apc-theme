<?php
/**
 * IT Challenges Block - Server-side rendering
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render IT Challenges Block
 */
function apc_render_it_challenges_block($attributes) {
    $title = $attributes['title'] ?? 'Solving IT Challenges in every industry, every day.';
    $description = $attributes['description'] ?? 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.';
    $main_button_text = $attributes['mainButtonText'] ?? 'Get Started';
    $main_button_link = $attributes['mainButtonLink'] ?? '#contact';
    $main_button_page = $attributes['mainButtonPage'] ?? 0;
    $main_button_type = $attributes['mainButtonType'] ?? 'url';
    $challenges = $attributes['challenges'] ?? array();
    
    // Determine the final main button URL
    $final_main_button_url = '';
    if ($main_button_type === 'page' && !empty($main_button_page)) {
        $final_main_button_url = get_permalink($main_button_page);
    } elseif ($main_button_type === 'url' && !empty($main_button_link)) {
        $final_main_button_url = $main_button_link;
    }
    
    // Default challenges if none provided
    if (empty($challenges)) {
        $challenges = array(
            array(
                'title' => 'Accounting',
                'description' => 'With accounting and finance practices having moved fully online, there is a growing need for technology support and management through a Managed Service Provider (MSP) with extensive experience. APC is here to meet that need.',
                'buttonText' => 'Talk to an expert',
                'buttonLink' => '#contact'
            ),
            array(
                'title' => 'Healthcare',
                'description' => 'Healthcare organizations require robust, secure, and compliant IT infrastructure. Our specialized solutions ensure patient data protection while maintaining operational efficiency and regulatory compliance.',
                'buttonText' => 'Talk to an expert',
                'buttonLink' => '#contact'
            ),
            array(
                'title' => 'Legal',
                'description' => 'Law firms need secure document management, reliable communication systems, and robust backup solutions. We provide tailored IT services that protect sensitive client information.',
                'buttonText' => 'Talk to an expert',
                'buttonLink' => '#contact'
            ),
            array(
                'title' => 'Manufacturing',
                'description' => 'Manufacturing companies require integrated systems that connect production, inventory, and management processes. Our solutions optimize efficiency while maintaining security.',
                'buttonText' => 'Talk to an expert',
                'buttonLink' => '#contact'
            ),
            array(
                'title' => 'Education',
                'description' => 'Educational institutions need scalable IT infrastructure that supports both in-person and remote learning. We provide solutions that enhance the learning experience.',
                'buttonText' => 'Talk to an expert',
                'buttonLink' => '#contact'
            ),
            array(
                'title' => 'Retail',
                'description' => 'Retail businesses need integrated POS systems, inventory management, and customer data protection. Our solutions help streamline operations and enhance customer experience.',
                'buttonText' => 'Talk to an expert',
                'buttonLink' => '#contact'
            )
        );
    }
    
    ob_start();
    ?>
    <div class="it-challenges-block">
        <div class="it-challenges-container">
            <div class="it-challenges-content">
                <div class="challenges-text">
                    <h2><?php echo esc_html($title); ?></h2>
                    <p><?php echo esc_html($description); ?></p>
                    <?php if (!empty($final_main_button_url)) : ?>
                        <a href="<?php echo esc_url($final_main_button_url); ?>" class="challenge-btn main-btn"><?php echo esc_html($main_button_text); ?></a>
                    <?php endif; ?>
                </div>
                <div class="challenges-cards-container">
                    <?php foreach ($challenges as $challenge) : 
                        $challenge_title = $challenge['title'] ?? '';
                        $challenge_description = $challenge['description'] ?? '';
                        $challenge_button_text = $challenge['buttonText'] ?? 'Talk to an expert';
                        $challenge_button_link = $challenge['buttonLink'] ?? '#contact';
                        $challenge_button_page = $challenge['buttonPage'] ?? 0;
                        $challenge_button_type = $challenge['buttonType'] ?? 'url';
                        
                        // Determine the final button URL
                        $final_challenge_button_url = '';
                        if ($challenge_button_type === 'page' && !empty($challenge_button_page)) {
                            $final_challenge_button_url = get_permalink($challenge_button_page);
                        } elseif ($challenge_button_type === 'url' && !empty($challenge_button_link)) {
                            $final_challenge_button_url = $challenge_button_link;
                        }
                    ?>
                    <div class="challenges-card">
                        <?php 
                        $icon_url = $challenge['iconUrl'] ?? '';
                        $icon_alt = $challenge['iconAlt'] ?? $challenge_title;
                        if (!empty($icon_url)) : 
                        ?>
                            <div class="challenge-icon">
                                <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" />
                            </div>
                        <?php endif; ?>
                        <h4><?php echo esc_html($challenge_title); ?></h4>
                        <p><?php echo esc_html($challenge_description); ?></p>
                        <?php if (!empty($final_challenge_button_url)) : ?>
                            <a href="<?php echo esc_url($final_challenge_button_url); ?>" class="challenge-btn"><?php echo esc_html($challenge_button_text); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}