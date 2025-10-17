<?php
/**
 * Custom Post Types and Meta Boxes
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Services Custom Post Type
 */
function apc_register_services_post_type() {
    $labels = array(
        'name'                  => _x('Services', 'Post Type General Name', 'apc-theme'),
        'singular_name'         => _x('Service', 'Post Type Singular Name', 'apc-theme'),
        'menu_name'             => __('Services', 'apc-theme'),
        'name_admin_bar'        => __('Service', 'apc-theme'),
        'archives'              => __('Service Archives', 'apc-theme'),
        'attributes'            => __('Service Attributes', 'apc-theme'),
        'parent_item_colon'     => __('Parent Service:', 'apc-theme'),
        'all_items'             => __('All Services', 'apc-theme'),
        'add_new_item'          => __('Add New Service', 'apc-theme'),
        'add_new'               => __('Add New', 'apc-theme'),
        'new_item'              => __('New Service', 'apc-theme'),
        'edit_item'             => __('Edit Service', 'apc-theme'),
        'update_item'           => __('Update Service', 'apc-theme'),
        'view_item'             => __('View Service', 'apc-theme'),
        'view_items'            => __('View Services', 'apc-theme'),
        'search_items'          => __('Search Service', 'apc-theme'),
        'not_found'             => __('Not found', 'apc-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'apc-theme'),
        'featured_image'        => __('Featured Image', 'apc-theme'),
        'set_featured_image'    => __('Set featured image', 'apc-theme'),
        'remove_featured_image' => __('Remove featured image', 'apc-theme'),
        'use_featured_image'    => __('Use as featured image', 'apc-theme'),
        'insert_into_item'      => __('Insert into service', 'apc-theme'),
        'uploaded_to_this_item' => __('Uploaded to this service', 'apc-theme'),
        'items_list'            => __('Services list', 'apc-theme'),
        'items_list_navigation' => __('Services list navigation', 'apc-theme'),
        'filter_items_list'     => __('Filter services list', 'apc-theme'),
    );
    
    $args = array(
        'label'                 => __('Service', 'apc-theme'),
        'description'           => __('APC Services', 'apc-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'            => array('service_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-tools',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => 'solution'),
    );
    
    register_post_type('service', $args);
}
add_action('init', 'apc_register_services_post_type', 0);

/**
 * Register Service Categories Taxonomy
 */
function apc_register_service_categories() {
    $labels = array(
        'name'                       => _x('Service Categories', 'Taxonomy General Name', 'apc-theme'),
        'singular_name'              => _x('Service Category', 'Taxonomy Singular Name', 'apc-theme'),
        'menu_name'                  => __('Categories', 'apc-theme'),
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
    );
    
    register_taxonomy('service_category', array('service'), $args);
}
add_action('init', 'apc_register_service_categories', 0);