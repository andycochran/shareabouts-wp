<?php

// Register the custom post type
function shareabouts_place_post_type() {
  register_post_type( 'shareabouts_place',
    array('labels' => array(
      'name' => __('Places', 'shareabouts'),
      'singular_name' => __('Place', 'shareabouts'),
      'all_items' => __('All Places', 'shareabouts'),
      'add_new' => __('Add New', 'shareabouts'),
      'add_new_item' => __('Add New Place', 'shareabouts'),
      'edit' => __( 'Edit', 'shareabouts' ),
      'edit_item' => __('Edit Place', 'shareabouts'),
      'new_item' => __('New Place', 'shareabouts'),
      'view_item' => __('View Place', 'shareabouts'),
      'search_items' => __('Search Places', 'shareabouts'),
      'not_found' =>  __('Nothing found in the Database.', 'shareabouts'),
      'not_found_in_trash' => __('Nothing found in Trash', 'shareabouts')
      ),
      'description' => __( 'Shareabouts Places', 'shareabouts' ),
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'show_in_nav_menus'=> false,
      'query_var' => true,
      'menu_position' => 20,
      'menu_icon' => 'dashicons-location',
      'rewrite'  => array( 'slug' => 'places', 'with_front' => false ),
      'has_archive' => false,
      // 'capability_type' => 'page',
      'hierarchical' => false,
      'supports' => array( 'title', 'editor', 'thumbnail'),
      'register_meta_box_cb' => 'add_place_metabox',
      'show_in_rest' => true,
     )
  );
}
add_action( 'init', 'shareabouts_place_post_type');

// Add place metabox
function add_place_metabox() {
  add_meta_box('shareabouts_place_metabox', 'Place Members', 'shareabouts_place_metabox', 'shareabouts_place', 'side', 'default');
}
add_action( 'add_meta_boxes', 'add_place_metabox' );

// Define the place meta
function shareabouts_place_metabox() {
  global $post;
  echo '<input type="hidden" name="shareabouts_place_metabox_noncename" id="shareabouts_place_metabox_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';

  $place_latlng = get_post_meta($post->ID, 'place_latlng', true);

  ?>
  <p><strong>LatLng</strong></p>
  <input type="text" name="place_latlng" value="<?php echo esc_attr( $place_latlng ); ?>" placeholder="38.2431627,-85.7567134" />
<?php
}

// Save the place meta
function save_shareabouts_place_metabox($post_id, $post) {
  if ( isset($_POST['shareabouts_place_metabox_noncename']) )  {
    if ( !wp_verify_nonce( $_POST['shareabouts_place_metabox_noncename'], plugin_basename(__FILE__) )) {
      return $post->ID;
    }
    if ( !current_user_can( 'edit_post', $post->ID ))
      return $post->ID;
    $place_meta['place_latlng'] = $_POST['place_latlng'];
    foreach ($place_meta as $key => $value) { // Cycle through the $events_meta array!
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }
}
add_action('save_post', 'save_shareabouts_place_metabox', 1, 2);

// Add the place LatLng to the REST API
// function slug_register_latlng() {
//   register_rest_field( 'shareabouts_place',
//     'place_latlng',
//     array(
//       'get_callback'    => 'slug_get_latlng',
//       'update_callback' => null,
//       'schema'          => null,
//     )
//   );
// }
// add_action( 'rest_api_init', 'slug_register_latlng' );
//
// function slug_get_latlng( $object, $field_name, $request ) {
//   return get_post_meta( $object[ 'id' ], $field_name, true );
// }

// Create custom places endpoint for WP REST API
function get_shareabouts_places() {
  $args = array(
    'post_type'      => 'shareabouts_place',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
  );

  $posts = get_posts($args);

  if ( empty( $posts ) ) {
    return [];
  }

  $geojson = array(
    'type'      => 'FeatureCollection',
    'features'  => array()
  );

  foreach ( $posts as $post ) {
    $feature = array(
      'id' => $post->ID,
      'type' => 'Feature',
      'geometry' => array(
          'type' => 'Point',
          'coordinates' => array($post->place_latlng)
      ),
      'properties' => array(
          'title' => $post->post_title,
          'date' => $post->post_date,
          'permalink' => get_permalink( $post->ID )
      )
    );
    array_push($geojson['features'], $feature);
  }

  return rest_ensure_response( $geojson );
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'shareabouts/v1', '/places', array(
    'methods' => 'GET',
    'callback' => 'get_shareabouts_places',
  ) );
} );
