<?php get_header(); ?>

<div class="site-width">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
	endif;
	?>
</div><!-- .site-width -->

<?php get_footer(); ?>