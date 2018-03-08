<?php get_header(); ?>

<div class="site-width">
	<?php
	if (have_posts()) {
		while (have_posts()) : the_post();
      if (is_search()) {
        global $product;
        $image_id = $product->get_gallery_attachment_ids();
        $image = wp_get_attachment_url($image_id[0]);
        $image = $image ? $image : get_template_directory_uri()."/images/apple-touch-icon.png";
        ?>
        <a href="<?php echo get_permalink(); ?>" class="search-result">
          <div class="image" style="background-image: url(<?php echo $image; ?>);"></div>
          
          <?php
          $manufacturer = get_post_meta($post->ID, 'fg_wc_manufacturer', true);
          if ($manufacturer) echo "<h2>".$manufacturer."</h2>";
          
          the_title("<h1>", "</h1>");

          $subtitle = get_post_meta($post->ID, 'fg_wc_subtitle', true);
          if ($subtitle) echo "<h3>".$subtitle."</h3>";
          ?>

          <h4>
            Found in:
            <?php
            $prodcats = get_page_by_path($product, OBJECT, 'product');
            $terms = get_the_terms($prodcats->ID, 'product_cat');
            foreach ($terms as $term) { echo $term->name." > "; }
            the_title();
            ?>
          </h4>

          <span>&raquo;</span>
        </a>
        <?php
      } else {
        the_content();
      }
		endwhile;
  } else {
    if (is_search()) echo "Sorry, no results found.";
	}
	?>
  
  <?php if (is_search()) { ?>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      var widest = 0;
      jQuery(".search-result").each(function () {
        widest = Math.max(widest, jQuery(this).width());
      }).width(widest+1);
    });
  </script>
  <?php } ?>
</div><!-- .site-width -->

<?php get_footer(); ?>