<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<section class="pageHeading contain searchHeader">
	<div class="container">
		<h1 class="pageTitle">Search Results</h1>
		<?php if ( have_posts() ) { ?>
			<p>Search results for "<span><?php echo get_search_query(); ?></span>"</p>
		<?php } else { ?>
			<p>No results for "<span><?php echo get_search_query(); ?></span>"</p>
		<?php } // endif; ?>
	</div>
</section>

<div class="mainContent contain">
  <section class="mainContent__content">
  	<div class="container">
		
		<?php if(have_posts()){ ?>
			<?php while(have_posts()){ the_post(); ?>
				<div class="searchResult">
					<h4><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></h4></a>			
				</div>
			<?php } wp_reset_postdata(); // End of the loop. ?>
		<?php } else { ?>
			
		<?php } //endif; ?>
   </div>
  </section>  
	<?php get_sidebar('events'); ?>
</div>

<?php get_footer(); ?>