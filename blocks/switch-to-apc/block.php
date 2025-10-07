<?php
/**
 * Switch to APC Block Render Function
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Switch to APC block
 */
function apc_render_switch_to_apc_block($attributes) {
    $title = isset($attributes['title']) ? $attributes['title'] : '<h2>Why <span style="color: #7055EE;">Switch to APC</span>?</h2>';
    $listings = isset($attributes['listings']) ? $attributes['listings'] : array();

    if (empty($listings)) {
        return '';
    }

    ob_start();
    ?>
    <div class="switch-to-apc-wrapper">
        <div class="container">
            <div class="switch-to-apc-header">
                <?php if (!empty($title)) : 
                    // Allow specific HTML tags for rich content in title
                    $allowed_title_html = array(
                        'h1' => array('class' => array(), 'style' => array()),
                        'h2' => array('class' => array(), 'style' => array()),
                        'h3' => array('class' => array(), 'style' => array()),
                        'h4' => array('class' => array(), 'style' => array()),
                        'h5' => array('class' => array(), 'style' => array()),
                        'h6' => array('class' => array(), 'style' => array()),
                        'span' => array('class' => array(), 'style' => array()),
                        'strong' => array('class' => array(), 'style' => array()),
                        'b' => array('class' => array(), 'style' => array()),
                        'em' => array('class' => array(), 'style' => array()),
                        'i' => array('class' => array(), 'style' => array()),
                        'u' => array('class' => array(), 'style' => array()),
                        'br' => array(),
                        'p' => array('class' => array(), 'style' => array()),
                        'div' => array('class' => array(), 'style' => array())
                    );
                ?>
                    <div class="switch-to-apc-title"><?php echo wp_kses($title, $allowed_title_html); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="reasons-grid">
                <?php foreach ($listings as $index => $reason) : 
                    $reason_title = isset($reason['title']) ? sanitize_text_field($reason['title']) : '';
                    $reason_description = isset($reason['description']) ? $reason['description'] : '';
                    $button_text = isset($reason['buttonText']) ? sanitize_text_field($reason['buttonText']) : 'Learn More';
                    $button_link = isset($reason['buttonLink']) ? esc_url($reason['buttonLink']) : '#';
                    $label_text = isset($reason['labelText']) ? sanitize_text_field($reason['labelText']) : '';
                    
                    // Allow specific HTML tags for rich content
                    $allowed_html = array(
                        'p' => array(
                            'class' => array()
                        ),
                        'br' => array(),
                        'strong' => array(),
                        'b' => array(),
                        'em' => array(),
                        'i' => array(),
                        'u' => array(),
                        'ul' => array(
                            'class' => array()
                        ),
                        'ol' => array(
                            'class' => array()
                        ),
                        'li' => array(
                            'class' => array()
                        ),
                        'a' => array(
                            'href' => array(),
                            'title' => array(),
                            'target' => array(),
                            'class' => array()
                        ),
                        'span' => array(
                            'style' => array(),
                            'class' => array()
                        )
                    );
                    // Decode HTML entities and then sanitize
                    $reason_description = html_entity_decode($reason_description, ENT_QUOTES, 'UTF-8');
                    $reason_description = wp_kses($reason_description, $allowed_html);
                    
                    // Clean up unwanted <br> tags around block elements
                    $reason_description = preg_replace('/<br\s*\/?>\s*<(ul|ol|li|\/ul|\/ol|\/li)/', '<$1', $reason_description);
                    $reason_description = preg_replace('/<\/(ul|ol|li)>\s*<br\s*\/?>/', '</$1>', $reason_description);
                    $reason_description = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/', '<br>', $reason_description);
                    $reason_description = trim($reason_description);
                ?>
                    <div class="reason-card">
                        <?php if (!empty($label_text)) : ?>
                            <div class="reason-label">
                                <?php echo esc_html($label_text); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($reason_title)) : ?>
                            <h4 class="reason-title"><?php echo esc_html($reason_title); ?></h4>
                        <?php endif; ?>
                        
                        <?php if (!empty($reason_description)) : ?>
                            <div class="reason-description"><?php echo $reason_description; ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($button_text) && !empty($button_link)) : ?>
                            <a href="<?php echo $button_link; ?>" class="reason-button">
                                <?php echo esc_html($button_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>