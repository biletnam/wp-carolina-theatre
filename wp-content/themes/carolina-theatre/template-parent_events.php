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
?>

<section class="pageHeader contain">
	<div class="container">
	  <p class="date"><i class="far fa-calendar-alt"></i><?php echo $dateString; ?></p>
	  <h1><?php the_title(); ?></h1>
  </div>
</section>

<div class="mainContent contain">
  <section class="mainContent__content">
  	<div class="container">
	    <div class="tabbedContent__tabs">
	       <ul>
	         	<li data-tab="overview" class="tabbedContent__tab active-link">
	          	<a href="#overview">Overview</a>
	        	</li>
	          <li data-tab='films' class="tabbedContent__tab">
	          	<a href="#films">Films</a>
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
	      <div class="tabbedContent__content films card__wrapper hide-tab-content">
	        <?php // get associated films with this festival
					$associatedFilms_query_args = array(
						'post_type' => array('event', 'film'),
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

					// The Loop
					$associatedFilms_query = new WP_Query($associatedFilms_query_args);
					if ($associatedFilms_query->have_posts()) {
						while ($associatedFilms_query->have_posts()) { $associatedFilms_query->the_post(); ?>
						  <?php get_template_part('template-parts/event', 'thumbnail_card'); ?>
			  		<?php } // endwhile have_posts events_query ?>
					<?php wp_reset_postdata(); // Restore original Post Data
					} else {
					echo '<div><h2>No Films Yet.</h2><p>Check back for updates!</p></div>';
					} // endif have_posts events_query
				?>
	      </div>
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
        <?php get_template_part('template-parts/event', 'ticket_buttons'); ?>
      
        <div class="sidebar__eventInfo">
				  <p><i class="far fa-calendar-alt"></i><?php echo $dateString; ?></p>

		    	<?php // EVENT LOCATION ?>
	       	<?php if($event_location != null){ ?>
					<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
       		<?php } // end event_location ?>
	       	
	       	<?php get_template_part( 'template-parts/event', 'ticket_prices' ); ?>
		    </div>
  		</div>
   	
   		<?php // TO-DO: Add sidebar menu ?>
			<div><h3>sidebar menu</h3></div>

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