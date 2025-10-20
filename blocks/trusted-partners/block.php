<?php
/**
 * Trusted Partners Block - Server-side rendering
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Trusted Partners Block
 */
function apc_render_trusted_partners_block($attributes) {
    $title = $attributes['title'] ?? 'Trusted partners';
    $subtitle = $attributes['subtitle'] ?? 'Working with the best';
    $background_image = $attributes['backgroundImage'] ?? '';
    $partners = $attributes['partners'] ?? array();
    
    // Default partners if none provided
    if (empty($partners)) {
        $partners = array(
            array(
                'name' => 'Microsoft',
                'logo' => 'microsoft.png',
                'url' => ''
            ),
            array(
                'name' => 'Cisco',
                'logo' => 'cisco.png',
                'url' => ''
            ),
            array(
                'name' => 'SonicWall',
                'logo' => 'sonicwal.png',
                'url' => ''
            ),
            array(
                'name' => 'Fortinet',
                'logo' => 'fortinet.png',
                'url' => ''
            ),
            array(
                'name' => 'Azure',
                'logo' => 'azure.png',
                'url' => ''
            ),
            array(
                'name' => 'Dell',
                'logo' => 'dell.png',
                'url' => ''
            ),
            array(
                'name' => 'lenovo',
                'logo' => 'lenovo.png',
                'url' => ''
            ),
            array(
                'name' => 'Sentinel',
                'logo' => 'sentinel.png',
                'url' => ''
            ),
            array(
                'name' => 'n-able',
                'logo' => 'n-able.png',
                'url' => ''
            ),
            array(
                'name' => '1password',
                'logo' => '1password.png',
                'url' => ''
            ),
            array(
                'name' => 'knowbe4',
                'logo' => 'knowbe4.png',
                'url' => ''
            )
        );
    }
    
    // Background style
    $background_style = '';
    if (!empty($background_image)) {
        $background_style = 'style="background-image: url(' . esc_url($background_image) . '), url(\'' . get_template_directory_uri() . '/assets/img/site/diamond.png\');"';
    }
    
    ob_start();
    ?>
    <div class="trusted-partners-block" <?php echo $background_style; ?>>
        <div class="trusted-partners-container">
            <div class="partners-content">
                <h2><?php echo esc_html($title); ?></h2>
                <p><strong><?php echo esc_html($subtitle); ?></strong></p>
                <div class="partners-icons-wrapper">
                    <div class="partners-icons partners-scroll">
                        <?php 
                        // Display partners twice for seamless infinite scroll
                        for ($i = 0; $i < 2; $i++) :
                            foreach ($partners as $partner) : 
                                $partner_name = $partner['name'] ?? '';
                                $partner_logo = $partner['logo'] ?? '';
                                $partner_url = $partner['url'] ?? '';
                                
                                // Construct logo path
                                $logo_path = get_template_directory_uri() . '/assets/img/partners/' . $partner_logo;
                                
                                // Create partner element (with or without link)
                                $partner_element_start = '';
                                $partner_element_end = '';
                                
                                if (!empty($partner_url)) {
                                    $partner_element_start = '<a href="' . esc_url($partner_url) . '" target="_blank" rel="noopener noreferrer">';
                                    $partner_element_end = '</a>';
                                }
                            ?>
                            <div class="partner-icon">
                                <?php echo $partner_element_start; ?>
                                <img src="<?php echo esc_url($logo_path); ?>" alt="<?php echo esc_attr($partner_name); ?>" />
                                <?php echo $partner_element_end; ?>
                            </div>
                            <?php 
                            endforeach;
                        endfor;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}