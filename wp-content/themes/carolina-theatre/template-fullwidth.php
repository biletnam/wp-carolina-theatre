<?php
	// Template name: Full Width
?>

<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>

<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>
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
<?php get_template_part( 'template-parts/slider', 'page_hero' ); ?>
<?php } //endif show hero ?>

<section class="mainContent mainContent__noSidebar contain">
	<div class="container">
		<?php get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
	</div>
</section>

<?php } // endwhile; ?>
<?php get_footer(); ?>