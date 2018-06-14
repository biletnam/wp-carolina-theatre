<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>

<?php 
	// SHARED FILM & EVENT FIELDS
	$event_title = get_the_title(); 

	$event_preheading = get_field('event_preheading'); 							// text
	$event_specialguests = get_field('event_specialguests'); 				// text
	$event_subheading = get_field('event_subheading'); 							// text

	$coming_soon = get_field('event_comingsoon');										// boolean | if no dates have been announced
	// $multiday = get_field('event_multipledates'); 									// boolean
	$event_location = get_field('event_location');									// Select (array)
	// $start_date = get_field('start_date'); 													// YYYYMMDD
	// $end_date = get_field('end_date'); 															// YYYYMMDD
	// $showtimes = get_field('showtimes'); 														// repeater
		// $date = get_sub_field('date'); 																// YYYYMMDD
		// $times = get_sub_field('times'); 															// repeater
		// $time = get_sub_field('time'); 																// 8:55 pm  |  g:i a

	// $ticket_link = get_field('ticket_link'); 												// url
	// $ticket_prices = get_field('ticket_prices'); 										// repeater
	// 	// $ticket_price = get_sub_field('ticket_price'); 								// text (no leading $)
	// 	// $ticket_label get_sub_field('ticket_label'); 									// text
	// $tickets_onsaledate = get_field('tickets_onsaledate'); 					// 2018-06-06 20:55:09  |  Y-m-d H:i:s
	// $tickets_presaledate = get_field('tickets_presaledate'); 				// 2018-06-06 20:55:09  |  Y-m-d H:i:s

	// $show_member_tickets = get_field('show_member_tickets'); 				// boolean
	// $member_ticket_link = get_field('member_ticket_link'); 					// url
	// $show_season_pass = get_field('show_season_pass'); 							// boolean
	// $season_pass_link = get_field('season_pass_link'); 							// url
	// $event_soldout = get_field('event_soldout');
	
	$associated_event = get_field('associated_event');							// Post ID

	$show_sidebar_fineprint = get_field('show_sidebar_fineprint'); 	// boolean
	$sidebar_fineprint = get_field('sidebar_fineprint'); 						// text area
	
	// DETERMINE POST TYPE
	$post_type = '';
	if (get_post_type() == 'film') {
		$post_type = 'film';
	} else if (get_post_type() == 'event') {
		$post_type = 'event';
	}

	// LIVE EVENT FIELDS
	$event_doorstime = get_field('event_doorstime'); 								// text

	// FILM FIELDS
	$film_director = get_field('director'); 												// text
	$film_release_country = get_field('release_country'); 					// text
	$film_release_year = get_field('release_year'); 								// text
	$film_runtime = get_field('runtime'); 													// text
	$film_rating = get_field('rating');															// select

	// CUSTOM TAXONOMY CATEGORY
	$custom_taxonomy = 'event_categories';
	if($post_type === 'film'){
		$custom_taxonomy = 'film_categories';
	}
	$terms = get_the_terms( $post->ID , $custom_taxonomy );
?>

<?php
	/////// DATES in YYYYMMDD format
	$start_date = get_field('start_date'); 		
	$end_date = get_field('end_date'); 				
	date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));
	// get closest date's earliest time
	// $showtime_soonestDate (Ymd - 20180704)
	// $showtime_soonestTime (g:ia - 7:30pm or empty string)
	include(locate_template('template-parts/event-get_soonest_date.php', false, true));
?>

