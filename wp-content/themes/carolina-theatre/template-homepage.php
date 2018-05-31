<?php
// Template name: Homepage Template
get_header();

?>
<?php while ( have_posts() ) { the_post(); ?>
<div class="hero--homepage">
	<section class="heroSlider heroSlider--homepage">
    <?php if (have_rows("slider")) { ?>
      <?php while (have_rows("slider")) { the_row(); ?>
      	<?php $image = get_sub_field("image"); ?>
        <div class="heroSlider__slide" data-thumb="<?php echo $image['sizes']['thumbnail']; ?>" style="background-image:url(<?php echo $image['url']; ?>);">
          <div class="heroSlider__slideContent">
          	<div class="contain container">
          		<?php echo get_sub_field("content"); ?>
          	</div>
          </div>
        </div>
      <?php } // endwhile ?>
    <?php } // end if ?>
  </section>  
  <?php if (have_rows("statistics")) { ?>
		<?php // get how many stats there are for styling
    	$statistics = get_field_object("statistics");
			$statistics_count = (count($statistics["value"]));
		?>
    <aside class="statistics statistics--<?php echo $statistics_count; ?>">
      <?php while (have_rows("statistics")) { the_row(); ?>
        <a href="<?php echo get_sub_field("link")["url"]; ?>" class="statistic">
      		<div class="statistic__back">
            <p class="stat_link"><?php echo get_sub_field("hover_description"); ?></p>
          </div>
          <div class="statistic__front">
            <p class="stat_value"><?php echo get_sub_field("stat_value"); ?></p>
            <p class="stat_description"><?php echo get_sub_field("stat_description") ?></p>
          </div>
        </a>
      <?php } // endwhile ?>
    </aside>
	<?php } // end if ?>
</div>
<section class="hp-upcoming">
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
</section>
<section class="hp-ctaCards">
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
</section>
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
