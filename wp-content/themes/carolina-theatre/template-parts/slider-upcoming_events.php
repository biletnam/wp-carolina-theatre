<div class="cardSlider">
  <?php // The Query
    $limit = 12;
		$events_query_args = array(
			'post_type' => array('event', 'film'),
			'post_status' => 'publish',
			'posts_per_page' => $limit,
			'meta_query' => array(
			  'start_clause' => array('key' => 'start_date'),
			  'end_clause' => array('key' => 'end_date')
			),
			'orderby' => array(
			  'relation' => 'AND',
			  'start_clause' => 'ASC',
			  'end_clause' => 'ASC'
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