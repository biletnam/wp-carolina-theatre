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
      <h1>Upcoming Events</h1>

      <?php
	      // TO-DO: setup tabbed filters to work across pagination and on page load. 
	      // Dynamic $_GET parameters
	      // https://www.advancedcustomfields.com/resources/query-posts-custom-fields/  
      ?>
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

    	<?php // The Query     
 			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
      $limit = 6;
      $today = date("Ymd", strtotime('today'));
			$events_query_args = array(
				'post_type' => array('event', 'film'),
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'paged' => $paged,
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