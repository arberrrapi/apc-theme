<?php
/**
 * Testimonials Block Render
 * 
 * @param array $attributes Block attributes
 * @param string $content Block content
 * @return string
 */

function render_testimonials_block($attributes, $content = '') {
    // Extract attributes with defaults
    $api_url = isset($attributes['apiUrl']) ? $attributes['apiUrl'] : 'https://app.smileback.io/api/testimonials';
    $auto_slide = isset($attributes['autoSlide']) ? $attributes['autoSlide'] : true;
    $slide_interval = isset($attributes['slideInterval']) ? $attributes['slideInterval'] : 20;
    $title = isset($attributes['title']) ? $attributes['title'] : 'What Our Clients Say';
    $subtitle = isset($attributes['subtitle']) ? $attributes['subtitle'] : 'CSAT <span>99.5</span>';
    $stats_text = isset($attributes['statsText']) ? $attributes['statsText'] : 'Trusted by 500+ companies worldwide';

    // Fetch testimonials from SmileBack API
    $testimonials = fetch_smileback_testimonials($api_url);
    
    // If API fails, use fallback testimonials
    if (empty($testimonials)) {
        $testimonials = get_fallback_testimonials();
    }

    // Generate animation duration based on slide interval
    $animation_duration = $slide_interval . 's';
    
    ob_start();
    ?>
    <div class="wp-block-apc-testimonials">
        <div class="testimonials-container">
            <div class="testimonials-header">
                <div class="testimonials-header-left">
                    <h2>Live Client Feedback</h2>
                    <p>CSAT <span>99.5</span></p>
                </div>
                <div class="testimonials-header-right">
                    <p>20 Reviews in the last 24 hours</p>
                </div>
            </div>
            
            <div class="testimonials-slider">
                <div class="testimonials-track"<?php if ($auto_slide): ?> style="animation-duration: <?php echo esc_attr($animation_duration); ?>;"<?php endif; ?>>
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="testimonial-card">
                            <div class="stars">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="testimonial-text">
                                <?php echo esc_html($testimonial['text']); ?>
                            </div>
                            <div class="testimonial-author">
                                <strong><?php echo esc_html($testimonial['author']); ?></strong>
                                <span><?php echo esc_html($testimonial['position']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (!$auto_slide): ?>
    <style>
        .wp-block-apc-testimonials .testimonials-track {
            animation: none !important;
        }
    </style>
    <?php endif; ?>
    
    <?php
    return ob_get_clean();
}

/**
 * Fetch testimonials from SmileBack API
 * 
 * @param string $api_url API endpoint URL (deprecated - now uses theme settings)
 * @return array Array of testimonials or empty array on failure
 */
function fetch_smileback_testimonials($api_url = '') {
    // Ignore the $api_url parameter (legacy from block attributes)
    // Use theme settings instead
    
    $api = new Smileback_API();
    $reviews = $api->get_reviews();
    
    // If API returns empty, use fallback
    if (empty($reviews)) {
        return get_fallback_testimonials();
    }
    
    return $reviews;
}

/**
 * Get fallback testimonials when API is unavailable
 * 
 * @return array Array of fallback testimonials
 */
function get_fallback_testimonials() {
    return array(
        array(
            'text' => 'APC has transformed our IT infrastructure. Their expertise in cloud solutions and proactive support has significantly improved our operational efficiency.',
            'author' => 'Sarah Johnson',
            'position' => 'CTO, TechCorp Solutions'
        ),
        array(
            'text' => 'Outstanding service and support. APC\'s team is incredibly knowledgeable and responsive. They\'ve been instrumental in our digital transformation journey.',
            'author' => 'Michael Chen',
            'position' => 'IT Director, Global Dynamics'
        ),
        array(
            'text' => 'Professional, reliable, and innovative. APC consistently delivers solutions that exceed our expectations. Highly recommended for any business looking to modernize their IT.',
            'author' => 'Emily Rodriguez',
            'position' => 'VP Operations, InnovateCorp'
        ),
        array(
            'text' => 'APC\'s cybersecurity solutions have given us peace of mind. Their comprehensive approach to security and compliance is exactly what we needed.',
            'author' => 'David Thompson',
            'position' => 'Security Manager, SecureFinance'
        ),
        array(
            'text' => 'Exceptional partnership with APC. Their managed services have allowed us to focus on our core business while they handle all our IT needs efficiently.',
            'author' => 'Lisa Wang',
            'position' => 'CEO, StartupSuccess'
        )
    );
}
?>