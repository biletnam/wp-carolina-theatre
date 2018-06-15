<?php
	// Template name: Full Width
?>

<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>

<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>
<?php get_template_part( 'template-parts/part', 'page_heading' ); ?>

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