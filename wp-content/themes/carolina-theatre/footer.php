<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.2
 */

?>
</main> <?php // end <main role="main"> from header.php ?>

<?php // get all ACF for Footer fields and custom JavaScript
	$custom_scripts = get_field('custom_scripts', 'option');
	$footer_bg = get_field('footer_bg', 'option');
	$slogan = get_field('slogan', 'options');
	$copyright_after = get_field('copyright', 'option');
	$logomark_text = get_field('logomark_text', 'option');
	$show_email_signup = get_field('show_email_signup', 'option');
	$email_signup_headline = get_field('email_signup_headline', 'option');
	$email_signup_shortcode = get_field('email_signup_shortcode', 'option', false);

	$show_social_feed = get_field('show_social_feed', 'options');
	$social_title = get_field('social_feed_title', 'options');
	$social_shortcode = get_field('social_feed_shortcode', 'option', false);
?>

<?php if($show_social_feed && $social_shortcode){ ?>
<section class="socialmedia__feed">
	<div class="socialmedia__feed--title">
		<?php if($social_title){ ?><h3><?php echo $social_title; ?></h3><?php } ?>
	</div>
	<div class="socialmedia__feed--posts contain container">
		<?php echo do_shortcode($social_shortcode); ?>
	</div>
</section>
<?php } //end if $show_social_feed ?>

<?php if(have_rows('social_media_accounts', 'options')){ ?>
<section class="socialmedia__bar">
	<?php while(have_rows('social_media_accounts', 'options')){ the_row(); ?>
	<div class="socialmedia__bar--icon">
		<?php 
			$platform = get_sub_field('platform');
			$handle = get_sub_field('handle');
			$url = get_sub_field('url');
			$icon = get_sub_field('icon');
		?>
		<a href="<?php echo $url; ?>" title="Follow the Carolina Theatre on <?php echo $platform; ?>." target="_blank">
			<i class="fab fa-<?php echo $icon; ?>"></i>
		</a>
	</div>
	<?php } // endwhile footer sitemap ?>
</section>
<?php } // endif footer sitemap ?>

<footer class="footer--main"<?php if($footer_bg) { echo ' style="background-image:url('.$footer_bg.');"'; } ?>>
	<?php if($slogan){ ?>
		<div class="footer__slogan">
			<p class="h1"><?php echo $slogan; ?></h1>
		</div>
	<?php } // endif slogan ?>

	<?php if($show_email_signup){ ?>
		<div class="footer__newsletter">
			<p><?php echo $email_signup_headline; ?></p>
	    <?php echo do_shortcode($email_signup_shortcode); ?>
			<?php 
			// <div class="newsletter__form">
			//   <input type="email" id="bronto-newsletter_%formID%" class="bronto_signup_input newsletter__input" name="email" placeholder="email address">
			//   <button class="newsletter__submit bronto_signup_submit" type="submit"><i class="fas fa-arrow-right"></i></button>
			// </div>
		 	?>
	  </div>
	<?php } //endif newsletter ?>

	<?php if(have_rows('footer_sitemap', 'options')){ ?>
	<div class="footer__sitemap">
		<div class="container contain">
			<?php while(have_rows('footer_sitemap', 'options')){ the_row(); ?>
			<div class="footer__sitemap-column">
				<?php 
					$title = get_sub_field('column_title');
					$menu_html = get_sub_field('column_menu');
				?>
				<?php if($title){ ?>
					<h5><?php echo $title; ?></h5>
				<?php } ?>
				<?php if($menu_html){ ?>
					<nav class="footer-menu">
						<?php echo $menu_html; ?>
					</nav>
				<?php } ?>
			</div>
			<?php } // endwhile footer sitemap ?>
		</div>
	</div>
	<?php } // endif footer sitemap ?>

	<div class="footer__logo">
		<?php
			$footer_logo = get_field('footer_logo', 'options');
			if($footer_logo){
				echo file_get_contents($footer_logo);
			} else {
				include 'src/img/logos/ctd-logomark-new.svg';
			}
	 	?>
		<?php if($logomark_text){ ?><p class="h5"><?php echo $logomark_text; ?></p><?php } ?>
	</div>

	<div class="footer__contact">
		<?php if($GLOBALS["location_address"]){ ?>
		<p>
			The Carolina Theatre of Durham<br>
			<a href="<?php echo $GLOBALS["location_directionlink"]; ?>" title="Get Directions" target="_blank"><?php echo $GLOBALS["location_address"]; ?></a>
		</p>
		<?php } // endif location address ?>
		<?php if($GLOBALS["phone"]){ ?>
		<p>
			<?php echo $GLOBALS["phone"]; ?>
		</p>
		<?php } // endif phone number ?>

	</div>

	<div class="footer__copyright">
		<p>&copy;<?php echo date('Y');?> <?php echo $copyright_after; ?></p>
	</div>
</footer>

</div> <?php // <div class="mainWrapper"> from header.php ?>

<?php wp_footer(); ?>

<?php // Any custom JavaScript scripts (thru Theme Settings)
	if ($custom_scripts){
		echo $custom_scripts;
	}
?>
</body>
</html>




