<div class="cardSlider">
  <?php // The Query
    $limit = 8;
    $today = date("Ymd", strtotime('today'));
		$events_query_args = array(
			'post_type' => array('event', 'film'),
			'post_status' => 'publish',
			'posts_per_page' => $limit,
			'paged' => $paged,
			'meta_query'	=> array(
				array( 	// make sure event has not passed
					'sorting_clause' => array( // if event hasn't ended yet
						'key'		=> 'soonest_date',
						'compare'	=> '>=',
						'value'		=> $today,
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