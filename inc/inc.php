<?php
/**
 * Main include file
 * 
 * Includes all the component files of the theme.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme directory path constant
if (!defined('GIVING_THEME_DIR')) {
    define('GIVING_THEME_DIR', get_stylesheet_directory());
}

// Define theme directory URI constant
if (!defined('GIVING_THEME_URI')) {
    define('GIVING_THEME_URI', get_stylesheet_directory_uri());
}

// Include theme components
require_once GIVING_THEME_DIR . '/inc/theme-setup.php';
require_once GIVING_THEME_DIR . '/inc/flatsome-mods.php';
require_once GIVING_THEME_DIR . '/inc/post-types.php';
require_once GIVING_THEME_DIR . '/inc/taxonomy-meta.php';
require_once GIVING_THEME_DIR . '/inc/elements/elements.php';

// Additional files can be included here as the theme grows
// require_once GIVING_THEME_DIR . '/inc/widgets.php';
// require_once GIVING_THEME_DIR . '/inc/shortcodes.php';
// etc. 