<?php
/**
 * Sectors Custom Post Type
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Sectors Custom Post Type
 */
function apc_register_sectors_post_type() {
    $labels = array(
        'name'                  => _x('Sectors', 'Post type general name', 'apc-theme'),
        'singular_name'         => _x('Sector', 'Post type singular name', 'apc-theme'),
        'menu_name'             => _x('Sectors', 'Admin Menu text', 'apc-theme'),
        'name_admin_bar'        => _x('Sector', 'Add New on Toolbar', 'apc-theme'),
        'add_new'               => __('Add New', 'apc-theme'),
        'add_new_item'          => __('Add New Sector', 'apc-theme'),
        'new_item'              => __('New Sector', 'apc-theme'),
        'edit_item'             => __('Edit Sector', 'apc-theme'),
        'view_item'             => __('View Sector', 'apc-theme'),
        'all_items'             => __('All Sectors', 'apc-theme'),
        'search_items'          => __('Search Sectors', 'apc-theme'),
        'parent_item_colon'     => __('Parent Sectors:', 'apc-theme'),
        'not_found'             => __('No sectors found.', 'apc-theme'),
        'not_found_in_trash'    => __('No sectors found in Trash.', 'apc-theme'),
        'featured_image'        => _x('Sector Featured Image', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'apc-theme'),
        'set_featured_image'    => _x('Set sector image', 'Overrides the "Set featured image" phrase for this post type. Added in 4.3', 'apc-theme'),
        'remove_featured_image' => _x('Remove sector image', 'Overrides the "Remove featured image" phrase for this post type. Added in 4.3', 'apc-theme'),
        'use_featured_image'    => _x('Use as sector image', 'Overrides the "Use as featured image" phrase for this post type. Added in 4.3', 'apc-theme'),
        'archives'              => _x('Sector archives', 'The post type archive label used in nav menus. Default "Post Archives". Added in 4.4', 'apc-theme'),
        'insert_into_item'      => _x('Insert into sector', 'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post). Added in 4.4', 'apc-theme'),
        'uploaded_to_this_item' => _x('Uploaded to this sector', 'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post). Added in 4.4', 'apc-theme'),
        'filter_items_list'     => _x('Filter sectors list', 'Screen reader text for the filter links heading on the post type listing screen. Default "Filter posts list"/"Filter pages list". Added in 4.4', 'apc-theme'),
        'items_list_navigation' => _x('Sectors list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default "Posts list navigation"/"Pages list navigation". Added in 4.4', 'apc-theme'),
        'items_list'            => _x('Sectors list', 'Screen reader text for the items list heading on the post type listing screen. Default "Posts list"/"Pages list". Added in 4.4', 'apc-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'sectors'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-building',
        'show_in_rest'       => true, // Enable Gutenberg editor
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'custom-fields',
            'page-attributes'
        ),
    );

    register_post_type('sector', $args);
}
add_action('init', 'apc_register_sectors_post_type');

/**
 * Register Sector Categories Taxonomy
 */
function apc_register_sector_categories_taxonomy() {
    $labels = array(
        'name'                       => _x('Sector Categories', 'Taxonomy General Name', 'apc-theme'),
        'singular_name'              => _x('Sector Category', 'Taxonomy Singular Name', 'apc-theme'),
        'menu_name'                  => __('Sector Categories', 'apc-theme'),
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
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'sector-category'),
    );

    register_taxonomy('sector_category', array('sector'), $args);
}
add_action('init', 'apc_register_sector_categories_taxonomy');

/**
 * Register Sector Tags Taxonomy
 */
function apc_register_sector_tags_taxonomy() {
    $labels = array(
        'name'                       => _x('Sector Tags', 'Taxonomy General Name', 'apc-theme'),
        'singular_name'              => _x('Sector Tag', 'Taxonomy Singular Name', 'apc-theme'),
        'menu_name'                  => __('Sector Tags', 'apc-theme'),
        'all_items'                  => __('All Tags', 'apc-theme'),
        'new_item_name'              => __('New Tag Name', 'apc-theme'),
        'add_new_item'               => __('Add New Tag', 'apc-theme'),
        'edit_item'                  => __('Edit Tag', 'apc-theme'),
        'update_item'                => __('Update Tag', 'apc-theme'),
        'view_item'                  => __('View Tag', 'apc-theme'),
        'separate_items_with_commas' => __('Separate tags with commas', 'apc-theme'),
        'add_or_remove_items'        => __('Add or remove tags', 'apc-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'apc-theme'),
        'popular_items'              => __('Popular Tags', 'apc-theme'),
        'search_items'               => __('Search Tags', 'apc-theme'),
        'not_found'                  => __('Not Found', 'apc-theme'),
        'no_terms'                   => __('No tags', 'apc-theme'),
        'items_list'                 => __('Tags list', 'apc-theme'),
        'items_list_navigation'      => __('Tags list navigation', 'apc-theme'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'sector-tag'),
    );

    register_taxonomy('sector_tag', array('sector'), $args);
}
add_action('init', 'apc_register_sector_tags_taxonomy');



/**
 * Customize columns for sectors admin list
 */
function apc_sectors_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['sector_category'] = __('Category', 'apc-theme');
    $new_columns['featured_image'] = __('Image', 'apc-theme');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_sector_posts_columns', 'apc_sectors_admin_columns');

/**
 * Display custom column content
 */
function apc_sectors_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'sector_category':
            $terms = get_the_terms($post_id, 'sector_category');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo implode(', ', $term_names);
            } else {
                echo '—';
            }
            break;
            
        case 'featured_image':
            $thumbnail = get_the_post_thumbnail($post_id, array(50, 50));
            if ($thumbnail) {
                echo $thumbnail;
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_sector_posts_custom_column', 'apc_sectors_admin_column_content', 10, 2);

/**
 * Make custom columns sortable
 */
function apc_sectors_sortable_columns($columns) {
    $columns['sector_category'] = 'sector_category';
    return $columns;
}
add_filter('manage_edit-sector_sortable_columns', 'apc_sectors_sortable_columns');

/**
 * Flush rewrite rules on theme activation
 */
function apc_flush_rewrite_rules() {
    apc_register_sectors_post_type();
    apc_register_sector_categories_taxonomy();
    apc_register_sector_tags_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'apc_flush_rewrite_rules');
?>