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

	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:600,700,800|Teko:400,500,600,700">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?<?php echo filemtime(get_template_directory() . "/style.css"); ?>">

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("a[href^='http']").not("[href*='" + window.location.host + "']").prop('target','new');
      $("a[href$='.pdf']").prop('target', 'new');

      var headerHeight = $('#main-header').outerHeight();
      $('#header-spacer').height(headerHeight);

      $(window).scroll(function() {
		    if ($(window).scrollTop() >= 10) {
		      $('#main-header').removeClass('home-header');
		    } else {
		      $('#main-header').addClass('home-header');
		    }
		  });

      $('.slideshow-1 .foresite-content P SPAN, #banner .site-width').html(function(){
        var text = $(this).text().trim().split(' ');
        var first = text.shift();
        var sep = ($(this).is('#banner .site-width')) ? ' ' : '<br>';
        return (text.length > 0 ? '<span style="color: #FFFFFF;">'+first+'</span>'+sep : first) + text.join(sep);
      });
    });
  </script>
</head>

<body <?php body_class(); ?>>
	<div id="header-spacer"></div>

	<header id="main-header"<?php if(is_front_page()) echo ' class="home-header'; ?>">
		<div class="site-width">
	    <a href="<?php echo home_url(); ?>" id="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Sherwin Industries, Inc."></a>
      
      <input type="checkbox" id="toggle-menu" role="button">
      <label for="toggle-menu"></label>
	    <?php wp_nav_menu(array('theme_location' => 'main-menu', 'container_class' => 'main-menu')); ?>

      <a href="#" id="search"><i class="fa fa-search" aria-hidden="true"></i></a>
	  </div>
	</header>

	<?php if(is_front_page()) { ?>
    <div class="tongue">
	    <?php echo do_shortcode('[foresite-slider category="3"]'); ?>
    </div>
	<?php } else { ?>
    <div id="banner"<?php if ($post->post_name == "about" || $post->post_name == "contact") echo ' class="tongue"'; ?>>
      <div class="site-width">
	      <?php single_post_title(); ?>
      </div>
    </div>
	<?php } ?>

	<div id="content">
