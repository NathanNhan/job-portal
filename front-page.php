<?php get_header(); ?>
<!-- Header Section End -->
<?php
$categories_title = get_field('categories_title');
$categories_sub__title = get_field('categories_subtitle');
$browse_jobs_title = get_field('browse_jobs_title');
$browse_jobs_description = get_field('browse_jobs_description');
$browse_jobs_img = get_field('browse_jobs_image');
$how_it_works__title = get_field('how_it_works_title');
$how_it_works_des = get_field('how_it_works_description');
$how_it_works_box = get_field('how_it_works_items');
$latest_job_title = get_field('latest_job_title');
$latest_job_description = get_field('latest_job_description');

?>
<!-- Category Section Start -->
<section class="category section bg-gray">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php echo esc_html($categories_title); ?></h2>
      <p><?php echo esc_html($categories_sub__title); ?></p>
    </div>
    <div class="row">
      <?php
      $job_categories = get_terms(
        array(
          'taxonomy' => 'job_category',
          'hide_empty' => false,
        )
      );
      foreach ($job_categories as $category) :
      ?>
        <div class="col-lg-3 col-md-6 col-xs-12 f-category">
          <a href="browse-jobs.html">
            <div class="icon bg-color-1">
              <i class="lni-home"></i>
            </div>
            <h3><?php echo esc_html($category->name); ?></h3>
            <p>(<?php echo esc_html($category->count); ?> jobs)</p>
          </a>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>
<!-- Category Section End -->


<!-- Listings Section End -->

<!-- Browse jobs Section Start -->
<div id="browse-jobs" class="section bg-gray">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="text-wrapper">
          <div>
            <h3><?= !empty($browse_jobs_title) ? $browse_jobs_title : ''; ?></h3>
            <p><?= !empty($browse_jobs_description) ? $browse_jobs_description : ''; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="img-thumb">
          <img class="img-fluid" src="<?= is_array($browse_jobs_img) ? $browse_jobs_img["url"] : get_template_directory() . "/assets/img/search.png"; ?>" alt="">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Browse jobs Section End -->

<!-- How It Work Section Start -->
<section class="how-it-works section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?= $how_it_works__title; ?></h2>
      <p><?= $how_it_works_des; ?></p>
    </div>
    <div class="row">
      <?php if (!is_null($how_it_works_box) && is_array($how_it_works_box)) :  ?>
        <?php foreach ($how_it_works_box as $box) : ?>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="work-process">
              <?= $box["icon"]; ?>
              <h4><?= $box["position"]; ?></h4>
              <p><?= $box["description"]; ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
  </div>
</section>
<!-- How It Work Section End -->

<!-- Latest Section Start -->
<section id="latest-jobs" class="section bg-gray">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title"><?php echo esc_html($latest_job_title); ?></h2>
      <p><?php echo esc_html($latest_job_description); ?></p>
    </div>
    <div class="row">
      <?php
      $latest_jobs = new WP_Query(
        array(
          'post_type'      => 'job',
          'post_status'    => 'publish',
          'posts_per_page' => 6,
          'orderby'        => 'date',
          'order'          => 'DESC',
        )
      );

      if ($latest_jobs->have_posts()) :
        while ($latest_jobs->have_posts()) :
          $latest_jobs->the_post();
          $job_categories = get_the_terms(get_the_ID(), 'job_category');
      ?>
          <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="jobs-latest">
              <div class="img-thumb">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                <?php else : ?>
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/features/img-1.jpg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                <?php endif; ?>
              </div>
              <div class="content">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php if (!empty($job_categories) && !is_wp_error($job_categories)) : ?>
                  <p class="brand"><?php echo esc_html($job_categories[0]->name); ?></p>
                <?php endif; ?>
                <div class="tags">
                  <span><i class="lni-user"></i> <?php the_author(); ?></span>
                </div>
                <div class="tag mb-3">
                  <i class="lni-tag"></i>
                  <?php
                  $skills_job = get_post_meta(get_the_ID(), 'skills', true);
                  echo $skills_job;
                  ?>
                </div>
              </div>
            </div>
          </div>
      <?php
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
      <div class="col-12 text-center mt-4">
        <a href="<?php echo esc_url(get_post_type_archive_link('job')); ?>" class="btn btn-common">Browse All Jobs</a>
      </div>
    </div>
  </div>
