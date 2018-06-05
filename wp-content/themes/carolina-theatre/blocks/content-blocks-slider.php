<?php $uniqueID = 0; ?>
<?php if (have_rows('panel_content')) { ?>

	<div class="block__slider">
		<div class="carousel" >
			<?php while (have_rows('panel_content')) { the_row(); ?>
		  	<?php // make sure first row has an image to determine if slider is actually used.  ?>
				<?php $anyImages = get_field('panel_content')[0]['image']; ?>
				<?php if ($anyImages) { ?>	
					<?php 
					  $uniqueID++;
					  $media_type = get_sub_field('media_type'); 
						$embedCode = get_sub_field('video_embed');

						$image = get_sub_field('image');
						$image_full = $image['sizes']['hero-small'];
						$image_alt = $image['alt'];
						$image_cap = $image['caption'];
				  ?>
				  <div>
				  <?php if ($media_type == 'image') { ?>
			     	<div class="image_wrapper">
			      	<img src="<?php echo $image_full; ?>" alt="<?php echo $image_alt; ?>" />
			      </div>
			      <?php if($image_cap) { ?>
			      	<figcaption class="small caption"><?php echo $image_cap; ?></figcaption>
			      <?php } ?>
				  <?php } else if ($media_type == 'video') { ?>
				    <a href="<?php echo '.sliderContent-' . $uniqueID; ?>" data-featherlight>
	            <div class="image_wrapper">
	            	<i class="fas fa-play"></i>
				      	<img src="<?php echo $image_full; ?>" alt="<?php echo $image_alt; ?>" />
				      </div>
				      <?php if($image_cap) { ?>
				      	<figcaption class="small caption"><?php echo $image_cap; ?></figcaption>
				      <?php } ?>
				    </a>
				    <div class="gallery-content <?php echo 'sliderContent-' . $uniqueID; ?>">
				      <div class="video"><?php echo $embedCode; ?></div>
				    </div>
				  <?php } // end if image or video ?>
	        </div>
				<?php } else { ?>
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/src/img/no-event-image-full.jpg" alt="No Event Image to Show">
				<?php } // endif $anyimages ?>
	  	<?php } // end while ?> 
	  </div>
	</div>
<?php } // end if ?> 

