<?php
// Template name: Homepage Template
get_header();

?>
<?php while ( have_posts() ) { the_post(); ?>
<div class="hero-block">
  <div class="hero-block__slider-wrapper clearfix">
		<div class="hero-block__slider">
      <?php if (have_rows("slider")) { ?>
        <?php while (have_rows("slider")) { the_row(); ?>
          <div class="hero-block__card">
            <img 
                src="<?php echo get_sub_field("image")['url']; ?>" 
                alt="<?php echo get_sub_field("image")['alt']; ?>"
            />
            <div class="hero-block__card--content">
              <?php echo get_sub_field("content"); ?>
            </div>
          </div>
        <?php } // endwhile ?>
      <?php } // end if ?>
    </div>
      
    <div class="hero-block__stats">
      <?php if (have_rows("statistics")) { ?>
        <ul>
          <?php while (have_rows("statistics")) { the_row(); ?>
            <li class="hero-block__stats-item">
              <div class="hero-block__stats--normal">
                <p><?php echo get_sub_field("stat_value"); ?></p>
                <p><?php echo get_sub_field("stat_description") ?></p>
              </div>
              <div class="hero-block__stats--hover">
                <p><?php echo get_sub_field("hover_description"); ?></p>
                <p><a href="<?php echo get_sub_field("link")["url"]; ?>"><?php echo get_sub_field("link")["title"]; ?> Link</a></p>
              </div>
            </li>
          <?php } // endwhile ?>
      	</ul>
  		<?php } // end if ?>
    </div>
  </div>
  <div class="hero-block__slider--nav clearfix">
    <div class="hero-block__slider--arrows">
      <?php $slide_number = 1; ?>
      <?php if (have_rows("slider")) { ?>
        <?php while (have_rows("slider")) { the_row(); ?>
        <?php // go-to slide on button click: https://codepen.io/vilcu/pen/ZQwdGQ ?>
          <div class="hero-block__btn-block">
            <button class="hero-block__go-to-btn" data-slide="<?php echo $slide_number; ?>">
                Slide <?php echo $slide_number; ?>
            </button>
            <img 
                class="hero-block__thumbnail" 
                src="<?php echo get_sub_field("image")["sizes"]["thumbnail"]; ?>" 
                alt="small poster of event"/>
          </div>
          <?php $slide_number++; ?>
        <?php } // endwhile ?>
      <?php } // end if ?>
    </div>
	</div>
</div>
<div class="hp-upcoming">
  <div class="container contain">
  	<h2>Upcoming Events</h2>
    <div class="cardSlider">
      <?php // The Query
      	// TO-DO: Filter event showtimes within ARGS
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $limit = 5;
				$events_query_args = array(
					'post_type' => array('event', 'film'),
					'post_status' => 'publish',
					// 'posts_per_page' => $limit,
					// 'paged' => $paged,
					'meta_query' => array(
					  'start_clause' => array('key' => 'start_date'),
					  'end_clause' => array('key' => 'end_date')
					),
					'orderby' => array(
					  'relation' => 'AND',
					  'start_clause' => 'ASC',
					  'end_clause' => 'ASC'
					),
				);

				// The Loop
				$events_query = new WP_Query($events_query_args);
				if ($events_query->have_posts()) {
					while ($events_query->have_posts()) { $events_query->the_post(); ?>
					  <?php get_template_part('blocks/event', 'card'); ?>
		  		<?php } // endwhile have_posts events_query ?>
				<?php wp_reset_postdata(); // Restore original Post Data
				} else {
				echo 'No events at this time';
				} // endif have_posts events_query
			?>
    </div>
    <div class="cardSlider__nav">
      <a href="/events" class="button gray">See All Events</a>
      <div class="cardSlider__arrows"></div>
  	</div>
</div>
<div class="hp-ctaCards">
    <?php
        if (have_rows("call_to_action_card")) {
            while (have_rows("call_to_action_card")) {
                the_row();    
            ?>
	            	<?php //get_template_part( 'blocks/content-blocks', 'link-block' ); ?>
                <div class="cta__card">
                    <h2><?php echo get_sub_field("title"); ?></h2>
                    <p>
                        <?php echo get_sub_field("content") . ' '; ?>
                        <a href="<?php echo get_sub_field("link")["url"];?>">
                            <?php echo get_sub_field("link")["title"]; ?>
                        </a>
                    </p>
                </div>
            <?php
            }
        }

    ?>
</div>

<section class="hp-news">
	<div class="container contain">
		<h2>New &amp; Press</h2>
		<?php // TO-DO: get Posts pulled in here ?>
	  <div class="cardSlider">
	      <div class="cardSlider__card">
	          <img 
	              src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260"
	              alt="landscape on the lake in fall"
	          />
	      </div>
	      <div class="cardSlider__card">
	          <img 
	              src="https://static.boredpanda.com/blog/wp-content/uploads/2015/11/reflection-landscape-photography-jaewoon-u-36.jpg"
	              alt="landscape on the lake in fall"
	          />
	      </div>
	      <div class="cardSlider__card">Panel 3</div>
	      <div class="cardSlider__card">Panel 4</div>
	      <div class="cardSlider__card">Panel 5</div>
	      <div class="cardSlider__card">Panel 6</div>
	      <div class="cardSlider__card">Panel 7</div>
	      <div class="cardSlider__card">Panel 8</div>
	      <div class="cardSlider__card">Panel 9</div>
	      <div class="cardSlider__card">Panel 10</div>
	  </div>
	  <div class="cardSlider__nav">
	      <a href="#" class="button gray">See All News</a>
	      <div class="cardSlider__arrows"></div>
	  </div>
	</div>
</section>
<?php } // endwhile; ?>
<?php
get_footer();
?>
