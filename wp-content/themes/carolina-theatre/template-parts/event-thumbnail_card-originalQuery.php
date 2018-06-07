<?php // TO-DO: Refactor taking into account the new event query
	// array of showdates and showtimes
	$date_range = get_field('showtimes');
  if ($date_range != NULL) {
  	// dates in YYYYMMDD format for easy comparing (ie: 20180130)
    $start_date = get_field('start_date');
    $end_date = get_field('end_date');
    $today = date("Ymd", strtotime('today'));

    // if event is a single day, set end_date
    if($end_date == NULL) {
    	$end_date = $start_date;
    }

    // only construct events if they are in the future
   	if ($end_date >= $today) {
		  $event_dates = array();
		  $event_times = array();
  		if (have_rows('showtimes')) { 
        while (have_rows('showtimes')) { the_row();
      		$showtime = get_sub_field('dates', false, false);
      		if ($showtime >= $today) { // if the showtime is today or in the future,
        		array_push($event_dates, $showtime);	// push date to array
        		array_push($event_times, get_sub_field('times')[0]['time']);	// push times to an array
      		}
         } // endwhile showtimes
      } //endif showtimes 
      
      // the closest upcoming date (to show in the card as the date square)
      $dateToShowInCard = $event_dates[0]; 
		
      // assign correct classes to event depending if it's a film or live event
      $class_names = [];
      if (get_post_type() == "film") {
        if(get_field('film_type')){ $class_names = get_field('film_type'); }
        array_push($class_names, "film"); // add 'film' to list of classes for html template below
      } else if (get_post_type() == "event") {
        if(get_field('single_event_type')){ $class_names = get_field('single_event_type'); }
        array_push($class_names, "event"); // add 'film' to list of classes for html template below
      }

      // transform human readable classes to html classes with hyphens
      $class_string = '';
      for ($i = 0; $i < count($class_names); $i++) {
        $transform_class = strtolower($class_names[$i]);
        $transform_class = str_replace(' ', '-', $transform_class);
        $class_string .= $transform_class . ' ';
      }

      if ($start_date <= $today and $today <= $end_date) {
        $class_string .= ' now-playing';
      } else if ($today < $start_date) {
        $class_string .= ' coming-soon';
      }    
  		?>

			<div class="card eventCard<?php echo ' ' . $class_string; ?>">
         <a href="<?php echo get_page_link(get_the_id()); ?>">
          <div class="event__dateBox">
						<span class="day"><?php echo date("j", strtotime($dateToShowInCard)); ?></span>
						<span class="month"><?php echo date("M", strtotime($dateToShowInCard)); ?></span>
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
              <p class="card__subtitle"><?php the_field('single_event_type');?></p>
              <p class="card__title"><?php the_title();?></p>
              <div class="card__info">	
              	<?php if (get_post_type() == "film") { ?>
              		<?php $movie_info = get_field('film_information'); ?>
              		<p><i class="far fa-clock"></i><?php echo $movie_info["runtime"] . ' min'; ?></p>
									<p><i class="far fa-film"></i><?php echo $movie_info["director"]; ?>, <?php echo $movie_info["release_year"]; ?></p>
			          <?php } else if (get_post_type() == "event") { ?>
			          	<p><i class="far fa-clock"></i><?php echo $event_times[0]; ?> show</p>
                  <p><i class="far fa-map-marker-alt"></i><?php the_field('location'); ?></p>
			          <?php } ?>
            		<p><i class="far fa-ticket-alt"></i>$<?php echo get_field('ticket_prices')[0]['price'];if(get_field('ticket_prices')[1]['price']){ echo " +"; } ?></p>
              </div>
          </div>
          <div class="button card__button"><span>Tickets & Info <i class="fas fa-arrow-right"></i></span></div>
        </a>
    	</div>
		<?php } // endif event is in the future ?>
	<?php } // endif date range isnt null ?>