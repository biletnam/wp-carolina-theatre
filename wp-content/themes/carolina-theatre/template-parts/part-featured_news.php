<?php 
// TO-DO: get this fixed and pulling in the corect data
	$featured = get_field('featured_post');
	$featured_ID = $featured->ID; 
?>
<?php if ($featured != null) { ?>
<div class="featuredPost event">
	<div class="featuredEvent__slideContainer">
		<?php 
			// $image = get_the_post_thumbnail( $featured_ID, 'hero-small' );

			$image_url = get_the_post_thumbnail_url($featured_ID, 'hero-small');
			if($image_url == null){
  			$image_url = get_stylesheet_directory_uri().'/src/img/no-event-image-full.jpg';
			}
      ?>
		<div class="featuredEvent__image" style="background-image:url(<?php echo $image_url; ?>);">
			<div class="event__dateBox">
				<span class="day"><?php echo get_the_date('j', $featured_ID); ?></span>
				<span class="month"><?php echo get_the_date('M', $featured_ID); ?></span>
	    </div>
			
	 		<img src="<?php echo $image_url; ?>"/>	
    </div>
    <div class="featuredEvent__info">
      <div class="container">
      	<h5><?php echo get_the_date('F j', $featured_ID); ?></h5>
        <h3><?php echo get_the_title($featured_ID); ?></h3>

        <div class="card__info">
        	<p class="small">
        	<?php if(empty( $featured->post_excerpt)){
				    echo wp_trim_words( $featured->post_content, 40 );
					} else {
				    echo $featured->post_excerpt; 
					} ?>
					</p>
				</div>

				<a href="<?php the_permalink($featured_ID); ?>" class="button secondary">Read More</a>
        <?php if(get_the_category($featured_ID)){ ?>
				<div class="card__categories">
					<i class="far fa-tag"></i>
					<?php if(get_the_category($featured_ID)){ echo ' <em>'; the_category( ', ', '', $featured_ID ); echo '</em>'; } ?>
				</div>
        <?php } ?>
    	</div>
    </div>
  </div> 
</div> 
<?php } ?>