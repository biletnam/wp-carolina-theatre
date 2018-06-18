<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>

<?php if(get_field('show_hero_slider')){ ?>
<?php get_template_part( 'template-parts/slider', 'page_hero' ); ?>
<?php } ?>

<?php
	/////// DATES in YYYYMMDD format 
	$start_date = get_field('start_date'); 		
	$end_date = get_field('end_date'); 				
	$today = date("Ymd", strtotime('today')); 

	$show_sidebar_fineprint = get_field('show_sidebar_fineprint'); 	// boolean
	$sidebar_fineprint = get_field('sidebar_fineprint'); 						// text area
	$event_location = get_field('event_location');									// Select (array)

	$dateString = '';
	if($start_date && $end_date){
		$dateString = date('M j', strtotime($start_date));
		$dateString .= ' - ';

		if(date('M', strtotime($start_date)) === date('M', strtotime($end_date))) {
			$dateString .= date('j, Y', strtotime($end_date));			
		} else {
			$dateString .= date('M j, Y', strtotime($end_date));			
		}
	} else if($start_date && $end_date == NULL) {
		$dateString .= date('F j, Y', strtotime($start_date));	
	} else if($end_date && $start_date == NULL) {
		$dateString .= date('F j, Y', strtotime($start_date));	
	}

	$post_type = 'series';
	if(is_singular('education')){
		$post_type = 'education';
	} else if(is_singular('series')) {
		$post_type = 'series';
	} else if(is_singular('festival')) {
		$post_type = 'festival';
	}
?>

<?php // Query for Tabs and Events/Films 

if ($post_type == 'festival') {
	// get associated events for a festival
	$associatedEvents_query_args = array(
		'post_type' => array('event'),
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_query'	=> array(
			array(
	      'key'     => 'associated_event',
	      'value'   => get_the_id(),
	      'compare' => '=',
	    )
		),
		'meta_key' => 'start_date', // order by the soonest date (may not be most recent, but close enough)
	  'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
	  'order' => 'ASC',
	);
	$associatedEvents_query = new WP_Query($associatedEvents_query_args);
}

if ($post_type == 'series' || $post_type == 'festival') {
	// get associated films for a festival/series
	$associatedFilms_query_args = array(
		'post_type' => array('film'),
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_query'	=> array(
			array(
	      'key'     => 'associated_event',
	      'value'   => get_the_id(),
	      'compare' => '=',
	    )
		),
		'meta_key' => 'start_date', // order by the soonest date (may not be most recent, but close enough)
	  'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
	  'order' => 'ASC',
	);
	$associatedFilms_query = new WP_Query($associatedFilms_query_args);
}

if ($post_type == 'education') {
	// get associated shows (films/events) for an education series
	$associatedShows_query_args = array(
		'post_type' => array('film', 'event'),
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_query'	=> array(
			array(
	      'key'     => 'associated_event',
	      'value'   => get_the_id(),
	      'compare' => '=',
	    )
		),
		'meta_key' => 'start_date', // order by the soonest date (may not be most recent, but close enough)
	  'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
	  'order' => 'ASC',
	);
	$associatedShows_query = new WP_Query($associatedShows_query_args);
}

?>

<section class="pageHeader contain">
	<div class="container">
	  <?php if($dateString){ ?><p class="date"><i class="far fa-calendar-alt"></i><?php echo $dateString; ?></p> <?php } ?>
	  <h1><?php the_title(); ?></h1>
  </div>
</section>

