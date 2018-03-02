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
  remove_meta_box('postimagediv' , 'product' , 'side');
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

  add_meta_box('fg_wc_custom_fields_box_side',
    'Gallery Type',
    'display_fg_wc_custom_fields_side',
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
  </style>';
}

// Create the fields we want
function display_fg_wc_custom_fields($post) {
  $fg_wc_manufacturer = esc_html(get_post_meta($post->ID, 'fg_wc_manufacturer', true));
  $fg_wc_subtitle = esc_html(get_post_meta($post->ID, 'fg_wc_subtitle', true));
  ?>
  <input type="text" name="fg_wc_manufacturer" value="<?php echo $fg_wc_manufacturer; ?>" placeholder="Manufacturer">
  <input type="text" name="fg_wc_subtitle" value="<?php echo $fg_wc_subtitle; ?>" placeholder="Subtitle">
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

// Save the data from our fields
add_action('save_post', 'save_fg_wc_custom_fields', 10, 2);
function save_fg_wc_custom_fields($post_id){
  if (isset($_POST['fg_wc_manufacturer']))
    update_post_meta($post_id, 'fg_wc_manufacturer', $_POST['fg_wc_manufacturer']);
  if (isset($_POST['fg_wc_subtitle']))
    update_post_meta($post_id, 'fg_wc_subtitle', $_POST['fg_wc_subtitle']);
  if (isset($_POST['fg_wc_gallery_type']))
    update_post_meta($post_id, 'fg_wc_gallery_type', $_POST['fg_wc_gallery_type']);
}


/*
*  WooCommerce product page display
*/
add_action('woocommerce_before_single_product_summary', 'fg_wc_product_content', 10);
function fg_wc_product_content() {
  echo '<div id="text">';
  the_content();
  echo "</div>";
}

add_action('wp_enqueue_scripts', 'remove_foresite_slider', 999);
function remove_foresite_slider() {
  if (is_product()) wp_dequeue_style('foresite-cycle-style');
}

add_action('woocommerce_before_single_product_summary', 'fg_wc_image_gallery', 20);
function fg_wc_image_gallery() {
  global $product;
  global $post;

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

          foreach ($attachment_ids as $attachment_id) {
            $gallery_image = wp_get_attachment_image_src($attachment_id, 'full');
            $imagemeta = get_post($attachment_id);

            echo '<a href="'.$gallery_image[0].'" data-fancybox="product" style="background-image: url('.$gallery_image[0].');" data-cycle-title="'.get_post_meta($attachment_id, '_wp_attachment_image_alt', true).'" data-caption="'.$imagemeta->post_excerpt.'"></a>';

            $pager .= '<span style="background-image: url('.$gallery_image[0].'); width: calc(20% - 20px);"></span>';
          }
          ?>

          <p id="pager"><?php echo $pager; ?></p>
        </div>

        <a href="#" id="prev"><i class="fas fa-caret-left"></i></a>
        <a href="#" id="next"><i class="fas fa-caret-right"></i></a>

        <div id="image-title"></div>
      <?php } ?>
      <?php if (get_post_meta($post->ID, 'fg_wc_gallery_type', true) == "gallery-stacked") { ?>
        <u>Image Gallery</u>
        
        <?php
        foreach ($attachment_ids as $attachment_id) {
          $gallery_image = wp_get_attachment_image_src($attachment_id, 'full');
          $imagemeta = get_post($attachment_id);

          echo '<img src="'.$gallery_image[0].'" alt="">';

          if ($imagemeta->post_excerpt != "") echo $imagemeta->post_excerpt."<br>";
        }
        ?>
      <?php } ?>
    </div>
    <?php
  }
  $images = get_attached_media('image', $post->ID);
}

add_filter('body_class', 'fg_wc_product_classes');
function fg_wc_product_classes($classes) {
  global $post;

  $attachments = get_post_meta($post->ID, '_product_image_gallery', true);

  if (is_product()) {
    if ($attachments) {
      $fg_wc_gallery_type = esc_html(get_post_meta($post->ID, 'fg_wc_gallery_type', true));
      $classes[] = $fg_wc_gallery_type;
    } else {
      $classes[] = 'no-gallery';
    }
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