<div class="cardSlider">
  <?php // The Query
    $limit = 8;
    $today = date("Ymd", strtotime('today'));
		$eventSlider_query_args = array(
			'post_type' => array('event', 'film'),
			'post_status' => 'publish',
			'posts_per_page' => $limit,
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
		$eevntSlider_query = new WP_Query($eventSlider_query_args);
		if ($eevntSlider_query->have_posts()) {
			while ($eevntSlider_query->have_posts()) { $eevntSlider_query->the_post(); ?>
			  <?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
  		<?php } // endwhile have_posts eevntSlider_query ?>
		<?php wp_reset_postdata(); // Restore original Post Data
		} else {
		echo 'No events at this time';
		} // endif have_posts eevntSlider_query
	?>
</div>
<div class="cardSlider__nav">
  <a href="/events" class="button gray">See All Events</a>
  <div class="cardSlider__arrows"></div>
</div>