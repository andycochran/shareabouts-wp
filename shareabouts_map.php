<?php

$add_place_page = new WP_Query(array(
  'post_type' => 'page',
  'posts_per_page' => 1,
  'meta_query' => array( array('key' => '_wp_page_template', 'value' => 'page-add_shareabouts_place.php') )
));

if ( $add_place_page->have_posts() ) {
  while ( $add_place_page->have_posts() ) {
    $add_place_page->the_post();
    $add_place_permalink = get_permalink();
  }
  wp_reset_postdata();
}

?>

<div id="map-container">
  <div id="map"></div><?php if ( isset($add_place_permalink) ) { ?>
  <a href="<?php echo $add_place_permalink; ?>" id="add-place" class="button large smoothstate<?php if(is_page_template('page-add_shareabouts_place.php')){ echo ' hide'; } ?>"><strong>Add Place</strong><!-- TODO: make text configurable --></a>
    <?php
  } ?>
  <!-- TODO: add #centerpoint marker -->
</div>
