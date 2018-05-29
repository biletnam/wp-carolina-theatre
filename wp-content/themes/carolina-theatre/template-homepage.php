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
        <?php
        // sort all films and events by start_date and then end_date
         $upcoming_query_args = array(
            'post_type' => array('film', 'event'),
            'meta_query' => array(
                "start" => array("key" => "start_date"),
                "end" => array("key" => "end_date")
            ),
            'orderby' => array(
                    "start" => "ASC",
                    "end" => "ASC"
                )
            );
        
        $upcoming_query = new WP_Query($upcoming_query_args);
        $count = 0;
        if ($upcoming_query->have_posts()) {
            while ($upcoming_query->have_posts()) {
                $upcoming_query->the_post();
                $today = strtotime("today");
                $end_date = strtotime(get_field("end_date"));
                
                // construct html for events with an end_date of today or in the future
                // limit upcoming events to 10
                if ($end_date >= $today && $count < 10) {
                ?>
                    <div class="cardSlider__card">
                        <h3><?php echo get_the_title(); ?></h3>
                        <p><?php echo get_field("start_date") . " - " . get_field("end_date"); ?></p>
                    </div>
                <?php
                    // only increment if end_date is today or in the future
                    // not incrementing for events that have been returned by the query but are
                    // in the past
                    $count++;
                }
            }  
        }
        wp_reset_postdata();
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