<div class="mainContent contain">
  <section class="mainContent__content">
  	<div class="container">
  		<?php 
	  		// get the 'event_category' custom taxonomy for filtering
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
      <div class="singleEvent__image <?php echo $post_type; ?>">
       <div class="event__dateBox">
					<span class="day"><?php echo date("j", strtotime($showtime_soonestDate)); ?></span>
					<span class="month"><?php echo date("M", strtotime($showtime_soonestDate)); ?></span>
				</div>
				<div class="singleEvent__hero">
					<?php if (have_rows('event_hero')){ ?>
					<?php while (have_rows('event_hero')){ the_row(); ?>
					<?php get_template_part( 'template-parts/content-blocks/block', 'slider' ); ?>
					<?php } //endwhile ?>
					<?php } else { ?>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/src/img/no-event-image-full.jpg" alt="No Event Image to Show">
					<?php } //endif ?>
				</div>
      </div>

      <div class="singleEvent__headings">
	      <?php if (!empty($event_preheading)) { ?>
	      <p class="singleEvent__preheading h5"><?php echo $event_preheading; ?></p>
	      <?php } ?>
	      <h1 class="singleEvent__title h2"><?php echo $event_title; ?></h1>
	      <?php if (!empty($event_specialguests)) { ?>
	      <p class="singleEvent__specialGuests h3"><?php echo $event_specialguests; ?></p>
	      <?php } ?>
	      <?php if (!empty($event_subheading)) { ?>
	      <p class="singleEvent__subtitle"><?php echo $event_subheading; ?></p>
	      <?php } ?>
	    </div>

      <div class="singleEvent__description">
				<?php get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
			</div>

			<div class="socialShare">
				<?php get_template_part('template-parts/part', 'social_sharing'); ?>						
			</div>

    	<?php
    		// RELATED POSTS
    		// TO-DO: fix this to use the correct custom taxonomies
    		$relatedCategories = array();
				foreach ( $terms as $term ) {
					array_push($relatedCategories, $term->name);
				}
				$related_query = new WP_Query( array( 
						'tax_query' => array(
						  array( 
						  	'taxonomy' => $custom_taxonomy, 
						  	'field' => 'slug', 
						  	'terms' => $relatedCategories
						  )
						),
						'post_type' => array('film', 'event'), 
						'posts_per_page' => 3, 
						'post__not_in' => array($post->ID),
						'meta_query'	=> array(
							array (
								'key'		=> 'end_date', // double check that end date hasnt happened yet
								'compare'	=> '>=',
								'value'		=> $today,
							),
						),
					) 
				);
			?>
			<?php if ($related_query->have_posts()) { ?>
			<div class="singleEvent__relatedPosts">
    		<h3>Other Events You May Like...</h3>
        <div class="card__wrapper">
        <?php while ($related_query->have_posts()) { $related_query->the_post(); ?>
        	<?php //print_r(wp_get_post_categories($post->ID)); ?>
					<?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
				<?php } // end while each ?>
				<?php wp_reset_postdata(); ?>
				</div>
      </div>
			<?php } else { echo 'no related posts'; } // end if related posts ?>

    </div>
  </section>  

  <aside class="mainContent__sidebar">
  	<div class="container">
			<?php 
				$ticket_link = get_field('ticket_link'); 												// url
				$ticket_prices = get_field('ticket_prices'); 										// repeater
				$tickets_onsaledate = get_field('tickets_onsaledate'); 					// 2018-06-06 20:55:09  |  Y-m-d H:i:s
				$tickets_presaledate = get_field('tickets_presaledate'); 				// 2018-06-06 20:55:09  |  Y-m-d H:i:s
				
				date_default_timezone_set('America/New_York');
				$dateTime_now = date('Y-m-d H:i:s');

				$show_member_tickets = get_field('show_member_tickets'); 				// boolean
				$member_ticket_link = get_field('member_ticket_link'); 					// url
				$show_season_pass = get_field('show_season_pass'); 							// boolean
				$season_pass_link = get_field('season_pass_link'); 							// url
				$event_soldout = get_field('event_soldout');
			?>

  		<div class="sidebar__tickets">
        <?php if($ticket_link){ ?>
        	<?php if(!$event_soldout){ ?>
        		<?php if($tickets_onsaledate == NULL || $tickets_onsaledate <= $dateTime_now ){ ?>
		        	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button"><i class="far fa-ticket-alt"></i> Buy Tickets</a>
		        <?php } else if($tickets_presaledate != NULL && $tickets_presaledate <= $dateTime_now) { ?>
		        	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Presale Tickets to <?php the_title(); ?>" class="button"><i class="far fa-ticket-alt"></i> Presale Tickets</a>
		        	<p class="small"><i><strong>General Tickets</strong> <?php echo date('F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?></i></p>

	        	<?php } else if ($tickets_presaledate > $dateTime_now){ ?>
							<a title="Presale tickets go on sale <?php echo date('l, F j', strtotime($tickets_presaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_presaledate)); ?>" class="button disabled"><i class="far fa-ticket-alt"></i> Presale Begins <?php echo date('n/j', strtotime($tickets_presaledate)); ?></a>
		        	<p class="small"><i><strong>General Tickets</strong> <?php echo date('F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?></i></p>
	        	<?php } else { ?>
	        		<a title="Tickets available <?php echo date('l, F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?>" class="button disabled"><i class="far fa-ticket-alt"></i> Tickets <?php echo date('n/j', strtotime($tickets_onsaledate)); ?></a>
	        	<?php } ?>
        	<?php } else { ?> 
	        	<a title="Tickets are sold out." class="button disabled"><i class="far fa-ticket-alt"></i> Sold Out</a>
        	<?php } // if event's sold out or not ?>
        <?php } else { ?>
					<a title="Tickets to be announced." class="button disabled"><i class="far fa-ticket-alt"></i> Tickets TBA</a>
      	<?php } // if there's a main ticket link ?>
      	

      	<?php if ($post_type == 'film') { ?>
        <?php 
        	$ticket_string = '';
					if(have_rows('ticket_prices')){ 
						$i = 0;
						while(have_rows('ticket_prices')){ the_row();
							$ticket_price = get_sub_field('ticket_price');
							$ticket_label = get_sub_field('ticket_label'); 
							
							if($i == 0) {
								$ticket_string .= '<p class="primary">';
							} else if($i == 1) {								
								$ticket_string .= '<p class="small"><span>';
							} else {
								$ticket_string .= '<span>';
							}
							$ticket_string .= '$'.$ticket_price;

							if($ticket_label){
								$ticket_string .= ' ' . $ticket_label;
							}
							if($i == 0){
								$ticket_string .= '</p>';
							} else {
								$ticket_string .= '</span>';
							}
							$i++;
						}
						$ticket_string .= '</p>';

  				}
  			?>
      	<div class="ticket__prices"><?php echo $ticket_string; ?></div>
  			<?php } // end tickets for FILM ?>

  			<?php if($show_member_tickets && $show_season_pass){ ?>
        	<p class="small"><a href="<?php echo $member_ticket_link; ?>" target="_blank">Member Tickets</a> | <a href="<?php echo $season_pass_link; ?>" target="_blank">Season Pass</a></p>
        <?php } else if($show_member_tickets && !$show_season_pass){ ?>
        	<p class="small"><a href="<?php echo $member_ticket_link; ?>" target="_blank">Member Tickets</a></p>
        <?php } else if($show_season_pass && !$show_member_tickets){ ?>
        	<p class="small"><a href="<?php echo $season_pass_link; ?>" target="_blank">Season Pass</a></p>
        <?php } // season pass link ?>
		

	      <?php if ($post_type == 'event') { ?>
        <div class="sidebar__eventInfo">
	       	<?php // EVENT DATES & TIMES
		      if (!$coming_soon){
		      	$i = 0;
			    	if (have_rows('showtimes')) { // output all dates for a show
				      while (have_rows('showtimes')) { the_row();
				        	$date = get_sub_field('date');
									$times = get_sub_field('times');
									$classes = '';
									
									if($date < $today){
										$classes = ' past';
									} 
								?>
							  <li class="showInfo__date<?php echo $classes; ?>">
									<?php 
									if($i == 0){ 
										echo '<i class="far fa-calendar-alt"></i>';
									} 
									
									echo date('D, F j', strtotime($date));
 
				      	  if (have_rows('times')) { // output all times for a given date
										$num_times = count($times);
										$j = 0;
										while (have_rows('times')) { the_row(); 
											if($j == 0){ echo ' at '; }
											echo date('g:ia', strtotime(get_sub_field('time')));
											if($j < $num_times - 1){ echo ', '; }
											$j++;
										} // endwhile times
									} // endif times
									$i++; 
									?>
							  </li>
						  <?php 
				     	} // endwhile showtimes
			      } //endif showtimes
		    	} // endif showtimes are available 
		    	?>   
		    	
		    	<?php // DOORS TIME ?>
	       	<?php if($event_doorstime != null){ ?>
					<p><i class="far fa-clock"></i>Doors <?php echo $event_doorstime; ?></p>
       		<?php } // end event_location ?>

		    	<?php // EVENT LOCATION ?>
	       	<?php if($event_location != null){ ?>
					<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
       		<?php } // end event_location ?>
	       	
	       	<?php get_template_part( 'template-parts/part', 'event_ticketLowest' ); ?>
		    </div>
	      <?php } // end show information for live events ?>
  		</div>

  		


      <?php if ($post_type == 'film') { ?>
      <div class="sidebar__showInfo">
        <h3>Showtimes</h3>
	      <?php if (!$coming_soon){ ?>
	      	<ul class="showInfo__showdates">
	        	<?php if (have_rows('showtimes')) { // output all dates for a show
	            while (have_rows('showtimes')) { the_row(); ?>
	            	<?php 
		            	$date = get_sub_field('date');
									$times = get_sub_field('times');
									$classes = '';
									
									if($date < $today){
										$classes = ' past';
									} 
								?>
	            <li class="showInfo__date<?php echo $classes; ?>"><span class="date"><?php echo date('D, M j', strtotime($date)); ?></span>
	            <?php if (have_rows('times')) { // output all times for a given date ?>
	            	<ul class="showInfo__times">
	                <?php while (have_rows('times')) { the_row(); ?>
	                	<?php $time = get_sub_field('time'); ?>
	               	 	<li>
	               	 		<span class="time"><?php echo date('g:ia', strtotime($time)); ?></span>
	               	 		<a href="<?php echo $ticket_link; ?>" target="_blank"></a>
	               	 	</li>
	                <?php } // endwhile times ?>
	              </ul>
	             <?php } // endif times ?>
	             </li>
	           <?php } // endwhile showtimes ?>
	          <?php } //endif showtimes ?>
	      	</ul>
	      <?php } else { ?>
				<ul class="showInfo__showdates">
					<li>Dates Coming Soon</li>
				</ul>
	    	<?php } // endif showtimes are available ?>   
      </div>
      <?php } // end showtimes for films ?>

      <?php if ($post_type == 'film') { ?>
      <div class="sidebar__filmInfo">
        <h3>Movie Info</h3>
        <?php if ($film_director) { ?>
        <div>
            <h5>Director</h5>
            <p><?php echo $film_director; ?></p>
        </div>
        <?php } ?>
        <?php if ($film_release_year) { ?>
        <div>
            <h5>Release Year</h5>
            <p><?php echo $film_release_year; ?></p>
        </div>
        <?php } ?>
        <?php if ($film_release_country) { ?>
        <div>
            <h5>Release Country</h5>
            <p><?php echo $film_release_country; ?></p>
        </div>
        <?php } ?>
        <?php if ($film_runtime) { ?>
        <div>
            <h5>Runtime</h5>
            <p><?php echo $film_runtime; ?> min</p>
        </div>
        <?php } ?>
        <?php if ($film_rating) { ?>
        <div>
            <h5>MPAA Rating</h5>
            <p><?php echo $film_rating; ?></p>
        </div>
        <?php } ?>
      </div>
      <?php } // end if post type is film ?>
     
      <?php if ($associated_event) { ?>
  	 	<div class="associatedEvent">
		  	<p class="small">This <?php echo $post_type; ?> is a part of </p>
		  	<a class="singleEvent__associatedEvent button small gray" href="<?php echo get_permalink($associated_event); ?>#films"><?php echo get_the_title($associated_event); ?> ››</a>
    	</div>
    	<?php } //end associated_event ?>

      <?php get_template_part( 'template-parts/event', 'external_links' ); ?>
      	
      <?php // TO-DO: Add and implement sidebar link blocks ?>
      <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>

     	<?php if ($show_sidebar_fineprint) {?> 
     		<div><p class="small"><?php echo $sidebar_fineprint; ?></p></div>
   		<?php } ?>
    </div>
  </aside>
</div>
<?php } // endwhile; ?>
<?php get_footer(); ?>