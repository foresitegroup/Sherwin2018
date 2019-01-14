<?php
/* Template Name: Events */

get_header();
?>

<?php
$rightnow = strtotime("Today");

$args = array (
  'post_type' => 'foresite_event',
  'orderby'   => 'meta_value_num',
  'order'     => 'ASC',
  'showposts' => -1,
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
    <div class="site-width events">
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

<!-- <div class="site-width"> -->
  <?php
  // $rightnow = strtotime("Today");

  // $args = array (
  //   'post_type' => 'foresite_event',
  //   'orderby'   => 'meta_value_num',
  //   'order'     => 'ASC',
  //   'showposts' => -1,
  //   'meta_query' => array(
  //     'relation'=>'OR',
  //      array(
  //       'key' => 'foresite_event_date_start',
  //       'value' => $rightnow,
  //       'compare' => '>=',
  //       'type' => 'NUMERIC'
  //      ),
  //      array(
  //       'key' => 'foresite_event_date_end',
  //       'value' => $rightnow,
  //       'compare' => '>=',
  //       'type' => 'NUMERIC'
  //      ),
  //      array('key' => 'foresite_event_date_start', 'compare' => 'NOT EXISTS')
  //   )
  // );

  // $events = new WP_Query($args);

  // if ($events->have_posts()) {
  //   while ($events->have_posts() ) : $events->the_post();
  //     echo '<div class="event">';
  //       echo "<h2>" . date("M j", $post->foresite_event_date_start);

  //       if ($post->foresite_event_date_end != "") {
  //         echo " - ";

  //         if (date("M", $post->foresite_event_date_start) != date("M", $post->foresite_event_date_end))
  //           echo date("M ", $post->foresite_event_date_end);

  //         echo date("j", $post->foresite_event_date_end);
  //       }

  //       echo "</h2>";

  //       the_title("<h3>","</h3>");
  //     echo "</div>";
  //   endwhile;
  // }
  // wp_reset_postdata();
  ?>
<!-- </div> -->

<?php get_footer(); ?>