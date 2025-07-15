<?php
/**
 * The template for displaying project archives.
 *
 * @package Giving
 */

get_header();

// Get current taxonomy and term if we're on a taxonomy archive
$current_term_id = 0;
$current_taxonomy = '';

if (is_tax()) {
    $queried_object = get_queried_object();
    if ($queried_object && isset($queried_object->term_id)) {
        $current_term_id = $queried_object->term_id;
        $current_taxonomy = $queried_object->taxonomy;
    }
}
?>

<div id="content" class="projects-archive-wrapper page-wrapper">
    <div class="container">
        <!-- Archive Header -->
        <header class="archive-header text-center">
            <h1 class="page-title">
                <?php
                if (is_tax()) {
                    single_term_title();
                    echo ' ' . __('Projects', 'giving');
                } else {
                    _e('All Projects', 'giving');
                }
                ?>
            </h1>
            <div class="taxonomy-description">
                <?php the_archive_description(); ?>
            </div>
        </header>
        
        <!-- Filter Section -->
        <div class="project-filters">
            <div class="row">
                <?php
                // Display filters for each taxonomy
                $taxonomies = array(
                    'project_style' => __('Filter by Style', 'giving'),
                    'project_category' => __('Filter by Category', 'giving'),
                    'project_area' => __('Filter by Area', 'giving')
                );
                
                foreach ($taxonomies as $taxonomy => $label) :
                    $terms = get_terms(array(
                        'taxonomy' => $taxonomy,
                        'hide_empty' => true
                    ));
                    
                    if (!empty($terms) && !is_wp_error($terms)) :
                    ?>
                    <div class="col medium-4 small-12">
                        <div class="filter-group">
                            <h4 class="filter-title"><?php echo esc_html($label); ?></h4>
                            <ul class="filter-list">
                                <?php foreach ($terms as $term) : 
                                    $active_class = ($current_taxonomy == $taxonomy && $current_term_id == $term->term_id) ? 'active' : '';
                                ?>
                                <li class="filter-item <?php echo $active_class; ?>">
                                    <a href="<?php echo esc_url(get_term_link($term)); ?>" class="filter-link">
                                        <?php echo esc_html($term->name); ?>
                                        <span class="count">(<?php echo esc_html($term->count); ?>)</span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
        
        <?php if (have_posts()) : ?>
            <!-- Projects Grid -->
            <div class="projects-grid">
                <div class="row large-columns-3 medium-columns-2 small-columns-1">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col">
                            <div class="col-inner">
                                <a href="<?php the_permalink(); ?>" class="project-box plain">
                                    <div class="box box-normal box-text-bottom box-blog-post has-hover">
                                        <div class="box-image">
                                            <div class="image-cover" style="padding-top:75%;">
                                                <?php 
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('medium_large');
                                                } else {
                                                    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/placeholder.svg" alt="' . get_the_title() . '" />';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="box-text text-center">
                                            <div class="box-text-inner blog-post-inner">
                                                <h5 class="post-title is-large"><?php the_title(); ?></h5>
                                                
                                                <?php
                                                // Display project style if available
                                                $styles = get_the_terms(get_the_ID(), 'project_style');
                                                if ($styles && !is_wp_error($styles)) {
                                                    echo '<div class="project-meta">';
                                                    echo '<span class="project-style">' . esc_html($styles[0]->name) . '</span>';
                                                    echo '</div>';
                                                }
                                                ?>
                                                
                                                <div class="project-excerpt is-small op-7">
                                                    <?php echo wp_trim_words(get_the_excerpt(), 12); ?>
                                                </div>
                                                
                                                <div class="project-read-more">
                                                    <button class="button is-outline is-small"><?php _e('View Project', 'giving'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                <?php flatsome_pagination(); ?>
            </div>
            
        <?php else : ?>
            <!-- No Projects Found -->
            <div class="no-projects-found">
                <p><?php _e('No projects found matching your criteria.', 'giving'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Custom CSS for Projects Archive -->
<style>
    .projects-archive-wrapper {
        padding-top: 30px;
        padding-bottom: 50px;
    }
    
    .archive-header {
        margin-bottom: 30px;
    }
    
    .page-title {
        font-size: 2.2em;
        margin-bottom: 10px;
    }
    
    .taxonomy-description {
        max-width: 700px;
        margin: 0 auto 20px;
    }
    
    .project-filters {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 40px;
    }
    
    .filter-title {
        font-size: 1.1em;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .filter-list {
        list-style: none;
        margin: 0 0 15px;
        padding: 0;
    }
    
    .filter-item {
        margin-bottom: 5px;
    }
    
    .filter-item.active a {
        font-weight: bold;
        color: var(--primary-color);
    }
    
    .filter-link {
        color: #333;
        text-decoration: none;
    }
    
    .filter-link:hover {
        color: var(--primary-color);
    }
    
    .filter-link .count {
        color: #777;
        font-size: 0.9em;
    }
    
    .projects-grid {
        margin-bottom: 40px;
    }
    
    .project-box {
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    
    .project-box:hover {
        transform: translateY(-5px);
    }
    
    .project-meta {
        margin-bottom: 10px;
    }
    
    .project-style {
        display: inline-block;
        padding: 3px 10px;
        background-color: #f1f1f1;
        border-radius: 3px;
        font-size: 0.8em;
        color: #555;
    }
    
    .project-read-more {
        margin-top: 15px;
    }
    
    .no-projects-found {
        text-align: center;
        padding: 50px 0;
    }
</style>

<?php get_footer(); ?> 