<?php
/* Template Name: Rental Equipment */

get_header();
?>

<div class="rental-gray">
  <div class="site-width">
    <?php
    if ( have_posts() ) :
      while ( have_posts() ) : the_post();
        the_content();
      endwhile;
    endif;
    ?>
  </div>
</div>

<div class="site-width rental-list">
  <?php echo do_shortcode('[table id=1 /]'); ?>
</div>

<?php get_footer(); ?>