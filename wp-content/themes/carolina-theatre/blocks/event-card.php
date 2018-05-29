<?php 
	$date_range = get_field('showtimes');

  if ($date_range != NULL) {
    $start_date_string = get_field('start_date');
    $end_date_string = get_field('end_date');
    $start_date = strtotime($start_date_string);
    $end_date = strtotime($end_date_string);
    $today = strtotime('today');

    // only construct events if they are playing or coming soon
    if ($end_date >= $today) {
    	
      // store all single event dates to use later YYYYMMDD
    	$today_YYYYMMDD = date("Ymd", strtotime('today'));
    	$start_date_YYYYMMDD = get_field('start_date', false, false);
      $end_date_YYYYMMDD = get_field('end_date', false, false);
		  $event_dates = array();
		  $event_times = array();
  		if (have_rows('showtimes')) { 
        while (have_rows('showtimes')) { the_row();
      		$showtime_YYYYMMDD = get_sub_field('dates', false, false);
      		if ($showtime_YYYYMMDD >= $today_YYYYMMDD) { // if the showtime is today or in the future,
        		array_push($event_dates, $showtime_YYYYMMDD);	// push future showtime dates to an array
        		array_push($event_times, get_sub_field('times')[0]['time']);	// push future showtime dates to an array
      		}
         } // endwhile showtimes
      } //endif showtimes 
      $dateToShowInCard = $event_dates[0]; // the next date to show in the card
		
      // test for event type
      $class_names = "";
      if (get_post_type() == "film") {
        $class_names = get_field('film_type');
        array_push($class_names, "film"); // add 'film' to list of classes for html template below
      } else if (get_post_type() == "event") {
        $class_names = get_field('single_event_type');
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
            <img src="<?php echo get_field('event_image')['url'];?>" alt="<?php echo get_field('event_image')['alt']; ?>" />
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