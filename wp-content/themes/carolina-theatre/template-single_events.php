<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>

<?php 
	// SHARED FILM & EVENT FIELDS
	$event_title = get_the_title(); 

	$event_preheading = get_field('event_preheading'); 							// text
	$event_specialguests = get_field('event_specialguests'); 				// text
	$event_subheading = get_field('event_subheading'); 							// text

	$coming_soon = get_field('event_comingsoon');										// boolean
	$multiday = get_field('event_multipledates'); 									// boolean
	$start_date = get_field('start_date'); 													// YYYYMMDD
	$end_date = get_field('end_date'); 															// YYYYMMDD
	$showtimes = get_field('showtimes'); 														// repeater
		// $date = get_sub_field('date'); 																// YYYYMMDD
		// $times = get_sub_field('times'); 															// repeater
		// $time = get_sub_field('time'); 																// 8:55 pm  |  g:i a
	$event_location = get_field('event_location');									// Select (array)

	$ticket_link = get_field('ticket_link'); 												// url
	$ticket_prices = get_field('ticket_prices'); 										// repeater
		// $ticket_price = get_sub_field('ticket_price'); 								// text (no leading $)
		// $ticket_label get_sub_field('ticket_label'); 									// text
	$tickets_onsaledate = get_field('tickets_onsaledate'); 					// 2018-06-06 20:55:09  |  Y-m-d H:i:s
	$tickets_presaledate = get_field('tickets_presaledate'); 				// 2018-06-06 20:55:09  |  Y-m-d H:i:s

	$show_member_tickets = get_field('show_member_tickets'); 				// boolean
	$member_ticket_link = get_field('member_ticket_link'); 					// url
	$show_season_pass = get_field('show_season_pass'); 							// boolean
	$season_pass_link = get_field('season_pass_link'); 							// url
	$event_soldout = get_field('event_soldout');
	
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

	// LVIE EVENT FIELDS
	$event_doorstime = get_field('event_doorstime'); 								// text

	// FILM FIELDS
	$film_director = get_field('director'); 												// text
	$film_release_country = get_field('release_country'); 					// text
	$film_release_year = get_field('release_year'); 								// text
	$film_runtime = get_field('runtime'); 													// text
	$film_rating = get_field('rating');															// select

?>

<?php
  $today = date("Ymd", strtotime('today'));
  $showtime_closestToToday = $start_date; 

  // if no start date was given, set it as yesterday (so it doesn't show)
  if ($start_date == NULL) {
  	$start_date == $today-1;
  }

  // if a single day event, set end_date 
  if($end_date == NULL) {
  	$end_date = $start_date;
  }

  if ($showtimes != NULL) {
    // only construct events if they are in the future
    if ($end_date >= $today) {
		  $event_dates = array();

  		if (have_rows('showtimes')) { 
        while (have_rows('showtimes')) { the_row();
      		$single_date = get_sub_field('date', false, false);
      		if ($single_date >= $today) { // if the showtime is today or in the future,
        		array_push($event_dates, $single_date);	// push date to array
      		}
         } // endwhile showtimes
      } //endif showtimes 
      
      // get the date to show in the card as the date square
      $showtime_closestToToday = $event_dates[0]; 
    }
  }
?>

<div class="mainContent contain <?php echo $post_type; ?>">
  <section class="mainContent__content">
  	<div class="container">
      <?php if ($associated_event) { ?>
    	<a class="singleEvent__associatedEvent" href="<?php echo get_permalink($associated_event); ?>#films"><?php echo get_the_title($associated_event); ?> ››</a>
      <?php } ?>

      <div class="singleEvent__image">
       <div class="event__dateBox">
					<span class="day"><?php echo date("j", strtotime($showtime_closestToToday)); ?></span>
					<span class="month"><?php echo date("M", strtotime($showtime_closestToToday)); ?></span>
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

      <?php if (!empty($event_preheading)) { ?>
      <p class="singleEvent__preheading"><?php echo $event_preheading; ?></p>
      <?php } ?>
      <h1 class="singleEvent__title h2"><?php echo $event_title; ?></h1>
      <?php if (!empty($event_specialguests)) { ?>
      <p class="singleEvent__specialGuests"><?php echo $event_specialguests; ?></p>
      <?php } ?>
      <?php if (!empty($event_subheading)) { ?>
      <p class="singleEvent__subtitle"><?php echo $event_subheading; ?></p>
      <?php } ?>


      <div class="singleEvent__description">
				<?php get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
			</div>

      <?php // TO-DO: Related Events/Films ?>
      <div class="singleEvent__relatedPosts">
      	<h3>related posts go here</h3>
      </div>
    </div>
  </section>  

  <aside class="mainContent__sidebar">
  	<div class="container">
  		<?php // TO-DO: Ticket Button functionality ?>
  		<div class="sidebar__tickets">
        <a href="#" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button">Buy Tickets</a>
  		</div>
      <div class="sidebar__showInfo">
        <h3><i class="fas fas-clock-o offset-left" aria-hidden="true"></i>Showtimes &amp; Tickets</h3>
      	<?php $price_vals = array(); // append ticket prices
          if (have_rows('ticket_prices')) {
            while (have_rows('ticket_prices')) { the_row();
                $price = get_sub_field('price');
                array_push($price_vals, $price);
            } //endwhile ticket_prices
        	} //endif ticket_prices
      	?>
        <p class="showInfo__ticketPrices"><?php echo '$' . join($price_vals, ' | '); ?></p>
        
      <?php if (!$coming_soon){ ?>
      	<ul class="showInfo__showdates">
        	<?php if (have_rows('showtimes')) { // output all dates for a show
            while (have_rows('showtimes')) { the_row(); ?>
            	<?php 
	            	$date = get_sub_field('date');
								$times = get_sub_field('times');
							?>
              <li><?php echo date('F j', strtotime($date)); ?></li>
              <?php if (have_rows('times')) { // output all times for a given date ?>
              	<ul class="showInfo__showtimes">
                  <?php while (have_rows('times')) { the_row(); ?>
                  	<?php $time = get_sub_field('time'); ?>
                 	 	<li>
                 	 		<?php echo date('g:ia', strtotime($time)); ?>
                 	 		<a href="<?php echo $ticket_link; ?>" target="_blank"><i class="far fa-ticket-alt" aria-hidden="true"></i></a>
                 	 	</li>
                  <?php } // endwhile times ?>
                </ul>
               <?php } // endif times ?>
             <?php } // endwhile showtimes ?>
          <?php } //endif showtimes ?>
      	</ul>
      <?php } else { ?>
			<ul class="showInfo__showdates">
				<li>Dates Coming Soon</li>
			</ul>
    	<?php } // endif showtimes are available ?>
        
      </div>
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

      <?php get_template_part( 'template-parts/event', 'external_links' ); ?>
      	
      <?php // TO-DO: Add and implement sidebar link blocks ?>
      <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>

      <?php // TO-DO: Add and implement fine print text area ?>
     	<?php if ($show_sidebar_fineprint) {?> 
     		<div><p class="small"><?php echo $sidebar_fineprint; ?></p></div>
   		<?php } ?>
    </div>
  </aside>
</div>
<?php } // endwhile; ?>
<?php get_footer(); ?>