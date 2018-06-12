<div class="carousel">
  <?php $featured = get_field('featured_events'); ?>
  <?php foreach($featured as $feature_obj) { $featured_ID = $feature_obj->ID; ?>
    <?php 
    /////// DATES in YYYYMMDD format
		$start_date = get_field('start_date', $featured_ID); 	
		$end_date = get_field('end_date', $featured_ID); 			
		$showtime_soonestDate = get_field('soonest_date', $featured_ID); 
		$today = date("Ymd", strtotime('today'));

		$dateString = '';
		if($start_date && $end_date){
			$dateString = date('M j', strtotime($start_date));
			$dateString .= ' - ';

			if(date('M', strtotime($start_date)) === date('M', strtotime($end_date))) {
				$dateString .= date('j, Y', strtotime($end_date));			
			} else {
				$dateString .= date('M j, Y', strtotime($end_date));			
			}
		} else if($start_date && $end_date == NULL) {
			$dateString .= date('F j, Y', strtotime($start_date));	
		} else if($end_date && $start_date == NULL) {
			$dateString .= date('F j, Y', strtotime($start_date));	
		}

   	$class_names = 'event';
		if (get_post_type($featured_ID) == 'film') {
			$class_names = 'film';
		}

   	?>

    <div class="featuredEvent__slide <?php echo $class_names; ?>">
    	<div class="featuredEvent__slideContainer">
    		<div class="featuredEvent__image">
    			<div class="event__dateBox">
						<span class="day"><?php echo date("j", strtotime($showtime_soonestDate)); ?></span>
						<span class="month"><?php echo date("M", strtotime($showtime_soonestDate)); ?></span>
			    </div>
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
					<?php } //endif haveRows ?>
				 	<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />	
        </div>
        <div class="featuredEvent__info">
          <div class="container">
            <p class="event__categories">
						<?php 
						// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
						$category = get_the_category($featured_ID);
						$useCatLink = false;
						
						if ($category){

							$category_display = '';
							// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
							if ( class_exists('WPSEO_Primary_Term') ) {
								$wpseo_primary_term = new WPSEO_Primary_Term( 'category', $featured_ID );
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
						 	if (get_post_type($featured_ID) == 'film') {
					  		echo 'Film';
					  	} else if (get_post_type($featured_ID) == 'event') {
								echo 'Live Event';
							} 
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
									$pricesOrdered[ $i ] = $price['ticket_price'];
								}
							  sort($pricesOrdered, SORT_NUMERIC);

								if($pricesOrdered[0]['ticket_price']) { // if there is a valid ticket price, start making string
									$ticket_string = '$';
									$ticket_string .= $pricesOrdered[0]; // use the lowest price 				
									if($pricesOrdered[1]){  // and if there are more prices, add a plus sign
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
  <?php } // end foreach ?>
</div> <!-- .carousel -->