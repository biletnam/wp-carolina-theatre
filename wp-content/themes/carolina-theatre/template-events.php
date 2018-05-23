<?php
	// Template name: Events Template
	get_header();
?>
<?php while ( have_posts() ) { the_post(); ?>

<section class="featuredEvent_carousel">
  <div class="container contain">
  	<h2>Featured Events</h2>
    <div class="carousel">
      <?php $featured = get_field('featured_events'); ?>
      <?php foreach($featured as $feature_obj) { $featured_ID = $feature_obj->ID; ?>
        <div class="featuredEvent__slide">
        	<div class="featuredEvent__slideContainer">
        		<div class="featuredEvent__image">
              <img src="<?php echo get_field('event_image', $featured_ID)["url"]; ?>" alt="event poster" />
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
                            while (have_rows('ticket_prices', $featured_ID)) {
                                the_row();
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
  </div> <!-- .container -->
</section>
<section class="mainContent upcoming-events contain">
  <div class="mainContent__content">
    <div class="container">
      <h2>Upcoming Events</h2>

      <div class="content-tabs">
        <ul class="upcoming-events__type">
            <li class="content-tabs__tab active-link">All</li>
            <li class="content-tabs__tab">Film</li>
            <li class="content-tabs__tab">Music</li>
            <li class="content-tabs__tab">Comedy</li>
            <li class="content-tabs__tab">Theater</li>
            <li class="content-tabs__tab">Discussion</li>
            <li class="content-tabs__tab">Dance</li>
            <li class="content-tabs__tab">Family Saturday</li>
            <?php 
                $standard_events = array("Music", "Comedy", "Theater", "Discussion", "Dance", "Family Saturday");
                $custom_events = array();

                // filter events only to check for custom event types
                $filter_query_args = array(
                    'post_type' => 'event');
                
                $filter_query = new WP_Query($filter_query_args);
                
                if ($filter_query->have_posts()) {
                    while ($filter_query->have_posts()) {
                        $filter_query->the_post();
                        // assumes 'End Date' and last 'Showtime' are the same in the dashboard
                        $last_date = get_field('end_date');

                        // if event is playing or will be in the future, append custom
                        // event type to array
                        if (strtotime($last_date) >= strtotime('today')) {
                            $event_types = get_field("single_event_type");
                            // loop thru all event types associated with post,
                            // check if they are in $standard_events and $custom_events, if not
                            // in either add to $custom_events
                            foreach($event_types as $et) {
                                if (!in_array($et, $standard_events) && !in_array($et, $custom_events)) {
                                    array_push($custom_events, $et);
                                }
                            }
                        }  
                    }
                }
                // append $custom_events to filter list of standard events
                if (count($custom_events) > 0) {
                    foreach($custom_events as $ce) { ?>
                        <li class="content-tabs__tab"><?php echo $ce ?></li>
              <?php }
                }
                wp_reset_postdata();
            ?>
        </ul>
        <ul class="upcoming-events__type--secondary filmFilters">
            <li class="content-tabs__tab active-link">All Films</li>
            <li class="content-tabs__tab">Now Playing</li>
            <li class="content-tabs__tab">Coming Soon</li>
            <li class="content-tabs__tab">Retro Epics</li>
            <li class="content-tabs__tab">Anime-Magic</li>
            <li class="content-tabs__tab">SplatterFlix</li>
            <li class="content-tabs__tab">Realistic Realm</li>
            <li class="content-tabs__tab">Retro Art House</li>
        </ul>
      </div>
      <div class="events card__wrapper">
        <?php // The Query
        	// TO-DO: Filter event showtimes within ARGS
	        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	        $limit = 5;
					$events_query_args = array(
						'post_type' => array('event', 'film'),
						'post_status' => 'publish',
						// 'posts_per_page' => $limit,
						// 'paged' => $paged,
						'meta_query' => array(
						  'start_clause' => array('key' => 'start_date'),
						  'end_clause' => array('key' => 'end_date')
						),
						'orderby' => array(
						  'relation' => 'AND',
						  'start_clause' => 'ASC',
						  'end_clause' => 'ASC'
						),
					);

					// The Loop
					$events_query = new WP_Query($events_query_args);
					if ($events_query->have_posts()) {
						while ($events_query->have_posts()) { $events_query->the_post();
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
			  		<?php } // endwhile have_posts events_query ?>
					<?php wp_reset_postdata(); // Restore original Post Data
					} else {
					echo 'No events at this time';
					} // endif have_posts events_query
				?>
      </div> <!-- .events -->
    </div>
  </div><!-- .mainContent__content -->
  <aside class="mainContent__sidebar">
  	<div class="container">
      <div class="upcoming-events__sidebar--search">
      <input type="text" placeholder="Search..." />
      <button>Search Events</button>
      </div>
      <div class="sidebar__menus">
      	<div class="sidebar__menu">
	        <p class="h3">Upcoming Film Series</p>
	        <ul>
	            <li><a href="#" title="">Retro Epics ››</a></li>
	            <li><a href="#" title="">Anime-Magic ››</a></li>
	            <li><a href="#" title="">SplatterFlix ››</a></li>
	            <li><a href="#" title="">Fantastic Realm ››</a></li>
	            <li><a href="#" title="">Retro ArtHouse ››</a></li>
	        </ul>
	      </div>
	      <div class="sidebar__menus--menu">
	        <p class="h3">Upcoming Film Festivals</p>
	        <ul>
	          <li><a href="#" title="">NC Gay &amp; Lesbian Film Festival >></a></li>
	          <li><a href="#" title="">Nevermore ››</a></li>
	          <li><a href="#" title="">Full Frame ››</a></li>
	        </ul>
	      </div>
      </div>
      
      <?php get_template_part( 'blocks/content-blocks', 'link-block' ); ?>
  	</div>
  </aside>
</section>
<?php } // endwhile; ?>

<?php get_footer(); ?>