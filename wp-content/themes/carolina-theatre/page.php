<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) { the_post(); ?>

<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>
<?php get_template_part( 'template-parts/part', 'page_heading' ); ?>


<?php if(get_field('show_hero_slider')){ ?>
<?php get_template_part( 'template-parts/slider', 'page_hero' ); ?>
<?php } //endif show hero ?>

<section class="mainContent contain">
  <div class="mainContent__content">
		<div class="container">
		<?php get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
		</div>
	</div>
	<?php get_sidebar(); ?>
</section>

<?php } // endwhile; ?>

<?php get_footer();