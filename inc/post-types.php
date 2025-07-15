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

/**
 * Register custom post type for Projects (Dự án)
 */
function giving_register_project_post_type() {
    $labels = array(
        'name'               => _x('Dự án', 'post type general name'),
        'singular_name'      => _x('Dự án', 'post type singular name'),
        'menu_name'          => _x('Dự án', 'admin menu'),
        'name_admin_bar'     => _x('Dự án', 'add new on admin bar'),
        'add_new'            => _x('Thêm mới', 'project'),
        'add_new_item'       => __('Thêm dự án mới'),
        'new_item'           => __('Dự án mới'),
        'edit_item'          => __('Sửa dự án'),
        'view_item'          => __('Xem dự án'),
        'all_items'          => __('Tất cả dự án'),
        'search_items'       => __('Tìm kiếm dự án'),
        'parent_item_colon'  => __('Dự án cha:'),
        'not_found'          => __('Không tìm thấy dự án nào.'),
        'not_found_in_trash' => __('Không tìm thấy dự án nào trong thùng rác.')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'du-an'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
    );

    register_post_type('project', $args);
}
add_action('init', 'giving_register_project_post_type');

/**
 * Register taxonomy for Project Styles (Phong cách)
 */
function giving_register_project_style_taxonomy() {
    $labels = array(
        'name'              => _x('Phong cách', 'taxonomy general name'),
        'singular_name'     => _x('Phong cách', 'taxonomy singular name'),
        'search_items'      => __('Tìm kiếm phong cách'),
        'all_items'         => __('Tất cả phong cách'),
        'parent_item'       => __('Phong cách cha'),
        'parent_item_colon' => __('Phong cách cha:'),
        'edit_item'         => __('Sửa phong cách'),
        'update_item'       => __('Cập nhật phong cách'),
        'add_new_item'      => __('Thêm phong cách mới'),
        'new_item_name'     => __('Tên phong cách mới'),
        'menu_name'         => __('Phong cách')
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'phong-cach')
    );

    register_taxonomy('project_style', array('project'), $args);
}
add_action('init', 'giving_register_project_style_taxonomy');

/**
 * Register taxonomy for Project Categories (Thể loại)
 */
function giving_register_project_category_taxonomy() {
    $labels = array(
        'name'              => _x('Thể loại', 'taxonomy general name'),
        'singular_name'     => _x('Thể loại', 'taxonomy singular name'),
        'search_items'      => __('Tìm kiếm thể loại'),
        'all_items'         => __('Tất cả thể loại'),
        'parent_item'       => __('Thể loại cha'),
        'parent_item_colon' => __('Thể loại cha:'),
        'edit_item'         => __('Sửa thể loại'),
        'update_item'       => __('Cập nhật thể loại'),
        'add_new_item'      => __('Thêm thể loại mới'),
        'new_item_name'     => __('Tên thể loại mới'),
        'menu_name'         => __('Thể loại')
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'the-loai')
    );

    register_taxonomy('project_category', array('project'), $args);
}
add_action('init', 'giving_register_project_category_taxonomy');

/**
 * Register taxonomy for Project Areas (Diện tích)
 */
function giving_register_project_area_taxonomy() {
    $labels = array(
        'name'              => _x('Diện tích', 'taxonomy general name'),
        'singular_name'     => _x('Diện tích', 'taxonomy singular name'),
        'search_items'      => __('Tìm kiếm diện tích'),
        'all_items'         => __('Tất cả diện tích'),
        'parent_item'       => __('Diện tích cha'),
        'parent_item_colon' => __('Diện tích cha:'),
        'edit_item'         => __('Sửa diện tích'),
        'update_item'       => __('Cập nhật diện tích'),
        'add_new_item'      => __('Thêm diện tích mới'),
        'new_item_name'     => __('Tên diện tích mới'),
        'menu_name'         => __('Diện tích')
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'dien-tich')
    );

    register_taxonomy('project_area', array('project'), $args);
}
add_action('init', 'giving_register_project_area_taxonomy'); 