<div class="mainContent contain">
  <section class="mainContent__content">
  	<div class="container">
	    <div class="tabbedContent__tabs">
	       <ul>
	        	<?php if($post_type == 'education'){ ?>
		          <?php if ($associatedShows_query->have_posts()) { ?>
			          <li data-tab="shows" class="tabbedContent__tab default">
			          	<a href="#shows">Shows</a>
			        	</li>
		        	<?php } ?>
	        	<?php } ?>

	        	<?php if($post_type == 'series' || $post_type == 'festival') { ?>
		          <?php if ($associatedFilms_query->have_posts()) { ?>
		          <li data-tab="films" class="tabbedContent__tab default">
		          	<a href="#films">Films</a>
		        	</li>
		        	<?php } ?>
	        	<?php } ?>

	        	<?php if($post_type == 'festival') { ?>
	        		<?php if ($associatedEvents_query->have_posts()) { ?>
		          <li data-tab="events" class="tabbedContent__tab default">
		          	<a href="#events">Events</a>
		        	</li>
		        	<?php } ?>
	        	<?php } ?>

	         	<li data-tab="overview" class="tabbedContent__tab active-link">
	          	<a href="#overview">Overview</a>
	        	</li>
	          <?php if( have_rows('tabs') ) { ?>
           	<?php while ( have_rows('tabs') ) { the_row(); ?>
            <?php
              $tab_name = get_sub_field('tab_name');
              $id_name = str_replace(' ', '-', $tab_name);
              $id_name = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $id_name));
    				?>          
            <li data-tab="<?php echo $id_name; ?>" class="tabbedContent__tab">
            	<a href="#<?php echo $id_name;?>">
                <?php echo $tab_name; ?>
            	</a>
          	</li>
    				<?php } //end while tabs ?>
            <?php } // end if tabs ?>
	       </ul> 
	    </div>
	    <!-- Generate content for all tabs -->
	    <div class="tabbedContent_contentWrapper">
	      <div class="tabbedContent__content overview">
	        <?php if( have_rows('overview') ) { ?>
	       	<?php while ( have_rows('overview') ) { the_row(); ?>
          <?php get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
	        <?php } //end while overview ?>
	        <?php } // end if overview ?>
	      </div>
	     	
	     	<?php if($post_type == 'education'){ 
	      	// get associated shows (films and events) with this education series
					if ($associatedShows_query->have_posts()) { ?>
	      		<div class="tabbedContent__content shows card__wrapper hide-tab-content">
							<?php 
								while ($associatedShows_query->have_posts()) { $associatedShows_query->the_post();
								  get_template_part('template-parts/event', 'thumbnail_card');
					  		} wp_reset_postdata(); // endwhile have_posts events_query
				  		?>
			      </div>
					<?php } ?>
      	<?php } // endif an education series ?>

      	<?php if($post_type == 'series' || $post_type == 'festival') {
 	      	// get associated films with this festival/series
					if ($associatedFilms_query->have_posts()) { ?>
 	      		<div class="tabbedContent__content films card__wrapper hide-tab-content">
							<?php 
								while ($associatedFilms_query->have_posts()) { $associatedFilms_query->the_post();
								  get_template_part('template-parts/event', 'thumbnail_card');
					  		} wp_reset_postdata(); // endwhile have_posts events_query
				  		?>
		 	      </div>
					<?php } ?>
      	<?php } // endif a festival/series ?>

      	<?php if($post_type == 'festival') {
					// get associated events with this festival
					if ($associatedEvents_query->have_posts()) { ?>
	 	      	<div class="tabbedContent__content events card__wrapper hide-tab-content">
							<?php 
								while ($associatedEvents_query->have_posts()) { $associatedEvents_query->the_post();
								  get_template_part('template-parts/event', 'thumbnail_card');
					  		} wp_reset_postdata(); // endwhile have_posts events_query 
							?>
	 	      	</div>
					<?php } ?>
      	<?php } // endif a festival ?>
        
	      <?php // using regex to replace tab names with valid id's for html
				if( have_rows('tabs') ) {
				while ( have_rows('tabs') ) { the_row();
          $tab_name = get_sub_field('tab_name');
          $id_name = str_replace(' ', '-', $tab_name);
          $id_name = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $id_name));
          $tab_content = get_sub_field('tab_content'); ?>  

          <div class='tabbedContent__content <?php echo $id_name ?> hide-tab-content'>
          	<?php get_template_part( 'template-parts/content-blocks/content-blocks' ); ?>
        	</div>
	    	<?php } // end while have_rows for tabs ?>
	    	<?php } // end if have_rows for tabs ?>
	  	</div>

	  	<div class="socialShare">
				<?php get_template_part('template-parts/part', 'social_sharing'); ?>						
			</div>
	  </div>
  </section> <!-- Main Content Content end -->
  <aside class="mainContent__sidebar">
  	<div class="container">
  		<div class="sidebar__tickets">
	  		<?php if (get_field('event_areticketsbeingsold')){ ?>
	        <?php get_template_part('template-parts/event', 'ticket_buttons'); ?>
	  		<?php } ?>
      
        <div class="sidebar__eventInfo">
				  <?php if($dateString){ ?>
			  	<p><i class="far fa-calendar-alt"></i><?php echo $dateString; ?></p>
			  	<?php } else { ?>
			  	<p><i class="far fa-calendar-alt"></i>Dates To Be Announced</p>
		  		<?php } ?>

		    	<?php // EVENT LOCATION ?>
	       	<?php if($event_location != null){ ?>
					<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
       		<?php } // end event_location ?>
	       	
	       	<?php get_template_part( 'template-parts/event', 'ticket_prices' ); ?>
		    </div>
  		</div>
   		
   		<?php 
	    	$sidebar_menu = get_field('sidebar_menu'); 
	    	$sidebar_menu_title = get_field('sidebar_menu_title'); 
	  	?>
	   	<?php if($sidebar_menu){ ?>
	    <div class="sidebar__menus">
				<div class="sidebar__menu">
					<?php if ($sidebar_menu_title){ ?>
					<p class="h3"><?php echo $sidebar_menu_title; ?></p>
					<?php } //endif ?>				
					<?php echo $sidebar_menu; ?>
				</div>
			</div>
			<?php } // endif sidebar menus ?>
	   	
	    <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
	    <?php get_template_part( 'template-parts/event', 'external_links' ); ?>

	    <?php 
	    	$additional_text = get_field('sidebar_additional_text');
	   		if($additional_text){
	   	?>
	    <div class="sidebar__text">
	    	<p class="small"><?php echo $additional_text; ?><p>
	    </div>
	    <?php } // endif additional text ?>
    </div>
  </aside>
</div>
<?php } // endwhile; ?>
<?php get_footer(); ?>