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
            <div class="vertical-center">
            	<p class="stat_link"><?php echo get_sub_field("hover_description"); ?><i class="fas fa-arrow-right"></i></p>
            </div>
          </div>
          <div class="statistic__front">
          	<div class="vertical-center">
          		<p class="stat_value"><?php echo get_sub_field("stat_value"); ?></p>
            	<p class="stat_description"><?php echo get_sub_field("stat_description") ?></p>
          	</div>
          </div>
        </a>
      <?php } // endwhile ?>
    </aside>
	<?php } // end if ?>
</div>
<section class="hp-upcoming">
  <div class="container contain">
  	<h2>Upcoming Events</h2>
    <?php get_template_part( 'template-parts/slider', 'upcoming_events' ); ?>
  </div>
</section>
<section class="hp-ctaCards">
	<div class="container contain">
		<?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
	</div>
</section>
<section class="hp-news">
	<div class="container contain">
		<h2>New &amp; Press</h2>
    <?php get_template_part( 'template-parts/slider', 'latest_news' ); ?>
	</div>
</section>
<?php } // endwhile; ?>
<?php
get_footer();
?>
