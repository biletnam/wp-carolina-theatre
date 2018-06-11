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
			  <div class="card newsCard">
			  	<a href="<?php echo get_page_link(get_the_id()); ?>">
				  	<div class="card__infoWrapper">
							<p class="card__subtitle h5"><?php echo get_the_date('F j'); ?></p>
							<p class="card__title"><?php the_title(); ?></p>
							<div class="card__info">
								<p class="card__excerpt small"><?php the_excerpt(); ?></p>	
							</div>
	          </div>
			      <div class="button card__button"><span>Read More <i class="fas fa-arrow-right"></i></span></div>
			    </a>
			  </div>
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