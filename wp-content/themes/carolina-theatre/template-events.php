<?php
	// Template name: Events Template
	get_header();
?>
<?php while ( have_posts() ) { the_post(); ?>

<section class="featuredEvent_carousel">
  <div class="container contain">
  	<h2>Featured Events</h2>
    <?php get_template_part('template-parts/slider', 'featured_events'); ?>
  </div>
</section>
<section class="mainContent upcoming-events contain">
  <div class="mainContent__content">
    <div class="container">
      <h2>Upcoming Events</h2>

      <div class="tabbedContent__tabs">
        <ul class="upcoming-events__type">
            <li class="tabbedContent__tab active-link">All</li>
            <li class="tabbedContent__tab">Film</li>
            <?php // TO-DO: Make tabs dynamic based on event types ?>
            <li class="tabbedContent__tab">Music</li>
            <li class="tabbedContent__tab">Comedy</li>
            <li class="tabbedContent__tab">Theater</li>
            <li class="tabbedContent__tab">Discussion</li>
            <li class="tabbedContent__tab">Dance</li>
            
            <li class="tabbedContent__tab">Family Saturday</li>
            <?php 
                $standard_events = array("Music", "Comedy", "Theater", "Discussion", "Dance", "Family Saturday");
                $custom_events = array();

                // filter events only to check for custom event types
                $filter_query_args = array(
                    'post_type' => 'event');
                
                $filter_query = new WP_Query($filter_query_args);
                
                if ($filter_query->have_posts()) {
                    while ($filter_query->have_posts()) { $filter_query->the_post();
                        // assumes 'End Date' and last 'Showtime' are the same in the dashboard
                        $last_date = get_field('end_date');

                        // if event is playing or will be in the future, append custom
                        // event type to array
                        if (strtotime($last_date) >= strtotime('today')) {
                            $event_types = get_field("single_event_type");
                            // loop thru all event types associated with post,
                            // check if they are in $standard_events and $custom_events, if not
                            // in either add to $custom_events
                            foreach($event_types as $et) {
                                if (!in_array($et, $standard_events) && !in_array($et, $custom_events)) {
                                    array_push($custom_events, $et);
                                }
                            }
                        }  
                    }
                }
                // append $custom_events to filter list of standard events
                if (count($custom_events) > 0) {
                    foreach($custom_events as $ce) { ?>
                        <li class="tabbedContent__tab"><?php echo $ce; ?></li>
	              <?php } // end for each ?>
	            <?php } // end if ?>
	          <?php wp_reset_postdata(); ?>
        </ul>
        <ul class="upcoming-events__type--secondary filmFilters">
          <li class="tabbedContent__tab default active-link">All Films</li>
          <li class="tabbedContent__tab default">Now Playing</li>
          <li class="tabbedContent__tab default">Coming Soon</li>
	        <?php // TO-DO: Make these dynamically pulled in based on current film series/festivals ?>
          <li class="tabbedContent__tab">Retro Epics</li>
          <li class="tabbedContent__tab">Anime-Magic</li>
          <li class="tabbedContent__tab">SplatterFlix</li>
          <li class="tabbedContent__tab">Realistic Realm</li>
          <li class="tabbedContent__tab">Retro Art House</li>
        </ul>
      </div>

      <div class="events card__wrapper">
        <?php // The Query
	        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	        $limit = 10;

	        $today = date("Ymd", strtotime('today'));
					$events_query_args = array(
						'post_type' => array('event', 'film'),
						'post_status' => 'publish',
						'posts_per_page' => $limit,
						'paged' => $paged,
						'max_num_pages' => -1,
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

					// // Original Query, filtering out past dates after in PHP
					// $events_query_args = array(
					// 	'post_type' => array('event', 'film'),
					// 	'post_status' => 'publish',
					// 	'posts_per_page' => $limit,
					// 	'paged' => $paged,
					// 	'meta_query' => array(
					// 	  'start_clause' => array('key' => 'start_date'),
					// 	  'end_clause' => array('key' => 'end_date')
					// 	),
					// 	'orderby' => array(
					// 	  'relation' => 'AND',
					// 	  'start_clause' => 'ASC',
					// 	  'end_clause' => 'ASC'
					// 	),
					// );

					// The Loop
					$events_query = new WP_Query($events_query_args);
					if ($events_query->have_posts()) {
						// print_r($events_query);
						while ($events_query->have_posts()) { $events_query->the_post(); ?>
						  <?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
			  		<?php } // endwhile have_posts events_query ?>

						<div class="pagination">
			        <?php // TO-DO: Style pagination ?>
			        <ul class="pagination pull-right">
		            <li><?php echo get_next_posts_link( 'Next Page', $events_query->max_num_pages ); ?></li>
		            <li><?php echo get_previous_posts_link( 'Previous Page' ); ?></li>
			        </ul>
						</div>

					<?php wp_reset_postdata(); // Restore original Post Data
					} else {
					echo 'No events at this time';
					} // endif have_posts events_query
				?>
      </div> <!-- .events -->
    </div>
  </div><!-- .mainContent__content -->
  <?php get_sidebar('events'); ?>
</section>
<?php } // endwhile; ?>

<?php get_footer(); ?>