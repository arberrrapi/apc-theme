<?php
/**
 * Meta Boxes for Services and Pages
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}



/**
 * Add Post Type Selector Meta Box
 */
function apc_add_post_type_meta_boxes() {
    add_meta_box(
        'apc_post_type_selector',
        __('Content Type', 'apc-theme'),
        'apc_post_type_selector_callback',
        'post',
        'side',
        'high'
    );
    
    add_meta_box(
        'apc_post_content_fields',
        __('Content Type Fields', 'apc-theme'),
        'apc_post_content_fields_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apc_add_post_type_meta_boxes');

/**
 * Post Type Selector Meta Box Callback
 */
function apc_post_type_selector_callback($post) {
    wp_nonce_field('apc_post_type_nonce', 'post_type_nonce');
    
    $selected_type = get_post_meta($post->ID, '_apc_content_type', true);
    if (!$selected_type) {
        $selected_type = 'blog'; // Default to blog
    }
    
    $content_types = array(
        'blog' => __('Blog (Default Layout)', 'apc-theme'),
        'article' => __('Article', 'apc-theme'),
        'customer_success' => __('Customer Success', 'apc-theme'),
        'video' => __('Video', 'apc-theme'),
        'whitepaper' => __('Whitepaper', 'apc-theme')
    );
    
    echo '<label for="apc_content_type"><strong>' . __('Select Content Type:', 'apc-theme') . '</strong></label><br><br>';
    echo '<select name="apc_content_type" id="apc_content_type" style="width: 100%;" onchange="toggleContentFields(this.value)">';
    
    foreach ($content_types as $type => $label) {
        echo '<option value="' . esc_attr($type) . '"' . selected($selected_type, $type, false) . '>';
        echo esc_html($label);
        echo '</option>';
    }
    
    echo '</select>';
    
    echo '<p class="description">' . __('Choose the type of content to customize the layout and available fields.', 'apc-theme') . '</p>';
}

/**
 * Content Type Fields Meta Box Callback
 */
function apc_post_content_fields_callback($post) {
    $selected_type = get_post_meta($post->ID, '_apc_content_type', true);
    if (!$selected_type) {
        $selected_type = 'blog';
    }
    
    // Video fields
    $video_url = get_post_meta($post->ID, '_video_url', true);
    $video_duration = get_post_meta($post->ID, '_video_duration', true);
    
    // Whitepaper fields
    $file_url = get_post_meta($post->ID, '_whitepaper_file', true);
    $file_size = get_post_meta($post->ID, '_whitepaper_size', true);
    
    // Customer success fields
    $company_name = get_post_meta($post->ID, '_customer_company', true);
    $industry = get_post_meta($post->ID, '_customer_industry', true);
    $logo_url = get_post_meta($post->ID, '_customer_logo', true);
    ?>
    
    <div id="content-fields-container">
        
        <!-- Video Fields -->
        <div id="video-fields" class="content-type-fields" style="display: <?php echo ($selected_type === 'video') ? 'block' : 'none'; ?>;">
            <h4><?php _e('Video Settings', 'apc-theme'); ?></h4>
            <table class="form-table">
                <tr>
                    <th><label for="video_url"><?php _e('Video URL', 'apc-theme'); ?></label></th>
                    <td>
                        <input type="url" id="video_url" name="video_url" value="<?php echo esc_attr($video_url); ?>" class="regular-text" />
                        <p class="description"><?php _e('Enter YouTube, Vimeo, or direct video URL', 'apc-theme'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="video_duration"><?php _e('Duration', 'apc-theme'); ?></label></th>
                    <td>
                        <input type="text" id="video_duration" name="video_duration" value="<?php echo esc_attr($video_duration); ?>" class="regular-text" />
                        <p class="description"><?php _e('e.g., 5:30 or 10 minutes', 'apc-theme'); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Whitepaper Fields -->
        <div id="whitepaper-fields" class="content-type-fields" style="display: <?php echo ($selected_type === 'whitepaper') ? 'block' : 'none'; ?>;">
            <h4><?php _e('Whitepaper Settings', 'apc-theme'); ?></h4>
            <table class="form-table">
                <tr>
                    <th><label for="whitepaper_file"><?php _e('Download File URL', 'apc-theme'); ?></label></th>
                    <td>
                        <input type="url" id="whitepaper_file" name="whitepaper_file" value="<?php echo esc_attr($file_url); ?>" class="regular-text" />
                        <button type="button" class="button" onclick="openMediaUploader('whitepaper_file')"><?php _e('Upload File', 'apc-theme'); ?></button>
                        <p class="description"><?php _e('Upload or enter URL for the whitepaper PDF', 'apc-theme'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="whitepaper_size"><?php _e('File Size', 'apc-theme'); ?></label></th>
                    <td>
                        <input type="text" id="whitepaper_size" name="whitepaper_size" value="<?php echo esc_attr($file_size); ?>" class="regular-text" />
                        <p class="description"><?php _e('e.g., 2.5 MB', 'apc-theme'); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Customer Success Fields -->
        <div id="customer_success-fields" class="content-type-fields" style="display: <?php echo ($selected_type === 'customer_success') ? 'block' : 'none'; ?>;">
            <h4><?php _e('Customer Success Settings', 'apc-theme'); ?></h4>
            <table class="form-table">
                <tr>
                    <th><label for="customer_company"><?php _e('Company Name', 'apc-theme'); ?></label></th>
                    <td>
                        <input type="text" id="customer_company" name="customer_company" value="<?php echo esc_attr($company_name); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th><label for="customer_industry"><?php _e('Industry', 'apc-theme'); ?></label></th>
                    <td>
                        <input type="text" id="customer_industry" name="customer_industry" value="<?php echo esc_attr($industry); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th><label for="customer_logo"><?php _e('Company Logo', 'apc-theme'); ?></label></th>
                    <td>
                        <input type="url" id="customer_logo" name="customer_logo" value="<?php echo esc_attr($logo_url); ?>" class="regular-text" />
                        <button type="button" class="button" onclick="openMediaUploader('customer_logo')"><?php _e('Upload Logo', 'apc-theme'); ?></button>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Blog and Article Fields -->
        <div id="blog-fields" class="content-type-fields" style="display: <?php echo (in_array($selected_type, ['blog', 'article'])) ? 'block' : 'none'; ?>;">
            <p><em><?php _e('No additional fields required for this content type.', 'apc-theme'); ?></em></p>
        </div>
        
    </div>
    
    <script>
    function toggleContentFields(type) {
        // Hide all field groups
        const fieldGroups = document.querySelectorAll('.content-type-fields');
        fieldGroups.forEach(group => {
            group.style.display = 'none';
        });
        
        // Show the selected field group
        const selectedGroup = document.getElementById(type + '-fields');
        if (selectedGroup) {
            selectedGroup.style.display = 'block';
        }
    }
    
    function openMediaUploader(targetField) {
        const uploader = wp.media({
            title: 'Select File',
            button: {
                text: 'Use This File'
            },
            multiple: false
        });
        
        uploader.on('select', function() {
            const attachment = uploader.state().get('selection').first().toJSON();
            document.getElementById(targetField).value = attachment.url;
        });
        
        uploader.open();
    }
    </script>
    
    <?php
}

/**
 * Add Service Meta Boxes (Icon only)
 */
function apc_add_service_meta_boxes() {
    add_meta_box(
        'apc_service_icon',
        __('Service Icon', 'apc-theme'),
        'apc_service_icon_callback',
        'service',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'apc_add_service_meta_boxes');

/**
 * Service Icon Meta Box Callback
 */
function apc_service_icon_callback($post) {
    wp_nonce_field('apc_service_icon_nonce', 'service_icon_nonce');
    
    $icon = get_post_meta($post->ID, '_service_icon', true);
    
    // Popular FontAwesome icons for services
    $popular_icons = array(
        'fa-solid fa-headset' => 'Headset (Support)',
        'fa-solid fa-cloud' => 'Cloud',
        'fa-solid fa-shield-halved' => 'Security Shield',
        'fa-solid fa-network-wired' => 'Network',
        'fa-solid fa-file-contract' => 'Contract',
        'fa-solid fa-database' => 'Database',
        'fa-solid fa-laptop-code' => 'Laptop Code',
        'fa-solid fa-server' => 'Server',
        'fa-solid fa-cog' => 'Settings',
        'fa-solid fa-users' => 'Users',
        'fa-solid fa-rocket' => 'Rocket',
        'fa-solid fa-lock' => 'Lock',
        'fa-solid fa-wifi' => 'WiFi',
        'fa-solid fa-mobile-alt' => 'Mobile',
        'fa-solid fa-desktop' => 'Desktop',
        'fa-solid fa-chart-line' => 'Analytics',
        'fa-solid fa-tools' => 'Tools',
        'fa-solid fa-phone' => 'Phone',
        'fa-solid fa-envelope' => 'Email',
        'fa-solid fa-globe' => 'Globe'
    );
    
    echo '<div class="apc-icon-selector">';
    echo '<label for="service_icon"><strong>' . __('Select Icon:', 'apc-theme') . '</strong></label><br><br>';
    
    echo '<div class="icon-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">';
    foreach ($popular_icons as $icon_class => $label) {
        $checked = ($icon === $icon_class) ? 'checked' : '';
        echo '<div class="icon-option" style="text-align: center; padding: 10px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;">';
        echo '<input type="radio" name="service_icon" value="' . $icon_class . '" id="' . $icon_class . '" ' . $checked . ' style="display: none;">';
        echo '<label for="' . $icon_class . '" style="cursor: pointer; display: block;">';
        echo '<i class="' . $icon_class . '" style="font-size: 24px; margin-bottom: 5px; display: block;"></i>';
        echo '<small>' . $label . '</small>';
        echo '</label>';
        echo '</div>';
    }
    echo '</div>';
    
    echo '<label for="service_custom_icon"><strong>' . __('Or enter custom FontAwesome class:', 'apc-theme') . '</strong></label><br>';
    echo '<input type="text" name="service_custom_icon" id="service_custom_icon" placeholder="e.g., fa-solid fa-star" style="width: 100%; margin: 5px 0;">';
    echo '<small>Visit <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a> for more icons</small>';
    echo '</div>';
    
    // Add JavaScript for better UX
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('.icon-option').click(function() {
            $('.icon-option').removeClass('selected');
            $(this).addClass('selected');
            $(this).find('input[type="radio"]').prop('checked', true);
        });
        
        $('input[name="service_icon"]:checked').closest('.icon-option').addClass('selected');
        
        $('#service_custom_icon').on('input', function() {
            if ($(this).val()) {
                $('input[name="service_icon"]').prop('checked', false);
                $('.icon-option').removeClass('selected');
            }
        });
    });
    </script>
    <style>
    .icon-option.selected {
        background: #0073aa;
        color: white;
    }
    .icon-option:hover {
        background: #f0f0f1;
    }
    .icon-option.selected:hover {
        background: #005a87;
    }
    .apc-icon-selector .icon-grid {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 4px;
    }
    </style>
    <?php
}

/**
 * Add Page and Service Meta Boxes for Header Content
 */
function apc_add_header_content_meta_boxes() {
    $post_types = array('page', 'service');
    
    foreach ($post_types as $post_type) {
        add_meta_box(
            'apc-header-content',
            'Header Content (Subtitle & Button)',
            'apc_render_header_content_meta_box',
            $post_type,
            'side',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'apc_add_header_content_meta_boxes');





/**
 * Header Content Meta Box Callback (for Pages and Services)
 */
function apc_render_header_content_meta_box($post) {
    wp_nonce_field('apc_header_content_meta_box', 'apc_header_content_nonce');
    
    // Get current values (support both old page_ and new header_ meta keys for backward compatibility)
    $subtitle = get_post_meta($post->ID, '_header_subtitle', true);
    if (empty($subtitle)) {
        $subtitle = get_post_meta($post->ID, '_page_subtitle', true); // Backward compatibility
    }
    
    $button_text = get_post_meta($post->ID, '_header_button_text', true);
    if (empty($button_text)) {
        $button_text = get_post_meta($post->ID, '_page_button_text', true); // Backward compatibility
    }
    
    $button_link_type = get_post_meta($post->ID, '_header_button_link_type', true);
    if (empty($button_link_type)) {
        $button_link_type = get_post_meta($post->ID, '_page_button_link_type', true); // Backward compatibility
    }
    
    $button_page_id = get_post_meta($post->ID, '_header_button_page_id', true);
    if (empty($button_page_id)) {
        $button_page_id = get_post_meta($post->ID, '_page_button_page_id', true); // Backward compatibility
    }
    
    $button_custom_url = get_post_meta($post->ID, '_header_button_custom_url', true);
    if (empty($button_custom_url)) {
        $button_custom_url = get_post_meta($post->ID, '_page_button_custom_url', true); // Backward compatibility
    }
    
    if (empty($button_link_type)) {
        $button_link_type = 'page';
    }
    
    $post_type_label = ($post->post_type === 'service') ? 'service' : 'page';
    
    echo '<table class="form-table">';
    
    // Hide Header field
    $hide_header = get_post_meta($post->ID, '_hide_header', true);
    echo '<tr>';
    echo '<th><label for="apc_hide_header">Hide Header:</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="apc_hide_header" name="apc_hide_header" value="1"' . checked($hide_header, '1', false) . ' />';
    echo '<label for="apc_hide_header">Hide the entire page header section</label>';
    echo '<p class="description">Check this to hide the header with title, subtitle, and button on this ' . $post_type_label . '.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Subtitle field
    echo '<tr>';
    echo '<th><label for="apc_header_subtitle">Subtitle:</label></th>';
    echo '<td>';
    echo '<input type="text" id="apc_header_subtitle" name="apc_header_subtitle" value="' . esc_attr($subtitle) . '" style="width: 100%;" placeholder="Enter ' . $post_type_label . ' subtitle..." />';
    echo '<p class="description">This subtitle will appear below the main ' . $post_type_label . ' title in the header.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Button text field
    echo '<tr>';
    echo '<th><label for="apc_header_button_text">Button Text:</label></th>';
    echo '<td>';
    echo '<input type="text" id="apc_header_button_text" name="apc_header_button_text" value="' . esc_attr($button_text) . '" style="width: 100%;" placeholder="Enter button text..." />';
    echo '<p class="description">Leave empty to hide the button.</p>';
    echo '</td>';
    echo '</tr>';
    
    // Button link type
    echo '<tr>';
    echo '<th><label for="apc_header_button_link_type">Button Link Type:</label></th>';
    echo '<td>';
    echo '<select id="apc_header_button_link_type" name="apc_header_button_link_type" style="width: 100%;" onchange="toggleHeaderButtonLinkFields()">';
    echo '<option value="page"' . selected($button_link_type, 'page', false) . '>Select Existing Page</option>';
    echo '<option value="custom"' . selected($button_link_type, 'custom', false) . '>Custom URL</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Page selector
    echo '<tr id="header_page_selector_row" style="' . ($button_link_type == 'custom' ? 'display: none;' : '') . '">';
    echo '<th><label for="apc_header_button_page_id">Select Page:</label></th>';
    echo '<td>';
    wp_dropdown_pages(array(
        'name' => 'apc_header_button_page_id',
        'id' => 'apc_header_button_page_id',
        'selected' => $button_page_id,
        'show_option_none' => '-- Select a page --',
        'option_none_value' => '',
        'class' => 'widefat'
    ));
    echo '</td>';
    echo '</tr>';
    
    // Custom URL field
    echo '<tr id="header_custom_url_row" style="' . ($button_link_type == 'page' ? 'display: none;' : '') . '">';
    echo '<th><label for="apc_header_button_custom_url">Custom URL:</label></th>';
    echo '<td>';
    echo '<input type="url" id="apc_header_button_custom_url" name="apc_header_button_custom_url" value="' . esc_attr($button_custom_url) . '" style="width: 100%;" placeholder="https://example.com" />';
    echo '<p class="description">Enter a full URL including http:// or https://</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
    
    // Add JavaScript for toggling fields
    echo '<script>
    function toggleHeaderButtonLinkFields() {
        var linkType = document.getElementById("apc_header_button_link_type").value;
        var pageRow = document.getElementById("header_page_selector_row");
        var customRow = document.getElementById("header_custom_url_row");
        
        if (linkType === "page") {
            pageRow.style.display = "table-row";
            customRow.style.display = "none";
        } else {
            pageRow.style.display = "none";
            customRow.style.display = "table-row";
        }
    }
    </script>';
}

/**
 * Save Service Meta Data (Icon only)
 */
function apc_save_service_meta($post_id) {
    // Check nonce and permissions
    if (!isset($_POST['service_icon_nonce']) || !wp_verify_nonce($_POST['service_icon_nonce'], 'apc_service_icon_nonce')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
        return;
    }
    
    // Save icon
    $icon = '';
    if (isset($_POST['service_custom_icon']) && !empty($_POST['service_custom_icon'])) {
        $icon = sanitize_text_field($_POST['service_custom_icon']);
    } elseif (isset($_POST['service_icon'])) {
        $icon = sanitize_text_field($_POST['service_icon']);
    }
    update_post_meta($post_id, '_service_icon', $icon);
}
add_action('save_post', 'apc_save_service_meta');

/**
 * Save Header Content Meta Data (for Pages and Services)
 */
function apc_save_header_content_meta($post_id) {
    $post_type = get_post_type($post_id);
    if (!in_array($post_type, array('page', 'service'))) {
        return;
    }
    
    if (!isset($_POST['apc_header_content_nonce']) || !wp_verify_nonce($_POST['apc_header_content_nonce'], 'apc_header_content_meta_box')) {
        return;
    }
    
    // Check permissions based on post type
    if ($post_type === 'page' && !current_user_can('edit_page', $post_id)) {
        return;
    }
    if ($post_type === 'service' && !current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Save hide header checkbox
    if (isset($_POST['apc_hide_header'])) {
        update_post_meta($post_id, '_hide_header', '1');
    } else {
        delete_post_meta($post_id, '_hide_header');
    }
    
    // Save all header content fields with new naming
    $fields = array(
        'apc_header_subtitle' => '_header_subtitle',
        'apc_header_button_text' => '_header_button_text',
        'apc_header_button_link_type' => '_header_button_link_type',
        'apc_header_button_custom_url' => '_header_button_custom_url'
    );
    
    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            if ($field === 'apc_header_button_custom_url') {
                update_post_meta($post_id, $meta_key, esc_url_raw($_POST[$field]));
            } else {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
            }
        } else {
            delete_post_meta($post_id, $meta_key);
        }
    }
    
    // Handle page ID separately
    if (isset($_POST['apc_header_button_page_id'])) {
        update_post_meta($post_id, '_header_button_page_id', intval($_POST['apc_header_button_page_id']));
    } else {
        delete_post_meta($post_id, '_header_button_page_id');
    }
}
add_action('save_post', 'apc_save_header_content_meta');

/**
 * Save Post Type Meta
 */
function apc_save_post_type_meta($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['post_type_nonce']) || !wp_verify_nonce($_POST['post_type_nonce'], 'apc_post_type_nonce')) {
        return;
    }

    // Check if user has permissions to edit
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save content type
    if (isset($_POST['apc_content_type'])) {
        update_post_meta($post_id, '_apc_content_type', sanitize_text_field($_POST['apc_content_type']));
    }

    // Save video fields
    if (isset($_POST['video_url'])) {
        update_post_meta($post_id, '_video_url', sanitize_url($_POST['video_url']));
    }
    if (isset($_POST['video_duration'])) {
        update_post_meta($post_id, '_video_duration', sanitize_text_field($_POST['video_duration']));
    }

    // Save whitepaper fields
    if (isset($_POST['whitepaper_file'])) {
        update_post_meta($post_id, '_whitepaper_file', sanitize_url($_POST['whitepaper_file']));
    }
    if (isset($_POST['whitepaper_size'])) {
        update_post_meta($post_id, '_whitepaper_size', sanitize_text_field($_POST['whitepaper_size']));
    }

    // Save customer success fields
    if (isset($_POST['customer_company'])) {
        update_post_meta($post_id, '_customer_company', sanitize_text_field($_POST['customer_company']));
    }
    if (isset($_POST['customer_industry'])) {
        update_post_meta($post_id, '_customer_industry', sanitize_text_field($_POST['customer_industry']));
    }
    if (isset($_POST['customer_logo'])) {
        update_post_meta($post_id, '_customer_logo', sanitize_url($_POST['customer_logo']));
    }
}
add_action('save_post', 'apc_save_post_type_meta');

/**
 * Helper function to get header button URL (for pages and services)
 */
function apc_get_header_button_url($post_id) {
    // Try new field names first, fall back to old names for backward compatibility
    $link_type = get_post_meta($post_id, '_header_button_link_type', true);
    if (empty($link_type)) {
        $link_type = get_post_meta($post_id, '_page_button_link_type', true);
    }
    
    if ($link_type === 'custom') {
        $url = get_post_meta($post_id, '_header_button_custom_url', true);
        if (empty($url)) {
            $url = get_post_meta($post_id, '_page_button_custom_url', true);
        }
        return $url;
    } else {
        $page_id = get_post_meta($post_id, '_header_button_page_id', true);
        if (empty($page_id)) {
            $page_id = get_post_meta($post_id, '_page_button_page_id', true);
        }
        if ($page_id) {
            return get_permalink($page_id);
        }
    }
    
    return '';
}

/**
 * Helper function to get header subtitle (for pages and services)
 */
function apc_get_header_subtitle($post_id) {
    $subtitle = get_post_meta($post_id, '_header_subtitle', true);
    if (empty($subtitle)) {
        $subtitle = get_post_meta($post_id, '_page_subtitle', true); // Backward compatibility
    }
    return $subtitle;
}

/**
 * Helper function to get header button text (for pages and services)
 */
function apc_get_header_button_text($post_id) {
    $button_text = get_post_meta($post_id, '_header_button_text', true);
    if (empty($button_text)) {
        $button_text = get_post_meta($post_id, '_page_button_text', true); // Backward compatibility
    }
    return $button_text;
}

/**
 * Helper function to check if header should be hidden (for pages and services)
 */
function apc_is_header_hidden($post_id) {
    return get_post_meta($post_id, '_hide_header', true) === '1';
}