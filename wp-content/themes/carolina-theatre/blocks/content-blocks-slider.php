<?php $uniqueID = 0; ?>
<?php if (have_rows('panel_content')) { ?>
<div class="block__slider">
	<div class="carousel" >
		<?php while (have_rows('panel_content')) { the_row(); ?>
		  <?php 
			  $uniqueID++;
			  $media_type = get_sub_field('media_type');
        $image = get_sub_field('image'); 
      ?>
      
	    <?php if ($media_type == 'image') { ?>
        <div>
        	<img src="<?php echo $image['sizes']['hero-small']; ?>" alt="<?php echo $image['alt']; ?>" />
       	</div>
    	<?php } else if ($media_type == 'video') { ?>
        <?php $embedCode = get_sub_field('video_embed'); ?>
        <div>
        	<a href="<?php echo '.sliderContent-' . $uniqueID; ?>" data-featherlight>
            <i class="fas fa-play"></i>
						<img src="<?php echo $image['sizes']['hero-small']; ?>" alt="<?php echo $image['alt']; ?>" />
			    </a>
			    <div class="gallery-content <?php echo 'sliderContent-' . $uniqueID; ?>">
			      <div class="video"><?php echo $embedCode; ?></div>
			    </div>
			  </div>
	  	<?php } // end if image or video ?>
  	<?php } // end while ?> 
  </div>
</div>
<?php } // end if ?> 
