<?php
	// Template name: Events Template
	get_header();
  date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));
?>
<?php while ( have_posts() ) { the_post(); ?>

<?php if(get_field('featured_events')){ ?>
<section class="featuredEvent_carousel">
  <div class="container contain">
  	<h1>Featured Events</h1>
    <?php get_template_part('template-parts/slider', 'featured_events'); ?>
  </div>
</section>
<?php } //end if any featured events ?>
<section class="mainContent upcoming-events contain" id="upcoming-events">
  <div class="mainContent__content">
    <div class="container">
      <h1>Upcoming Events</h1>
			<div id="event-filter" class="tabbedContent__tabs">
			  <?php echo get_event_filters(); ?>
			</div>
			<div class="events" id="event-results"></div>
		</div>
	</div>
	<?php get_sidebar('events'); ?>
</section>
<?php } // endwhile; ?>

<?php get_footer(); ?>