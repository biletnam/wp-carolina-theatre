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
<?php 
	// Google Search Console Structured Data for Articles
	// https://developers.google.com/search/docs/data-types/article
	$thumbnail_url = get_template_directory_uri() . '/img/no-event-image-full.jpg';
	if(get_the_post_thumbnail()){ 
		$thumbnail_url = get_the_post_thumbnail_url(); 
	}  
?>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "NewsArticle",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?php the_permalink(); ?>"
  },
  "headline": "<?php the_title(); ?>",
  "image": "<?php echo $thumbnail_url; ?>",
  "datePublished": "<?php the_date('Y-m-d'); ?>",
  "dateModified": "<?php the_modified_date('Y-m-d'); ?>",
  "author": {
    "@type": "Person",
    "name": "<?php the_author(); ?>"
  },
   "publisher": {
    "@type": "Organization",
    "name": "MRC",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo get_template_directory_uri(); ?>/src/img/logos/ctd-logo-original.svg"
    }
  },
  "description": "<?php the_excerpt(); ?>"
}
</script>

<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>
<header class="blogPost__header contain container">
	<h1><?php the_title(); ?></h1>
	<p class="blogPost__info small"><span class="blogPost__date"><?php echo get_the_date('F j, Y'); ?></span> by <span class="blogPost__author"><?php the_author(); ?></span></p>
</header>
<section class="mainContent blogPost contain">
  <div class="mainContent__content">
    <div class="container">
		  <?php if(has_post_thumbnail()){ ?>
		  <div class="blogPost__image">
		  	<?php the_post_thumbnail( 'hero-small' ); ?>
		  </div>
		  <?php } ?>
			<main class="blogPost__content">
				<?php the_content(); ?>	

			</main>
			<footer class="blogPost__footer">
				<?php // TO-DO: check that social share works on remote server ?>
				<div class="socialShare">
					<?php get_template_part('template-parts/part', 'social_sharing'); ?>						
				</div>

				<div class="blogPost__categories">
				<?php if(get_the_category()){ echo '<i class="far fa-tag"></i> <em><span class="small">'; the_category( ', ' ); echo '</span></em>'; } ?>
				</div>
			</footer>
    </div><!-- .container -->
  </div><!-- .mainContent__content -->
  <?php get_sidebar('news'); ?>
</section>
<?php } // endwhile; ?>

<?php get_footer();