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
		<?php 
			$children = get_pages( array( 'child_of' => $post->ID ) ); 
			$children_children = get_pages( array( 'child_of' => $post->ID ) ); 
			$parent = $post->post_parent;
		?>
		<?php if(count($children) > 0){ ?>
		<h1 class="pageTitle"><?php echo get_the_title(); ?></h1>
		<div class="tabbedContent__tabs relatedPages children">
			<ul>
				<?php // show children of current page
					wp_list_pages(array(
				    'child_of' => $post->ID,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
			</ul>
		</div>
		<?php } else if($parent){ ?>
		<h1 class="pageTitle"><?php echo get_the_title($parent); ?></h1>
		<div class="tabbedContent__tabs relatedPages siblings">
			<ul>
				<?php // if current post has no children, show siblings
					wp_list_pages(array(
				    'child_of' => $post->post_parent,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
			</ul>
		</div>
		<?php } else { ?>
		<h1 class="pageTitle"><?php echo get_the_title(); ?></h1>
		<?php } ?>
	</div>
</section>

<?php if(get_field('show_hero_slider')){ ?>
<?php get_template_part( 'blocks/content-blocks', 'slider-hero' ); ?>
<?php } //endif show hero ?>

<section class="mainContent contain">
  <div class="mainContent__content">
		<div class="container">
			<?php get_template_part( 'blocks/content', 'blocks' ); ?>
		</div>
	</div>
	<?php get_sidebar(); ?>
</section>

<?php } // endwhile; ?>

<?php get_footer();