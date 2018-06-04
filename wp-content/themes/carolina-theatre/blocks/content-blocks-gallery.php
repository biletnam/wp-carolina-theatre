<?php $uniqueID = 0; ?>
<?php if ( have_rows('popup_overlay') ) { ?>
<div class="block__gallery">
<?php while ( have_rows('popup_overlay') ) { the_row(); ?>
  <?php 
	  $uniqueID++;
	  $media_type = get_sub_field('media_type'); 
		$image = get_sub_field('image');
  ?>
  
  <?php if ($media_type == 'image') { ?>
    <a class="gallery" href="<?php echo $image['sizes']['gallery-full']; ?>">
      <i class="fas fa-search-plus"></i>
      <img src="<?php echo $image['sizes']['gallery-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
    </a>
  <?php } else if ($media_type == 'video') { ?>
  	<?php $embedCode = get_sub_field('video_embed'); ?>
    <a class="gallery" href="<?php echo '.gallery-' . $uniqueID; ?>">
      <i class="fas fa-play"></i>
      <img src="<?php echo $image['sizes']['gallery-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
    </a>
    <div class="gallery-content <?php echo 'gallery-' . $uniqueID; ?>">
      <div class="video"><?php echo $embedCode; ?></div>
    </div>
  <?php } // end if image or video ?>
<?php } // endwhile ?>
</div>
<?php } // endif ?>
