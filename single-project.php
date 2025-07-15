<?php
/**
 * Template for displaying single project posts.
 *
 * @package Giving
 */

get_header();
?>

<div class="project-wrapper single-project page-wrapper">

<!-- Banner Section Start -->
<div class="banner has-hover banner-project-header">
  <div class="banner-inner fill">
    <div class="banner-bg fill">
      <?php if (has_post_thumbnail()) : ?>
        <?php echo get_the_post_thumbnail(null, 'large', array('class' => 'project-featured-image bg attachment-large size-large')); ?>
      <?php endif; ?>
      <div class="overlay"></div>
    </div>
    <div class="banner-layers container">
      <div class="fill banner-link"></div>
      <div class="text-box banner-layer center-box res-text x50 md-x50 lg-x50 y50 md-y50 lg-y50">
        <div class="text-box-content text dark">
          <div class="text-inner text-center">
            <div class="row">
              <div class="col small-12 large-12">
                <div class="col-inner">
                  <div class="gv-breadcrumb">
                    <a href="<?php echo esc_url(home_url()); ?>">Trang chủ</a>
                    <span class="separator">/</span>
                    <a href="<?php echo esc_url(home_url('/du-an')); ?>">Dự án</a>
                  </div>
                  <h2 class="gv-title"><?php the_title(); ?></h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <style>
          .center-box { width: 60%; }
          .center-box .text-box-content { font-size: 100%; }
        </style>
      </div>
    </div>
    <style>
      .banner-project-header { padding-top: 500px; }
      .banner-project-header .overlay { background-color: rgba(0, 0, 0, 0.25); }

      .gv-breadcrumb {
        margin: 0 0 15px;
        font-size: 1rem;
        font-weight: 500;
        text-align: center;
      }

      @media (max-width: 849px) {
        .gv-breadcrumb { font-size: 0.9rem; }
      }

      @media (max-width: 549px) {
        .gv-breadcrumb { font-size: 0.8rem; }
      }

      .gv-title {
        margin: 0 0 15px;
        padding: 0;
        text-transform: none;
        font-weight: 600;
        font-size: 2.5rem;
      }

      @media (max-width: 849px) {
        .gv-title { font-size: 2rem; }
      }

      @media (max-width: 549px) {
        .gv-title { font-size: 1.5rem; }
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
          <div class="entry-content single-page">
            <?php the_content(); ?>
          </div>

          <!-- Navigation -->
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
      $related_args = [
        'post_type' => 'project',
        'posts_per_page' => 3,
        'post__not_in' => [get_the_ID()],
        'orderby' => 'rand',
      ];

      $tax_query = ['relation' => 'OR'];
      foreach ($taxonomies as $taxonomy) {
        $terms = get_the_terms(get_the_ID(), $taxonomy);
        if ($terms && !is_wp_error($terms)) {
          $term_ids = wp_list_pluck($terms, 'term_id');
          if ($term_ids) {
            $tax_query[] = [
              'taxonomy' => $taxonomy,
              'field'    => 'term_id',
              'terms'    => $term_ids,
            ];
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

<!-- Custom CSS -->
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
