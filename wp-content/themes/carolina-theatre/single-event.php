<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>

<?php // ACF fields
	$event_title = get_the_title(); 

	$event_preheading = get_field('event_preheading'); 							// text
	$event_specialguests = get_field('event_specialguests'); 				// text
	$event_subheading = get_field('event_subheading'); 							// text

	$event_coming_soon = get_field('event_comingsoon');
	$multiday_event = get_field('event_multipledates'); 						// boolean
	$start_date = get_field('start_date'); 													// YYYYMMDD
	$end_date = get_field('end_date'); 															// YYYYMMDD
	$showtimes = get_field('showtimes'); 														// repeater
		// $date = get_sub_field('date'); 																// YYYYMMDD
		// $times = get_sub_field('times'); 															// repeater
		// 	$time = get_sub_field('time'); 															// 8:55 pm  |  g:i a
	$event_doorstime = get_field('event_doorstime'); 								// text
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
	$event_soldout = get_field('event_soldout');										// boolean
	
	$film_director = get_field('director'); 												// text
	$film_release_country = get_field('release_country'); 					// text
	$film_release_year = get_field('release_year'); 								// number
	$film_runtime = get_field('runtime'); 													// number
	$film_rating = get_field('rating');															// select

	$associated_event = get_field('associated_event');							// Post ID
	$event_categories = get_field('event_categories');							// Select (array)

	$show_sidebar_fineprint = get_field('show_sidebar_fineprint'); 	// boolean
	$sidebar_fineprint = get_field('sidebar_fineprint'); 						// text area
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

<div class="mainContent contain event">
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

      <div class="singleEvent__event-info">
        <ul>
          <li><?php echo '<i class="far fa-calendar-alt" aria-hidden="true"></i>' . $date_string; ?></li>
          <li>
            <?php $locations = get_field('location');
            echo '<i class="far fa-map-marker-alt" aria-hidden="true"></i>' . join($locations, ', '); ?>                    
          </li>
        </ul>
      </div>

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
    	<div class="sidebar__tickets">
    		<?php // TO-DO: ticket links, Coming soon conditional, sold out, etc ?>
        <a href="#" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button disabled">On Sale</a>
        <a href="#" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button secondary">Member Tickets</a>
  		</div>
      <div class="sidebar__showInfo">
        <?php if (have_rows('showtimes')) { // output all dates for a show
          while (have_rows('showtimes')) {  the_row(); ?>
           <?php $showdate = get_sub_field('dates');?>
	        	<p class="showInfo__showdates">
         		 	<p>
         		 		<i class="far fa-calendar-alt" aria-hidden="true"></i>
         		 		<?php echo $showdate;?>
         		 	</p>
          		<?php if (have_rows('times')) { // output all times for a given date ?>
                <ul class="showInfo__showtimes">
                  <?php while (have_rows('times')) { the_row(); ?>
                    <?php 
                      $doors_open = get_sub_field('doors_open');
                      $showtime = get_sub_field('time');
                    ?>
                    <li>
                    	<i class="fa fa-clock-o" aria-hidden="true"></i>
                    	<?php echo 'Doors Open ' . $doors_open . ' | Showtime ' . $showtime; ?>
                    	<i class="far fa-ticket-alt"></i>
                    </li>
                  <?php } // endwhile times ?>
                </ul>
              <?php } // endif times ?>
            </p>
					<?php } // endwhile showtimes ?>
      	<?php } //endif showtimes ?>
        <?php $price_vals = array(); // append ticket prices
        if (have_rows('ticket_prices')) {
          while (have_rows('ticket_prices')) { the_row();
            $price = get_sub_field('price');
            array_push($price_vals, $price);
          }
        } ?>
        <p class="showInfo__prices">
        	<i class="far fa-ticket-alt" aria-hidden="true"></i>
          <?php echo join($price_vals, ' | '); ?>
        </p>
        <p class="showInfo__location">
        	<i class="far fa-map-marker-alt" aria-hidden="true"></i>
          <?php echo join($locations, ', '); ?>
        </p>
        </ul>
      </div>
      <?php get_template_part( 'template-parts/event', 'external_links' ); ?>
      <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
    </div>
  </aside>
</div>

<?php } // endwhile; ?>
<?php get_footer(); ?>