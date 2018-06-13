<?php 
// TO-DO: get this fixed and pulling in the corect data
	$featured = get_field('featured_post');
	$featured_ID = $featured->ID; 
?>
<?php if ($featured != null) { ?>
<div class="featuredPost event">
	<div class="featuredEvent__slideContainer">
		<?php 
			$image_url = get_the_post_thumbnail_url( 'hero-small' , $featured_ID);
			if($image_url == null){
  			$image_url = get_stylesheet_directory_uri().'/src/img/no-event-image-full.jpg';
			}
      ?>
		<div class="featuredEvent__image" style="background-image:url(<?php echo $image_url; ?>)">
			<div class="event__dateBox">
				<span class="day"><?php echo get_the_date('j'); ?></span>
				<span class="month"><?php echo get_the_date('M'); ?></span>
	    </div>
			
	 		<img src="<?php echo $image_url; ?>" />	
    </div>
    <div class="featuredEvent__info">
      <div class="container">
      	<h5><?php echo get_the_date('F j'); ?></h5>
        <h3><?php echo get_the_title($featured_ID) ?></h3>
        <p><?php echo get_the_excerpt($featured_ID); ?></p>
        <a href="<?php the_permalink($featured_ID); ?>" class="button secondary">Read More</a>
    	</div>
    </div>
  </div> 
</div> 
<?php } ?>