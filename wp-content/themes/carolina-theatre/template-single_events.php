<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>

<?php 
	// SHARED FILM & EVENT FIELDS
	$coming_soon = get_field('event_comingsoon');										// boolean | if no dates have been announced
	
	$show_sidebar_fineprint = get_field('show_sidebar_fineprint'); 	// boolean
	$sidebar_fineprint = get_field('sidebar_fineprint'); 						// text area
	
	// DETERMINE POST TYPE
	$post_type = '';
	if (get_post_type() == 'film') {
		$post_type = 'film';
	} else if (get_post_type() == 'event') {
		$post_type = 'event';
	}

	// GET LIVE EVENT FIELDS
	$event_doorstime = get_field('event_doorstime'); 								// text

	// GET CATEGORIES - CUSTOM TAXONOMY CATEGORY
	$custom_taxonomy = 'event_categories';
	if($post_type === 'film'){
		$custom_taxonomy = 'film_categories';
	}
	$terms = get_the_terms( $post->ID , $custom_taxonomy );

	// SHOWTIMES
	$start_date = get_field('start_date'); 		
	$end_date = get_field('end_date'); 				
	date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));

	if($end_date < $today) {
		$showtime_soonestDate = $end_date;
	} else {
		// get closest date's earliest time
		// $showtime_soonestDate (Ymd - 20180704)
		// $showtime_soonestTime (g:ia - 7:30pm or empty string)
		include(locate_template('template-parts/event-get_soonest_date.php', false, true));
	}
?>

<div class="mainContent contain">
  <section class="mainContent__content">
  	<div class="container">
  		<?php // show the event's categories
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
      	<?php 
      		$event_preheading = get_field('event_preheading'); 							// text
					$event_specialguests = get_field('event_specialguests'); 				// text
					$event_subheading = get_field('event_subheading'); 							// text
 				?>
	      <?php if (!empty($event_preheading)) { ?>
	      <p class="singleEvent__preheading h5"><?php echo $event_preheading; ?></p>
	      <?php } ?>
	      <h1 class="singleEvent__title h2"><?php echo get_the_title(); ?></h1>
	      <?php if (!empty($event_specialguests)) { ?>
	      <p class="singleEvent__specialGuests h3"><?php echo $event_specialguests; ?></p>
	      <?php } ?>
	      <?php if (!empty($event_subheading)) { ?>
	      <p class="singleEvent__subtitle small"><?php echo $event_subheading; ?></p>
	      <?php } ?>
	    </div>

	    <div class="singleEvent__soonestShowtime">
	    	<i class="far fa-calendar-alt"></i> <?php echo date('l, F j', strtotime($showtime_soonestDate)); ?><?php if($showtime_soonestTime){ echo ' at '. date('g:ia', strtotime($showtime_soonestTime)); } ?>
	    	<?php if(count(get_field('showtimes')) > 1){
	    		// echo '+';
	    	} ?>
	    </div>

	    <div class="singleEvent__tickets--mobile">
	    	<?php get_template_part('template-parts/event', 'ticket_buttons'); ?>
	    </div>

      <div class="singleEvent__description">
				<?php get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
			</div>

			<div class="socialShare">
				<?php get_template_part('template-parts/part', 'social_sharing'); ?>						
			</div>

    	<?php
    		// RELATED POSTS
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
					<?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
				<?php } // end while each ?>
				<?php wp_reset_postdata(); ?>
				</div>
      </div>
			<?php } // end if related posts ?>
    </div>
  </section>  

  <aside class="mainContent__sidebar">
  	<div class="container">
			<?php 
				$show_member_tickets = get_field('show_member_tickets'); 				// boolean
				$member_ticket_link = get_field('member_ticket_link'); 					// url
				$show_season_pass = get_field('show_season_pass'); 							// boolean
				$season_pass_link = get_field('season_pass_link'); 							// url
				$event_soldout = get_field('event_soldout');
			?>

  		<div class="sidebar__tickets">
        <?php get_template_part('template-parts/event', 'ticket_buttons'); ?>

      	<?php if ($post_type == 'film') { ?>
        <?php get_template_part('template-parts/film', 'ticket_prices'); ?>
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
	       	<?php // EVENT DATES & TIMES ?>
					<?php if (!$coming_soon){ ?>
					 <?php get_template_part( 'template-parts/event', 'dates_times' ); ?>
					<?php } ?>
		    	
		    	<?php // DOORS TIME ?>
	       	<?php if($event_doorstime != null){ ?>
					<p><i class="far fa-clock"></i>Doors <?php echo $event_doorstime; ?></p>
       		<?php } // end doorstime ?>

		    	<?php // EVENT LOCATION ?>
		    	<?php $event_location = get_field('event_location');	// Select (array) ?>
	       	<?php if($event_location != null){ ?>
					<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
       		<?php } // end event_location ?>
	       	
	       	<?php // EVENT ABBREVIATED TICKET PRICES ?>
	       	<?php get_template_part( 'template-parts/event', 'ticket_prices' ); ?>
		    </div>
	      <?php } // end show information for live events ?>
  		</div>

  		
		<?php if ($post_type == 'film') { ?>
  		<?php // FILM SHOWTIMES ?>
			<div class="sidebar__showInfo">
			  <h3>Showtimes</h3>
			  <?php if (!$coming_soon){ ?>
	      <?php get_template_part('template-parts/film','showtimes'); ?>
			  <?php } else { ?>
				<ul class="showInfo__showdates">
					<li>Dates Coming Soon</li>
				</ul>
				<?php } // endif showtimes are available ?> 
			</div>

			<?php // FILM MOVIE DETAILS ?>
			<div class="sidebar__filmInfo">
			  <h3>Movie Info</h3>
	      <?php get_template_part('template-parts/film','movie_info'); ?>
			</div>
		<?php } ?>
      
		<?php $associated_event = get_field('associated_event'); // Post ID ?>
    <?php if ($associated_event) { ?>
  	 	<div class="associatedEvent">
		  	<p class="small">This <?php echo $post_type; ?> is a part of </p>
		  	<a class="singleEvent__associatedEvent button small gray" href="<?php echo get_permalink($associated_event); ?>#films"><?php echo get_the_title($associated_event); ?> ››</a>
    	</div>
  	<?php } //end associated_event ?>

    <?php get_template_part( 'template-parts/event', 'external_links' ); ?>
    <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>

    <?php 
			$show_sidebar_fineprint = get_field('show_sidebar_fineprint'); 	// boolean
			$sidebar_fineprint = get_field('sidebar_fineprint'); 						// text area
		?>
   	<?php if ($show_sidebar_fineprint) {?> 
   		<div><p class="small"><?php echo $sidebar_fineprint; ?></p></div>
 		<?php } ?>
    </div>
  </aside>
</div>
<?php } // endwhile; ?>
<?php get_footer(); ?>