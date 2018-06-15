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

<?php // determine what to show based on search's hidden input field
$searchType = 'Sitewide';
if(isset($_GET['search-type'])) {

  $type = $_GET['search-type'];
  if($type === 'normal') {

  } elseif($type === 'events') {
		$searchType = 'Events';
		$args = array( 
			'post_type' => array('event', 'film'),
			'meta_key' => 'soonest_date', 
      'orderby' => 'meta_value_num', 
      'order' => 'ASC',
		);
		$args = array_merge( $args, $wp_query->query );
		query_posts( $args );
  }
}
?>

<section class="pageHeading contain searchHeader">
	<div class="container">
		<h1 class="pageTitle">Searching <?php echo $searchType; ?></h1>
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
			<div <?php if($type === 'events'){ echo 'class="events card__wrapper"'; } ?>>
			<?php while(have_posts()){ the_post(); ?>
				<?php if($type === 'events'){ ?> 
					<?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
				<?php } else { ?>
					<div class="searchResult">
						<?php if(get_post_type() === 'film'){ ?> 
							<h5>Film</h5>
						<?php } else if (get_post_type() === 'event'){ ?>
							<h5>Live Event</h5>
						<?php } else if (get_post_type() === 'post'){ ?>
							<h5>News</h5>
						<?php } else if (get_post_type() === 'page'){ ?>
							<h5>Page</h5>
						<?php } else if (get_post_type() === 'series'){ ?>
							<h5>Film Series</h5>
						<?php } else if (get_post_type() === 'festival'){ ?>
							<h5>Film Festival</h5>
						<?php } else if (get_post_type() === 'education'){ ?>
							<h5>Educational Series</h5>
						<?php } ?>
						<h4><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h4>
					</div>
				<?php } ?>		
			<?php } wp_reset_postdata(); // End of the loop. ?>
			</div>
		<?php } else { ?>
			
		<?php } //endif; ?>
   </div>
  </section>  
	<?php get_sidebar('search'); ?>
</div>

<?php get_footer(); ?>


