<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Job_Portal
 */
$logo = get_field('logo', 'option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <!-- Required meta tags -->
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="Bootstrap, Landing page, Template, Registration, Landing">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="author" content="UIdeck">
  <title>JobX - Job Portal Template</title>

  <!-- Bootstrap CSS -->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <!-- Header Section Start -->
  <header id="home" class="hero-area">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
      <div class="container">
        <div class="theme-header clearfix">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              <span class="lni-menu"></span>
              <span class="lni-menu"></span>
              <span class="lni-menu"></span>
            </button>
            <a href="index.html" class="navbar-brand"><img src="<?php echo esc_url($logo["url"]); ?>" alt=""></a>
          </div>
          <div class="collapse navbar-collapse" id="main-navbar">
            <!--<ul class="navbar-nav mr-auto w-100 justify-content-end">
              <li class="nav-item active">
                <a class="nav-link" href="index.html">
                  Home
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Pages
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="about.html">About</a></li>
                  <li><a class="dropdown-item" href="job-page.html">Job Page</a></li>
                  <li><a class="dropdown-item" href="job-details.html">Job Details</a></li>
                  <li><a class="dropdown-item" href="resume.html">Resume Page</a></li>
                  <li><a class="dropdown-item" href="privacy-policy.html">Privacy Policy</a></li>
                  <li><a class="dropdown-item" href="faq.html">FAQ</a></li>
                  <li><a class="dropdown-item" href="pricing.html">Pricing Tables</a></li>
                  <li><a class="dropdown-item" href="contact.html">Contact</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Candidates
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="browse-jobs.html">Browse Jobs</a></li>
                  <li><a class="dropdown-item" href="browse-categories.html">Browse Categories</a></li>
                  <li><a class="dropdown-item" href="add-resume.html">Add Resume</a></li>
                  <li><a class="dropdown-item" href="manage-resumes.html">Manage Resumes</a></li>
                  <li><a class="dropdown-item" href="job-alerts.html">Job Alerts</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Employers
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="post-job.html">Add Job</a></li>
                  <li><a class="dropdown-item" href="manage-jobs.html">Manage Jobs</a></li>
                  <li><a class="dropdown-item" href="manage-applications.html">Manage Applications</a></li>
                  <li><a class="dropdown-item" href="browse-resumes.html">Browse Resumes</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Blog
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="blog.html">Blog - Right Sidebar</a></li>
                  <li><a class="dropdown-item" href="blog-left-sidebar.html">Blog - Left Sidebar</a></li>
                  <li><a class="dropdown-item" href="blog-full-width.html"> Blog full width</a></li>
                  <li><a class="dropdown-item" href="single-post.html">Blog Single Post</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">
                  Contact
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.html">Sign In</a>
              </li>
              <li class="button-group">
                <a href="post-job.html" class="button btn btn-common">Post a Job</a>
              </li>
            </ul>
            -->
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'menu-1',
                'menu_id'        => 'Primary Menu',
                'container'      => false,
                'menu_class'     => 'navbar-nav mr-auto w-100 justify-content-end',

                'link_before'    => '<li class="nav-item">',
                'link_after'     => '</li>',
              )
            );

            ?>
          </div>
        </div>
      </div>
      <div class="mobile-menu" data-logo="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo-mobile.png'); ?>"></div>
    </nav>
    <!-- Navbar End -->

    <div class="container">
      <div class="row space-100 justify-content-center">
        <div class="col-lg-10 col-md-12 col-xs-12">
          <div class="contents">
            <h2 class="head-title">Find the job that fits your life</h2>
            <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue posuere lacus, <br> id tincidunt nisi porta sit amet. Suspendisse et sapien varius, pellentesque dui non.</p>
            <div class="job-search-form">
              <form>
                <div class="row">
                  <div class="col-lg-5 col-md-6 col-xs-12">
                    <div class="form-group">
                      <input class="form-control" type="text" placeholder="Job Title or Company Name">
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-xs-12">
                    <div class="form-group">
                      <div class="search-category-container">
                        <label class="styled-select">
                          <select>
                            <option value="none">Locations</option>
                            <option value="none">New York</option>
                            <option value="none">California</option>
                            <option value="none">Washington</option>
                            <option value="none">Birmingham</option>
                            <option value="none">Chicago</option>
                            <option value="none">Phoenix</option>
                          </select>
                        </label>
                      </div>
                      <i class="lni-map-marker"></i>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-xs-12">
                    <div class="form-group">
                      <div class="search-category-container">
                        <label class="styled-select">
                          <select>
                            <option>All Categories</option>
                            <option>Finance</option>
                            <option>IT & Engineering</option>
                            <option>Education/Training</option>
                            <option>Art/Design</option>
                            <option>Sale/Markting</option>
                            <option>Healthcare</option>
                            <option>Science</option>
                            <option>Food Services</option>
                          </select>
                        </label>
                      </div>
                      <i class="lni-layers"></i>
                    </div>
                  </div>
                  <div class="col-lg-1 col-md-6 col-xs-12">
                    <button type="submit" class="button"><i class="lni-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>