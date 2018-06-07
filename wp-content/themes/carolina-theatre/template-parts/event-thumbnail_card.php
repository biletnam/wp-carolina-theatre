<?php // TO-DO: Refactor taking into account the new event query

/////// DATES 
$start_date = get_field('start_date'); 		// YYYYMMDD format
$end_date = get_field('end_date'); 				// YYYYMMDD format
$today = date("Ymd", strtotime('today')); // YYYYMMDD format
$showtime_closestToToday = $start_date; 

if ($start_date == NULL) { $start_date = $today-1; } // if no start date is given, set it to yesterday (so event doesn't show)
if($end_date == NULL) {	$end_date = $start_date; } // if a single day event, set end_date 

// construct events' future dates
// get most recent date for card's datebox & most recent time for card info
if (have_rows('showtimes')) { 
  if ($end_date >= $today) {
	  $event_dates = array();

    while (have_rows('showtimes')) { the_row();
  		$single_date = get_sub_field('date', false, false);
  		if ($single_date >= $today) { // if the showtime is today or in the future,
    		array_push($event_dates, $single_date);	// push date to array
  		}
     } // endwhile showtimes
    
    // get the date to show in the card as the date square
    $showtime_closestToToday = $event_dates[0]; 
  }
}

/////// ASSIGN CLASS NAMES FOR EACH EVENT
$class_names = [];
if (get_post_type() == 'film') {
	array_push($class_names, 'film'); 

	if ($start_date <= $today && $today <= $end_date) {
	  array_push($class_names, 'now-playing'); 
	} else if ($today < $start_date) {
	  array_push($class_names, 'coming-soon'); 
	}  
} 
if (get_post_type() == 'event') {
  array_push($class_names, 'event'); 

	$event_categories = get_field('event_categories'); 
  if($event_categories){ 
		foreach($event_categories as $event_category) {
			array_push($class_names, $event_category);
		}
  }
}

// classes for associated (parent) Series and Festivals
$associated_event = get_field('associated_event'); 
if($associated_event){ 
	$title = get_the_title($associated_event);
	array_push($class_names, $title);
}

// transform human readable classes to html classes with hyphens
$class_string = '';
for ($i = 0; $i < count($class_names); $i++) {
	// convert each future class name to lowercase
	$transform_class = strtolower($class_names[$i]);

	// replace all characters except letters, replace with underscore
  $transform_class = preg_replace('/[^a-z]+/i', '_', $transform_class);

  // trim any leading/trailing underscores
	$transform_class = preg_replace('/\G_|_(?=_*$)/', '', $transform_class);
  
  // replace underscores with dashes
  $transform_class = str_replace("_", "-", $transform_class);

  // add class to the string
  $class_string .= $transform_class . ' ';
}
?>


<div class="card eventCard<?php echo ' ' . $class_string; ?>">
   <a href="<?php echo get_page_link(get_the_id()); ?>">
    <div class="event__dateBox">
			<span class="day"><?php echo date("j", strtotime($showtime_closestToToday)); ?></span>
			<span class="month"><?php echo date("M", strtotime($showtime_closestToToday)); ?></span>
    </div>
    <div class="eventCard__image">
    	<?php 
  			$image_url = get_stylesheet_directory_uri().'/src/img/no-event-image-thumb.jpg';
				$image_alt = 'No Event Image to Show'; 
				
				if (have_rows('event_hero')){
					$slideRepeater = get_field('panel_content');
					$image = $slideRepeater[0]['image'];
			 	 	
			 	 	if($image){ 
         		$image_url = $image['sizes']['event-thumb'];
         		$image_alt = $image['alt'];
          } //endif 
				} //endif haveRows 
			?>
		 	<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
    </div>
    <div class="card__infoWrapper">
        <p class="card__subtitle">
        	<?php if (get_post_type() == 'film') {
        		echo 'film';
        	} else if (get_post_type() == 'event') {
      			$event_categories = get_field('event_categories'); 
  					if($event_categories){ 
  						echo join(", ", $event_categories);
  					} else {
	      			echo 'live event';
	      		}
      		} ?>
        </p>
        <p class="card__title"><?php the_title();?></p>
        <div class="card__info">	
        	<?php if (get_post_type() == 'film'){ ?>
        		<?php $movie_info = get_field('film_information'); ?>
        		<p><i class="far fa-clock"></i><?php echo $movie_info["runtime"] . ' min'; ?></p>
						<p><i class="far fa-film"></i><?php echo $movie_info["director"]; ?>, <?php echo $movie_info["release_year"]; ?></p>
          <?php } else if (get_post_type() == 'event'){ ?>
          	<p><i class="far fa-clock"></i><?php echo $event_times[0]; ?> show</p>
            <p><i class="far fa-map-marker-alt"></i><?php the_field('location'); ?></p>
          <?php } ?>
      		<p><i class="far fa-ticket-alt"></i>$<?php echo get_field('ticket_prices')[0]['price'];if(get_field('ticket_prices')[1]['price']){ echo " +"; } ?></p>
        </div>
    </div>
    <div class="button card__button"><span>Tickets & Info <i class="fas fa-arrow-right"></i></span></div>
  </a>
</div>