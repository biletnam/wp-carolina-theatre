<div class="carousel">
<?php $featured = get_field('featured_events'); ?>
<?php foreach($featured as $feature_obj) { $featured_ID = $feature_obj->ID; ?>
  <?php 
  /////// DATES in YYYYMMDD format
	$past_event = get_field('past_event', $featured_ID);
	$start_date = get_field('start_date', $featured_ID); 	
	$end_date = get_field('end_date', $featured_ID); 			
  date_default_timezone_set('America/New_York');
	$today = date("Ymd", strtotime('today'));
	
	// Before doing anything, see if the event is upcoming
	if(!$past_event){

		$dateString = '';
		if($start_date && $end_date){
			$dateString = date('F j', strtotime($start_date));
			$dateString .= ' - ';
			
			if($start_date == $end_date) {
				$dateString = date('l, F j', strtotime($start_date));	
			} else if(date('M', strtotime($start_date)) === date('M', strtotime($end_date))) {
				$dateString .= date('j', strtotime($end_date));			
			} else {
				$dateString .= date('F j', strtotime($end_date));			
			}
		}

   	$class_names = 'event';
		if (get_post_type($featured_ID) == 'film') {
			$class_names = 'film';
		}


		// Get soonest date
		$start_date = get_field('start_date', $featured_ID); 	
		$showtime_soonestDate = $start_date; 	
		$showtime_soonestTime = ''; 
		$upcoming_showtimes = array();
		$showtimes = get_field('showtimes', $featured_ID);

		if(is_array($showtimes) || is_object($showtimes)){
			$i = 0;
			foreach($showtimes as $showtime){	
				if ($showtime['date'] >= $today){	
				  $j = 0;	
					$upcoming_showtimes[$i]['date'] = $showtime['date'];	
			  	$times = $showtime['times'];	
			  	
			  	if(is_array($times) || is_object($times)){
				  	foreach($times as $time) {	
							$upcoming_showtimes[$i]['times'][$j] = $time;	
						  $j++;
				  	}	
				  }
				  $i++;	
			  }	
			}
			$showtime_soonestDate = $upcoming_showtimes[0]['date']; 	

			if($showtime_soonestDate != NULL && isset($upcoming_showtimes[0]['times'])){
				$showtime_soonestTime = $upcoming_showtimes[0]['times'][0]['time']; 	
			}
		}

   	?>

    <div class="featuredEvent__slide <?php echo $class_names; ?>">
    	<div class="featuredEvent__slideContainer">
    		<?php 
    			$haveRows = get_field('event_hero', $featured_ID);
    			$image_url = get_stylesheet_directory_uri().'/src/img/no-event-image-full.jpg';
					$image_alt = 'No Event Image to Show'; 
  				
  				if ($haveRows){
						$slideRepeater = get_field('panel_content', $featured_ID);
						$image = $slideRepeater[0]['image'];
				 	 	
				 	 	if($image){ 
           		$image_url = $image['sizes']['hero-small'];
           		$image_alt = $image['alt'];
            } //endif 
          ?>
    		<div class="featuredEvent__image" style="background-image:url(<?php echo $image_url; ?>)">
    			<div class="event__dateBox">
						<span class="day"><?php echo date("j", strtotime($showtime_soonestDate)); ?></span>
						<span class="month"><?php echo date("M", strtotime($showtime_soonestDate)); ?></span>
			    </div>
    			
					<?php } //endif haveRows ?>
			 		<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />	
        </div>
        <div class="featuredEvent__info">
          <div class="container">
            
            <p class="event__categories">
							<?php // show the event's categories
								$custom_taxonomy = 'event_categories';
								if(get_post_type($featured_ID) == 'film'){
									$custom_taxonomy = 'film_categories';
								}
								$terms = get_the_terms( $featured_ID , $custom_taxonomy );
								if($terms){
								
									$categories_string = '';
									$i = 1;
									foreach ( $terms as $term ) {
										$categories_string .= $term->name;
										$categories_string .= ($i < count($terms))? ", " : "";
										$i++;
									}
						  		echo '<h5>' . $categories_string . '</h5>';
								}
				  		?>
						</p>

            <h3><?php echo $feature_obj->post_title; ?></h3>
            <p><i class="far fa-calendar-alt"></i><?php echo $dateString; ?></p>
           	
           	<?php // EVENT LOCATION ?>
           	<?php $event_location = get_field('event_location', $featured_ID); ?>
		       	<?php if($event_location != null){ ?>
						<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
	       		<?php } // end event_location ?>

            <?php // EVENT TICKET PRICES ?>
						<?php 
							$ticket_link = get_field('ticket_link', $featured_ID); // repeater 
							$ticket_prices = get_field('ticket_prices', $featured_ID); // repeater 
							$ticket_string = 'TBA';
							
							if($ticket_prices){ 
								$pricesOrdered = array(); // array to reorder ticket prices
								foreach( $ticket_prices as $i => $price ) { // add each ticket price to the order array
									$pricesOrdered[$i] = $price['ticket_price'];
								}

								// put prices in order, low to high
							  sort($pricesOrdered, SORT_NUMERIC);

							  // if a valid ticket price, make string
							  if(is_array($pricesOrdered) || is_object($pricesOrdered)){
									$ticket_string = '$';
									$ticket_string .= $pricesOrdered[0]; // use the lowest price 				
									if(isset($pricesOrdered[1])){  // and if there are more prices, add a plus sign
										$ticket_string .= '+'; 
									} 
								}
							}
						?>
						<?php if ($ticket_prices){ ?>
						<p><i class="far fa-ticket-alt"></i><?php echo $ticket_string; ?></p>
						<?php } ?>

            <a href="<?php echo get_page_link($featured_ID); ?>" class="button">More Info</a>
           	
	         	<?php 
							$ticket_link = get_field('ticket_link', $featured_ID); 												// url
							$ticket_prices = get_field('ticket_prices', $featured_ID); 										// repeater
							$tickets_onsaledate = get_field('tickets_onsaledate', $featured_ID); 					// 2018-06-06 20:55:09  |  Y-m-d H:i:s
							$tickets_presaledate = get_field('tickets_presaledate', $featured_ID); 				// 2018-06-06 20:55:09  |  Y-m-d H:i:s
							date_default_timezone_set('America/New_York');
							$dateTime_now = date('Y-m-d H:i:s');
							$event_soldout = get_field('event_soldout', $featured_ID);
						?>

		        <?php if($ticket_link && !$event_soldout && ($tickets_onsaledate == NULL || $tickets_onsaledate <= $dateTime_now)){ ?>
	        	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button secondary"><i class="far fa-ticket-alt"></i> Buy Tickets</a>
		        <?php } // if there's a main ticket link ?>
        	</div>
        </div>
      </div> 
    </div> 
	<?php } // if end date <= today ?>
<?php } // end foreach ?>
<?php wp_reset_postdata(); ?>
</div>