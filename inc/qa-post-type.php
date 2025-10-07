<?php
/**
 * Q&A Custom Post Type and Taxonomy
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Q&A Custom Post Type
 */
function apc_register_qa_post_type() {
    $labels = array(
        'name'                  => _x('Q&A', 'Post Type General Name', 'apc-theme'),
        'singular_name'         => _x('Q&A', 'Post Type Singular Name', 'apc-theme'),
        'menu_name'             => __('Q&A', 'apc-theme'),
        'name_admin_bar'        => __('Q&A', 'apc-theme'),
        'archives'              => __('Q&A Archives', 'apc-theme'),
        'attributes'            => __('Q&A Attributes', 'apc-theme'),
        'parent_item_colon'     => __('Parent Q&A:', 'apc-theme'),
        'all_items'             => __('All Q&A', 'apc-theme'),
        'add_new_item'          => __('Add New Q&A', 'apc-theme'),
        'add_new'               => __('Add New', 'apc-theme'),
        'new_item'              => __('New Q&A', 'apc-theme'),
        'edit_item'             => __('Edit Q&A', 'apc-theme'),
        'update_item'           => __('Update Q&A', 'apc-theme'),
        'view_item'             => __('View Q&A', 'apc-theme'),
        'view_items'            => __('View Q&A', 'apc-theme'),
        'search_items'          => __('Search Q&A', 'apc-theme'),
        'not_found'             => __('Not found', 'apc-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'apc-theme'),
        'featured_image'        => __('Featured Image', 'apc-theme'),
        'set_featured_image'    => __('Set featured image', 'apc-theme'),
        'remove_featured_image' => __('Remove featured image', 'apc-theme'),
        'use_featured_image'    => __('Use as featured image', 'apc-theme'),
        'insert_into_item'      => __('Insert into Q&A', 'apc-theme'),
        'uploaded_to_this_item' => __('Uploaded to this Q&A', 'apc-theme'),
        'items_list'            => __('Q&A list', 'apc-theme'),
        'items_list_navigation' => __('Q&A list navigation', 'apc-theme'),
        'filter_items_list'     => __('Filter Q&A list', 'apc-theme'),
    );

    $args = array(
        'label'                 => __('Q&A', 'apc-theme'),
        'description'           => __('Questions and Answers', 'apc-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'revisions'),
        'taxonomies'            => array('qa_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-editor-help',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'qa',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );

    register_post_type('qa', $args);
}
add_action('init', 'apc_register_qa_post_type', 0);

/**
 * Register Q&A Category Taxonomy
 */
function apc_register_qa_category_taxonomy() {
    $labels = array(
        'name'                       => _x('Q&A Categories', 'Taxonomy General Name', 'apc-theme'),
        'singular_name'              => _x('Q&A Category', 'Taxonomy Singular Name', 'apc-theme'),
        'menu_name'                  => __('Q&A Categories', 'apc-theme'),
        'all_items'                  => __('All Categories', 'apc-theme'),
        'parent_item'                => __('Parent Category', 'apc-theme'),
        'parent_item_colon'          => __('Parent Category:', 'apc-theme'),
        'new_item_name'              => __('New Category Name', 'apc-theme'),
        'add_new_item'               => __('Add New Category', 'apc-theme'),
        'edit_item'                  => __('Edit Category', 'apc-theme'),
        'update_item'                => __('Update Category', 'apc-theme'),
        'view_item'                  => __('View Category', 'apc-theme'),
        'separate_items_with_commas' => __('Separate categories with commas', 'apc-theme'),
        'add_or_remove_items'        => __('Add or remove categories', 'apc-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'apc-theme'),
        'popular_items'              => __('Popular Categories', 'apc-theme'),
        'search_items'               => __('Search Categories', 'apc-theme'),
        'not_found'                  => __('Not Found', 'apc-theme'),
        'no_terms'                   => __('No categories', 'apc-theme'),
        'items_list'                 => __('Categories list', 'apc-theme'),
        'items_list_navigation'      => __('Categories list navigation', 'apc-theme'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'qa_category',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
    );

    register_taxonomy('qa_category', array('qa'), $args);
}
add_action('init', 'apc_register_qa_category_taxonomy', 0);

/**
 * Add custom fields to Q&A post type
 */
function apc_add_qa_meta_boxes() {
    add_meta_box(
        'qa_details',
        __('Q&A Details', 'apc-theme'),
        'apc_qa_details_callback',
        'qa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apc_add_qa_meta_boxes');

/**
 * Q&A Details meta box callback
 */
function apc_qa_details_callback($post) {
    wp_nonce_field('apc_qa_details_nonce', 'qa_details_nonce');
    
    $question = get_post_meta($post->ID, '_qa_question', true);
    $answer = get_post_meta($post->ID, '_qa_answer', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="qa_question"><?php _e('Question', 'apc-theme'); ?></label></th>
            <td>
                <textarea name="qa_question" id="qa_question" rows="3" style="width: 100%;"><?php echo esc_textarea($question); ?></textarea>
                <p class="description"><?php _e('Enter the question here.', 'apc-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="qa_answer"><?php _e('Answer', 'apc-theme'); ?></label></th>
            <td>
                <?php
                wp_editor($answer, 'qa_answer', array(
                    'textarea_name' => 'qa_answer',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                    'teeny' => false,
                    'tinymce' => true
                ));
                ?>
                <p class="description"><?php _e('Enter the detailed answer here. HTML is supported.', 'apc-theme'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Q&A meta fields
 */
function apc_save_qa_meta($post_id) {
    if (!isset($_POST['qa_details_nonce']) || !wp_verify_nonce($_POST['qa_details_nonce'], 'apc_qa_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['qa_question'])) {
        update_post_meta($post_id, '_qa_question', sanitize_textarea_field($_POST['qa_question']));
    }

    if (isset($_POST['qa_answer'])) {
        update_post_meta($post_id, '_qa_answer', wp_kses_post($_POST['qa_answer']));
    }
}
add_action('save_post', 'apc_save_qa_meta');

/**
 * Customize Q&A admin columns
 */
function apc_qa_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['qa_question'] = __('Question', 'apc-theme');
    $new_columns['qa_category'] = __('Category', 'apc-theme');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_qa_posts_columns', 'apc_qa_admin_columns');

/**
 * Populate custom admin columns
 */
function apc_qa_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'qa_question':
            $question = get_post_meta($post_id, '_qa_question', true);
            echo !empty($question) ? wp_trim_words($question, 15, '...') : '—';
            break;
        case 'qa_category':
            $terms = get_the_terms($post_id, 'qa_category');
            if ($terms && !is_wp_error($terms)) {
                $term_names = wp_list_pluck($terms, 'name');
                echo implode(', ', $term_names);
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_qa_posts_custom_column', 'apc_qa_admin_column_content', 10, 2);
?>