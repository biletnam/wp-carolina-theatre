<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php // convert date strings to integers for sorting
	$event_dates = array();
	if (have_rows('showtimes')) {
    while (have_rows('showtimes')) { the_row();
      $event_date = strtotime(get_sub_field('dates'));
      array_push($event_dates, $event_date);
    }
	}

	// pick the min/max and convert to string 
	$date_string = '';
	$start_date = date("F d, Y", min($event_dates));
	$end_date = date("F d, Y", max($event_dates));

	if ($start_date == $end_date) {
		$date_string = $start_date;
	} else {
		$date_string = $start_date . '-' . $end_date;
	}
?>
<section class="mainContent contain eventType__film">
  <div class="mainContent__content">
  	<div class="container">
      <p class="singleEvent__category"><?php echo get_post_type() ?></p>
      <div class="singleEvent__image">
        <img src="<?php echo get_field('event_image')["url"]; ?>" alt="the poster for the film">
        <div class="singleEvent__image--date"><?php echo $date_string; ?></div>
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
      <?php get_template_part( 'blocks/event', 'externalLinks' ); ?>
      <?php get_template_part( 'blocks/content-blocks', 'link-block' ); ?>
    </div>
  </aside>
</section>
<?php } // endwhile; ?>
<?php get_footer(); ?>