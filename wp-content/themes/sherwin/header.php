<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<title><?php echo get_bloginfo('name'); if(!is_home() || !is_front_page()) wp_title('|', true, 'left'); ?></title>

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
  
  <?php wp_enqueue_script("jquery"); ?>
	<?php wp_head(); ?>

	<link href="//fonts.googleapis.com/css?family=Open+Sans:600,700,800|Teko:400,500,600,700" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?<?php echo filemtime(get_template_directory() . "/style.css"); ?>">

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("a[href^='http']").not("[href*='" + window.location.host + "']").prop('target','new');
      $("a[href$='.pdf']").prop('target', 'new');

      $('#header-spacer').height($('#main-header').outerHeight());

      $(window).scroll(function() {
		    if ($(window).scrollTop() >= 10) {
		      $('.home-header').removeClass('home-header-border');
		    } else {
		      $('.home-header').addClass('home-header-border');
		    }
		  });

      $('.slideshow-1 .foresite-content P SPAN, #banner .site-width > H1').html(function(){
        var text = $(this).text().trim().split(' ');
        var first = text.shift();
        var sep = ($(this).is('#banner .site-width H1')) ? ' ' : '<br>';
        return (text.length > 0 ? '<span style="color: #FFFFFF;">'+first+'</span>'+sep : first) + text.join(sep);
      });

      $(window).trigger('resize');
    });

    jQuery(window).on('resize',function() {
      jQuery('#breadcrumb-spacer').height(jQuery('#product-breadcrumbs').outerHeight());
    });
  </script>
</head>

<body <?php body_class(); ?>>
	<div id="header-spacer"></div>

	<header id="main-header"<?php if(is_front_page()) echo ' class="home-header home-header-border'; ?>">
		<div class="site-width">
	    <a href="<?php echo home_url(); ?>" id="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Sherwin Industries, Inc."></a>
      
      <input type="checkbox" id="toggle-menu" role="button">
      <label for="toggle-menu"></label>
	    <?php wp_nav_menu(array('theme_location' => 'main-menu', 'container_class' => 'main-menu')); ?>

      <a href="#" id="search"><i class="fas fa-search"></i></a>
	  </div>
	</header>

	<?php if (is_front_page()) { ?>
    <div class="tongue">
	    <?php echo do_shortcode('[foresite-slider category="3"]'); ?>
    </div>
  <?php } elseif (is_product()) { ?>
    <div id="banner" class="banner-product">
      <div id="breadcrumb-spacer"></div>

      <div class="site-width">
        <div id="product-breadcrumbs">
          <?php
          $prodcats = get_page_by_path($product, OBJECT, 'product');
          $terms = get_the_terms($prodcats->ID, 'product_cat');
          foreach ($terms as $term) { echo "<span>".$term->name."</span>"; }
          the_title('<span>', '</span>');
          ?>
        </div>

        <div id="product-header">
          <?php
          if (get_post_meta($post->ID, 'fg_wc_manufacturer', true))
            echo "<h2>" . get_post_meta($post->ID, 'fg_wc_manufacturer', true) . "</h2>";
          
          the_title('<h1>', '</h1>');

          if (get_post_meta($post->ID, 'fg_wc_subtitle', true))
            echo "<h3>" . get_post_meta($post->ID, 'fg_wc_subtitle', true) . "</h3>";
          ?>
        </div>
      </div>
    </div>
	<?php } else { ?>
    <div id="banner"<?php if ($post->post_name == "about" || $post->post_name == "contact") echo ' class="tongue"'; ?>>
      <div class="site-width">
	      <h1><?php single_post_title(); ?></h1>
        <?php
        if ($post->post_name == "product-catalog") {
          echo '<div class="quick-jump">';
            echo "Quick Jump To<br>";

            $quick = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'parent' => 0, 'exclude' => array(17)));
            foreach ($quick as $jump) {
              echo '<a href="#'.$jump->slug.'">'.$jump->name.'</a>';
            }

          echo "</div>";
        }
        ?>
      </div>
    </div>
	<?php } ?>

	<div id="content">
