<?php

/**
 * GV Title Element
 *
 * Display customizable title with various styling options
 */

function giving_gv_title_element() {
    add_ux_builder_shortcode('gv_title', array(
        'name'      => __('Tiêu đề', 'giving'),
        'icon'      => 'dashicons-editor-heading',
        
        'options' => array(
            'title' => array(
                'type' => 'textfield',
                'heading' => __('Tiêu đề', 'giving'),
                'default' => __('Tiêu đề', 'giving'),
            ),
            'heading_tag' => array(
                'type' => 'select',
                'heading' => __('Thẻ Heading', 'giving'),
                'default' => 'h2',
                'options' => array(
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p' => 'Paragraph',
                    'div' => 'Div'
                )
            ),
            'text_transform' => array(
                'type' => 'select',
                'heading' => __('Biến đổi chữ', 'giving'),
                'default' => 'none',
                'options' => array(
                    'none' => 'Không',
                    'uppercase' => 'CHỮ HOA',
                    'lowercase' => 'chữ thường',
                    'capitalize' => 'Viết Hoa Chữ Đầu',
                )
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
                'default' => '',
                'helpers' => require( get_template_directory() . '/inc/builder/shortcodes/helpers/colors.php' ),
            ),
            'text_align' => array(
                'type' => 'select',
                'heading' => __('Căn lề', 'giving'),
                'default' => '',
                'options' => array(
                    '' => 'Mặc định',
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
            'padding_top' => array(
                'type' => 'scrubfield',
                'heading' => __('Padding Top', 'giving'),
                'default' => '0px',
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
            'padding_bottom' => array(
                'type' => 'scrubfield',
                'heading' => __('Padding Bottom', 'giving'),
                'default' => '0px',
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
            'font_size' => array(
                'type' => 'slider',
                'heading' => __('Cỡ chữ', 'giving'),
                'responsive' => true,
                'default' => 2.5,
                'unit' => 'rem',
                'min' => 0.5,
                'max' => 5,
                'step' => 0.05,
            ),
            'mobile_font_size' => array(
                'type' => 'slider',
                'heading' => __('Cỡ chữ (Mobile)', 'giving'),
                'default' => 1.5,
                'unit' => 'rem',
                'min' => 0.5,
                'max' => 5,
                'step' => 0.05,
            ),
            'tablet_font_size' => array(
                'type' => 'slider',
                'heading' => __('Cỡ chữ (Tablet)', 'giving'),
                'default' => 2,
                'unit' => 'rem',
                'min' => 0.5,
                'max' => 5,
                'step' => 0.05,
            ),
            'class' => array(
                'type' => 'textfield',
                'heading' => __('CSS class', 'giving'),
                'default' => '',
            ),
        ),
    ));
}
add_action('ux_builder_setup', 'giving_gv_title_element');

/**
 * GV Title Element Shortcode
 */
function shortcode_gv_title($atts) {
    extract(shortcode_atts(array(
        'title' => 'Tiêu đề',
        'heading_tag' => 'h2',
        'text_transform' => 'none',
        'font_weight' => 'normal',
        'color' => '',
        'text_align' => '',
        'margin_top' => '0px',
        'margin_bottom' => '15px',
        'padding_top' => '0px',
        'padding_bottom' => '0px',
        'font_size' => '2.5',
        'mobile_font_size' => '1.5',
        'tablet_font_size' => '2',
        'class' => '',
    ), $atts));
    
    // Generate a unique ID for this instance
    $unique_id = 'gv-title-' . uniqid();
    
    // Build CSS
    $css = '';
    $css .= "#$unique_id {";
    $css .= "margin-top: $margin_top;";
    $css .= "margin-bottom: $margin_bottom;";
    $css .= "padding-top: $padding_top;";
    $css .= "padding-bottom: $padding_bottom;";
    
    if (!empty($text_transform)) {
        $css .= "text-transform: $text_transform;";
    }
    
    if (!empty($font_weight)) {
        $css .= "font-weight: $font_weight;";
    }
    
    if (!empty($color)) {
        $css .= "color: $color;";
    }
    
    if (!empty($text_align)) {
        $css .= "text-align: $text_align;";
    }
    
    $css .= "font-size: " . floatval($font_size) . "rem;";
    $css .= "}";
    
    // Responsive CSS
    $css .= "@media (max-width: 849px) {";
    $css .= "#$unique_id {";
    $css .= "font-size: " . floatval($tablet_font_size) . "rem;";
    $css .= "}";
    $css .= "}";
    
    $css .= "@media (max-width: 549px) {";
    $css .= "#$unique_id {";
    $css .= "font-size: " . floatval($mobile_font_size) . "rem;";
    $css .= "}";
    $css .= "}";
    
    // Start output
    ob_start();
    
    // Output CSS
    echo '<style>' . $css . '</style>';
    
    // Output HTML
    echo '<' . esc_attr($heading_tag) . ' id="' . esc_attr($unique_id) . '" class="gv-title ' . esc_attr($class) . '">';
    echo esc_html($title);
    echo '</' . esc_attr($heading_tag) . '>';
    
    return ob_get_clean();
}
add_shortcode('gv_title', 'shortcode_gv_title'); 