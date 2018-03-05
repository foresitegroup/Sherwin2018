<?php
/* Template Name: About */

get_header();
?>

<div class="site-width about">
  <?php
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      the_content();
    endwhile;
  endif;

  $image1 = get_the_post_thumbnail_url(get_the_ID(),'full'); 
  $image2_id = get_post_meta(get_the_ID(), '_fg_about_featured_image_id', true);
  $image2 = wp_get_attachment_image_src($image2_id, "full");
  ?>

  <img src="<?php echo $image1; ?>" alt="" id="image1">
  <img src="<?php echo $image2[0]; ?>" alt="" id="image2">
</div>

<img src="<?php echo get_template_directory_uri(); ?>/images/about-exterior.png" alt="" id="image-exterior">

<?php get_footer(); ?>