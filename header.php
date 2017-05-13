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

        <div id="site-header-primary">
          <a class="site-title shareabouts-font" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a>
          <span class="site-description"><?php bloginfo('description'); ?></span>
          <button id="site-header-toggle-button" type="button" data-toggle="site-header-secondary"></button>
        </div>

        <div id="site-header-secondary" class="show-for-large" data-toggler=".show-for-large">
          <div id="user-menu">
            <?php
            global $current_user;
            get_currentuserinfo();
            if ( is_user_logged_in() ) {
              echo '<button data-toggle="user-dropdown" class="float-right">' . get_avatar( $current_user->user_email, 32 ) . '</button>';
              echo '<div id="user-dropdown" class="dropdown-pane bottom text-center" data-dropdown data-hover="true" data-hover-pane="true">';
                echo '<p>Signed in as <strong>' . $current_user->display_name . '</strong></p>';
                if ( current_user_can('administrator') ) {
                  echo '<p><a href="' . admin_url() . '">WordPress Admin</a></p>';
                }
                wp_loginout();
              echo '</div>';
            } else {
              ?><ul class="menu"><li><a data-open="pt-user-modal"><?php _e('Sign in', 'shareabouts'); ?></a></li></ul><?php
            }
            ?>
          </div>
          <?php the_main_nav(); ?>
        </div>

    </header>
