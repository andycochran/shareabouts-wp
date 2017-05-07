<!doctype html>

  <html class="no-js"  <?php language_attributes(); ?>>

  <head>
    <meta charset="utf-8">

    <!-- Force IE to use the latest rendering engine available -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700" rel="stylesheet">

    <!-- TODO: configurable favicon -->
    <!-- <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" /> -->

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>

  </head>

  <body <?php body_class(); ?>>

    <header id="site-header">
      <div class="row expanded">
        <div class="column medium-6">
          <a class="site-title shareabouts-font" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a>
          <span class="site-description"><?php bloginfo('description'); ?></span>
        </div>
        <div class="column medium-6">

          <?php the_main_nav(); ?>

          <?php
          global $current_user;
          get_currentuserinfo();
          if ( is_user_logged_in() ) {
            echo $current_user->display_name . "\n";
          }
          wp_loginout();
          ?>

        </div>
      </div>
    </header>
