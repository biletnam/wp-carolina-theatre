<?php // TO-DO: Refactor taking into account the new event query

/////// DATES 
$start_date = get_field('start_date'); 		// YYYYMMDD format
$end_date = get_field('end_date'); 				// YYYYMMDD format
$today = date("Ymd", strtotime('today')); // YYYYMMDD format
$showtime_soonestDate = $start_date; 
$showtime_soonestTime = ''; 

if ($start_date == NULL) { $start_date = $today-1; } // if no start date is given, set it to yesterday (so event doesn't show)
if($end_date == NULL) {	$end_date = $start_date; } // if a single day event, set end_date 

// construct events' future dates
// get most recent date for card's datebox & most recent time for card info
if (have_rows('showtimes')) { 
  if ($end_date >= $today) {
	  $event_dates = array();
	  $event_times = array();

    while (have_rows('showtimes')) { the_row();
  		$single_date = get_sub_field('date', false, false);
  		if ($single_date >= $today) { // if the showtime is today or in the future,
    		array_push($event_dates, $single_date);	// push date to array
    		array_push($event_times, get_sub_field('times')[0]['time']);	// push future showtime dates to an array
  		}
     } // endwhile showtimes
    
    $showtime_soonestDate = $event_dates[0];    // get the date to show in the card as the date square
    $showtime_soonestTime = $event_times[0]; 
  }
} // endif showtimes

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
			<span class="day"><?php echo date("j", strtotime($showtime_soonestDate)); ?></span>
			<span class="month"><?php echo date("M", strtotime($showtime_soonestDate)); ?></span>
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
      <p class="card__subtitle card__category">
      	<?php 
      	// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
				$category = get_the_category();
				$useCatLink = false;
				
				if ($category){
					$category_display = '';
					// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
					if ( class_exists('WPSEO_Primary_Term') ) {
						$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
						$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
						$term = get_term( $wpseo_primary_term );
						if (is_wp_error($term)) {  // Default to first category (not Yoast) if an error is returned
							$category_display = $category[0]->name;
						} else {  // Yoast Primary category
							$category_display = $term->name;
						}
					} 
					else { // Default, display the first category in WP's list of assigned categories
						$category_display = $category[0]->name;
					}

					if ( !empty($category_display) ){
						echo htmlspecialchars($category_display);
					}
				} else {
				 	if (get_post_type() == 'film') {
	      		echo 'Film';
	      	} else if (get_post_type() == 'event') {
      			echo 'Live Event';
	    		} 
				}
  		?>
      </p>
      <p class="card__title"><?php the_title();?></p>
      <div class="card__info">	
      	<?php $event_location = get_field('eevnt_location'); ?>
      	<?php if (get_post_type() == 'film'){ ?>
      		<?php 
						$film_director = get_field('director'); 												// text
						$film_release_country = get_field('release_country'); 					// text
						$film_release_year = get_field('release_year'); 								// text
						$film_runtime = get_field('runtime'); 													// text
						$film_rating = get_field('rating');															// select
					?>
      		<?php if($film_runtime){ ?>
    			<p><i class="far fa-clock"></i><?php echo $film_runtime . ' min'; ?></p>
					<?php } ?>
					<?php if($film_director && $film_release_year){ ?>
					<p><i class="far fa-film"></i><?php echo $film_director; ?>, <?php echo $film_release_year; ?></p>
					<?php } else if ($film_director) { ?>
					<p><i class="far fa-film"></i><?php echo $film_director; ?></p>
					<?php } else if ($film_release_year) { ?>
					<p><i class="far fa-film"></i><?php echo $film_release_year; ?></p>
					<?php } ?>
        <?php } else if (get_post_type() == 'event'){ ?>
        	<?php if($showtime_soonestTime){ ?>
      		<p><i class="far fa-clock"></i><?php echo $showtime_soonestTime; ?></p>
      		<?php } ?>
          <?php if($event_location){ ?>
        	<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
        	<?php } ?>
        <?php } ?>
    		<p>
    			<i class="far fa-ticket-alt"></i>
    			<?php 
    				$ticket_prices = get_field('ticket_prices'); // repeater 
  					$ticket_string = 'TBA';
  					
  					if($ticket_prices){ 
							$pricesOrdered = array(); // array to reorder ticket prices
	    				foreach( $ticket_prices as $i => $price ) { // add each ticket price to the order array
								$pricesOrdered[ $i ] = $price['ticket_price'];
							}
						  sort($pricesOrdered, SORT_NUMERIC);

							if($pricesOrdered[0]['ticket_price']) { // if there is a valid ticket price, start making string
								$ticket_string = '$';
								$ticket_string .= $pricesOrdered[0]; // use the lowest price 				
		    				if($pricesOrdered[1]){  // and if there are more prices, add a plus sign
			    				$ticket_string .= ' +'; 
			    			} 
							}
    				}
    				echo $ticket_string;
    			?>
    		</p>
      </div>
    </div>
    <div class="button card__button"><span>Tickets & Info <i class="fas fa-arrow-right"></i></span></div>
  </a>
</div>