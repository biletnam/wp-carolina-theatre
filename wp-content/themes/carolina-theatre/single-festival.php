<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); ?>
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
	    <!-- Generate all tabs, show only highlighted tab content -->
	    <div class="tabbedContent_contentWrapper">
	      <div class="tabbedContent__content overview">
	          <?php if (have_rows("overview")) {
	            while (have_rows("overview")) {
	              the_row();
	                get_template_part( 'blocks/content-blocks' );
	            }
	          } ?>
	      </div>
	      <div class="tabbedContent__content films hide-tab-content">
	        <?php // film tab contents
	        $meta_query_args = array(
	            'post_type' => 'film',
	            'meta_query' => array (array(
	                'key'     => 'associated_events',
	                'value'   => get_the_id(),
	                'compare' => '='
	                )
	            )
	        );
	        $meta_query = new WP_Query( $meta_query_args );
	        if ($meta_query->have_posts()) {
	          while ($meta_query->have_posts()) { $meta_query->the_post();
	            $start_date_string = get_field('start_date');
	            $end_date_string = get_field('end_date');
	            echo get_post_type(); ?>
	            <!-- single film card -->
	            <div class="event-card__front card">
	                <div class="event-image-container">
	                    <img src="<?php  echo get_field('event_image')["url"];?>"
	                        alt="death proof poster" />
	                    <div class="event-date">
	                        <?php if ($start_date_string == $end_date_string) {
	                            echo $start_date_string;
	                        } else {
	                            echo "$start_date_string - $end_date_string";
	                        } ?>
	                    </div>
	                </div>
	                <div class="event-content-container">
	                    <p><?php the_field('single_event_type');?></p>
	                    <h3><?php the_title();?></h3>
	                    <p><?php the_content();?></p>
	                    <p><i class="fa fa-map-marker"></i><?php the_field('location'); ?></p>
	                    <p>
	                        <i class="fas fa-ticket-alt"></i>
	                        <?php 
	                            $prices = array();
	                            if (have_rows('ticket_prices')) {
	                                while (have_rows('ticket_prices')) {
	                                    the_row();
	                                    $price = get_sub_field('price');
	                                    array_push($prices, $price);
	                                }
	                            }
	                            echo '$ ' . join(", ", $prices);
	                        ?>
	                    </p>
	                    <p>
	                        <i class="fas fa-calendar-alt"></i>
	                                <?php 
	                                    if ($start_date_string == $end_date_string) {
	                                        echo $start_date_string;
	                                    } else {
	                                        echo "$start_date_string - $end_date_string";
	                                    }
	                                ?>
	                    </p>
	                    <p><a href="<?php echo get_page_link(get_the_id()); ?>"><button>More Info</button></a></p>
	                </div>
	            </div>
	        	<?php } // end while meta_query for films ?>
	        <?php } // end if meta_query for films ?>
	        <?php wp_reset_postdata(); ?>
	      </div>
	      <?php // using regex to replace tab names with valid id's for html
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
                  <i class="fa fa-ticket" aria-hidden="true"></i>
                  $12
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
          <div class="upcoming-events__cta-card">
              <h2>Plan Your Visit >></h2>
              <p>What to Bring, Where to Eat, Where to Stay, Parking and more...</p>
          </div>
      </div>
      <div class="festival-sidebar__additional-links">
          <ul>
              <?php
                  $files = get_field('additional_resources');

                  if (have_rows('additional_resources')) {
                      while(have_rows('additional_resources')) {
                          the_row();
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