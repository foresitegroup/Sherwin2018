<?php get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
endif;
?>

<!-- <div style="width: 10px; height: 2000px; background: blue;"></div> -->

<?php get_footer(); ?>