</section>
<!-- Latest Section End -->

<!-- Testimonial Section Start -->
<section id="testimonial" class="section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Clients Review</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit ellentesque dignissim quam et <br> metus effici turac fringilla lorem facilisis.</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div id="testimonials" class="touch-slider owl-carousel">
          <div class="item">
            <div class="testimonial-item">
              <div class="author">
                <div class="img-thumb">
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/testimonial/img1.png'); ?>" alt="">
                </div>
              </div>
              <div class="content-inner">
                <p class="description">Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui.</p>
                <div class="author-info">
                  <h2><a href="#">Jessica</a></h2>
                  <span>Senior Accountant</span>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimonial-item">
              <div class="author">
                <div class="img-thumb">
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/testimonial/img2.png'); ?>" alt="">
                </div>
              </div>
              <div class="content-inner">
                <p class="description">Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui.</p>
                <div class="author-info">
                  <h2><a href="#">John Doe</a></h2>
                  <span>Project Menager</span>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimonial-item">
              <div class="author">
                <div class="img-thumb">
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/testimonial/img3.png'); ?>" alt="">
                </div>
              </div>
              <div class="content-inner">
                <p class="description">Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui Morbi quam enim, cursus non erat pretium veh icula finibus ex stibulum venenatis viverra dui.</p>
                <div class="author-info">
                  <h2><a href="#">Helen</a></h2>
                  <span>Engineer</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Testimonial Section End -->
<!-- Blog Section -->
<section id="blog" class="section">
  <!-- Container Starts -->
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Blog Post</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit ellentesque dignissim quam et <br> metus effici turac fringilla lorem facilisis.</p>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6 col-xs-12 blog-item">
        <!-- Blog Item Starts -->
        <div class="blog-item-wrapper">
          <div class="blog-item-img">
            <a href="single-post.html">
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/blog/img1.jpg'); ?>" alt="">
            </a>
          </div>
          <div class="blog-item-text">
            <h3><a href="single-post.html">Tips to write an impressive resume online for beginner</a></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore praesentium asperiores ad vitae.</p>
          </div>
          <a class="readmore" href="#">Read More</a>
        </div>
        <!-- Blog Item Wrapper Ends-->
      </div>

      <div class="col-lg-4 col-md-6 col-xs-12 blog-item">
        <!-- Blog Item Starts -->
        <div class="blog-item-wrapper">
          <div class="blog-item-img">
            <a href="single-post.html">
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/blog/img2.jpg'); ?>" alt="">
            </a>
          </div>
          <div class="blog-item-text">
            <h3><a href="single-post.html">Let's explore 5 cool new features in JobBoard theme</a></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore praesentium asperiores ad vitae.</p>
          </div>
          <a class="readmore" href="#">Read More</a>
        </div>
        <!-- Blog Item Wrapper Ends-->
      </div>

      <div class="col-lg-4 col-md-6 col-xs-12 blog-item">
        <!-- Blog Item Starts -->
        <div class="blog-item-wrapper">
          <div class="blog-item-img">
            <a href="single-post.html">
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/blog/img3.jpg'); ?>" alt="">
            </a>
          </div>
          <div class="blog-item-text">
            <h3><a href="single-post.html">How to convince recruiters and get your dream job</a></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore praesentium asperiores ad vitae.</p>
          </div>
          <a class="readmore" href="#">Read More</a>
        </div>
        <!-- Blog Item Wrapper Ends-->
      </div>
    </div>
  </div>
</section>
<!-- blog Section End -->


<!-- download Section Start -->

<!-- Footer Section Start -->
<?php get_footer(); ?>