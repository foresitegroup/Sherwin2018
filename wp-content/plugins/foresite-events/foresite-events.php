<?php
/*
Plugin Name: Foresite Events
Plugin URI: https://foresitegrp.com
Description: Event management system.
Version: 1.1
Author: Foresite Group
Author URI: https://foresitegrp.com
*/

date_default_timezone_set(get_option('timezone_string'));

add_action( 'init', 'foresite_event' );
function foresite_event() {
  register_post_type( 'foresite_event',
    array(
      'labels' => array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Event',
        'edit' => 'Edit',
        'edit_item' => 'Edit Event',
        'new_item' => 'New Event',
        'view' => 'View',
        'view_item' => 'View Event',
        'search_items' => 'Search Events',
        'not_found' => 'No Events found',
        'not_found_in_trash' => 'No Events found in Trash',
        'parent' => 'Parent Event'
      ),

      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'supports' => array( 'title' ),
      'taxonomies' => array( '' ),
      'menu_icon' => 'dashicons-calendar-alt',
      'has_archive' => true
    )
  );
}


add_action('add_meta_boxes', 'foresite_event_admin_pre_desc');
function foresite_event_admin_pre_desc() {
  add_meta_box( 'foresite_event_meta_box_pre_desc',
    'Event Date',
    'display_foresite_event_meta_box_pre_desc',
    'foresite_event',
    'fgevent', // change to something other then normal, advanced or side
    'high'
  );
}

function display_foresite_event_meta_box_pre_desc( $foresite_event ) {
  wp_enqueue_script( 'jquery-ui-datepicker' );
  wp_enqueue_style( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);

  $foresite_event_date_start = get_post_meta($foresite_event->ID, 'foresite_event_date_start', true);
  $foresite_event_date_end = get_post_meta($foresite_event->ID, 'foresite_event_date_end', true);
  ?>
  <script>
    jQuery(document).ready(function(){
      jQuery('#date_start, #date_end').datepicker();
    });
  </script>

  <input type="text" name="foresite_event_date_start" value="<?php if ($foresite_event_date_start != "") echo date("m/d/Y", $foresite_event_date_start); ?>" id="date_start" placeholder="Start Date">
  <input type="text" name="foresite_event_date_end" value="<?php if ($foresite_event_date_end != "") echo date("m/d/Y", $foresite_event_date_end); ?>" id="date_end" placeholder="End Date">
  <br>
  If the event is just one day, leave the End Date blank.
  <?php
}

add_action('edit_form_after_title', 'foresite_move_pre_desc');
function foresite_move_pre_desc() {
  global $post, $wp_meta_boxes;
  do_meta_boxes( get_current_screen(), 'fgevent', $post );
  unset($wp_meta_boxes['post']['fgevent']);
}

add_action('admin_head', 'foresite_event_css');
function foresite_event_css() {
  echo '<style>
    #foresite_event_meta_box_pre_desc { margin: 1.5em 0 0; }
    #foresite_event_meta_box_pre_desc .inside { box-sizing: border-box; }
    #ui-datepicker-div { position: absolute; top: 0; z-index: 1010 !important; }
  </style>';
}


add_action( 'save_post', 'add_foresite_event_fields', 10, 2 );
function add_foresite_event_fields( $foresite_event_id, $foresite_event ) {
  if ( $foresite_event->post_type == 'foresite_event' ) {
    if (isset($_POST['foresite_event_date_start']))
      update_post_meta($foresite_event->ID, 'foresite_event_date_start', strtotime($_POST['foresite_event_date_start']));

    if (isset($_POST['foresite_event_date_end']))
      update_post_meta($foresite_event->ID, 'foresite_event_date_end', strtotime($_POST['foresite_event_date_end']));
  }
}
?>