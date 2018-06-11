<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) { the_post(); ?>

<?php // TO-DO: hero image for blog ?>

<section class="mainContent news-press contain">
  <div class="mainContent__content">
    <div class="container">
		  <?php 
			  echo get_the_date('F j');
				the_title();
				the_content();
			?>
    </div><!-- .container -->
  </div><!-- .mainContent__content -->
  <?php get_sidebar(); ?>
</section>
<?php } // endwhile; ?>

<?php get_footer();