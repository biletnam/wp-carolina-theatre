<?php
/////// DATES in YYYYMMDD format
$start_date = get_field('start_date'); 		
$end_date = get_field('end_date'); 				
$showtime_soonestDate = get_field('soonest_date'); 
$today = date("Ymd", strtotime('today')); 

// get closest date's earliest time
$showtimes = get_field('showtimes');
$si = array_search($showtime_soonestDate, array_column($showtimes, 'date'));
$showtime_soonestTime = $showtimes[$si]['times'][0]['time'];


/////// ASSIGN CLASS NAMES FOR EACH EVENT
$class_names = [];
if (get_post_type() == 'film') {
	array_push($class_names, 'film'); 

	if ($showtime_soonestDate == $today) {
	  array_push($class_names, 'now-playing'); 
	} else if ($today < $start_date) {
	  array_push($class_names, 'coming-soon'); 
	}  
}
if (get_post_type() == 'event') {
  array_push($class_names, 'event'); 
 
	// get the 'event_category' custom taxonomy for filtering
	$terms = get_the_terms( $post->ID , array( 'event_categories') );
	foreach ( $terms as $term ) {
		$term_link = get_term_link( $term, array( 'event_categories') );
		array_push($class_names, $term->name);
	}
}

// classes for associated (parent) Series and Festivals
$associated_event = get_field('associated_event'); 
if($associated_event){ 
	$title = get_the_title($associated_event);
	array_push($class_names, $title);
}

// transform human readable classes to html classes with hyphens
$class_string = '';
for ($i = 0; $i < count($class_names); $i++) {
	// convert each future class name to lowercase
	$transform_class = strtolower($class_names[$i]);

	// replace all characters except letters, replace with underscore
  $transform_class = preg_replace('/[^a-z]+/i', '_', $transform_class);

  // trim any leading/trailing underscores
	$transform_class = preg_replace('/\G_|_(?=_*$)/', '', $transform_class);
  
  // replace underscores with dashes
  $transform_class = str_replace("_", "-", $transform_class);

  // add class to the string
  $class_string .= $transform_class . ' ';
}
?>


<div class="card eventCard<?php echo ' ' . $class_string; ?>">
   <a href="<?php echo get_page_link(get_the_id()); ?>">
    <div class="event__dateBox">
			<span class="day"><?php echo date("j", strtotime($showtime_soonestDate)); ?></span>
			<span class="month"><?php echo date("M", strtotime($showtime_soonestDate)); ?></span>
    </div>
    <div class="eventCard__image">
    	<?php 
  			$image_url = get_stylesheet_directory_uri().'/src/img/no-event-image-thumb.jpg';
				$image_alt = 'No Event Image to Show'; 
				
				if (have_rows('event_hero')){
					$slideRepeater = get_field('panel_content');
					$image = $slideRepeater[0]['image'];
			 	 	
			 	 	if($image){ 
         		$image_url = $image['sizes']['event-thumb'];
         		$image_alt = $image['alt'];
          } //endif 
				} //endif haveRows 
			?>
		 	<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
    </div>
    <div class="card__infoWrapper">
      <?php get_template_part('template-parts/part', 'event_categories'); ?>
      <p class="card__title"><?php the_title();?></p>
      <div class="card__info">	
      	<?php $event_location = get_field('event_location'); ?>
      	<?php if (get_post_type() == 'film'){ ?>
      		<?php 
						$film_director = get_field('director'); 												// text
						$film_release_country = get_field('release_country'); 					// text
						$film_release_year = get_field('release_year'); 								// text
						$film_runtime = get_field('runtime'); 													// text
						$film_rating = get_field('rating');															// select
					?>
      		<?php if($film_runtime){ ?>
    			<p><i class="far fa-clock"></i><?php echo $film_runtime . ' min'; ?></p>
					<?php } ?>
					<?php if($film_director && $film_release_year){ ?>
					<p><i class="far fa-film"></i><?php echo $film_director; ?>, <?php echo $film_release_year; ?></p>
					<?php } else if ($film_director) { ?>
					<p><i class="far fa-film"></i><?php echo $film_director; ?></p>
					<?php } else if ($film_release_year) { ?>
					<p><i class="far fa-film"></i><?php echo $film_release_year; ?></p>
					<?php } ?>
        <?php } else if (get_post_type() == 'event'){ ?>
        	<?php if($showtime_soonestTime){ ?>
      		<p><i class="far fa-clock"></i><?php echo $showtime_soonestTime; ?></p>
      		<?php } ?>
          <?php if($event_location){ ?>
        	<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
        	<?php } ?>
        <?php } ?>
        
    		<?php get_template_part( 'template-parts/part', 'event_ticketLowest' ); ?>
      </div>
    </div>
    <div class="button card__button"><span>Tickets & Info <i class="fas fa-arrow-right"></i></span></div>
  </a>
</div>