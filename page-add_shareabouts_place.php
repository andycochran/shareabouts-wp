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
        <?php the_content(); ?>
        <form>
          <!-- TODO: create a form to publish a shareabouts_place through the WP API -->
        </form>
      </section>
    </article>
    <?php endwhile; endif; ?>
  </div>

</div>

<?php get_footer(); ?>
