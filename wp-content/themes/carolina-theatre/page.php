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
	
<?php // TO-DO: setup breadcrumbs ?>
<?php get_template_part( 'blocks/content', 'breadcrumb' ); ?>

<?php // TO-DO: setup title ?>
<section class="pageHeading contain">
	<div class="container">
		<h1 class="pageTitle"><?php the_title(); ?></h1>
		<?php // TO-DO: setup tabbed sections for child/sibling posts ?>	
		child / sibling posts menu	
		<?php 
			$parentID = $post->post_parent;
			echo $parentID;
			if($parentID){
				wp_list_pages(array(
			    'child_of' => $post->post_parent,
			    // 'exclude' => $post->ID
				));
			}
			
 		?>
	</div>
</section>

<?php // TO-DO: setup page hero slider ?>
<section class="pageHero contain">
	<div class="container">
		<div class="carousel">
			<?php //get_template_part( 'blocks/content', 'slider' ); ?>

			<div>slide 1</div>
			<div>slide 2</div>
			<div>slide 3</div>
		</div>
	</div>
</section>

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
