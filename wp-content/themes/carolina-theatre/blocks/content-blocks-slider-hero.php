<?php $uniqueID = 0; ?>
<?php if (have_rows('panel_content')) { ?>
<section class="pageHero contain container block__slider">
	<div class="heroSlider">
		<?php while (have_rows('panel_content')) { the_row(); ?>
		  <?php 
			  $uniqueID++;
			  $media_type = get_sub_field('media_type');
				$embedCode = get_sub_field('video_embed');

        $image = get_sub_field('image'); 
        $image_full = $image['sizes']['hero-default'];
				$image_thumb = $image['sizes']['thumbnail'];
				$image_alt = $image['alt'];
				$image_cap = $image['caption'];
      ?>
      
	    <?php if ($media_type == 'image') { ?>
        <div data-thumb="<?php echo $image_thumb; ?>" >
        	<img src="<?php echo $image_full; ?>" alt="<?php echo $image_alt; ?>" />
       	</div>
    	<?php } else if ($media_type == 'video') { ?>
        <div data-thumb="<?php echo $image_thumb; ?>" >
        	<a href="<?php echo '.sliderContent-' . $uniqueID; ?>" data-featherlight>
            <i class="fas fa-play"></i>
						<img src="<?php echo $image_full; ?>" alt="<?php echo $image_alt; ?>" />
			    </a>
			    <div class="gallery-content <?php echo 'sliderContent-' . $uniqueID; ?>">
			      <div class="video"><?php echo $embedCode; ?></div>
			    </div>
			  </div>
	  	<?php } // end if image or video ?>
  	<?php } // end while ?> 
  </div>
</section>
<?php } // end if ?> 
