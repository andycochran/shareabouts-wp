<?php /* Template Name: Shareabouts Map */ ?>

<?php get_header(); ?>

<div id="map-container">
  <div id="map"></div>
  <button id="add-place" class="button large"><strong>Add Place</strong><!-- TODO: make text configurable --></button>
</div>

<div id="content">
  <div class="row column expanded">
    <button class="close-button" aria-label="close content" type="button"><span aria-hidden="true">&times;</span></button>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <header class="page-header">
      <h2 class="page-title"><?php the_title(); ?></h2>
    </header>
    <section class="page-content">
      <?php the_content(); ?>
    </section>
    <?php endwhile; endif; ?>
  </div>
</div>

<?php get_footer(); ?>
