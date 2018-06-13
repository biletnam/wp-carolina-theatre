<?php
	// Template name: Events Template
	get_header();
  date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));
?>
<?php while ( have_posts() ) { the_post(); ?>

<?php if(get_field('featured_events')){ ?>
<section class="featuredEvent_carousel">
  <div class="container contain">
  	<h2>Featured Events</h2>
    <?php get_template_part('template-parts/slider', 'featured_events'); ?>
  </div>
</section>
<?php } //end if any featured events ?>

<section class="mainContent upcoming-events contain">
  <div class="mainContent__content">
    <div class="container">
      <h1>Upcoming Events</h1>
			<?php get_template_part('template-parts/event', 'filters'); ?>

			<?php  // The Query     
 			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
      $limit = -1;

      // 'soonest_date' (assigned in functions.php) stores the events closest date to today.
			$events_query_args = array(
				'post_type' => array('event', 'film'),
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'paged' => $paged,
				'meta_query'	=> array(
					'relation' => 'AND',
					array (
						'key'		=> 'past_event', // if event hasn't ended yet
						'compare'	=> '==', 
						'value'		=> false,
					),
					array (
						'key'		=> 'end_date', // double check that end date hasnt happened yet
						'compare'	=> '>=',
						'value'		=> $today,
					),
				),
				'meta_key' => 'soonest_date', // order by the soonest date (may not be most recent, but close enough)
	      'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
	      'order' => 'ASC',
			);
			
			// The Loop
			$events_query = new WP_Query($events_query_args);
			if ($events_query->have_posts()) { ?>
	      <div class="events card__wrapper">
					<?php while ($events_query->have_posts()) { $events_query->the_post(); ?>
					  <?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
		  		<?php } // endwhile have_posts events_query ?>
	 			</div> <!-- .events -->

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
			<div class="events card__wrapper">
			 No events at this time.
			</div>
			<?php } // endif have_posts events_query ?>
    </div><!-- .container -->
  </div><!-- .mainContent__content -->
  <?php get_sidebar('events'); ?>
</section>
<?php } // endwhile; ?>

<?php get_footer(); ?>