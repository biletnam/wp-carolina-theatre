<?php global $sliderCount; ?>
<?php if (have_rows('panel_content')) { ?>
	<?php while (have_rows('panel_content')) { the_row(); ?>
  	<?php // make sure first row has an image to determine if slider is actually used.  ?>
		<?php $image = get_sub_field('image');
		if ($image) { ?>	
			<?php 
			  $sliderCount++;
			  $media_type = get_sub_field('media_type'); 
				$embedCode = get_sub_field('video_embed');

				$image_full = $image['sizes']['hero-small'];
				$image_thumb = $image['sizes']['thumbnail'];
				$image_alt = $image['alt'];
				// $image_cap = $image['caption'];
		  ?>
		  <div data-thumb="<?php echo $image_thumb; ?>">
		  <?php if ($media_type == 'image') { ?>
	     	<div class="image_wrapper">
	      	<img src="<?php echo $image_full; ?>" alt="<?php echo $image_alt; ?>" />
	      </div>
	      <?php //if($image_cap) { ?>
	      	<!-- <figcaption class="small caption"><?php echo $image_cap; ?></figcaption> -->
	      <?php //} ?>
		  <?php } else if ($media_type == 'video') { ?>
		    <a href="<?php echo '.sliderContent-' . $sliderCount; ?>" data-featherlight>
          <div class="image_wrapper">
          	<i class="fas fa-play"></i>
		      	<img src="<?php echo $image_full; ?>" alt="<?php echo $image_alt; ?>" />
		      </div>
		      <?php //if($image_cap) { ?>
		      	<!-- <figcaption class="small caption"><?php echo $image_cap; ?></figcaption> -->
		      <?php //} ?>
		    </a>
		    <div class="gallery-content <?php echo 'sliderContent-' . $sliderCount; ?>">
		      <div class="video"><?php echo $embedCode; ?></div>
		    </div>
		  <?php } // end if image or video ?>
      </div>
		<?php } else { ?>
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/src/img/no-event-image-full.jpg" alt="No Event Image to Show">
		<?php } // endif $image ?>
	<?php } // end while ?> 
<?php } else { ?>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/src/img/no-event-image-full.jpg" alt="No Event Image to Show">
<?php } // end if ?> 