<?php
add_filter( 'the_content', function( $content ) {
  if (  is_page_template('page-add_shareabouts_place.php') &&
        is_user_logged_in() &&
        current_user_can('edit_posts')
      ) {
      // the user is logged in and can edit places
      ob_start();?>
      <form id="place-submission-form">

        <label for="place-submission-title"><?php _e( 'Title', 'shareabouts' ); ?></label>
        <input type="text" name="place-submission-title" id="place-submission-title" required aria-required="true">

        <label for="place-submission-excerpt"><?php _e( 'Excerpt', 'shareabouts' ); ?></label>
        <textarea rows="2" cols="20" name="place-submission-excerpt" id="place-submission-excerpt" required aria-required="true"></textarea>

        <label for="place-submission-content"><?php _e( 'Content', 'shareabouts' ); ?></label>
        <textarea rows="10" cols="20" name="place-submission-content" id="place-submission-content"></textarea>

        <input type="submit" value="<?php esc_attr_e( 'Submit', 'shareabouts'); ?>">

      </form>
      <?php

      $content .= ob_get_clean();
    } else {
      // the user is not logged in or cannot edit places
      $content .=  sprintf( '<a href="%1s">%2s</a>', esc_url( wp_login_url() ), __( 'Log in', 'shareabouts' ) );
  }

  return $content;
});
