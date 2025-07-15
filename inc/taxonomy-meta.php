<?php
/**
 * Taxonomy Meta Fields
 * 
 * Adds additional fields to taxonomy terms like featured images for categories
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add featured image field to service category
 */
class Giving_Taxonomy_Meta {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        // Add form fields to service_category taxonomy
        add_action('service_category_add_form_fields', array($this, 'add_category_image_field'));
        add_action('service_category_edit_form_fields', array($this, 'edit_category_image_field'), 10, 2);
        
        // Save the form fields
        add_action('created_service_category', array($this, 'save_category_image_field'));
        add_action('edited_service_category', array($this, 'save_category_image_field'));
        
        // Enqueue scripts
        add_action('admin_enqueue_scripts', array($this, 'load_media_scripts'));
        
        // Add column to admin list table
        add_filter('manage_edit-service_category_columns', array($this, 'add_image_column'));
        add_filter('manage_service_category_custom_column', array($this, 'add_image_column_content'), 10, 3);
    }
    
    /**
     * Add featured image field to "Add new category" form
     */
    public function add_category_image_field() {
        ?>
        <div class="form-field term-group">
            <label for="category-image-id"><?php _e('Featured Image', 'giving'); ?></label>
            <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
            <div id="category-image-wrapper"></div>
            <p>
                <input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button" name="taxonomy_media_button" value="<?php _e('Add Image', 'giving'); ?>">
                <input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove" name="taxonomy_media_remove" value="<?php _e('Remove Image', 'giving'); ?>">
            </p>
        </div>
        <?php
    }
    
    /**
     * Add featured image field to "Edit category" form
     */
    public function edit_category_image_field($term, $taxonomy) {
        $image_id = get_term_meta($term->term_id, 'category-image-id', true);
        ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="category-image-id"><?php _e('Featured Image', 'giving'); ?></label>
            </th>
            <td>
                <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo esc_attr($image_id); ?>">
                <div id="category-image-wrapper">
                    <?php if ($image_id) { 
                        echo wp_get_attachment_image($image_id, 'thumbnail');
                    } ?>
                </div>
                <p>
                    <input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button" name="taxonomy_media_button" value="<?php _e('Add Image', 'giving'); ?>">
                    <input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove" name="taxonomy_media_remove" value="<?php _e('Remove Image', 'giving'); ?>">
                </p>
            </td>
        </tr>
        <?php
    }
    
    /**
     * Save the featured image field
     */
    public function save_category_image_field($term_id) {
        if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
            $image = absint($_POST['category-image-id']);
            update_term_meta($term_id, 'category-image-id', $image);
        } else {
            delete_term_meta($term_id, 'category-image-id');
        }
    }
    
    /**
     * Enqueue scripts for media uploader
     */
    public function load_media_scripts() {
        $screen = get_current_screen();
        
        if (isset($screen->taxonomy) && $screen->taxonomy === 'service_category') {
            wp_enqueue_media();
            
            // Add custom script
            wp_enqueue_script(
                'giving-taxonomy-media-js', 
                get_stylesheet_directory_uri() . '/assets/js/taxonomy-media.js', 
                array('jquery'), 
                '1.0.0', 
                true
            );
        }
    }
    
    /**
     * Add image column to admin list table
     */
    public function add_image_column($columns) {
        $new_columns = array();
        
        foreach ($columns as $key => $value) {
            // Add image column after name column
            if ($key === 'name') {
                $new_columns[$key] = $value;
                $new_columns['featured-image'] = __('Image', 'giving');
            } else {
                $new_columns[$key] = $value;
            }
        }
        
        return $new_columns;
    }
    
    /**
     * Add image column content
     */
    public function add_image_column_content($content, $column_name, $term_id) {
        if ($column_name === 'featured-image') {
            $image_id = get_term_meta($term_id, 'category-image-id', true);
            if ($image_id) {
                $content = wp_get_attachment_image($image_id, array(50, 50));
            }
        }
        return $content;
    }
}

// Initialize the class
new Giving_Taxonomy_Meta(); 