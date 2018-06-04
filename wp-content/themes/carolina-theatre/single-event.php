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
<section class="mainContent contain eventType__event">
  <div class="mainContent__content">
    <div class="container">
        
      <p class="singleEvent__category"><?php echo get_post_type(); ?></p>
      <div class="singleEvent__image">
          <img src="<?php echo get_field('event_image')["url"]; ?>" alt="the poster for the film">
          <div class="singleEvent__image--date"><?php echo $date_string; ?></div>
      </div>
      <p>The Carolina Theatre Presents...
      <h2 class="singleEvent__title"><?php echo the_title(); ?></h2>
      <p class="singleEvent__subtitle"><?php echo get_field('event_subtitle'); ?></p>
      <div class="singleEvent__event-info">
        <ul>
          <li>
            <?php echo '<i class="fa fa-calendar" aria-hidden="true"></i>' . $date_string; ?>
          </li>
          <li>
            <?php $locations = get_field('location');
            echo '<i class="fa fa-map-marker" aria-hidden="true"></i>' . join($locations, ', '); ?>                    
          </li>
        </ul>
      </div>
      <div class="singleEvent__description"><?php the_content(); ?></div>
      <div class="singleEvent__read-more">
          <hr />
          <p>Read More</p>
      </div>
      <div class="singleEvent__videos">
          <div class="singleEvent__videos--one">
              <?php the_field('video_1_link'); ?>
              <p><?php the_field('video_1_caption'); ?></p>
          </div>
          <div class="singleEvent__videos--two">
              <?php the_field('video_2_link'); ?>
              <p><?php the_field('video_2_caption'); ?></p>
          </div>
      </div>
    </div>
  </div>

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
         		 		<i class="fa fa-calendar" aria-hidden="true"></i>
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
                    	<i class="fas fa-ticket-alt"></i>
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
        	<i class="fa fa-ticket" aria-hidden="true"></i>
          <?php echo join($price_vals, ' | '); ?>
        </p>
        <p class="showInfo__location">
        	<i class="fa fa-map-marker" aria-hidden="true"></i>
          <?php echo join($locations, ', '); ?>
        </p>
        </ul>
      </div>
      <?php get_template_part( 'blocks/event', 'externalLinks' ); ?>
      <?php get_template_part( 'blocks/content-blocks', 'link-block' ); ?>
    </div>
  </aside>
</section>

<?php } // endwhile; ?>
<?php get_footer(); ?>