<?php
/* Template Name: Contact */

get_header();
?>

<div class="site-width contact">
  <div id="contact-find">
    TOP HALF
  </div>
  
  <div id="contact-map">
    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>" alt="">
  </div>
</div>

<div id="contact-results">
  <div class="site-width">
    RESULTS
  </div>
</div>

<?php get_footer(); ?>