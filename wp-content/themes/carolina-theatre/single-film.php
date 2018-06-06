<?php get_header(); ?>
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>

<?php while ( have_posts() ) { the_post(); ?>

<?php 
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
		  // $event_times = array();
  		if (have_rows('showtimes')) { 
        while (have_rows('showtimes')) { the_row();
      		$showtime = get_sub_field('dates', false, false);
      		if ($showtime >= $today) { // if the showtime is today or in the future,
        		array_push($event_dates, $showtime);	// push date to array
        		// array_push($event_times, get_sub_field('times')[0]['time']);	// push times to an array
      		}
         } // endwhile showtimes
      } //endif showtimes 
      
      // the closest upcoming date (to show in the card as the date square)
      $dateToShowInCard = $event_dates[0]; 
    }
  }
?>

<section class="mainContent contain film">
  <div class="mainContent__content">
  	<div class="container">
      <div class="singleEvent__image">
       <div class="event__dateBox">
					<span class="day"><?php echo date("j", strtotime($dateToShowInCard)); ?></span>
					<span class="month"><?php echo date("M", strtotime($dateToShowInCard)); ?></span>
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

      <p>The Carolina Theatre Presents...</p>
      <h2 class="singleEvent__title"><?php echo the_title(); ?></h2>
      <p class="singleEvent__subtitle"><?php echo get_field('event_subtitle'); ?></p>
      <div class="singleEvent__description">
      	<?php the_content(); ?>
      </div>
      <div class="singleEvent__read-more">
        <hr />
        <p>Read More</p>
      </div>
      <div class="singleEvent__videos">
        <div class="singleEvent__videos--one">
          <?php the_field('video_1_link'); ?>
          <p><?php the_field('video_1_caption') ?></p>
        </div>
        <div class="singleEvent__videos--two">
          <?php the_field('video_2_link'); ?>
          <p><?php the_field('video_2_caption') ?></p>
        </div>
      </div>
    </div>
  </div>  

  <aside class="mainContent__sidebar">
  	<div class="container">
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
        <ul class="showInfo__showdates">
        	<?php if (have_rows('showtimes')) { // output all dates for a show
            while (have_rows('showtimes')) { the_row(); ?>
            	<?php $showdate = get_sub_field('dates');?>
              <li><?php echo $showdate; ?></li>
              <?php if (have_rows('times')) { // output all times for a given date ?>
              	<ul class="showInfo__showtimes">
                  <?php while (have_rows('times')) { the_row(); ?>
                  	<?php $showtime = get_sub_field('time'); ?>
                 	 	<li><?php echo $showtime . '<i class="fa fa-ticket" aria-hidden="true"></i>'; ?></li>
                  <?php } // endwhile times ?>
                </ul>
               <?php } // endif times ?>
             <?php } // endwhile showtimes ?>
          <?php } //endif showtimes ?>
      	</ul>
      </div>
      <div class="sidebar__filmInfo">
      		<?php $movie_info = get_field('film_information'); ?>
          <h3>Movie Info</h3>
          <div>
              <h5>Director</h5>
              <p><?php echo $movie_info["director"]; ?></p>
          </div>
          <div>
              <h5>Release Year</h5>
              <p><?php echo $movie_info["release_year"]; ?></p>
          </div>
          <div>
              <h5>Release Country</h5>
              <p><?php echo $movie_info["release_country"]; ?></p>
          </div>
          <div>
              <h5>Rating</h5>
              <p><?php echo $movie_info["rating"]; ?></p>
          </div>
          <div>
              <h5>Runtime</h5>
              <p><?php echo $movie_info["runtime"] . ' min'; ?></p>
          </div>
      </div>
      <?php get_template_part( 'template-parts/event', 'external_links' ); ?>
      <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
    </div>
  </aside>
</section>
<?php } // endwhile; ?>
<?php get_footer(); ?>