<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php $favicon_code = get_field('favicon_code', 'option'); ?>
	<?php if ($favicon_code){ ?>
		<?php echo $favicon_code; ?>
	<?php } // endif ?>

	<?php wp_head(); ?>

	<?php $web_fonts = get_field('font_scripts', 'option'); ?>
	<?php if ($web_fonts){ ?>
		<?php echo $web_fonts; ?>
	<?php } // endif ?>

	<?php $custom_styles = get_field('custom_styles', 'option'); ?>
	<?php if ($custom_styles){ ?>
		<style type="text/css">
			<?php echo $custom_styles; ?>
		</style>
	<?php } // endif ?>

	<!-- Adobe Typekit Fonts -->
	<script>
	  (function(d) {
	    var config = {
	      kitId: 'ooq4moz',
	      scriptTimeout: 3000,
	      async: true
	    },
	    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
	  })(document);
	</script>
	<!-- END Adobe Typekit Fonts -->

	<!-- Font Awesome Pro CDN -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG" crossorigin="anonymous">
	<!-- END Font Awesome Pro CDN -->
</head>

<body <?php body_class(); ?>>
<!-- Google Analytics Code -->
<?php the_field('google_analytics', 'option'); ?>
<!-- END Google Analytics Code -->

<?php // get variables for contact/location for header & footer
$GLOBALS["phone"] = get_field('phone_number', 'option');
$GLOBALS["location_address"] = get_field('address', 'option');
$GLOBALS["location_directionlink"] = get_field('google_map_link', 'option');
?>

<div class="header header__mobileNav">
	<div class="header__mobileNavTop"> 
		<?php // top left secondary navigation (member tickets)
		if(has_nav_menu('header-topleft')){ ?>
		<nav role="navigation">
	  	<a href="#" id="header__searchBtn" class="header__searchBtn"><i class="fas fa-search"></i></a>
			<?php wp_nav_menu( array( 
	    	'theme_location' 	=> 'header-topleft', 
	    	'container'				=> false,
	    	'menu_class'			=> 'menu-header-top-left',
	    	'menu_id'					=> '',
	    	) 
	  	); ?>
		</nav>
  	<div id="mobileNav__closeBtn" class="btn__close fas fa-times"></div>
	</div>
	<?php } ?>
	
  <?php // primary mobile menu
	if(has_nav_menu('header-main')){ ?>
    <nav class="header__mobileNav--menu" id="header__mobileNav--menu" role="navigation">
			<?php wp_nav_menu( array( 
	    	'theme_location' 	=> 'header-main', 
	    	'container'				=> false,
	    	'menu_class'			=> '',
	    	'menu_id'					=> '',
	    	'walker' 					=> new Arrow_Walker_Nav_Menu,
	    	) 
	  	); ?>
  	</nav>
	<?php } ?>

	<?php // call to action button
	if(has_nav_menu('header-cta')){ ?>
	<div class="cta">
		<?php wp_nav_menu( array( 
    	'theme_location' 	=> 'header-cta', 
    	'container'				=> false,
    	'menu_class'			=> 'header__cta',
    	'menu_id'					=> '',
    	) 
  	); ?>
	</div>
	<?php } ?>	
	
</div>

<div class="mainWrapper">

<?php // Alert Banner Markup 
	$alertbanner_query_args = array(
		'post_type' => 'alertbanner',
		'post_status' => 'publish',
		'posts_per_page' => 1
	);
	$alertbanner_query = new WP_Query($alertbanner_query_args);
?>

<?php if ($alertbanner_query->have_posts()) { ?>
	<?php while ($alertbanner_query->have_posts()) { $alertbanner_query->the_post(); ?>
		<?php 
			$banner_alert = get_field('banner_alert');
			$banner_link = get_field('link');
			$closeable = get_field('allow_visitor_to_close_banner'); 
		?>
		<section id="alertBanner" class="alertBanner bg-gold" style="display: none;">
			<?php if($closeable){ ?>
	  	<a id="alertBanner__closeBtn" class="alertBanner__closeBtn" onClick="alertBanner('hide');"><i class="fas fa-times"></i></a>
		  <?php } //end if closeable ?>
  		<?php if($banner_link){ ?>
				<a href="<?php echo $banner_link; ?>">
					<p class="alertBanner__text"><?php echo $banner_alert; ?></p>
				</a>
		  <?php } else { ?>
				<p class="alertBanner__text"><?php echo $banner_alert; ?></p>
		  <?php } //end if closeable ?>
		</section>

	<?php } // end while ?>
<?php } // end if ?>


<header id="header" class="header">
  <div class="header__top">
		<div class="contain container">
			<div class="left">
				<?php // top left secondary navigation (member tickets)
				if(has_nav_menu('header-topleft')){ ?>
				<nav role="navigation">
					<?php wp_nav_menu( array( 
			    	'theme_location' 	=> 'header-topleft', 
			    	'container'				=> false,
			    	'menu_class'			=> 'menu-header-top-left',
			    	'menu_id'					=> '',
			    	) 
			  	); ?>
		  	</nav>
		  	<?php } ?>
			</div>
			<div class="right">
				<?php // top right secondary navigation (history, donate, contact, etc)
				if(has_nav_menu('header-topright')){ ?>
				<nav role="navigation">
					<?php wp_nav_menu( array( 
			    	'theme_location' 	=> 'header-topright', 
			    	'container'				=> false,
			    	'menu_class'			=> 'menu-header-top-right',
			    	'menu_id'					=> '',
			    	) 
			  	); ?>
			  	<a href="#" id="header__searchBtn" class="header__searchBtn"><i class="fas fa-search"></i></a>
		  	</nav>
		  	<?php } ?>
			</div>
		</div>			
	</div>
	<div id="header__main" class="header__main">
		<div class="contain container">
		  <div class="header__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Back to Homepage">
				<?php
					$header_logo = get_field('header_logo', 'options');

					if($header_logo){
						echo file_get_contents($header_logo);
					} else {
						include 'src/img/logos/ctd-logo-new.svg';
					}
			 	?>
			 </a>
			</div>
      <a id="mobileNavTrigger" class="mobileNavTrigger">
			  <p class="h5 mobileNavTrigger__label">menu</p>
			  <div class="mobileNavTrigger__icon">
			  	<span></span>
				  <span></span>
				  <span></span>
				  <span></span>
			  </div>
      </a>
	    <nav id="header__nav" class="header__nav" role="navigation">		  
		  <?php // header main menu
			if(has_nav_menu('header-main')){ ?>
				<?php wp_nav_menu( array( 
		    	'theme_location' 	=> 'header-main', 
		    	'container'				=> false,
		    	'menu_class'			=> 'header__mainMenu',
		    	'menu_id'					=> '',
		    	) 
		  	); ?>
			<?php } ?>
	    <?php // call to action button
			if(has_nav_menu('header-cta')){ ?>
				<?php wp_nav_menu( array( 
		    	'theme_location' 	=> 'header-cta', 
		    	'container'				=> false,
		    	'menu_class'			=> 'header__cta',
		    	'menu_id'					=> '',
		    	) 
		  	); ?>
			<?php } ?>
			</nav>
		</div>

		<div id="eventsDropdown" class="eventsDropdown">
		  <div class="container contain">
		  	<h2>Upcoming Events</h2>
		    <?php get_template_part( 'blocks/content', 'upcoming-events-slider' ) ?>
		  </div>
		</div>
  </div><!-- .header-main  -->
</header>


<main role="main">