<div class="cardSlider">
  <?php // The Query
    $limit = 8;
		$news_query_args = array(
			'post_type' 			=> 'post',
			'post_status' 		=> 'publish',
			'posts_per_page' 	=> $limit,
			'orderby' 				=> 'date',
			'order' 					=> 'DESC'
		);

		// The Loop
		$news_query = new WP_Query($news_query_args);
		if ($news_query->have_posts()) {
			while ($news_query->have_posts()) { $news_query->the_post(); ?>
			  <?php get_template_part('template-parts/news', 'thumbnail_card'); ?>
  		<?php } // endwhile have_posts news_query ?>
		<?php wp_reset_postdata(); // Restore original Post Data
		} else {
		echo 'No news at this time.';
		} // endif have_posts news_query
	?>
</div>
<div class="cardSlider__nav">
  <a href="/news" class="button gray">See All News</a>
  <div class="cardSlider__arrows"></div>
</div>