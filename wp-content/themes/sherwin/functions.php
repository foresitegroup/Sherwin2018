<?php
// Don't send emails when Wordpress updates happen
add_filter('auto_core_update_send_email', 'stop_auto_update_emails', 10, 4);
function stop_update_emails($send, $type, $core_update, $result) {
  if (!empty($type) && $type == 'success') return false;
  return true;
}
add_filter('auto_plugin_update_send_email', '__return_false');
add_filter('auto_theme_update_send_email', '__return_false');


// Remove emojis (and other crud)
add_action('init', 'disable_wp_emojicons');
function disable_wp_emojicons() {
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  add_filter('emoji_svg_url', '__return_false');
  add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');

  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'start_post_rel_link');
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'adjacent_posts_rel_link');
}

function disable_emojicons_tinymce($plugins) {
  if (is_array($plugins)) {
    return array_diff($plugins, array('wpemoji'));
  } else {
    return array();
  }
}


// Add to header
add_action('wp_head', 'meta_og', 5);
function meta_og() {
  global $post;

  if(has_post_thumbnail($post->ID))
    $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');

  $excerpt = strip_tags($post->post_content);
  $excerpt_more = '';
  if (strlen($excerpt ) > 155) {
    $excerpt = substr($excerpt,0,155);
    $excerpt_more = ' ...';
  }
  $excerpt = str_replace('"', '', $excerpt);
  $excerpt = str_replace("'", '', $excerpt);
  $excerptwords = preg_split('/[\n\r\t ]+/', $excerpt, -1, PREG_SPLIT_NO_EMPTY);
  array_pop($excerptwords);
  $excerpt = implode(' ', $excerptwords) . $excerpt_more;

  $ogdesc = ($post->seo_description != "") ? $post->seo_description : $excerpt;

  if ($post->seo_keywords != "") echo '<meta name="keywords" content="'.$post->seo_keywords.'">'."\n";
  ?>
  <meta name="description" content="<?php echo $ogdesc; ?>">
  <meta name="author" content="<?php bloginfo('name'); ?>">
  <meta property="og:title" content="<?php echo the_title(); ?>">
  <meta property="og:description" content="<?php echo $ogdesc; ?>">
  <meta property="og:type" content="article">
  <meta property="og:url" content="<?php echo the_permalink(); ?>">
  <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
  <meta property="og:image" content="<?php echo $img_src[0]; ?>">
  <?php
}



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
      'top-menu' => __('Top Menu'),
      'main-menu' => __('Main Menu')
    )
  );
}
add_action( 'init', 'register_my_menus' );


