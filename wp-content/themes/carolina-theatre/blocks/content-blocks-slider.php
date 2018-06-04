<!-- 
    check for media type (image, wysiwyg, video) and construct html for slider 
    for single-film.php and single-series.php
-->

<div class="block__slider">
  <div class="carousel" >
    <?php if (have_rows('panel_content')) { ?>
			<?php while (have_rows('panel_content')) { the_row(); ?>
			  <?php 
			    $media_type = get_sub_field('media_type');
			    switch ($media_type) {
			        case 'image_upload':
			            ?>
			            <div>
			                <img src="<?php echo get_sub_field('image')['sizes']['hero-default'];?>" alt="poster" />
			            </div>
			            <?php
			            break;
			        case 'video_link':
			            ?>
			            <?php // TO-DO: Add thumbnail and play icon, open video in lightbox ?>
			            <a href="<?php echo '.inline-' . $video['preview_image']['ID'] ;?>">
							      <img src="<?php echo $video['preview_image']['sizes']['gallery-thumb'];?>" alt="<?php echo $video['preview_image']['alt']; ?>" />
							    </a>
							    <div class="gallery-content <?php echo 'inline-' . $video['preview_image']['ID']; ?>">
							      <div class="video"><?php echo $video['iframe_text']; ?></div>
							    </div>
							    
							    <div style="height: 250px; width: 250px; overflow: hidden">
			                <?php echo get_sub_field('iframe_text'); ?>
			            </div>
			            <?php
			            break;
			        case 'wysiwyg';
			            ?>
			            <div>
			                <?php echo get_sub_field('wysiwyg_editor'); ?>
			            </div>
			            <?php
			            break;
			        case 'default':
			            ?>
			            <div>
			                <?php echo "No Content Found"; ?>
			            </div>
			            <?php
			            break;
			  ?>
				<?php  } // end switch ?>
    	<?php } // end while ?> 
  	<?php } // end if ?> 
  </div>
</div>
