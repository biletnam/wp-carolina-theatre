<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php get_template_part( 'blocks/content', 'breadcrumb' ); ?>

<section class="hero-container contain container">
  <div class="carousel carousel__images">
    <?php if (have_rows('hero_images')) { ?>
			<?php while (have_rows('hero_images')) { the_row(); ?>
				<div>
					<img src="<?php echo get_sub_field('image')['url']; ?>" alt="<?php echo get_sub_field('image')['alt']; ?>" class="hero-slider__image">
				</div>
			<?php } // end while ?>
     <?php  } // end if; ?>
  </div>
</section>
<section class="pageHeader contain">
	<div class="container">
	  <p class="date">
      <i class="far fa-calendar-alt" aria-hidden="true"></i> <?php echo get_field('start_date') . ' - ' . get_field('end_date'); ?>
	  </p>
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
	        	<?php if( have_rows('tabbed_content') ) { ?>
           	<?php while ( have_rows('tabbed_content') ) { the_row(); ?>
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
            <?php } //end while tabbed_content ?>
            <?php } // end if tabbed_content ?>
	       </ul> 
	    </div>
	    <!-- Generate content for all tabs -->
	    <div class="tabbedContent_contentWrapper">
	      <div class="tabbedContent__content overview">
          <?php if( have_rows('tabbed_content') ) { ?>
           	<?php while ( have_rows('tabbed_content') ) { the_row(); ?>
	          <?php if( have_rows('overview') ) { ?>
           	<?php while ( have_rows('overview') ) { the_row(); ?>
              <?php get_template_part( 'blocks/content', 'blocks' ); ?>
            <?php } //end while overview ?>
            <?php } // end if overview ?>
            <?php } //end while tabbed_content ?>
            <?php } // end if tabbed_content ?>
	      </div>
	      <div class="tabbedContent__content films card__wrapper hide-tab-content">
	        <?php // get associated films with this festival
					$associatedFilms_query_args = array(
						'post_type' 			=> array('film'),
						'post_status' 		=> 'publish',
						'posts_per_page' 	=> -1,
						'meta_query' 			=> array ( 
							array(
	              'key'     				=> 'associated_event',
	              'value'   				=> get_the_id(),
	              'compare' 				=> '=',
	              'start_clause' 		=> array('key' => 'start_date'),
							  'end_clause' 			=> array('key' => 'end_date')
              )
            ),
						'orderby' 				=> array(
						  'relation' 				=> 'AND',
						  'start_clause'		=> 'ASC',
						  'end_clause' 			=> 'ASC'
						),
					);

					// The Loop
					$associatedFilms_query = new WP_Query($associatedFilms_query_args);
					if ($associatedFilms_query->have_posts()) {
						while ($associatedFilms_query->have_posts()) { $associatedFilms_query->the_post(); ?>
						  <?php get_template_part('blocks/event', 'card'); ?>
			  		<?php } // endwhile have_posts events_query ?>
					<?php wp_reset_postdata(); // Restore original Post Data
					} else {
					echo '<div><h2>No Films Yet.</h2><p>Check back for updates!</p></div>';
					} // endif have_posts events_query
				?>
	      </div>
	      <?php // using regex to replace tab names with valid id's for html
				if( have_rows('tabbed_content') ) {
				while ( have_rows('tabbed_content') ) { the_row();
				if( have_rows('tabs') ) {
				while ( have_rows('tabs') ) { the_row();
          $tab_name = get_sub_field('tab_name');
          $id_name = str_replace(' ', '-', $tab_name);
          $id_name = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $id_name));
          $tab_content = get_sub_field('tab_content'); ?>  

          <div class='tabbedContent__content <?php echo $id_name ?> hide-tab-content'>
          	<?php get_template_part( 'blocks/content-blocks' ); ?>
        	</div>
	    	<?php } // end while have_rows for tabs ?>
	    	<?php } // end if have_rows for tabs ?>
	    	<?php } // end while have_rows for tabbed_content ?>
	    	<?php } // end if have_rows for tabbed_content ?>
	  	</div>
	  </div>
  </section> <!-- Main Content end -->
  
  <aside class="mainContent__sidebar"> <!-- Sidebar start -->
    <div class='festival-sidebar__btn'>
        <button>Buy Tickets</button>
    </div>
    <div class="festival-sidebar__ticket-info">
        <ul>
          <li>
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <?php echo get_field('start_date') . ' - ' . get_field('end_date'); ?>
          </li>
          <li>
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <?php
                $locations = get_field('location');
                echo join(', ', $locations);
            ?>
          </li>
          <li>
          	<?php // TO-DO: tickets ?>
            <i class="fa fa-ticket" aria-hidden="true"></i> $12
          </li>
        </ul>
        <div class="festival-sidebar__links">
          <h3>Get Involved</h3>
          <ul>
              <li>Become a Volunteer >></li>
              <li>Support the Festival >></li>
              <li>Contact &amp; Media Kit >></li>
          </ul>
        </div>
        <div class="cta__card">
          <a href="">
          	<h3>Plan Your Visit ››</h3>
	          <p>What to Bring, Where to Eat, Where to Stay, Parking and more...</p>
          </a>
        </div>
    </div>
    <div class="festival-sidebar__additional-links">
      <ul>
        <?php
          $files = get_field('additional_resources');

          if (have_rows('additional_resources')) {
            while(have_rows('additional_resources')) { the_row();
              $href = "";
              $file = get_sub_field('file_link');
              if ($file['add_file_by'] == 'File URL') {
                  $href = $file['file_url'];
              } else if ($file['add_file_by'] == "Upload a File") {
                  $href = $file['upload_file'];
              }
 						 	?>
              <li>
                  <a target="_blank" href="<?php echo $href ?>">
                  <i class="fa fa-file-text-o" aria-hidden="true"></i>
                  <?php echo $file['link_text']; ?>
                  </a>
              </li> 
    				<?php     
            }
          }
        ?>
      </ul>
    </div>
  </aside>  <!-- Sidebar end -->
</div>
<?php } // endwhile; ?>
<?php get_footer(); ?>