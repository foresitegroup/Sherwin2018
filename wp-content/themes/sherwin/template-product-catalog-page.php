<?php
/* Template Name: Product Catalog */

get_header();

function CatLoop ($CatSlug) {
  $catloop = new WP_Query(array('product_cat' => $CatSlug, 'orderby' =>'menu_order', 'order' => 'ASC'));
  while ($catloop->have_posts()) : $catloop->the_post(); global $product;
    echo "<li>";
      echo '<a href="'.get_permalink($catloop->post->ID).'">';
      the_title();
      echo '</a>';
    echo "</li>";
  endwhile;
  wp_reset_query();
}

$cats1 = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'parent' => 0, 'exclude' => array(17)));

foreach ($cats1 as $cat1) {
  $cats2 = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'parent' => $cat1->term_id));

  $cat_img_id = get_woocommerce_term_meta($cat1->term_id, 'thumbnail_id', true);
  $cat_img = wp_get_attachment_image_src($cat_img_id, 'full');
  ?>
  <div class="main-cat"<?php if ($cat_img) echo ' style="background-image: url('.$cat_img[0].');"' ?>>
    <div class="site-width">
      <h1><?php echo $cat1->name; ?></h1>
    </div>
  </div>
  <div>
    <div class="site-width">
      <ul>
        <?php
        if ($cats2) {
          foreach($cats2 as $cat2) {
            $cats3 = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'parent' => $cat2->term_id));

            echo "<li>";
              echo "<h2>".$cat2->cat_name."</h2>";
              
              echo "<ul>";
                if ($cats3) {
                  foreach($cats3 as $cat3) {
                    echo "<li>";
                      echo "<h3>".$cat3->cat_name."</h3>";

                      echo "<ul>";
                        CatLoop($cat3->slug);
                      echo "</ul>";
                    echo "</li>";
                  }
                } else {
                  CatLoop($cat2->slug);
                }
              echo "</ul>";
            echo "</li>";
          }
        } else {
          CatLoop($cat1->slug);
        }
        ?>
      </ul>
    </div>
  </div>
<?php
}

get_footer();
?>