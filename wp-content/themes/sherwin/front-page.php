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
$args = array('post_type' => 'product', 'posts_per_page' => -1, 'tax_query' => array(
  array('taxonomy' => 'product_visibility', 'field'    => 'name', 'terms'    => 'featured')
));
$loop = new WP_Query($args);
if ($loop->have_posts()) {
  ?>
  <div class="cycle-slideshow featured-products" data-cycle-slides="> div" data-cycle-timeout="9000" data-cycle-speed="500" data-cycle-pause-on-hover="true" data-cycle-next="#fp-next" data-cycle-prev="#fp-prev" data-cycle-pager="#fp-pager" data-cycle-pager-template="<a href='#'></a>">
    <?php
    while ($loop->have_posts()) : $loop->the_post();
      global $product;
      $image_id = $product->get_gallery_attachment_ids();
      $image = wp_get_attachment_url($image_id[0]);
      $image = $image ? ' style="background-image: url('.$image.');"' : "";

      echo "<div".$image.">";
        echo '<div class="site-width">';
          echo "<div>";
            $manufacturer = get_post_meta($loop->post->ID, 'fg_wc_manufacturer', true);
            if ($manufacturer) echo "<h2>".$manufacturer."</h2>";

            the_title('<h1>','</h1>');

            echo '<a href="'.get_permalink($loop->post->ID).'">See Product</a>';
          echo "</div>";
        echo "</div>";
      echo "</div>";
    endwhile;

    if ($loop->post_count > 1) {
    ?>
      <p id="fp-pager"></p>
      <a href="#" id="fp-prev"><i class="fas fa-caret-left"></i></a>
      <a href="#" id="fp-next"><i class="fas fa-caret-right"></i></a>
    <?php } ?>
  </div>
  <?php
}
wp_reset_postdata();
?>

<div id="partners" class="site-width">
  <?php
  $partners = get_post(166);
  echo "<h1>".$partners->post_title."</h2>";
  echo $partners->post_content;
  ?>
</div>

<?php
$rightnow = strtotime("Today");

$args = array (
  'post_type' => 'foresite_event',
  'orderby'   => 'meta_value_num',
  'order'     => 'ASC',
  'showposts' => 3,
  'meta_query' => array(
      'relation'=>'OR',
       array(
          'key' => 'foresite_event_date_start',
          'value' => $rightnow,
          'compare' => '>=',
          'type' => 'NUMERIC'
       ),
       array(
          'key' => 'foresite_event_date_end',
          'value' => $rightnow,
          'compare' => '>=',
          'type' => 'NUMERIC'
       ),
       array('key' => 'foresite_event_date_start', 'compare' => 'NOT EXISTS')
   )
);

$events = new WP_Query($args);

if ($events->have_posts()) {
  ?>
  <div id="events">
    <div class="site-width">
      <div class="seeus">
        <h1>SEE US HERE</h1>
        Catch Sherwin Industries at the following events
      </div>

      <?php
      while ($events->have_posts() ) : $events->the_post();
        echo '<div class="event">';
          echo "<h2>" . date("M j", get_post_meta(get_the_ID(), 'foresite_event_date_start', true));

          if (get_post_meta(get_the_ID(), 'foresite_event_date_end', true) != "") {
            echo " - ";

            if (date("M", get_post_meta(get_the_ID(), 'foresite_event_date_start', true)) != date("M", get_post_meta(get_the_ID(), 'foresite_event_date_end', true)))
              echo date("M ", get_post_meta(get_the_ID(), 'foresite_event_date_end', true));

            echo date("j", get_post_meta(get_the_ID(), 'foresite_event_date_end', true));
          }

          echo "</h2>";

          the_title("<h3>","</h3>");
        echo "</div>";
      endwhile;
      ?>
    </div>
  </div>
  <?php
}
wp_reset_postdata();
?>

<?php get_footer(); ?>