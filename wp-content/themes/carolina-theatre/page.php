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
<?php if(get_field('show_hero_slider')){ ?>
<?php if(have_rows('hero_images')){ ?>
<section class="pageHero contain">
	<div class="container">
		<div class="carousel">
			<?php //get_template_part( 'blocks/content', 'slider' ); ?>
			<?php while(have_rows('hero_images')){ the_row(); ?>
				<?php
				$image_url = get_sub_field('image')['sizes']['thumbnail'];
				$image_alt = get_sub_field('image')['alt'];
				$image_cap = get_sub_field('image')['caption'];
				?>
				<div>
					<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
					<?php if($image_cap) { ?><figcaption class="small caption"><?php echo $image_cap; ?></figcaption><?php } ?>
				</div>
			<?php } //endwhile have rows ?>
		</div>
	</div>
</section>
<?php } //endif have rows ?>
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
