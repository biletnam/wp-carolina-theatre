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

<?php get_template_part( 'blocks/content', 'breadcrumb' ); ?>
<section class="pageHeading contain">
	<div class="container">
		<h1 class="pageTitle"><?php the_title(); ?></h1>
		<?php if($post->post_parent){ ?>
		<div class="tabbedContent__tabs">
			<ul class="siblings">
				<?php 
					wp_list_pages(array(
				    'child_of' => $post->post_parent,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
			</ul>
		</div>
		<?php } ?>
	</div>
</section>

<?php if(get_field('show_hero_slider')){ ?>
<section class="pageHero contain container">
	<?php get_template_part( 'blocks/content-blocks', 'slider' ); ?>
</section>
<?php } //endif show hero ?>

<section class="mainContent contain">
	<?php if(get_field('show_sidebar')){ ?>
  <div class="mainContent__content">
		<div class="container">
			<?php get_template_part( 'blocks/content', 'blocks' ); ?>
		</div>
	</div>
	<?php get_template_part( 'blocks/content', 'sidebar' ); ?>
	<?php } else { ?>
	<div class="container mainContent__noSidebar">
		<?php get_template_part( 'blocks/content', 'blocks' ); ?>
	</div>
	<?php } ?>
</section>
<?php } // endwhile; ?>

<?php get_footer();