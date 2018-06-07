<div class="carousel">
  <?php $featured = get_field('featured_events'); ?>
  <?php foreach($featured as $feature_obj) { $featured_ID = $feature_obj->ID; ?>
    <div class="featuredEvent__slide">
    	<div class="featuredEvent__slideContainer">
    		<div class="featuredEvent__image">
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
            <h5>
              <?php if (get_post_type($featured_ID) == "film") {
                  echo "Film";
              } else {
                  echo join(get_field('single_event_type', $featured_ID), ', ');
              } ?>
            </h5>
            <h3><?php echo $feature_obj->post_title; ?></h3>
            <p><i class="far fa-calendar-alt"></i>
              <?php
                // convert date strings to integers for sorting
                $featured_event_dates = array();
                if (have_rows('showtimes', $featured_ID)) {
                    while (have_rows('showtimes', $featured_ID)) {
                        the_row();
                        $featured_event_date = strtotime(get_sub_field('dates'));
                        array_push($featured_event_dates, $featured_event_date);
                    }
                }

                $featured_start_date = min($featured_event_dates);
                $featured_end_date = max($featured_event_dates);
                $featured_start_date_string = date("F d, Y", min($featured_event_dates));
                $featured_end_date_string = date("F d, Y", max($featured_event_dates));
                echo $featured_start_date_string . ' - ' . $featured_end_date_string;
              ?> 
            </p>
            <p>
              <i class="far fa-map-marker-alt" aria-hidden="true"></i>
              <?php 
                $featured_location = get_field('location', $featured_ID);
                 
                if (count($featured_location) > 1) {
                    echo join(", ", $featured_location);
                } else {
                    echo $featured_location[0];
                }
              ?>
            </p>
            <p>
              <i class="far fa-ticket-alt" aria-hidden="true"></i>
              <?php 
                $multiple_ticket_prices = array();
                if (have_rows('ticket_prices', $featured_ID)) {
                  while (have_rows('ticket_prices', $featured_ID)) { the_row();
                    $price = get_sub_field('price');
                    array_push($multiple_ticket_prices, $price);
                  }
                }
                echo '$' . join(', ', $multiple_ticket_prices);
              ?>
            </p>
            <a href="<?php echo get_page_link($featured_ID); ?>" class="button">More Info</a>
            <a href="<?php echo get_page_link($featured_ID); ?>" class="button secondary">Tickets</a>
        	</div>
        </div>
      </div> 
    </div> 
  <?php } // end foreach ?>
</div> <!-- .carousel -->