<?php
function site_scripts() {
  global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  // Add JavaScript files in the footer
  wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/js/foundation.min.js', array( 'jquery' ), '6.2', true );
  wp_enqueue_script( 'smoothstate-js', get_template_directory_uri() . '/assets/js/jquery.smoothState.min.js', array( 'jquery' ), '', true );
  wp_enqueue_script( 'leaflet-js', get_template_directory_uri() . '/assets/js/leaflet.js', array(), '', true );
  wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/js/scripts.js', array(), '', true );

  // Register main stylesheet
  wp_enqueue_style( 'site-css', get_template_directory_uri() . '/assets/css/app.min.css', array(), '', 'all' );

}
add_action('wp_enqueue_scripts', 'site_scripts', 999);
