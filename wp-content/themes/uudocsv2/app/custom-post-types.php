<?php
/**
 * Custom post types
 */

add_action('init', 'create_docs_cpt');

function create_docs_cpt()
{
    // Register product post type
    /*
    register_post_type(
        'product',
        array(
            'labels' => array(
                'name'               => 'Products',
                'singular_name'      => 'Product',
                'menu_name'          => 'Products',
                'name_admin_bar'     => 'Products',
                'add_new'            => 'Add New Product',
                'add_new_item'       => 'Add New Product',
                'edit_item'          => 'Edit',
                'new_item'           => 'New',
                'view_item'          => 'View',
                'search_items'       => 'Search',
                'not_found'          => 'No products found',
                'not_found_in_trash' => 'No products found in trash',
                'all_items'          => 'Products',
            ),
            'public'                 => true,
            'menu_position'          => 14,
            'supports'               => array('title', 'editor', 'thumbnail'),
            'show_in_rest'           => false,
            'taxonomies'             => array(''),
            'menu_icon'              => 'dashicons-products',
            'has_archive'            => false
        )
    );
    */

    // Register release notes post type
    register_post_type(
        'release_note',
        array(
            'labels' => array(
                'name'               => 'Release Notes',
                'singular_name'      => 'Note',
                'menu_name'          => 'Release Notes',
                'name_admin_bar'     => 'Release Notes',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Note',
                'edit_item'          => 'Edit',
                'new_item'           => 'New',
                'view_item'          => 'View',
                'search_items'       => 'Search',
                'not_found'          => 'No release notes found',
                'not_found_in_trash' => 'No release notes found in trash',
                'all_items'          => 'Release Notes',
            ),
            'public'                 => true,
            'menu_position'          => 15,
            'supports'               => array('title', 'editor', 'thumbnail'),
            'show_in_rest'           => false,
            'taxonomies'             => array(''),
            'menu_icon'              => 'dashicons-media-document',
            'has_archive'            => false,
            'rewrite'                => array('slug' => 'release-note'),
        )
    );

    // Generate feature taxonomy labels
    $platform_labels = array(
        'name'              => __('Product', 'taxonomy general name'),
        'singular_name'     => __('Product', 'taxonomy singular name'),
        'search_items'      => __('Search Products'),
        'all_items'         => __('All Products'),
        'parent_item'       => __('Parent Product'),
        'parent_item_colon' => __('Parent Product:'),
        'edit_item'         => __('Edit Product'),
        'update_item'       => __('Update Product'),
        'add_new_item'      => __('Add New Product'),
        'new_item_name'     => __('New Product Name'),
        'menu_name'         => __('Product'),
    );

    // Register feature taxonomy
    register_taxonomy(
        'product',
        array('release_note', 'guide'),
        array(
            'hierarchical'      => true,
            'label'             => __('Product', ''),
            'labels'            => $platform_labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_nav_menus' => true,
            'rewrite'           => array('slug' => 'product'),
        )
    );

    // Generate feature taxonomy labels
    $feature_labels = array(
        'name'              => __('Feature', 'taxonomy general name'),
        'singular_name'     => __('Feature', 'taxonomy singular name'),
        'search_items'      => __('Search Features'),
        'all_items'         => __('All Features'),
        'parent_item'       => __('Parent Feature'),
        'parent_item_colon' => __('Parent Feature:'),
        'edit_item'         => __('Edit Feature'),
        'update_item'       => __('Update Feature'),
        'add_new_item'      => __('Add New Feature'),
        'new_item_name'     => __('New Feature Name'),
        'menu_name'         => __('Feature'),
    );

    // Register feature taxonomy
    register_taxonomy(
        'feature',
        array('release_note'),
        array(
            'hierarchical'      => true,
            'labels'            => $feature_labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'feature'),
        )
    );

    // Generate user taxonomy labels
    $user_labels = array(
        'name'              => __('User', 'taxonomy general name'),
        'singular_name'     => __('User', 'taxonomy singular name'),
        'search_items'      => __('Search Users'),
        'all_items'         => __('All Users'),
        'parent_item'       => __('Parent User'),
        'parent_item_colon' => __('Parent User:'),
        'edit_item'         => __('Edit User'),
        'update_item'       => __('Update User'),
        'add_new_item'      => __('Add New User'),
        'new_item_name'     => __('New User Name'),
        'menu_name'         => __('User'),
    );

    // Register user taxonomy
    register_taxonomy(
        'user',
        array('release_note'),
        array(
            'hierarchical'      => true,
            'public'            => true,
            'labels'            => $user_labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'user'),
        )
    );

    // Register guide post type
    register_post_type(
        'guide',
        array(
            'labels' => array(
                'name'               => 'Guides',
                'singular_name'      => 'Guide',
                'menu_name'          => 'Guides',
                'name_admin_bar'     => 'Guides',
                'add_new'            => 'Add New Guide',
                'add_new_item'       => 'Add New Guide',
                'edit_item'          => 'Edit',
                'new_item'           => 'New',
                'view_item'          => 'View',
                'search_items'       => 'Search',
                'not_found'          => 'No Guides found',
                'not_found_in_trash' => 'No Guides found in trash',
                'all_items'          => 'Guides',
            ),
            'public'                 => true,
            'menu_position'          => 15,
            'supports'               => array('title', 'editor', 'page-attributes', 'thumbnail'),
            'show_in_rest'           => false,
            'taxonomies'             => array(''),
            'menu_icon'              => 'dashicons-book',
            'hierarchical'           => false,
            'has_archive'            => false
        )
    );

    // Generate guide taxonomy labels
    $labels = array(
        'name'              => __('Guide Section', 'taxonomy general name'),
        'singular_name'     => __('Guide Section', 'taxonomy singular name'),
        'search_items'      => __('Search Guide Sections'),
        'all_items'         => __('All Guide Sections'),
        'parent_item'       => __('Parent Guide Section'),
        'parent_item_colon' => __('Parent Guide Section:'),
        'edit_item'         => __('Edit Guide Section'),
        'update_item'       => __('Update Guide Section'),
        'add_new_item'      => __('Add New Guide Section'),
        'new_item_name'     => __('New Guide Section Name'),
        'menu_name'         => __('Guide Sections'),
    );

    // Register guide taxonomy
    register_taxonomy(
        'guide_section',
        array('guide'),
        array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'guide-section'),
        )
    );
}
