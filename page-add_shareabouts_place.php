<?php /* Template Name: Shareabouts Add Place Form */ ?>

<?php get_header(); ?>

<div id="site-body" class="content-visible">

  <?php get_template_part( 'shareabouts_map' ); ?>

  <div id="content">
    <button id="content-close-button" class="close-button" aria-label="close content" type="button"><span aria-hidden="true">&times;<small class="show-for-small-only">&nbsp;Close</small></span></button>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post">
      <header class="post-header">
        <h2 class="post-title"><?php the_title(); ?></h2>
      </header>
      <section class="post-content">
        <?php

        the_content();

        if ( is_user_logged_in() && current_user_can('edit_posts') ) {
            // the user is logged in and can edit places
            ?>
            <form id="place-submission-form">

              <label for="place-submission-title"><?php _e( 'Title', 'shareabouts' ); ?></label>
              <input type="text" name="place-submission-title" id="place-submission-title" required aria-required="true">

              <label for="place-submission-content"><?php _e( 'Content', 'shareabouts' ); ?></label>
              <textarea rows="10" cols="20" name="place-submission-content" id="place-submission-content" required aria-required="true"></textarea>

              <input type="text" name="place-submission-location" id="place-submission-location" required aria-required="true" placeholder="Drag the map to your location.">

              <input type="submit" value="<?php
                if (get_option('submit_place_button')) {
                  echo esc_attr( get_option('submit_place_button') );
                } else {
                  esc_attr_e( 'Submit place', 'shareabouts');
                }
               ?>">

            </form>
            <?php
        } else {
            // the user is not logged in or cannot edit places
            ?>
            <a data-open="pt-user-modal" class="button large expanded"><strong><?php _e('Sign in to add a place', 'shareabouts'); ?></strong></a>
            <?php
        }

        ?>
      </section>
    </article>
    <?php endwhile; endif; ?>
  </div>

</div>

<?php get_footer(); ?>
