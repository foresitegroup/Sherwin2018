<?php
/* Template Name: Employment */
get_header(); ?>

<div class="site-width employment-post-header tongue">
  <strong>At Sherwin Industries</strong> every decision made, every capital purchase, and every long-term strategy implemented is done with one goal in mind: to make Sherwin a place where great people choose to work. If you are looking for a great company, you’ve come to the right place.
</div>

<div class="employment">
  <div class="site-width">
    <h2>Open Positions</h2>
    <?php
    if ( have_posts() ) :
    	while ( have_posts() ) : the_post();
    		the_content();
    	endwhile;
    endif;
    ?>
  </div>
</div>

<?php get_footer(); ?>