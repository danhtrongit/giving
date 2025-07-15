<?php
/**
 * Theme Setup Functions
 * 
 * Functions for basic theme setup, including styles and scripts.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue parent theme styles
function giving_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', 
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style'),
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style('fonts', get_stylesheet_directory_uri() . '/assets/fonts/stylesheet.css');
    
    // Enqueue member tabs CSS
    wp_enqueue_style('member-tabs', get_stylesheet_directory_uri() . '/assets/css/member-tabs.css', array(), '1.0.0');
    
    // Enqueue member tabs JavaScript
    wp_enqueue_script('member-tabs', get_stylesheet_directory_uri() . '/assets/js/member-tabs.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'giving_enqueue_styles'); 


add_action( 'init', function () {
    if ( function_exists( 'add_ux_builder_post_type' ) ) {
        add_ux_builder_post_type( 'project' );
    }
} );