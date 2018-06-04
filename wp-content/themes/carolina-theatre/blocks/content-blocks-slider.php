<div class="block__slider">
  <div class="carousel" >
    <?php if (have_rows('panel_content')) { ?>
			<?php while (have_rows('panel_content')) { the_row(); ?>
			  <?php $media_type = get_sub_field('media_type'); ?>
		    <?php switch ($media_type) {
	        case 'image': ?>
            <div>
                <img src="<?php echo get_sub_field('image')['sizes']['hero-default'];?>" alt="poster" />
            </div>
          	<?php 
        	break;
        	case 'video': 
          	?>
            <?php $video = get_sub_field('video'); ?>
            <div>
            	<a href="<?php echo '.inline-' . $video['video_thumb']['ID'] ;?>" data-featherlight>
		            <i class="fas fa-play"></i>
								<img src="<?php echo $video['video_thumb']['sizes']['hero-default'];?>" alt="<?php echo $video['video_thumb']['alt']; ?>" />
					    </a>
					    <div class="gallery-content <?php echo 'inline-' . $video['video_thumb']['ID']; ?>">
					      <div class="video"><?php echo $video['video_embed']; ?></div>
					    </div>
					  </div>
				  	<?php 
			  	break;
			  	case 'default': 
				  	?>
            <div><?php echo "No Content Found"; ?></div>
        		<?php 
      		break; 
      			?>
				<?php  } // end switch ?>
    	<?php } // end while ?> 
  	<?php } // end if ?> 
  </div>
</div>
