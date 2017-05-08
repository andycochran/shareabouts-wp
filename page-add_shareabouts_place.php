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

              <label for="place-submission-excerpt"><?php _e( 'Excerpt', 'shareabouts' ); ?></label>
              <textarea rows="2" cols="20" name="place-submission-excerpt" id="place-submission-excerpt" required aria-required="true"></textarea>

              <label for="place-submission-content"><?php _e( 'Content', 'shareabouts' ); ?></label>
              <textarea rows="10" cols="20" name="place-submission-content" id="place-submission-content"></textarea>

              <input type="submit" value="<?php esc_attr_e( 'Submit', 'shareabouts'); ?>">

            </form>
            <?php
        } else {
            // the user is not logged in or cannot edit places
            echo sprintf( '<a href="%1s">%2s</a>', esc_url( wp_login_url() ), __( 'Log in', 'shareabouts' ) );
        }

        ?>
      </section>
    </article>
    <?php endwhile; endif; ?>
  </div>

</div>

<?php get_footer(); ?>
