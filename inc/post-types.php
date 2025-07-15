<?php
/**
 * Custom Post Types and Taxonomies
 *
 * Register custom post types and taxonomies for the theme.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register custom post type for Services (Dịch vụ)
 */
function giving_register_service_post_type() {
    $labels = array(
        'name'               => _x('Dịch vụ', 'post type general name'),
        'singular_name'      => _x('Dịch vụ', 'post type singular name'),
        'menu_name'          => _x('Dịch vụ', 'admin menu'),
        'name_admin_bar'     => _x('Dịch vụ', 'add new on admin bar'),
        'add_new'            => _x('Thêm mới', 'service'),
        'add_new_item'       => __('Thêm dịch vụ mới'),
        'new_item'           => __('Dịch vụ mới'),
        'edit_item'          => __('Sửa dịch vụ'),
        'view_item'          => __('Xem dịch vụ'),
        'all_items'          => __('Tất cả dịch vụ'),
        'search_items'       => __('Tìm kiếm dịch vụ'),
        'parent_item_colon'  => __('Dịch vụ cha:'),
        'not_found'          => __('Không tìm thấy dịch vụ nào.'),
        'not_found_in_trash' => __('Không tìm thấy dịch vụ nào trong thùng rác.')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'dich-vu'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
    );

    register_post_type('service', $args);
}
add_action('init', 'giving_register_service_post_type');

/**
 * Register custom taxonomy for Service Categories (Danh mục dịch vụ)
 */
function giving_register_service_taxonomy() {
    $labels = array(
        'name'              => _x('Danh mục dịch vụ', 'taxonomy general name'),
        'singular_name'     => _x('Danh mục dịch vụ', 'taxonomy singular name'),
        'search_items'      => __('Tìm kiếm danh mục'),
        'all_items'         => __('Tất cả danh mục'),
        'parent_item'       => __('Danh mục cha'),
        'parent_item_colon' => __('Danh mục cha:'),
        'edit_item'         => __('Sửa danh mục'),
        'update_item'       => __('Cập nhật danh mục'),
        'add_new_item'      => __('Thêm danh mục mới'),
        'new_item_name'     => __('Tên danh mục mới'),
        'menu_name'         => __('Danh mục dịch vụ')
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'danh-muc-dich-vu')
    );

    register_taxonomy('service_category', array('service'), $args);
}
add_action('init', 'giving_register_service_taxonomy'); 