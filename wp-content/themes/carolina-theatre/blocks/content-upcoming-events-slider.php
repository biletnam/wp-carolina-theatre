<div class="cardSlider">
  <?php // The Query
  	// TO-DO: Filter event showtimes within ARGS
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

  	/////////// filtering events by dates   ///////////
  	/////////// PERFORMANCE IS WAY TOO SLOW /////////// 

  	// $today = date("Ymd", strtotime('today'));
		// $events_query_args['meta_query'] = array(
		// 'post_type' => array('event', 'film'),
		// 'post_status' => 'publish',
		// 'posts_per_page' => $limit,
		// 'orderby' => array(
		//   'relation' => 'AND',
		//   'start_clause' => 'ASC',
		//   'end_clause' => 'ASC'
		// ),

		// // Use an OR relationship between the query in this array and the one in
		//    // the next array. (AND is the default.)
		//    'relation' => 'OR',
		//    // If an end_date exists, check that it is upcoming.
		//    array(
		//      'key'        => 'end_date',
		//      'compare'    => '>=',
		//      'value'      => date( 'Ymd', $today ),
		//    ),
		//    // OR!
		//    array(
		//      // A nested set of conditions for when the above condition is false.
		//      array(
		//        // We use another, nested set of conditions, for if the end_date
		//        // value is empty, OR if it is null/not set at all. 
		//        'relation' => 'OR',
		//        array(
		//          'key'        => 'end_date',
		//          'compare'    => '=',
		//          'value'      => '',
		//        ),
		//        array(
		//          'key'        => 'end_date',
		//          'compare'    => 'NOT EXISTS',
		//        ),
		//      ),
		//      // AND, if the start date is upcoming.
		//      array(
		//        'key'        => 'start_date',
		//        'compare'    => '>=',
		//        'value'      => date( 'Ymd', $today ),
		//      ),
		//    ),
		//  );

		// The Loop
		$events_query = new WP_Query($events_query_args);
		if ($events_query->have_posts()) {
			while ($events_query->have_posts()) { $events_query->the_post(); ?>
			  <?php get_template_part('blocks/event', 'card'); ?>
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