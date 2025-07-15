<?php
/**
 * Flatsome Theme Modifications
 * 
 * Functions to disable or modify Flatsome theme features.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Disable all Flatsome theme notifications
 */
function giving_disable_flatsome_notifications() {
    // Remove theme registration notice
    remove_action('admin_notices', 'flatsome_maintenance_admin_notice');
    
    // Remove Flatsome dashboard widget
    function giving_remove_flatsome_dashboard_widget() {
        remove_meta_box('flatsome_dashboard_widget', 'dashboard', 'normal');
    }
    add_action('wp_dashboard_setup', 'giving_remove_flatsome_dashboard_widget', 99);
    
    // Remove Flatsome registration menu
    function giving_remove_registration_menu() {
        remove_submenu_page('themes.php', 'flatsome-panel');
        remove_submenu_page('flatsome-panel', 'flatsome-panel');
    }
    add_action('admin_menu', 'giving_remove_registration_menu', 999);
    
    // Disable theme update notification
    remove_filter('pre_set_site_transient_update_themes', 'flatsome_update_theme_check');
    
    // Disable Flatsome update notices
    add_filter('flatsome_update_notice_enabled', '__return_false');
    
    // Remove admin notice
    remove_action('admin_notices', 'flatsome_admin_notice');
    
    // Remove Customizer registration notice
    add_action('customize_register', function() {
        remove_action('customize_controls_enqueue_scripts', 'flatsome_customizer_admin_scripts');
    }, 99);
    
    // Disable template compatibility check notification
    add_filter('flatsome_wupdates_notification_template_files', '__return_false');
    
    // Additional method to remove template compatibility notice
    remove_action('admin_notices', 'flatsome_template_files_notice');
}
add_action('init', 'giving_disable_flatsome_notifications');

/**
 * More aggressive approach to remove Flatsome template notifications
 */
// Remove ALL admin notices from Flatsome
function giving_remove_all_flatsome_notices() {
    global $wp_filter;
    
    // Loop through all admin_notices
    if (isset($wp_filter['admin_notices'])) {
        foreach ($wp_filter['admin_notices']->callbacks as $priority => $callbacks) {
            foreach ($callbacks as $key => $callback) {
                // Check if the function name contains 'flatsome'
                if (is_array($callback['function']) && is_object($callback['function'][0])) {
                    $class = get_class($callback['function'][0]);
                    if (stripos($class, 'flatsome') !== false) {
                        remove_action('admin_notices', $callback['function'], $priority);
                    }
                } elseif (is_string($callback['function']) && stripos($callback['function'], 'flatsome') !== false) {
                    remove_action('admin_notices', $callback['function'], $priority);
                }
            }
        }
    }
    
    // Remove specific class of notices with CSS
    add_action('admin_head', 'giving_hide_flatsome_notices_css');
}
add_action('admin_init', 'giving_remove_all_flatsome_notices', 999);

// Add CSS to hide Flatsome notices
function giving_hide_flatsome_notices_css() {
    echo '<style>
    .flatsome-notice, 
    .notice:has(h3:contains("Flatsome")),
    .notice:has(svg[width="20"][height="20"][viewBox="0 0 438 438"]) {
        display: none !important;
    }
    </style>';
} 