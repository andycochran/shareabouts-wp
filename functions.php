<?php

// Register Foundation's scripts & stylesheets
require_once(get_template_directory().'/assets/functions/comments.php');
require_once(get_template_directory().'/assets/functions/enqueue-scripts.php');
require_once(get_template_directory().'/assets/functions/menus.php');
require_once(get_template_directory().'/assets/functions/places.php');

// Turn off the Admin Bar until it works with AJAX page loading
add_filter('show_admin_bar', '__return_false');
