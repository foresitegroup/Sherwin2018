<?php get_header(); ?>

<div class="home-content">
  <div class="site-width">
    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>" alt="">
    <?php
    if ( have_posts() ) :
    	while ( have_posts() ) : the_post();
    		the_content();
    	endwhile;
    endif;
    ?>
  </div>
</div>

<?php
$args = array(
  'post_type' => 'product',
  'posts_per_page' => -1,
  'tax_query' => array(
    array(
      'taxonomy' => 'product_visibility',
      'field'    => 'name',
      'terms'    => 'featured'
    ),
  ),
);
$loop = new WP_Query( $args );
if ($loop->have_posts()) {
  while ($loop->have_posts()) : $loop->the_post();
    echo $loop->post->ID;
    echo " ";

    $manufacturer = get_post_meta($loop->post->ID, 'fg_wc_manufacturer', true);
    if ($manufacturer) echo $manufacturer." ";

    the_title();
    echo " ";

    echo get_permalink($loop->post->ID);
    echo " ";

    global $product;
    $image_id = $product->get_gallery_attachment_ids();
    $image = wp_get_attachment_url($image_id[0]);
    $image = $image ? $image : "NO IMAGE";
    echo $image;

    echo "<br>";
  endwhile;
}
wp_reset_postdata();
?>

<?php get_footer(); ?>