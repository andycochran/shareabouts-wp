<?php /* Template Name: Shareabouts Map */ ?>

<?php get_header(); ?>

<div id="site-body" class="content-visible">

  <div id="map-container">
    <div id="map"></div>
    <button id="add-place" class="button large"><strong>Add Place</strong><!-- TODO: make text configurable --></button>
  </div>

  <div id="content">
    <button id="content-close-button" class="close-button" aria-label="close content" type="button"><span aria-hidden="true">&times;<small class="show-for-small-only">&nbsp;Close</small></span></button>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post">
      <header class="post-header">
        <h2 class="post-title"><?php the_title(); ?></h2>
      </header>
      <section class="post-content">
        <?php the_content(); ?>
      </section>
      <div class="post-comments">
        <?php comments_template(); ?>
      </div>
    </article>
    <?php endwhile; endif; ?>
  </div>

</div>

<?php get_footer(); ?>
