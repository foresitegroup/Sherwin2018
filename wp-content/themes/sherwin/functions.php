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


// Allow SVGs to be uploaded
function fg_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'fg_mime_types');


// Define menus
function register_my_menus() {
  register_nav_menus(
    array(
      'main-menu' => __('Main Menu')
    )
  );
}
add_action( 'init', 'register_my_menus' );


// Show site styles in visual editor
function themename_setup() {
  add_editor_style();
}
add_action( 'after_setup_theme', 'themename_setup' );


// Second featured image for About page
add_action('add_meta_boxes', 'fg_about_featured_image_add_metabox');
function fg_about_featured_image_add_metabox () {
  global $post;
  if ('template-about-page.php' == get_post_meta($post->ID, '_wp_page_template', true)) {
    add_meta_box('fg-about-featured-image',
      'Featured Image Two',
      'fg_about_featured_image_metabox',
      'page', 'side', 'low'
    );
    wp_enqueue_script('fgscript', get_stylesheet_directory_uri().'/inc/about-featured-image.js');
  }
}
function fg_about_featured_image_metabox ( $post ) {
  $image_id = get_post_meta($post->ID, '_fg_about_featured_image_id', true);

  if ($image_id && get_post($image_id)) {
    $thumbnail_html = wp_get_attachment_image($image_id, 'post-thumbnail');

    if (!empty($thumbnail_html)) {
      $content = $thumbnail_html;
      $content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_about_featured_image_button">Remove featured image two</a></p>';
      $content .= '<input type="hidden" id="upload_about_featured_image" name="_fg_about_featured_image_image" value="'.$image_id.'" />';
    }
  } else {
    $content = '<img src="" style="width: 100%; height: auto; border: 0; display: none;" />';
    $content .= '<p class="hide-if-no-js"><a title="Set featured image two" href="javascript:;" id="upload_about_featured_image_button" data-uploader_title="Choose an image" data-uploader_button_text="Set featured image two">Set featured image two</a></p>';
    $content .= '<input type="hidden" id="upload_about_featured_image" name="_fg_about_featured_image_image" value="" />';
  }

  echo $content;
}
add_action('admin_head', 'fg_about_css');
function fg_about_css() {
  echo '<style>
    #fg-about-featured-image IMG { max-width: 100%; height: auto; }
  </style>';
}
add_action('save_post', 'fg_about_featured_image_save', 10, 1);
function fg_about_featured_image_save ($post_id) {
  if (isset( $_POST['_fg_about_featured_image_image'])) {
    $image_id = (int) $_POST['_fg_about_featured_image_image'];
    update_post_meta($post_id, '_fg_about_featured_image_id', $image_id);
  }
}



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

  add_meta_box('fg_wc_custom_fields_box_side',
    'Gallery Type',
    'display_fg_wc_custom_fields_side',
    'product', 'side', 'low'
  );

  add_meta_box('fg_wc_custom_fields_box_side_video',
    'Videos',
    'display_fg_wc_custom_fields_side_video',
    'product', 'side', 'low'
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
    #fg_wc_custom_fields_box_side_video TEXTAREA { width: 100%; height: 4.5em; }
  </style>';
}

// Create the fields we want
function display_fg_wc_custom_fields($post) {
  $meta = get_post_meta($post->ID);
  ?>
  <input type="text" name="fg_wc_manufacturer" value="<?php if (isset($meta['fg_wc_manufacturer'])) echo $meta['fg_wc_manufacturer'][0]; ?>" placeholder="Manufacturer">
  <input type="text" name="fg_wc_subtitle" value="<?php if (isset($meta['fg_wc_subtitle'])) echo $meta['fg_wc_subtitle'][0]; ?>" placeholder="Subtitle">
  <?php
}

function display_fg_wc_custom_fields_side($post) {
  $fg_wc_gallery_type = esc_html(get_post_meta($post->ID, 'fg_wc_gallery_type', true));
  if ($fg_wc_gallery_type == "") $fg_wc_gallery_type = "gallery-carousel";
  ?>
  <label><input type="radio" name="fg_wc_gallery_type" value="gallery-carousel"<?php if ($fg_wc_gallery_type == "gallery-carousel") echo " checked"; ?>> Carousel</label><br>
  <label><input type="radio" name="fg_wc_gallery_type" value="gallery-stacked"<?php if ($fg_wc_gallery_type == "gallery-stacked") echo " checked"; ?>> Stacked</label>
  <?php
}

function display_fg_wc_custom_fields_side_video($post) {
  ?>
  <textarea name="fg_wc_videos"><?php if ($post->fg_wc_videos) echo $post->fg_wc_videos; ?></textarea>
  Full URL of video, one per line
  <?php
}

// Save the data from our fields
add_action('save_post', 'save_fg_wc_custom_fields', 10, 2);
function save_fg_wc_custom_fields($post_id){
  update_post_meta($post_id, 'fg_wc_manufacturer', $_POST['fg_wc_manufacturer']);
  update_post_meta($post_id, 'fg_wc_subtitle', $_POST['fg_wc_subtitle']);
  update_post_meta($post_id, 'fg_wc_gallery_type', $_POST['fg_wc_gallery_type']);
  update_post_meta($post_id, 'fg_wc_videos', $_POST['fg_wc_videos']);
}

// Remove WooCommerce fileds that we don't need
add_action('add_meta_boxes', 'fg_remove_wc_meta_boxes', 999);
function fg_remove_wc_meta_boxes() {
  remove_meta_box('woocommerce-product-data', 'product', 'normal');
  remove_meta_box('postexcerpt', 'product', 'normal');
  remove_meta_box('tagsdiv-product_tag' , 'product' , 'side');
  remove_meta_box('postimagediv' , 'product' , 'side');
}


/*
*  WooCommerce product page display
*/
add_action('wp_enqueue_scripts', 'remove_foresite_slider', 999);
function remove_foresite_slider() {
  if (is_product()) wp_dequeue_style('foresite-cycle-style');
}

add_filter('body_class', 'fg_wc_product_classes');
function fg_wc_product_classes($classes) {
  global $post;

  $attachments = get_post_meta($post->ID, '_product_image_gallery', true);

  if (is_product()) {
    if ($attachments) {
      $classes[] = $post->fg_wc_gallery_type;
    } else {
      $classes[] = 'no-gallery';
    }

    if ($post->fg_wc_videos != "") $classes[] = "product-video";
  }

  return $classes;
}

add_action('woocommerce_before_main_content', 'fg_remove_before_main_content', 1);
function fg_remove_before_main_content() {
  remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
}

add_action('woocommerce_after_main_content', 'fg_remove_after_main_content', 1);
function fg_remove_after_main_content() {
  remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
}

add_action('woocommerce_sidebar', 'fg_remove_sidebar', 1);
function fg_remove_sidebar() {
  remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}

add_action('woocommerce_before_single_product_summary', 'fg_remove_before_single_product_summary', 1);
function fg_remove_before_single_product_summary() {
  remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
}

add_action('woocommerce_single_product_summary', 'fg_remove_single_product_summary', 1);
function fg_remove_single_product_summary() {
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
}

add_action('woocommerce_after_single_product_summary', 'fg_remove_after_single_product_summary', 1);
function fg_remove_after_single_product_summary() {
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}
?>