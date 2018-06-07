<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>

<?php if(get_field('show_hero_slider')){ ?>
<?php get_template_part( 'template-parts/slider', 'page_hero' ); ?>
<?php } ?>

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
	  </div>
  </section> <!-- Main Content Content end -->
  
  <aside class="mainContent__sidebar"> <!-- Sidebar start -->
    <div class="container">
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

	    <?php get_template_part( 'template-parts/event', 'external_links' ); ?>
	    <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
	  </div>
  </aside>  <!-- Sidebar end -->
</div>
<?php } // endwhile; ?>
<?php get_footer(); ?>