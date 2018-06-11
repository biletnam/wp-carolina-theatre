<?php
/**
 * The template for displaying archive pages
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

<section class="featuredEvent_carousel">
  <div class="container contain">
  	<h2>News & Press</h2>
    <?php // TO-DO: set up featured blog posts ?>
    <?php //get_template_part('template-parts/slider', 'featured_news'); ?>
  </div>
</section>
<section class="mainContent upcoming-events contain">
  <div class="mainContent__content">
    <div class="container">

    	<?php // The Query
 			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
      $limit = 6;
      $today = date("Ymd", strtotime('today'));
			$post_query_args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'paged' => $paged,
				'orderby' => 'date',
				'order' => 'DESC'
			);

			// The Loop
			$posts_query = new WP_Query($post_query_args);
			if ($posts_query->have_posts()) { ?>
	      <div class="card__wrapper">
					<?php while ($posts_query->have_posts()) { $posts_query->the_post(); ?>
					  <?php 
						  echo get_the_date('F j');
							the_title();
							the_content();
						?>
					  <?php //get_template_part('template-parts/event', 'thumbnail_card'); ?>
		  		<?php } // endwhile have_posts posts_query ?>
	 			</div>

				<div class="paginate">
			    <?php 
		        $paginate_links = paginate_links( array(
	            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
	            'total'        => $events_query->max_num_pages,
	            'current'      => max( 1, get_query_var( 'paged' ) ),
	            'format'       => '?paged=%#%',
	            'show_all'     => false,
	            'type'         => 'array',
	            'end_size'     => 1,
	            'mid_size'     => 0,
	            'prev_next'    => true,
	            'prev_text'    => '<i class="fas fa-chevron-left"></i>',
	            'next_text'    => '<i class="fas fa-chevron-right"></i>',
	            'add_args'     => false,
	            'add_fragment' => '',
		        ) );

		        $paginate_next       = '';
						$paginate_current    = '1';
						$paginate_prev       = '';
						$paginate_pages			 = '1';

						if($events_query->max_num_pages != 0) {
							$paginate_pages = $events_query->max_num_pages;
						}

						foreach( $paginate_links as $link ) {           
					    if( false !== strpos( $link, 'prev ' ) ){
				        $paginate_prev = $link;
					    } else if( false !== strpos( $link, ' current' ) ){
				        $paginate_current = $link;       
					    } else if( false !== strpos( $link, 'next ' ) ){
				        $paginate_next = $link;
					    }
						}
			    ?>
			    <div class="paginate__prev"><?php echo $paginate_prev; ?></div>
			    <div class="paginate__current"><?php echo 'Page '. $paginate_current . ' of '. $paginate_pages; ?></div>
			    <div class="paginate__next"><?php echo $paginate_next; ?></div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php } else { ?>
			<div class="card__wrapper">
			 No posts at this time.
			</div>
			<?php } // endif have_posts posts_query ?>
    </div><!-- .container -->
  </div><!-- .mainContent__content -->
  <?php get_sidebar(); ?>
</section>
<?php } // endwhile; ?>

<?php get_footer();
