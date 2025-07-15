<?php
/**
 * The template for displaying single project posts.
 *
 * @package Giving
 */

get_header();
?>

<div id="content" class="project-wrapper single-project page-wrapper">


<!-- Banner Section Start -->
<div class="banner has-hover" id="banner-1329491744">
  <div class="banner-inner fill">
    <div class="banner-bg fill">
      <?php if (has_post_thumbnail()) : ?>
                <?php echo get_the_post_thumbnail(null, 'large', array('class' => 'project-featured-image bg attachment-large size-large')); ?>
            <?php endif; ?>
      <div class="overlay"></div>
    </div>
    <div class="banner-layers container">
      <div class="fill banner-link"></div>
      <div id="text-box-2007279858" class="text-box banner-layer x50 md-x50 lg-x50 y50 md-y50 lg-y50 res-text">
        <div class="text-box-content text dark">
          <div class="text-inner text-center">
            <div class="row" id="row-614772994">
              <div id="col-12277568" class="col small-12 large-12">
                <div class="col-inner">
                  <div id="gv-breadcrumb-6875c6bdf36c7" class="gv-breadcrumb">
                    <a href="https://fernandonguyen.site/">Trang chủ</a>
                    <span class="separator">/</span>
                    <a href="<?php echo home_url(); ?>/du-an">Dự án</a>
                    <span class="separator">/</span>
                    <?php the_title(); ?>
                  </div>
                  <h2 id="gv-title-6875c6bdf3845" class="gv-title"><?php the_title(); ?></h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Text box custom styles -->
        <style>
          #text-box-2007279858 { width: 60%; }
          #text-box-2007279858 .text-box-content { font-size: 100%; }
        </style>
      </div>
    </div>
    <!-- Banner custom styles -->
    <style>
      #banner-1329491744 { padding-top: 500px; }
      #banner-1329491744 .overlay { background-color: rgba(0, 0, 0, 0.25); }
      #gv-breadcrumb-6875c6bdf36c7 {
        margin-top: 0px; margin-bottom: 15px;
        font-size: 1rem; font-weight: 500; text-align: center;
      }
      @media (max-width: 849px) {
        #gv-breadcrumb-6875c6bdf36c7 { font-size: 0.9rem; }
      }
      @media (max-width: 549px) {
        #gv-breadcrumb-6875c6bdf36c7 { font-size: 0.8rem; }
      }
      #gv-title-6875c6bdf3845 {
        margin-top: 0px; margin-bottom: 15px;
        padding-top: 0px; padding-bottom: 0px;
        text-transform: none; font-weight: 600; font-size: 2.5rem;
      }
      @media (max-width: 849px) {
        #gv-title-6875c6bdf3845 { font-size: 2rem; }
      }
      @media (max-width: 549px) {
        #gv-title-6875c6bdf3845 { font-size: 1.5rem; }
      }
    </style>
  </div>
</div>
<!-- Banner Section End -->



    <div class="row row-large">
        <div class="large-12 col">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="article-inner">
                        <!-- Project Header -->
                        <!-- Project Content -->
                        <div class="entry-content single-page">
                            <?php 
                            the_content(); 
                            ?>
                            
                            <!-- Project Categories and Tags -->
                            <div class="project-taxonomy">
                                <?php 
                                // Display project taxonomies
                                $taxonomies = array('project_style', 'project_category', 'project_area');
                                foreach ($taxonomies as $taxonomy) {
                                    $terms = get_the_terms(get_the_ID(), $taxonomy);
                                    if ($terms && !is_wp_error($terms)) {
                                        $tax_obj = get_taxonomy($taxonomy);
                                        echo '<div class="project-taxonomy-group">';
                                        echo '<span class="taxonomy-label">' . esc_html($tax_obj->labels->name) . ':</span> ';
                                        
                                        $term_links = array();
                                        foreach ($terms as $term) {
                                            $term_links[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                                        }
                                        
                                        echo implode(', ', $term_links);
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                            
                            <?php if (get_theme_mod('blog_share', 1)) : ?>
                                <!-- Share Icons -->
                                <div class="project-share text-center">
                                    <div class="is-divider medium"></div>
                                    <?php echo do_shortcode('[share]'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Project Navigation -->
                        <div class="project-navigation">
                            <div class="flex-row next-prev-nav nav-divided nav-uppercase">
                                <div class="flex-col flex-grow prev-project-col">
                                    <?php previous_post_link('<span class="prev-link-text">%link</span>', '<span class="icon-angle-left"></span> ' . __('Previous Project', 'giving')); ?>
                                </div>
                                <div class="flex-col flex-grow next-project-col text-right">
                                    <?php next_post_link('<span class="next-link-text">%link</span>', __('Next Project', 'giving') . ' <span class="icon-angle-right"></span>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                
                <?php
                // Related projects based on taxonomy
                $related_args = array(
                    'post_type' => 'project',
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'rand',
                );
                
                // Get taxonomies and add to query
                $tax_query = array('relation' => 'OR');
                $taxonomies = array('project_style', 'project_category', 'project_area');
                
                foreach ($taxonomies as $taxonomy) {
                    $terms = get_the_terms(get_the_ID(), $taxonomy);
                    if ($terms && !is_wp_error($terms)) {
                        $term_ids = array();
                        foreach ($terms as $term) {
                            $term_ids[] = $term->term_id;
                        }
                        
                        if (!empty($term_ids)) {
                            $tax_query[] = array(
                                'taxonomy' => $taxonomy,
                                'field' => 'term_id',
                                'terms' => $term_ids,
                            );
                        }
                    }
                }
                
                if (count($tax_query) > 1) {
                    $related_args['tax_query'] = $tax_query;
                    
                    $related_query = new WP_Query($related_args);
                    
                    if ($related_query->have_posts()) :
                    ?>
                    <div class="related-projects">
                        <h3><?php _e('Related Projects', 'giving'); ?></h3>
                        <div class="row large-columns-3 medium-columns-2 small-columns-1">
                            <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                <div class="col">
                                    <div class="col-inner">
                                        <a href="<?php the_permalink(); ?>" class="plain">
                                            <div class="box box-normal box-text-bottom box-blog-post has-hover">
                                                <div class="box-image">
                                                    <div class="image-cover" style="padding-top:75%;">
                                                        <?php the_post_thumbnail('medium_large'); ?>
                                                    </div>
                                                </div>
                                                <div class="box-text text-center">
                                                    <div class="box-text-inner blog-post-inner">
                                                        <h5 class="post-title is-large"><?php the_title(); ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php
                    endif;
                    wp_reset_postdata();
                }
                ?>
                
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Custom CSS for Project Page -->
<style>
    .project-wrapper .entry-title {
        font-size: 2.5em;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .project-wrapper .entry-image-float {
        margin-bottom: 30px;
    }
    
    .project-taxonomy {
        margin: 30px 0;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }
    
    .project-taxonomy-group {
        margin-bottom: 10px;
    }
    
    .taxonomy-label {
        font-weight: bold;
        color: #333;
    }
    
    .project-navigation {
        margin: 40px 0 30px;
        padding-top: 20px;
        border-top: 1px solid #ececec;
    }
    
    .related-projects {
        margin-top: 50px;
        padding-top: 30px;
        border-top: 2px solid #ececec;
    }
    
    .related-projects h3 {
        margin-bottom: 20px;
        text-align: center;
        font-size: 1.5em;
    }
</style>

<?php get_footer(); ?> 