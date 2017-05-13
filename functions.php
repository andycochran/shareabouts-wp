<?php

// Register Foundation's scripts & stylesheets
require_once(get_template_directory().'/assets/functions/comments.php');
require_once(get_template_directory().'/assets/functions/enqueue-scripts.php');
require_once(get_template_directory().'/assets/functions/menus.php');
require_once(get_template_directory().'/assets/functions/places.php');
require_once(get_template_directory().'/assets/functions/user-registration.php');

// Turn off the Admin Bar until it works with AJAX page loading
add_filter('show_admin_bar', '__return_false');

function shareabouts_logout_redirect($logouturl, $redir) {
  return $logouturl . '&amp;redirect_to='.get_permalink();
}
add_filter('logout_url', 'shareabouts_logout_redirect', 10, 2);
