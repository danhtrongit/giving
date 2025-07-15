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
}
add_action('wp_enqueue_scripts', 'giving_enqueue_styles'); 