<?php
	// Template name: News Template
	get_header();
?>
<div class="news-wrapper">
	<h2>News and Press</h2>
	<section class="featured-story clearfix"> <!-- clearfix for floated __image and __content divs -->
		<div class="featured-story__image">
			<img src="https://i.ytimg.com/vi/-0hGNj5W7aU/maxresdefault.jpg" alt="live performance of event"/>
		</div>
		<div class="featured-story__content ">
			<p>I'm some content</p>
		</div>
	</section>
	<div class="news-content__wrapper clearfix">
		<section class="news-articles">
			<div class="news-articles__wrapper clearfix">
				<?php
					$news_query_args = array(
						'post_type' => 'post'
					);
					$news_query = new WP_Query($news_query_args);

					if ($news_query->have_posts()) {
						while ($news_query->have_posts()) {
							$news_query->the_post();
						?>
							<div class="news-articles__card">
								<h5>
									<?php echo get_the_title(); ?>
								</h5>
								<p><?php echo get_the_date() . ' ' . get_the_time(); ?></p>
								<p class="news-articles__card-text"><?php echo get_the_content(); ?></p>
							</div>
						<?php
						}
					}
					wp_reset_postdata();
				?>
				
				<div class="news-articles__card">Newsworthy 2</div>
				<div class="news-articles__card">Newsworthy 3</div>
				<div class="news-articles__card">Newsworthy 4</div>
				<div class="news-articles__card">Newsworthy 5</div>
				<div class="news-articles__card">Newsworthy 6</div>
			</div>
		</section> <!-- end .news-articles -->
		<section class="news-sidebar">
			<div class="news-sidebar__content">
				<div class="news-sidebar__recent-posts">
					<h3>Recent Posts</h3>
					<?php
						$counter = 0;
						if ($news_query->have_posts()) {
							while ($news_query->have_posts() && $counter < 3) {
								$news_query->the_post();
							?>
								<p><?php echo get_the_title(); ?></p>
							<?php
								$counter++;
							}
						}
						wp_reset_postdata();
					?>
				</div>
				<div class="news-sidebar__archives">
					<h3>Archives</h3>
					<select name="archive" id="archive">
						<option value="select">Select a Month...</option>
						<option value="May 2018">May 2018</option>
						<option value="April 2018">April 2018</option>
						<option value="March 2018">Marh 2018</option>
						<option value="February 2018">February 2018</option>
						<option value="January 2018">January 2018</option>
						<option value="Dec 2018">Dec 2018</option>
						<option value="Nov 2018">Nov 2018</option>
					</select>
				</div>
				<div class="news-sidebar__categories">
					<h3>Categories</h3>
					<ul>
						<li>Upcoming Shows</li>
						<li>Deals &amp; Presales</li>
						<li>Theatre News</li>
						<li>CTD in the Press</li>
					</ul>
				</div>
				<?php
					if (have_rows("call_to_action_card")) {
						while (have_rows("call_to_action_card")) {
							the_row();
							$title = get_sub_field("title");
							$content = get_sub_field("content");
							$link = get_sub_field("link");
						?>
							<div class="news-sidebar__cta">
								<h3><?php echo $title; ?></h3>
								<?php echo $content; ?>
								<a href="<?php echo $link['url']; ?>">
									<?php echo $link['title']; ?>
								</a>
							</div>
						<?php
						}
					}
					wp_reset_postdata();
				?>
			</div> <!-- end .news-sidebar__content -->
		</section> <!-- end .news-sidebar -->
	</div> <!-- end .news-content__wrapper -->
</div> <!-- end .news-wrapper -->
<?php get_footer(); ?>