<?php 
// CACHE THE EVENT DROPDOWN / HOMEPAGE EVENT SLIDER FOR 6 HOURS
// This speeds up page load tremendously

$cache_key = 'event_slider_query_cache';
if(!$ids = get_transient($cache_key)){
  $limit = 8;
  date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));
	$eventSlider_query_args = array(
		'fields' => 'ids',
		'post_type' => array('event', 'film'),
		'post_status' => 'publish',
		'posts_per_page' => $limit,
		'meta_query'	=> array(
			array (
				'key'		=> 'end_date', // double check that end date hasnt happened yet
				'compare'	=> '>=',
				'value'		=> $today,
			),
		),
	);
	$eventSlider_IDs = new WP_Query($eventSlider_query_args);

  $ids = $eventSlider_IDs->posts;
  set_transient( $cache_key, $ids, 60*60*1 ); // 6 hours = 60*60*6
}
?>

<div class="cardSlider">
	<?php 
	$eventSlider_query = new WP_Query(array(
    'post_type' => array('event', 'film'),
    'post__in' => $ids,
    'meta_key' => 'soonest_date', // order by the soonest date (may not be most recent, but close enough)
    'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
    'order' => 'ASC',
	));
		if ($eventSlider_query->have_posts()) {
			while ($eventSlider_query->have_posts()) { $eventSlider_query->the_post();
				get_template_part('template-parts/event', 'thumbnail_card');
  		} // endwhile have_posts eventSlider_query
		} else {
			echo 'No events at this time';
		} // endif have_posts eventSlider_query
		wp_reset_postdata();
	?>
</div>
<div class="cardSlider__nav">
  <a href="/events" class="button gray">See All Events</a>
  <div class="cardSlider__arrows"></div>
</div>