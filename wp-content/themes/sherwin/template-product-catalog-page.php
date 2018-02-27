<?php
/* Template Name: Product Catalog */

get_header();
?>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".arrow").click(function(event) {
      event.preventDefault();
      $(this).toggleClass('rotate')
      $('#'+$(this).parent().parent().parent().attr('id')+' + DIV').slideToggle('slow');
    });

    $("#banner .quick-jump A").click(function(event) {
      event.preventDefault();
      // console.log($(this).attr('href'));
      $('html, body').animate({
        scrollTop: $($(this).attr('href')).offset().top - 130
      }, 600);
    });
  });
</script>

<?php
function CatLoop ($CatSlug) {
  $count = 1;

  $catloop = new WP_Query(array('product_cat' => $CatSlug, 'orderby' =>'menu_order', 'order' => 'ASC', 'showposts' => -1));

  while ($catloop->have_posts()) : $catloop->the_post(); global $product;
    echo '<a href="'.get_permalink($catloop->post->ID).'">';
    the_title();
    echo "</a><br>\n";

    if ($count == 1) echo "</div> <!-- .group -->\n";
    $count++;
  endwhile;

  if (!$catloop->have_posts()) echo "</div> <!-- .group -->\n";

  wp_reset_query();
}

$cats1 = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'parent' => 0, 'exclude' => array(17)));

foreach ($cats1 as $cat1) {
  $cats2 = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'parent' => $cat1->term_id));

  $cat_img_id = get_woocommerce_term_meta($cat1->term_id, 'thumbnail_id', true);
  $cat_img = wp_get_attachment_image_src($cat_img_id, 'full');
  ?>
  <div id="<?php echo $cat1->slug; ?>" class="main-cat"<?php if ($cat_img) echo ' style="background-image: url('.$cat_img[0].');"' ?>>
    <div class="site-width">
      <h1><?php echo $cat1->name; ?><a href="#" class="arrow"><i class="fas fa-caret-down"></i></a></h1>
      
      <?php
      if ($cats2) {
        foreach($cats2 as $cat2main) { echo "<span>".$cat2main->cat_name."</span>"; }
      }
      ?>
    </div>
  </div>
  <div>
    <div class="site-width">
      <?php
      if ($cats2) {
        foreach($cats2 as $cat2) {
          $cats3 = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'parent' => $cat2->term_id));

          echo "<div class=\"group\">\n";
          echo "<h2>".$cat2->cat_name."</h2>\n";
            
          if ($cats3) {
            $h3count = 1;
            foreach($cats3 as $cat3) {
              if ($h3count >= 2) echo "<div class=\"group\">\n";
              echo "<h3>".$cat3->cat_name."</h3>\n";
              CatLoop($cat3->slug);
              $h3count++;
            }
          } else {
            CatLoop($cat2->slug);
          }
        }
      } else {
        CatLoop($cat1->slug);
      }
      ?>
    </div>
  </div>
<?php
}

get_footer();
?>