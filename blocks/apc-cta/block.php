<?php
/**
 * APC CTA Block Render
 * 
 * @param array $attributes Block attributes
 * @param string $content Block content
 * @return string
 */

function apc_render_cta_block($attributes, $content = '') {
    // Extract attributes with defaults
    $contact_label = isset($attributes['contactLabel']) ? $attributes['contactLabel'] : 'Contact Us';
    $title = isset($attributes['title']) ? $attributes['title'] : 'Partner with us for comprehensive IT';
    $description = isset($attributes['description']) ? $attributes['description'] : 'We\'re happy to answer any questions you may have and help you determine which of our services best fit your needs.';
    $benefits_title = isset($attributes['benefitsTitle']) ? $attributes['benefitsTitle'] : 'Your Benefits';
    $next_steps_title = isset($attributes['nextStepsTitle']) ? $attributes['nextStepsTitle'] : 'What happens next?';
    $form_title = isset($attributes['formTitle']) ? $attributes['formTitle'] : 'Partner with APC today';
    $submit_button_text = isset($attributes['submitButtonText']) ? $attributes['submitButtonText'] : 'Submit';
    $use_gravity_form = isset($attributes['useGravityForm']) ? $attributes['useGravityForm'] : false;
    $gravity_form_id = isset($attributes['gravityFormId']) ? $attributes['gravityFormId'] : '';
    
    ob_start();
    ?>
    <div class="wp-block-apc-cta">
        <div class="apc-cta-container">
            <div class="apc-cta-row-1">
                <div class="apc-cta-col-1">
                    <p class="apc-cta-contact"><?php echo esc_html($contact_label); ?></p>
                    <h2 class="apc-cta-title"><?php echo esc_html($title); ?></h2>
                </div>
                <div class="apc-cta-col-2">
                    <!-- Empty column for future content -->
                </div>
            </div>
            <div class="apc-cta-row-2">
                <div class="apc-cta-col-1">
                    <p class="apc-cta-content"><?php echo esc_html($description); ?></p>
                    <p class="apc-cta-benefit"><?php echo esc_html($benefits_title); ?></p>
                    <div class="benefits-lists">
                        <ul>
                            <li>Client-oriented</li>
                            <li>Independent</li>
                            <li>Competent</li>
                        </ul>
                        <ul>
                            <li>Results-driven</li>
                            <li>Problem-solving</li>
                            <li>Transparent</li>
                        </ul>
                    </div>
                    <div class="next-step">
                        <p class="next-step-title"><?php echo esc_html($next_steps_title); ?></p>
                        <div class="next-step-columns">
                            <div class="next-step-item">
                                <p class="step-number">1</p>
                                <p class="step-description">We listen to your goals.</p>
                            </div>
                            <div class="step-arrow">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                            <div class="next-step-item">
                                <p class="step-number">2</p>
                                <p class="step-description">Our experts assess your IT landscape.</p>
                            </div>
                            <div class="step-arrow">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                            <div class="next-step-item">
                                <p class="step-number">3</p>
                                <p class="step-description">You receive a customized IT plan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="apc-cta-col-2">
                    <div class="cta-form">
                        <h4 align="center"><?php echo esc_html($form_title); ?></h4>
                        
                        <?php if ($use_gravity_form && !empty($gravity_form_id) && class_exists('GFAPI')): ?>
                            <?php 
                            // Display Gravity Form (with AJAX disabled)
                            if (function_exists('gravity_form')) {
                                gravity_form($gravity_form_id, false, true, false, '', false);
                            } else {
                                echo '<p>Gravity Forms plugin is required.</p>';
                            }
                            ?>
                        <?php else: ?>
                            <!-- Default Contact Form -->
                            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="POST" class="contact-form">
                                <?php wp_nonce_field('apc_contact_form', 'apc_nonce'); ?>
                                
                                <div class="form-group">
                                    <input type="text" id="name" name="name" placeholder="Full Name" required />
                                </div>
                                <div class="form-group">
                                    <input type="email" id="email" name="email" placeholder="Email Address" required />
                                </div>
                                <div class="form-group">
                                    <input type="tel" id="phone" name="phone" placeholder="Phone Number" />
                                </div>
                                <div class="form-group">
                                    <input type="text" id="company" name="company" placeholder="Company Name" />
                                </div>
                                <div class="form-group">
                                    <select id="service" name="service" required>
                                        <option value="">Select a Service</option>
                                        <option value="it-support">IT Support & Helpdesk</option>
                                        <option value="cloud-infrastructure">Cloud Infrastructure</option>
                                        <option value="cyber-security">Cyber Security</option>
                                        <option value="network-connectivity">Network Connectivity</option>
                                        <option value="managed-contracts">Managed Contracts</option>
                                        <option value="data-backup">Data Backup & Recovery</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea id="message" name="message" placeholder="Tell us about your IT needs..." rows="4"></textarea>
                                </div>
                                <button type="submit" class="cta-submit-btn"><?php echo esc_html($submit_button_text); ?></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>