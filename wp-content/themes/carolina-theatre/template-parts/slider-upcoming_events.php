<?php 
// CACHE THE EVENT DROPDOWN / HOMEPAGE EVENT SLIDER FOR 6 HOURS
// This speeds up page load tremendously

global $upcomingEventIDs; // get the global upcomingEventIDs from functions.php
$upcomingEventIDs = getUpcomingEventIDs();
?>

<div class="cardSlider">
	<?php 
		$eventSlider_query = new WP_Query(array(
		  'post_type' => array('event', 'film'),
		  'post__in' => $upcomingEventIDs,
		  'posts_per_page' => 8,
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