<?php

/**
 * GV Breadcrumb Element
 *
 * Display customizable breadcrumbs with various styling options
 */

function giving_gv_breadcrumb_element() {
    add_ux_builder_shortcode('gv_breadcrumb', array(
        'name'      => __('Breadcrumb', 'giving'),
        'icon'      => 'dashicons-admin-links',
        
        'options' => array(
            'separator' => array(
                'type' => 'textfield',
                'heading' => __('Dấu phân cách', 'giving'),
                'default' => '/',
            ),
            'home_text' => array(
                'type' => 'textfield',
                'heading' => __('Tên trang chủ', 'giving'),
                'default' => 'Trang chủ',
            ),
            'show_home' => array(
                'type' => 'checkbox',
                'heading' => __('Hiển thị trang chủ', 'giving'),
                'default' => 'true',
            ),
            'font_size' => array(
                'type' => 'slider',
                'heading' => __('Cỡ chữ', 'giving'),
                'responsive' => true,
                'default' => 1,
                'unit' => 'rem',
                'min' => 0.5,
                'max' => 3,
                'step' => 0.01,
            ),
            'font_weight' => array(
                'type' => 'select',
                'heading' => __('Độ đậm', 'giving'),
                'default' => 'normal',
                'options' => array(
                    'normal' => 'Normal',
                    'bold' => 'Bold',
                    '100' => '100',
                    '200' => '200',
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                    '800' => '800',
                    '900' => '900',
                )
            ),
            'color' => array(
                'type' => 'colorpicker',
                'heading' => __('Màu chữ', 'giving'),
                'format' => 'hex',
                'position' => 'bottom right',
                'default' => '',
            ),
            'link_color' => array(
                'type' => 'colorpicker',
                'heading' => __('Màu liên kết', 'giving'),
                'format' => 'hex',
                'position' => 'bottom right',
                'default' => '',
            ),
            'separator_color' => array(
                'type' => 'colorpicker',
                'heading' => __('Màu dấu phân cách', 'giving'),
                'format' => 'hex',
                'position' => 'bottom right',
                'default' => '',
            ),
            'text_align' => array(
                'type' => 'select',
                'heading' => __('Căn lề', 'giving'),
                'default' => 'left',
                'options' => array(
                    'left' => 'Trái',
                    'center' => 'Giữa',
                    'right' => 'Phải',
                )
            ),
            'margin_top' => array(
                'type' => 'scrubfield',
                'heading' => __('Margin Top', 'giving'),
                'default' => '0px',
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
            'margin_bottom' => array(
                'type' => 'scrubfield',
                'heading' => __('Margin Bottom', 'giving'),
                'default' => '15px',
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
            'class' => array(
                'type' => 'textfield',
                'heading' => __('CSS class', 'giving'),
                'default' => '',
            ),
        ),
    ));
}
add_action('ux_builder_setup', 'giving_gv_breadcrumb_element');

/**
 * GV Breadcrumb Element Shortcode
 */
function shortcode_gv_breadcrumb($atts) {
    extract(shortcode_atts(array(
        'separator' => '/',
        'home_text' => 'Trang chủ',
        'show_home' => 'true',
        'font_size' => '1',
        'font_weight' => 'normal',
        'color' => '',
        'link_color' => '',
        'separator_color' => '',
        'text_align' => 'left',
        'margin_top' => '0px',
        'margin_bottom' => '15px',
        'class' => '',
    ), $atts));
    
    // Generate a unique ID for this instance
    $unique_id = 'gv-breadcrumb-' . uniqid();
    
    // Build CSS
    $css = '';
    $css .= "#$unique_id {";
    $css .= "margin-top: $margin_top;";
    $css .= "margin-bottom: $margin_bottom;";
    $css .= "font-size: " . floatval($font_size) . "rem;";
    $css .= "font-weight: $font_weight;";
    $css .= "text-align: $text_align;";
    
    if (!empty($color)) {
        $css .= "color: $color;";
    }
    $css .= "}";
    
    if (!empty($link_color)) {
        $css .= "#$unique_id a {";
        $css .= "color: $link_color;";
        $css .= "}";
    }
    
    if (!empty($separator_color)) {
        $css .= "#$unique_id .separator {";
        $css .= "color: $separator_color;";
        $css .= "}";
    }
    
    // Responsive font size
    $css .= "@media (max-width: 849px) {";
    $css .= "#$unique_id {";
    $css .= "font-size: " . (floatval($font_size) * 0.9) . "rem;";
    $css .= "}";
    $css .= "}";
    
    $css .= "@media (max-width: 549px) {";
    $css .= "#$unique_id {";
    $css .= "font-size: " . (floatval($font_size) * 0.8) . "rem;";
    $css .= "}";
    $css .= "}";
    
    // Start output
    ob_start();
    
    // Output CSS
    echo '<style>' . $css . '</style>';
    
    // Get breadcrumbs
    $breadcrumbs = array();
    
    // Add Home link
    if ($show_home === 'true') {
        $breadcrumbs[] = '<a href="' . esc_url(home_url('/')) . '">' . esc_html($home_text) . '</a>';
    }
    
    // Get current page info
    if (is_category() || is_single() || is_archive()) {
        if (is_category() || is_tax()) {
            $term = get_queried_object();
            $breadcrumbs[] = esc_html($term->name);
        } elseif (is_tag()) {
            $breadcrumbs[] = esc_html(single_tag_title('', false));
        } elseif (is_author()) {
            $breadcrumbs[] = esc_html(get_the_author());
        } elseif (is_date()) {
            if (is_day()) {
                $breadcrumbs[] = esc_html(get_the_date());
            } elseif (is_month()) {
                $breadcrumbs[] = esc_html(get_the_date('F Y'));
            } elseif (is_year()) {
                $breadcrumbs[] = esc_html(get_the_date('Y'));
            }
        } elseif (is_post_type_archive()) {
            $post_type = get_post_type_object(get_post_type());
            $breadcrumbs[] = esc_html($post_type->labels->name);
        } elseif (is_single()) {
            // Get post type
            $post_type = get_post_type();
            
            // If it's a blog post
            if ($post_type == 'post') {
                // Add categories if any
                $cats = get_the_category();
                if ($cats) {
                    $cat = $cats[0];
                    $breadcrumbs[] = '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                }
            } elseif ($post_type != 'page') {
                // For custom post types
                $post_type_obj = get_post_type_object($post_type);
                if ($post_type_obj) {
                    $breadcrumbs[] = '<a href="' . esc_url(get_post_type_archive_link($post_type)) . '">' . esc_html($post_type_obj->labels->name) . '</a>';
                }
            }
            
            // Add post title
            $breadcrumbs[] = esc_html(get_the_title());
        }
    } elseif (is_page()) {
        // If it's a page with a parent
        if ($post->post_parent) {
            $parent_id = $post->post_parent;
            $parent_links = array();
            
            while ($parent_id) {
                $page = get_post($parent_id);
                $parent_links[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a>';
                $parent_id = $page->post_parent;
            }
            
            $breadcrumbs = array_merge($breadcrumbs, array_reverse($parent_links));
        }
        
        // Add current page title
        $breadcrumbs[] = esc_html(get_the_title());
    } elseif (is_search()) {
        $breadcrumbs[] = __('Kết quả tìm kiếm cho', 'giving') . ': ' . esc_html(get_search_query());
    } elseif (is_404()) {
        $breadcrumbs[] = __('Trang không tìm thấy', 'giving');
    }
    
    // Output HTML
    echo '<div id="' . esc_attr($unique_id) . '" class="gv-breadcrumb ' . esc_attr($class) . '">';
    
    $i = 0;
    $count = count($breadcrumbs);
    
    foreach ($breadcrumbs as $breadcrumb) {
        echo $breadcrumb;
        
        if ($i < $count - 1) {
            echo ' <span class="separator">' . esc_html($separator) . '</span> ';
        }
        
        $i++;
    }
    
    echo '</div>';
    
    return ob_get_clean();
}
add_shortcode('gv_breadcrumb', 'shortcode_gv_breadcrumb'); 