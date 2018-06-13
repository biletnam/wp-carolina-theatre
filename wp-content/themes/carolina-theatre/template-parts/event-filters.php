<?php
  // TO-DO: setup tabbed filters to work across pagination and on page load. 
  // Dynamic $_GET parameters
  // https://www.advancedcustomfields.com/resources/query-posts-custom-fields/  
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

$cache_key = 'event_filters_query_cache';
if(!$html = get_transient($cache_key)){
  date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));
  $event_filters = array();
	$film_filters = array();
	$event_filters_unique = array();
	$film_filters_unique = array();
	$j = 0;
	$k = 0;

	$filters_args = array(
		'fields' => 'ids',
		'post_type' => array('event', 'film'),
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_query'	=> array(
			array (
				'key'		=> 'end_date', // double check that end date hasnt happened yet
				'compare'	=> '>=',
				'value'		=> $today,
			),
		),
	);
	$filters_query = new WP_Query($filters_args);

  ob_start();
 
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
	// remove any duplicated filters from the arrays
	$event_filters_unique = unique_multidim_array($event_filters, 'slug');
	$film_filters_unique = unique_multidim_array($film_filters, 'slug');
 	?>

	<ul class="upcoming-events__type">
    <li class="tabbedContent__tab active-link" data-filter="all">All</li>
    <li class="tabbedContent__tab" data-filter="film">Film</li>
    <?php // add filters based on active event types
    foreach($event_filters_unique as $filter){
			if($filter['slug'] != NULL){
				echo '<li class="tabbedContent__tab" data-filter="'.$filter['slug'].'">' . $filter['name'] . '</li>';
    	}
    } ?>
  </ul>
  <ul class="upcoming-events__type upcoming-events__type--secondary filmFilters">
    <li class="tabbedContent__tab default active-link" data-filter="film">All Films</li>
    <li class="tabbedContent__tab default" data-filter="now-playing">Now Playing</li>
    <li class="tabbedContent__tab default" data-filter="coming-soon">Coming Soon</li>
    <?php // add filters based on active film festival/series types
    foreach($film_filters_unique as $filter){
    	if($filter['slug'] != NULL){
    		echo '<li class="tabbedContent__tab" data-filter="'.$filter['slug'].'">' . $filter['name'] . '</li>';
    	}
    } ?>
  </ul>

	<?php 
  $html = ob_get_clean();
  set_transient( $cache_key, $html,  60*60*1 ); // 6 hours = 60*60*6
} ?> 
<div class="tabbedContent__tabs">
 <?php echo $html; ?>
</div>


	<?php 
	// query to get all filters
	// $filters_args = array(
	// 	'post_type' => array('event', 'film'),
	// 	'post_status' => 'publish',
	// 	'posts_per_page' => -1,
	// 	'meta_query'	=> array(
	// 		array (
	// 			'key'		=> 'end_date', // double check that end date hasnt happened yet
	// 			'compare'	=> '>=',
	// 			'value'		=> $today,
	// 		),
	// 	),
	// );
	// $filters_query = new WP_Query($filters_args);
	
	// $event_filters = array();
	// $film_filters = array();
	// $event_filters_unique = array();
	// $film_filters_unique = array();
	// $j = 0;
	// $k = 0;

	// if ($filters_query->have_posts()) {
	// 	while ($filters_query->have_posts()) { $filters_query->the_post();
	// 		// get filters based on event categories
	// 		if (get_post_type() == 'event') {
	// 			$terms = get_the_terms( $post->ID , 'event_categories');
	// 			for ($i = 0; $i < count($terms); $i++ ) {
	// 				$event_filters[$j]['name'] = $terms[$i]->name;
	// 				$event_filters[$j]['slug'] = $terms[$i]->slug;
	// 				$j++;
	// 			}
	// 		} 
	// 		// get filters for associated events
	// 		$associated_event = get_field('associated_event'); 
	// 		if($associated_event){ 
	// 			$film_filters[$k]['name'] = get_the_title($associated_event);
	// 			$film_filters[$k]['slug'] = get_post_field( 'post_name', $associated_event );
	// 			$k++;
	// 		}
	// 	}
	// }
	// // remove duplicate filters
	// $event_filters_unique = unique_multidim_array($event_filters, 'slug');
	// $film_filters_unique = unique_multidim_array($film_filters, 'slug');
?>


<?php
  // TO-DO: setup tabbed filters to work across pagination and on page load. 
  // Dynamic $_GET parameters
  // https://www.advancedcustomfields.com/resources/query-posts-custom-fields/  
?>
<!-- <div class="tabbedContent__tabs">
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
</div> -->