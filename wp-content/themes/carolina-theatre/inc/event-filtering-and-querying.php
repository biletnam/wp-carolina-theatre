<?php 
// AJAX Functions for getting the filters and upcoming events for template-events.php
// This file ties into event-filter.js, functions.php, and template-events.php

/* 
 * remove duplicates from multidimensional array
 */
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

/* 
 * sort filter array alphabetically
 */
function cmp($a, $b){
  return strcmp($a['name'], $b['name']);
} 

/* 
 * Get all filters for the events
 * films - associated event, coming soon, now playing
 * events - associated event, event_categories  
 */
function get_event_filters(){
	$html = false;
	$cache_key = 'event_filtering_html_cache';

	// setup the cache so query isn't run every time page is loaded
	if(!$html = get_transient($cache_key)){
	  // get the global upcomingEventIDs from functions.php
	  global $upcomingEventIDs; 
		$upcomingEventIDs = getUpcomingEventIDs();

	  $event_filters = array();
		$film_filters = array();
		$event_filters_unique = array();
		$film_filters_unique = array();
		$j = 0;
		$k = 0;

		$filters_args = array(
			'post_type' => array('event', 'film'),
			'fields' => 'ids',
			'post__in' => $upcomingEventIDs,
			'posts_per_page' => -1,
		);
		$filters_query = new WP_Query($filters_args);

		// turn on output buffer so nothing gets 'echoed', but instead stored in the $html variable
	  ob_start();
	 
		if ($filters_query->have_posts()) {
			while ($filters_query->have_posts()) { $filters_query->the_post();
				// get filters based on event categories
				if (get_post_type() == 'event') {
					$terms = get_the_terms( get_the_ID(), 'event_categories');
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
		// remove any duplicated filters from the arrays
		$event_filters_unique = unique_multidim_array($event_filters, 'slug');
		$film_filters_unique = unique_multidim_array($film_filters, 'slug');

		// sort filters ASC
		usort($event_filters_unique, "cmp");
		usort($film_filters_unique, "cmp");
	 	
		// build the html
	 	?>
	 	<div class="tabbedContent__tabs" id="event-filter">
			<ul class="upcoming-events__type">
		    <li class="tabbedContent__tab active-link" data-filter="all">All</li>
		    <li class="tabbedContent__tab" data-filter="event">Live Events<input type="radio" name="filter_event[]" value="event" class="hidden"></li>
		    <li class="tabbedContent__tab" data-filter="film">Film<input type="radio" name="filter_event[]" value="film" class="hidden"></li>
		    <?php // add filters based on active event types
		    foreach($event_filters_unique as $filter){
					if($filter['slug'] != NULL){
						echo '<li class="tabbedContent__tab" data-filter="'.$filter['slug'].'">'.$filter['name'].'<input type="radio" name="filter_event[]" value="'.$filter['slug'].'" class="hidden"></li>';
		    	}
		    } ?>
		  </ul>
		  <ul class="upcoming-events__type--secondary filmFilters">
		    <li class="tabbedContent__tab filmFilter default" data-filter="now-playing">Now Playing<input type="radio" name="filter_event[]" value="now-playing" class="hidden"></li>
		    <li class="tabbedContent__tab filmFilter default" data-filter="coming-soon">Coming Soon<input type="radio" name="filter_event[]" value="coming-soon" class="hidden"></li>
		    <?php // add filters based on active film festival/series types
		    foreach($film_filters_unique as $filter){
		    	if($filter['slug'] != NULL){
		    		echo '<li class="tabbedContent__tab filmFilter " data-filter="'.$filter['slug'].'">'.$filter['name'].'<input type="radio" name="filter_event[]" value="'.$filter['slug'].'" class="hidden"></li>';
		    	}
		    } ?>
		  </ul>
		</div>
		<?php 
	  $html = ob_get_clean(); // get the content ($html) from the buffer and delete the current buffer
	  set_transient( $cache_key, $html,  60*60*1 ); // 6 hours = 60*60*6
	}

	return $html;
}

// 
/* 
 * Enqueue Ajax Scripts
 */
function enqueue_event_ajax_scripts() {
  wp_register_script( 'event-ajax-js', get_bloginfo('template_url') . '/dist/event-filter-min.js', array( 'jquery' ), '', true );
  wp_localize_script( 'event-ajax-js', 'ajax_event_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
  wp_enqueue_script( 'event-ajax-js' );
}
add_action('wp_enqueue_scripts', 'enqueue_event_ajax_scripts');


/* 
 * Add Ajax Actions
 */
add_action('wp_ajax_event_filter', 'ajax_event_filter');
add_action('wp_ajax_nopriv_event_filter', 'ajax_event_filter');


/* 
 * Construct query & upcoming event results (based on filters)
 */
function ajax_event_filter(){
  // get the global upcomingEventIDs from functions.php
  global $upcomingEventIDs; 
	$upcomingEventIDs = getUpcomingEventIDs();

  date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));  
  
  // get the info passed from event_get_posts(paged) in event-filters.js
  $query_data = $_GET;
  $event_term = ($query_data['events']) ? $query_data['events'] : false;
  $paged = (isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
  
  // default argument variables for query
  $limit = 12;
  $meta_query = false;
  // Determine what meta-query to use, based on the filter clicked
  if($event_term === "now-playing") {
	  // show all films, and use jquery (after success in event_get_posts() to hide none now-playing cards)
	  $limit = -1;
	  $paged = false;
	  $meta_query = array(
			array (
				'key'		=> 'event_filter_string', 
				'value'		=> ',film,',
				'compare'	=> 'LIKE',
			)
		);
  } else if($event_term === "coming-soon") {
	  // show all films that havent yet started
	  $meta_query = array(
			'relation' => 'AND',
			array (
				'key'		=> 'start_date', 
				'compare'	=> '>',
				'value'		=> $today,
			),
			array (
				'key'		=> 'event_filter_string',
				'value'		=> ',film,',
				'compare'	=> 'LIKE',
			)
		);
  } else if($event_term){
		// show all events whose 'event_filter_string' (an ACF hidden field) contains the clicked filter
		$meta_query = array(
			array (
				'key'		=> 'event_filter_string',
				'value'		=> ','.$event_term.',',
				'compare'	=> 'LIKE',
			)
		);
  }

  // create the rest of the argumente, using the variables from above
	$event_args = array(
		'post__in' 				=> $upcomingEventIDs, // the IDs from the cache in functions.php
		'post_type' 			=> array('event', 'film'),
		'post_status' 		=> 'publish',
		'posts_per_page'	=> $limit,
		'ignore_sticky_posts'  => true,
		'meta_query'			=> $meta_query,
		'meta_key' 				=> 'soonest_date', 		// order by the soonest date (may not be most recent, but close enough)
		'orderby' 				=> 'meta_value_num', 	// 'soonest_date' is a number (ie 20180704)
		'order' 					=> 'ASC',
		'paged' 					=> $paged,
	);
	$event_loop = new WP_Query($event_args);
  
  // loop through the posts returned and create the event thumbnail cards
  if( $event_loop->have_posts() ) { ?>
    <div id="loader" class="loader">
		  <img src="<?php echo get_stylesheet_directory_uri(); ?>/src/img/ajax-loader.gif" width="32px" height="32px">
		</div>
    <div class="card__wrapper"> 
    <?php while( $event_loop->have_posts() ){ $event_loop->the_post();
			get_template_part('template-parts/event', 'thumbnail_card');
    } // endwhile;
    ?>
    </div>
    <div class="paginate" id="event-filter-navigation">
	    <?php 
        $paginate_links = paginate_links( array(
          'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
          'total' 			 => $event_loop->max_num_pages,
          'current' 		 => max( 1, $paged ),
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

				if($event_loop->max_num_pages != 0) {
					$paginate_pages = $event_loop->max_num_pages;
				}

				if (is_array($paginate_links) || is_object($paginate_links)){
					foreach( $paginate_links as $link ) {           
				    if( false !== strpos( $link, 'prev ' ) ){
			        $paginate_prev = $link;
				    } else if( false !== strpos( $link, ' current' ) ){
			        $paginate_current = $link;       
				    } else if( false !== strpos( $link, 'next ' ) ){
			        $paginate_next = $link;
				    }
					}
				}
	    ?>
	    <div class="paginate__prev change-page"><?php echo $paginate_prev; ?></div>
	    <div class="paginate__current"><?php echo 'Page '. $paginate_current . ' of '. $paginate_pages; ?></div>
	    <div class="paginate__next change-page"><?php echo $paginate_next; ?></div>
		</div>
		<?php
  } else {
    echo '<div class="card__wrapper"><h3>No events to show.</h3></div>';
  } //endif;

  wp_reset_postdata();
  die();
}