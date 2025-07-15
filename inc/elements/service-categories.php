<?php

/**
 * Service Categories Element
 *
 * Display service categories in an interactive column layout
 */

function giving_service_categories_element() {
    add_ux_builder_shortcode('service_categories', array(
        'name'      => __('Danh mục dịch vụ', 'giving'),
        'category'  => __('Nội dung'),
        'info'      => '',
        'icon'      => 'dashicons-category',
        'wrap'      => false,
        
        'options' => array(
            'number' => array(
                'type' => 'slider',
                'heading' => __('Số lượng danh mục', 'giving'),
                'default' => '4',
                'min'   => 1,
                'max'   => 12,
                'step'  => 1,
            ),
            'orderby' => array(
                'type' => 'select',
                'heading' => __('Sắp xếp theo', 'giving'),
                'default' => 'name',
                'options' => array(
                    'name' => 'Tên',
                    'id' => 'ID',
                    'count' => 'Số lượng',
                )
            ),
            'order' => array(
                'type' => 'select',
                'heading' => __('Thứ tự', 'giving'),
                'default' => 'asc',
                'options' => array(
                    'asc' => 'Tăng dần',
                    'desc' => 'Giảm dần',
                )
            ),
            'button_text' => array(
                'type' => 'textfield',
                'heading' => __('Văn bản nút', 'giving'),
                'default' => __('Xem chi tiết', 'giving'),
            ),
        ),
    ));
}
add_action('ux_builder_setup', 'giving_service_categories_element');

/**
 * Service Categories Element Shortcode
 */
function shortcode_service_categories($atts) {
    extract(shortcode_atts(array(
        'number' => 4,
        'orderby' => 'name',
        'order' => 'asc',
        'button_text' => 'Xem chi tiết',
    ), $atts));
    
    // Check if Service Category taxonomy exists
    if (!taxonomy_exists('service_category')) {
        return '<div class="alert alert-warning">Taxonomy Service Category không tồn tại.</div>';
    }
    
    // Get service categories
    $categories = get_terms(array(
        'taxonomy' => 'service_category',
        'orderby' => $orderby,
        'order' => $order,
        'number' => $number,
        'hide_empty' => false,
    ));
    
    if (is_wp_error($categories) || empty($categories)) {
        return '<div class="alert alert-warning">Không tìm thấy danh mục dịch vụ nào.</div>';
    }
    
    // Start output
    ob_start();
    
    // Add CSS styles
    ?>
    <style>
        .service-categories-wrapper {
            display: flex;
            flex-wrap: nowrap;
            width: 100%;
            overflow: hidden;
            position: relative;
            gap: 10px;
        }
        
        .service-category-item {
            flex: 1;
            position: relative;
            overflow: hidden;
            min-height: 550px;
            transition: flex 0.8s ease;
            background-size: cover;
            background-position: center;
            filter: grayscale(100%);
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .service-category-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 30%, rgba(0,0,0,0.3) 100%);
            z-index: 1;
            transition: opacity 0.8s ease;
        }
        
        .service-category-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 2;
            color: #fff;
            padding: 25px;
            box-sizing: border-box;
        }
        
        .service-category-title {
            margin: 0;
            padding: 0;
            font-size: 1.5em;
            font-weight: bold;
            transform: translateY(0);
            transition: transform 0.8s ease;
            color: #fff;
            display: block;
            margin-bottom: 10px;
        }
        
        .service-category-description {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.8s ease, opacity 0.8s ease, margin 0.8s ease;
            margin: 0;
        }
        
        .service-category-button {
            display: inline-block;
            background-color: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding: 8px 20px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            margin-top: 0;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .service-category-button:hover {
            background-color: #fff;
            color: #333;
        }
        
        /* Hover state */
        .service-category-item:hover {
            flex: 2;
            filter: grayscale(0%);
        }

        .service-category-item:hover::before {
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%);
        }
        
        .service-category-item:hover .service-category-title {
            transform: translateY(-10px);
        }
        
        .service-category-item:hover .service-category-description {
            max-height: 200px;
            opacity: 1;
            margin: 0 0 15px;
        }
        
        .service-category-item:hover .service-category-button {
            opacity: 1;
            margin-top: 5px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {

            .service-categories-wrapper {
                flex-direction: column;
                gap: 0;
            }
            
            .service-category-item {
                flex: none;
                min-height: 480px;
            }
            
            .service-category-description {
                max-height: 200px;
                opacity: 1;
                margin-bottom: 15px;
            }
            
            .service-category-button {
                opacity: 1;
                margin-top: 5px;
            }
            
            .service-category-title {
                transform: translateY(0);
            }
        }
    </style>
    
    <div class="service-categories-section">
        <div class="service-categories-wrapper">
            <?php foreach ($categories as $category): 
                // Get category thumbnail/image
                $thumbnail_id = get_term_meta($category->term_id, 'category-image-id', true);
                $image = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'large') : '';
                // Get category link
                $link = get_term_link($category);
            ?>
                <div class="service-category-item" style="background-image: url('<?php echo esc_url($image); ?>');">
                    <div class="service-category-content">
                        <h3 class="service-category-title"><?php echo esc_html($category->name); ?></h3>
                        <div class="service-category-description"><?php echo wp_kses_post($category->description); ?></div>
                        <a href="<?php echo esc_url($link); ?>" class="service-category-button">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    
    return ob_get_clean();
}
add_shortcode('service_categories', 'shortcode_service_categories');
