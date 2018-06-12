<?php
	// Template name: Events Template
	get_header();
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

      <?php // query to get all filters
			$filters_args = array(
				'post_type' => array('event', 'film'),
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'meta_query'	=> array(
					array( 	// make sure event has not passed
						'sorting_clause' => array( // if event hasn't ended yet
							'key'		=> 'soonest_date',
							'compare'	=> '>=',
							'value'		=> $today,
						),
					),
				),
			);
			?>
		
			<?php 
			function unique_multidim_array($array, $key) { 
			    $temp_array = array(); 
			    $i = 0; 
			    $key_array = array(); 
			    
			    foreach($array as $val) { 
			        if (!in_array($val[$key], $key_array)) { 
			            $key_array[$i] = $val[$key]; 
			            $temp_array[$i] = $val; 
			        } 
			        $i++; 
			    } 
			    return $temp_array; 
			} 
			?>
			<?php 
				$filters_query = new WP_Query($filters_args);
				$event_filters = array();
				$film_filters = array();
				$event_filters_unique = array();
				$film_filters_unique = array();
				$j = 0;
				$k = 0;

				if ($filters_query->have_posts()) {
					while ($filters_query->have_posts()) { $filters_query->the_post();
						// get filters based on event categories
						if (get_post_type() == 'event') {
							$terms = get_the_terms( $post->ID , 'event_categories');
							for ($i = 0; $i < count($terms); $i++ ) {
								$event_filters[$j]['name'] = $terms[$i]->name;
								$event_filters[$j]['slug'] = $terms[$i]->slug;
								$j++;
							}
						} 
						// get filters for associated events
						$associated_event = get_field('associated_event'); 
						if($associated_event){ 
							$film_filters[$k]['name'] = get_the_title($associated_event);
							$film_filters[$k]['slug'] = get_post_field( 'post_name', $associated_event );
							$k++;
						}
					}
				}
				// remove duplicate filters
				$event_filters_unique = unique_multidim_array($event_filters, 'slug');
				$film_filters_unique = unique_multidim_array($film_filters, 'slug');
			?>


      <?php
	      // TO-DO: setup tabbed filters to work across pagination and on page load. 
	      // Dynamic $_GET parameters
	      // https://www.advancedcustomfields.com/resources/query-posts-custom-fields/  
      ?>
      <div class="tabbedContent__tabs">
        <ul class="upcoming-events__type">
          <li class="tabbedContent__tab active-link" data-filter="all">All</li>
          <li class="tabbedContent__tab" data-filter="film">Film</li>
          <?php // add filters based on active event types
          foreach($event_filters_unique as $filter){
						echo '<li class="tabbedContent__tab" data-filter="'.$filter['slug'].'">' . $filter['name'] . '</li>';
          } ?>
        </ul>
        <ul class="upcoming-events__type upcoming-events__type--secondary filmFilters">
          <li class="tabbedContent__tab default active-link" data-filter="film">All Films</li>
          <li class="tabbedContent__tab default" data-filter="now-playing">Now Playing</li>
          <li class="tabbedContent__tab default" data-filter="coming-soon">Coming Soon</li>
          <?php // add filters based on active film festival/series types
          foreach($film_filters_unique as $filter){
          	echo '<li class="tabbedContent__tab" data-filter="'.$filter['slug'].'">' . $filter['name'] . '</li>';
          } ?>
        </ul>
      </div>
			    	
			<?php  // The Query     
 			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
      $limit = 10;

      // 'soonest_date' (assigned in functions.php) stores the events 
      // closest date to today. If it's < today, don't show the event
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