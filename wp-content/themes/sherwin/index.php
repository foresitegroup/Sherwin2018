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
        if (is_product()) {
          echo '<div class="single-product">';
            echo '<div id="text">';
              the_content();
            echo "</div>\n"; // /#text

            echo "<div id=\"product-sidebar\">\n";
              $attachment_ids = $product->get_gallery_image_ids();

              if ($attachment_ids) {
                ?>
                <div id="product-gallery">
                  <?php if (get_post_meta($post->ID, 'fg_wc_gallery_type', true) == "gallery-carousel") { ?>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.min.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/inc/jquery.cycle2.carousel.min.js"></script>
                    
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.min.js"></script>
                    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.css">
                    <script type="text/javascript">
                      jQuery(document).ready(function($) {
                        $('[data-fancybox="product"]').fancybox({
                          infobar: false,
                          buttons: ['close'],
                          idleTime : 0,
                          backFocus : false
                        });
                      });
                    </script>
                    
                    <div class="cycle-slideshow" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-slides="> a" data-cycle-carousel-visible="1" data-cycle-carousel-fluid="true" data-cycle-next="#next" data-cycle-prev="#prev" data-cycle-pager="#pager" data-cycle-pager-template="" data-cycle-caption="#image-title" data-cycle-caption-template="{{cycleTitle}}">
                      <?php
                      $pager = "";
                      $image_count = 0;

                      foreach ($attachment_ids as $attachment_id) {
                        $gallery_image = wp_get_attachment_image_src($attachment_id, 'full');
                        $imagemeta = get_post($attachment_id);

                        echo '<a href="'.$gallery_image[0].'" data-fancybox="product" style="background-image: url('.$gallery_image[0].');" data-cycle-title="'.esc_html(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)).'" data-caption="'.esc_html($imagemeta->post_excerpt).'"></a>';

                        $pager .= '<span style="background-image: url('.$gallery_image[0].'); width: calc(20% - 20px);"></span>';

                        $image_count++;
                      }

                      if ($image_count > 1) {
                      ?>
                      <p id="pager"><?php echo $pager; ?></p>
                      <?php } ?>
                    </div>
                    
                    <?php if ($image_count > 1) { ?>
                    <a href="#" id="prev"><i class="fas fa-caret-left"></i></a>
                    <a href="#" id="next"><i class="fas fa-caret-right"></i></a>
                    <?php } ?>

                    <div id="image-title"></div>
                  <?php
                  }

                  if (get_post_meta($post->ID, 'fg_wc_gallery_type', true) == "gallery-stacked") {
                    echo "<u>Image Gallery</u>\n";
                    
                    foreach ($attachment_ids as $attachment_id) {
                      $gallery_image = wp_get_attachment_image_src($attachment_id, 'full');
                      $imagemeta = get_post($attachment_id);

                      echo '<img src="'.$gallery_image[0].'" alt="">';

                      if ($imagemeta->post_excerpt != "") echo $imagemeta->post_excerpt."<br>";
                    }
                  }
                  ?>
                </div>
                <?php
              }
              $images = get_attached_media('image', $post->ID);

              echo '<div id="videos">';
                if ($post->fg_wc_videos != "") {
                  foreach(preg_split("/((\r?\n)|(\r\n?))/", $post->fg_wc_videos) as $video){
                    echo '<div class="video">'.wp_oembed_get($video)."</div>\n";
                  }
                }
              echo "</div>\n";
            echo "</div>\n"; // /#product-sidebar
          echo "</div>\n"; // /.single-product
        } else {
          the_content();
        }
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