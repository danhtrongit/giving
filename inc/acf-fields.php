<?php
/**
 * ACF Field Groups
 * 
 * Register Advanced Custom Fields field groups for the theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Check if ACF is active
if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Register Project Overview Field Group
 */
function giving_register_project_overview_fields() {
    acf_add_local_field_group(array(
        'key' => 'group_project_overview',
        'title' => 'TỔNG QUAN DỰ ÁN',
        'fields' => array(
            array(
                'key' => 'field_project_building_type',
                'label' => 'Loại hình công trình',
                'name' => 'project_building_type',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Ví dụ: Căn hộ cho thuê – Elite Compact Living',
            ),
            array(
                'key' => 'field_project_scale',
                'label' => 'Quy mô',
                'name' => 'project_scale',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Ví dụ: 450m², cao 6 tầng 1 tum',
            ),
            array(
                'key' => 'field_project_location',
                'label' => 'Địa điểm',
                'name' => 'project_location',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Ví dụ: Quận Hoàng Mai, Hà Nội',
            ),
            array(
                'key' => 'field_project_investor',
                'label' => 'Chủ đầu tư',
                'name' => 'project_investor',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Ví dụ: Anh Long – Chị Bích',
            ),
            array(
                'key' => 'field_project_contractor',
                'label' => 'Đơn vị Tổng thầu',
                'name' => 'project_contractor',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'TIDI CONS',
                'placeholder' => 'Ví dụ: TIDI CONS',
            ),
            array(
                'key' => 'field_project_design_style',
                'label' => 'Phong cách thiết kế',
                'name' => 'project_design_style',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Ví dụ: Compact hiện đại, tối ưu không gian',
            ),
            array(
                'key' => 'field_project_construction_time',
                'label' => 'Thời gian thi công',
                'name' => 'project_construction_time',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Ví dụ: 6 tháng',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'project',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
}
add_action('acf/init', 'giving_register_project_overview_fields');

/**
 * Display project overview in a styled box
 */
function giving_display_project_overview($post_id = null) {
    if (!function_exists('get_field')) {
        return;
    }
    
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    // Get ACF fields
    $building_type = get_field('project_building_type', $post_id);
    $scale = get_field('project_scale', $post_id);
    $location = get_field('project_location', $post_id);
    $investor = get_field('project_investor', $post_id);
    $contractor = get_field('project_contractor', $post_id);
    $design_style = get_field('project_design_style', $post_id);
    $construction_time = get_field('project_construction_time', $post_id);
    
    // Check if at least one field has value
    if (!$building_type && !$scale && !$location && !$investor && !$contractor && !$design_style && !$construction_time) {
        return;
    }
    
    // HTML output
    ob_start();
    ?>
    <div class="project-overview-box">
        <h3 class="project-overview-title">TỔNG QUAN DỰ ÁN</h3>
        <div class="project-overview-content">
            <?php if ($building_type) : ?>
            <div class="project-overview-item">
                <span class="project-overview-item-icon">🔹</span>
                <span class="project-overview-item-label">Loại hình công trình:</span>
                <span class="project-overview-item-value"><?php echo esc_html($building_type); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($scale) : ?>
            <div class="project-overview-item">
                <span class="project-overview-item-icon">🔹</span>
                <span class="project-overview-item-label">Quy mô:</span>
                <span class="project-overview-item-value"><?php echo esc_html($scale); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($location) : ?>
            <div class="project-overview-item">
                <span class="project-overview-item-icon">🔹</span>
                <span class="project-overview-item-label">Địa điểm:</span>
                <span class="project-overview-item-value"><?php echo esc_html($location); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($investor) : ?>
            <div class="project-overview-item">
                <span class="project-overview-item-icon">🔹</span>
                <span class="project-overview-item-label">Chủ đầu tư:</span>
                <span class="project-overview-item-value"><?php echo esc_html($investor); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($contractor) : ?>
            <div class="project-overview-item">
                <span class="project-overview-item-icon">🔹</span>
                <span class="project-overview-item-label">Đơn vị Tổng thầu thiết kế & thi công trọn gói:</span>
                <span class="project-overview-item-value"><?php echo esc_html($contractor); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($design_style) : ?>
            <div class="project-overview-item">
                <span class="project-overview-item-icon">🔹</span>
                <span class="project-overview-item-label">Phong cách thiết kế:</span>
                <span class="project-overview-item-value"><?php echo esc_html($design_style); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if ($construction_time) : ?>
            <div class="project-overview-item">
                <span class="project-overview-item-icon">🔹</span>
                <span class="project-overview-item-label">Thời gian thi công:</span>
                <span class="project-overview-item-value"><?php echo esc_html($construction_time); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Add CSS styles for project overview box
 */
function giving_project_overview_styles() {
    if (!is_singular('project')) {
        return;
    }
    ?>
    <style>
        .project-overview-box {
            margin-bottom: 30px;
        }
        .project-overview-title {
            font-size: 1.4em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .project-overview-item {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }
        .project-overview-item-icon {
            margin-right: 10px;
            color: #3498db;
        }
        .project-overview-item-label {
            font-weight: bold;
            margin-right: 5px;
        }
        .project-overview-item-value {
            flex: 1;
        }
    </style>
    <?php
}
add_action('wp_head', 'giving_project_overview_styles');

/**
 * Add project overview to content
 */
function giving_add_project_overview_to_content($content) {
    if (is_singular('project')) {
        $overview = giving_display_project_overview();
        if ($overview) {
            $content = $overview . $content;
        }
    }
    return $content;
}
add_filter('the_content', 'giving_add_project_overview_to_content'); 