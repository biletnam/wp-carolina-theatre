<div class="cardSlider">
  <?php // The Query
    $limit = 8;
    $today = date("Ymd", strtotime('today'));
		$events_query_args = array(
			'post_type' => array('event', 'film'),
			'post_status' => 'publish',
			'posts_per_page' => $limit,
			'meta_query'	=> array(
		  	'relation'		=> 'AND', // both arrays below must be TRUE
				array( 	// make sure event has not passed
					'relation' => 'OR',
					'start_clause' => array( // if event hasn't started yet
						'key'		=> 'start_date', 
						'compare'	=> '>=',
						'value'		=> $today,
					),
					'end_clause' => array( // if event hasn't ended yet
						'key'		=> 'end_date',
						'compare'	=> '>=',
						'value'		=> $today,
					),
				),
				array ( 	// make sure event has start date and use to order query
					'sorting_clause' => array(
            'key'     => 'start_date',
            'compare' => 'EXISTS',
	        ),
				),
			),
			'orderby' => array(
			  'sorting_clause' => 'ASC',
			),
		);

		// The Loop
		$events_query = new WP_Query($events_query_args);
		if ($events_query->have_posts()) {
			while ($events_query->have_posts()) { $events_query->the_post(); ?>
			  <?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
  		<?php } // endwhile have_posts events_query ?>
		<?php wp_reset_postdata(); // Restore original Post Data
		} else {
		echo 'No events at this time';
		} // endif have_posts events_query
	?>
</div>
<div class="cardSlider__nav">
  <a href="/events" class="button gray">See All Events</a>
  <div class="cardSlider__arrows"></div>
</div>