/* Customizer */
add_action('customize_register', 'fg_customize_register', 50);
remove_action('customize_register', 'shiftnav_register_customizers');
function fg_customize_register($wp_customize) {
  $wp_customize->add_section('fg_smtp', array(
    'title'    => __('SMTP', 'fg'),
    'description' => 'Settings for the forms to send emails. Don\'t change these unless you REALLY know what you\'re doing.',
    'priority' => 113
  ));

  $wp_customize->add_setting('fg_smtp_user', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('fg_smtp_user', array(
    'label'   => __('Username', 'smtp'),
    'section' => 'fg_smtp',
    'type'    => 'text'
  ));

  $wp_customize->add_setting('fg_smtp_pass', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('fg_smtp_pass', array(
    'label'   => __('Password', 'smtp'),
    'section' => 'fg_smtp',
    'type'    => 'text'
  ));

  $wp_customize->add_setting('fg_smtp_host', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('fg_smtp_host', array(
    'label'   => __('Host', 'smtp'),
    'section' => 'fg_smtp',
    'type'    => 'text'
  ));

  $wp_customize->add_setting('fg_smtp_port', array('sanitize_callback' => 'sanitize_text_field'));
  $wp_customize->add_control('fg_smtp_port', array(
    'label'   => __('Port', 'smtp'),
    'section' => 'fg_smtp',
    'type'    => 'text'
  ));
}


// Show site styles in visual editor
function themename_setup() {
  add_editor_style();
}
add_action( 'after_setup_theme', 'themename_setup' );


// Add meta description and keywords to pages
add_action('add_meta_boxes', 'seo_metabox');
function seo_metabox() {
  global $post;
  add_meta_box('seo_mb', 'SEO', 'seo_mb_content', $post->post_type, 'side', 'low');
}

function seo_mb_content($post) {
  ?>
  <strong>Meta Description</strong><br>
  <textarea name="seo_description"><?php if ($post->seo_description != "") echo $post->seo_description; ?></textarea><br>
  <br>

  <strong>Meta Keywords</strong><br>
  <textarea name="seo_keywords"><?php if ($post->seo_keywords != "") echo $post->seo_keywords; ?></textarea>
  <?php
}

add_action('admin_head', 'seo_css');
function seo_css() {
  echo '<style>
    #seo_mb TEXTAREA { width: 100%; height: 3.2em; }
    #seo_mb TEXTAREA[name="seo_keywords"] { height: 7.2em; }
  </style>';
}

add_action('save_post', 'seo_save');
function seo_save($post_id) {
  if (!empty($_POST['seo_description'])) {
    update_post_meta($post_id, 'seo_description', $_POST['seo_description']);
  } else {
    delete_post_meta($post_id, 'seo_description');
  }

  if (!empty($_POST['seo_keywords'])) {
    update_post_meta($post_id, 'seo_keywords', $_POST['seo_keywords']);
  } else {
    delete_post_meta($post_id, 'seo_keywords');
  }
}


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

  add_meta_box('fg_wc_custom_fields_box_side_featured',
    'Featured Items',
    'display_fg_wc_custom_fields_side_featured',
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

function display_fg_wc_custom_fields_side_featured($post) {
  $fg_wc_featured_img = ($post->fg_wc_featured_img == "") ? "contain" : $post->fg_wc_featured_img;
  ?>
  <input type="text" name="fg_wc_featured_sort" value="<?php if ($post->fg_wc_featured_sort != "") echo $post->fg_wc_featured_sort; ?>" placeholder="Sort"><br>
  <br>
  <label><input type="radio" name="fg_wc_featured_img" value="contain"<?php if ($fg_wc_featured_img == "contain") echo " checked"; ?>> Contain</label><br>
  <label><input type="radio" name="fg_wc_featured_img" value="cover"<?php if ($fg_wc_featured_img == "cover") echo " checked"; ?>> Cover</label>
  <?php
}

// Save the data from our fields
add_action('save_post', 'save_fg_wc_custom_fields', 10, 2);
function save_fg_wc_custom_fields($post_id){
  update_post_meta($post_id, 'fg_wc_manufacturer', $_POST['fg_wc_manufacturer']);
  update_post_meta($post_id, 'fg_wc_subtitle', $_POST['fg_wc_subtitle']);
  update_post_meta($post_id, 'fg_wc_gallery_type', $_POST['fg_wc_gallery_type']);
  update_post_meta($post_id, 'fg_wc_videos', $_POST['fg_wc_videos']);

  if (!empty($_POST['fg_wc_featured_sort'])) {
    update_post_meta($post_id, 'fg_wc_featured_sort', $_POST['fg_wc_featured_sort']);
  } else {
    delete_post_meta($post_id, 'fg_wc_featured_sort');
  }
  update_post_meta($post_id, 'fg_wc_featured_img', $_POST['fg_wc_featured_img']);
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
  the_content();
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
}

add_action('woocommerce_after_single_product_summary', 'fg_remove_after_single_product_summary', 1);
function fg_remove_after_single_product_summary() {
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}


/* Add Revision support to WooCommerce Products */
add_filter('woocommerce_register_post_type_product', 'add_revision_support');
function add_revision_support($supports) {
  $supports['supports'][] = 'revisions';
  return $supports;
}


/* Lowers the metabox priority to 'low' for Yoast SEO's metabox. */
add_filter('wpseo_metabox_prio', 'lower_yoast_metabox_priority');
function lower_yoast_metabox_priority($priority) {
  return 'low';
}


/*
*  Forms
*/
add_action('add_meta_boxes_page', 'form_metaboxes');
function form_metaboxes() {
  global $post;
  $template = get_post_meta($post->ID, '_wp_page_template', true);

  if ($template == "template-bowmonk.php") {
    add_meta_box('form_metabox_settings', 'Form Settings', 'display_form_metabox_settings', 'page', 'normal', 'high');
  }
}

function display_form_metabox_settings($post) {
  echo "<strong>Send To</strong><br>
  For multiple addresses, add one address per line.<br>\n";
  wp_editor(html_entity_decode($post->form_send_to, ENT_QUOTES), "form_send_to", array('textarea_name' => 'form_send_to', 'textarea_rows' => 6, 'tinymce' => false, 'media_buttons' => false, 'quicktags' => false));
  echo "<br>\n";

  echo "<strong>From Name</strong><br>\n";
  echo '<input type="text" name="form_from_name" value="'.$post->form_from_name.'" style="width: 100%;"><br>'."\n";
  echo "<br>\n";

  echo "<strong>Email Subject</strong><br>\n";
  echo '<input type="text" name="form_subject" value="'.$post->form_subject.'" style="width: 100%;"><br>'."\n";
  echo "<br>\n";

  echo "<strong>Success Message</strong><br>\n";
  wp_editor(html_entity_decode($post->form_success, ENT_QUOTES), "form_success", array('textarea_name' => 'form_success', 'textarea_rows' => 6, 'tinymce' => false, 'media_buttons' => false, 'quicktags' => false));
  echo "<br>\n";
}

add_action('save_post', 'form_save');
function form_save($post_id) {
  if (!empty($_POST['form_send_to'])) {
    update_post_meta($post_id, 'form_send_to', $_POST['form_send_to']);
  } else {
    delete_post_meta($post_id, 'form_send_to');
  }

  if (!empty($_POST['form_from_name'])) {
    update_post_meta($post_id, 'form_from_name', $_POST['form_from_name']);
  } else {
    delete_post_meta($post_id, 'form_from_name');
  }

  if (!empty($_POST['form_subject'])) {
    update_post_meta($post_id, 'form_subject', $_POST['form_subject']);
  } else {
    delete_post_meta($post_id, 'form_subject');
  }

  if (!empty($_POST['form_success'])) {
    update_post_meta($post_id, 'form_success', $_POST['form_success']);
  } else {
    delete_post_meta($post_id, 'form_success');
  }
}


add_action('admin_menu', 'bowmonk_link');
function bowmonk_link() {
  add_submenu_page('tools.php', '', 'Export Bowmonk Calibration Requests', 'manage_options', 'admin-ajax.php?action=bowmonk_export', '', 99);
}

add_action('wp_ajax_bowmonk_export','export_bowmonk_form_submissions');
function export_bowmonk_form_submissions() {
  global $wpdb;

  $results = $wpdb->get_results("SELECT * FROM bowmonk_calibration", ARRAY_A);

  $headers = 'Email,Business/Airport Name,Contact Person,Daytime Contact Telephone Number,Billing Address,Billing City,Billing State,Billing Zip,Shipping Address,Serial Number of Unit,Level of Service,Description of Problem/Error/Malfunction,Additional Information/Requests,Payment Option,Purchase Order Number,Return Shipping,Customer UPS Account Number,Date Submitted';

  if (count($results) > 0) {
    $output = "";

    foreach($results as $result) {
      $output .= '"'.$result['email'].'",';
      $output .= '"'.$result['business_airport_name'].'",';
      $output .= '"'.$result['contact_person'].'",';
      $output .= '"'.$result['phone'].'",';
      $output .= '"'.trim(preg_replace('/\s+/', ' ', $result['billing_address'])).'",';
      $output .= '"'.$result['billing_city'].'",';
      $output .= '"'.$result['billing_state'].'",';
      $output .= '"'.$result['billing_zip'].'",';
      $output .= '"'.trim(preg_replace('/\s+/', ' ', $result['shipping_address'])).'",';
      $output .= '"'.$result['serial_number'].'",';
      $output .= '"'.$result['service'].'",';
      $output .= '"'.trim(preg_replace('/\s+/', ' ', $result['description'])).'",';
      $output .= '"'.trim(preg_replace('/\s+/', ' ', $result['additional_info'])).'",';
      $output .= '"'.$result['payment'].'",';
      $output .= '"'.$result['po_number'].'",';
      $output .= '"'.$result['returnshipping'].'",';
      $output .= '"'.$result['rs_customer_ups'].'",';
      $output .= date("Y-m-d H:i", $result['date_submitted']);
      $output .= "\r\n";
    }
  }

  header("Content-type: application/vnd.ms-excel");
  header("Content-disposition: filename=bowmonk_calibration_requests_".date("Y-m-d_H-i",time()).".csv");
  print $headers."\n".$output;
  exit;
}

add_action('admin_menu', 'bowmonk_delete_link');
function bowmonk_delete_link() {
  add_submenu_page('tools.php', 'Delete Bowmonk Calibration Requests', 'Delete Bowmonk Calibration Requests', 'manage_options', 'delete-bowmonk-calibration-requests', 'delete_bowmonk_callback', 100);
}

function delete_bowmonk_callback() {
  ?>
  <style>
    .button-primary.red { background: #B32D2E; border-color: #B32D2E; }
    .button-primary.red:hover { background: #A30000; border-color: #A30000; }
  </style>

  <div class="wrap">
    <h1>Delete Bowmonk Calibration Requests</h1>

    <?php
    $message = get_transient('bowmonk_deleted');
    if ($message) {
      echo '<div class="notice notice-success is-dismissible"><p>'.$message.'</p></div>';

      delete_transient('bowmonk_deleted');
    }
    ?>

    <h2>This will <strong>DELETE</strong> all of the Bowmonk calibration requests that are currently in the database. Make sure that you have <a href="admin-ajax.php?action=bowmonk_export">exported</a> them before pressing the button.</h2>

    <br>

    <p><button onclick="location.href='admin-ajax.php?action=bowmonk_delete';" class="button button-primary red">DELETE Requests</button></p>
  </div>
  <?php
}

add_action('wp_ajax_bowmonk_delete','delete_bowmonk_form_submissions');
function delete_bowmonk_form_submissions() {
  global $wpdb;

  $wpdb->query("TRUNCATE TABLE `bowmonk_calibration`");

  set_transient('bowmonk_deleted', 'All Bowmonk calibration requests have been deleted.', 5);

  wp_redirect(wp_get_referer());

  exit;
}
?>