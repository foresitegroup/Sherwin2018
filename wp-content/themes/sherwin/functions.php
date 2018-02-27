<?php
// We want Featured Images on Pages and Posts
add_theme_support( 'post-thumbnails' );


// Don't resize Featured Images
function my_thumbnail_size() {
  set_post_thumbnail_size();
}
add_action('after_setup_theme', 'my_thumbnail_size', 11);


// Don't wrap images in P tags
add_filter('the_content', 'filter_ptags_on_images');
function filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


// Wrap video embed code in DIV for responsive goodness
add_filter( 'embed_oembed_html', 'my_oembed_filter', 10, 4 ) ;
function my_oembed_filter($html, $url, $attr, $post_ID) {
  $return = '<div class="video">'.$html.'</div>';
  return $return;
}


// Define menus
function register_my_menus() {
  register_nav_menus(
    array(
      'main-menu' => __('Main Menu')
    )
  );
}
add_action( 'init', 'register_my_menus' );


function fg_remove_wc_meta_boxes() {
  remove_meta_box('woocommerce-product-data', 'product', 'normal');
  remove_meta_box('postexcerpt', 'product', 'normal');
  remove_meta_box('tagsdiv-product_tag' , 'product' , 'side');
}
add_action('add_meta_boxes', 'fg_remove_wc_meta_boxes', 999);


/*
*  Add custom fields to WooCommerce product
*/
// Build the meta box
add_action('admin_init', 'fg_wc_custom_fields');
function fg_wc_custom_fields() {
  add_meta_box('fg_wc_custom_fields_box',
    'Additional Fields',
    'display_fg_wc_custom_fields',
    'product',
    'test', // change to something other then normal, advanced or side
    'high'
  );
}

// Place the meta box before the description
add_action('edit_form_after_title', 'fg_wc_move_pre_desc');
function fg_wc_move_pre_desc() {
  global $post, $wp_meta_boxes;
  do_meta_boxes( get_current_screen(), 'test', $post );
  unset($wp_meta_boxes['post']['test']);
}

// Add a little space before the meta box
add_action('admin_head', 'fg_wc_css');
function fg_wc_css() {
  echo '<style>
    #fg_wc_custom_fields_box { margin: 1.5em 0 0; }
    #fg_wc_custom_fields_box INPUT { margin: 0.5em 0; width: 100%; }
  </style>';
}

// Create the fields we want
function display_fg_wc_custom_fields($post) {
  $fg_wc_subtitle = esc_html(get_post_meta($post->ID, 'fg_wc_subtitle', true));
  $fg_wc_manufacturer = esc_html(get_post_meta($post->ID, 'fg_wc_manufacturer', true));
  ?>
  <input type="text" name="fg_wc_subtitle" value="<?php echo $fg_wc_subtitle; ?>" placeholder="Subtitle">
  <input type="text" name="fg_wc_manufacturer" value="<?php echo $fg_wc_manufacturer; ?>" placeholder="Manufacturer">
  <?php
}

// Save the data from our fields
function save_fg_wc_custom_fields($post_id){
  if (isset($_POST['fg_wc_subtitle']))
    update_post_meta($post_id, 'fg_wc_subtitle', $_POST['fg_wc_subtitle']);
  if (isset($_POST['fg_wc_manufacturer']))
    update_post_meta($post_id, 'fg_wc_manufacturer', $_POST['fg_wc_manufacturer']);
}
add_action('save_post', 'save_fg_wc_custom_fields', 10, 2);
?>