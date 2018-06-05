<?php $uniqueID = 0; ?>
<?php if ( have_rows('popup_overlay') ) { ?>
<div class="block__gallery">
<?php while ( have_rows('popup_overlay') ) { the_row(); ?>
  <?php 
	  $uniqueID++;
	  $media_type = get_sub_field('media_type'); 
		$embedCode = get_sub_field('video_embed');

		$image = get_sub_field('image');
		$image_full = $image['sizes']['gallery-full'];
		$image_thumb = $image['sizes']['gallery-thumb'];
		$image_alt = $image['alt'];
		$image_cap = $image['caption'];
  ?>
  
  <?php if ($media_type == 'image') { ?>
    <a class="gallery" href="<?php echo $image_full; ?>">
     	<div class="image_wrapper">
     		<i class="fas fa-search-plus"></i>
      	<img src="<?php echo $image_thumb; ?>" alt="<?php echo $image_alt; ?>" />
      </div>
      <?php if($image_cap) { ?><figcaption class="small caption"><?php echo $image_cap; ?></figcaption><?php } ?>
    </a>
  <?php } else if ($media_type == 'video') { ?>
    <a class="gallery" href="<?php echo '.gallery-' . $uniqueID; ?>">
      <div class="image_wrapper">
      	<i class="fas fa-play"></i>
      	<img src="<?php echo $image_thumb; ?>" alt="<?php echo $image_alt; ?>" />
      </div>
      <?php if($image_cap) { ?><figcaption class="small caption"><?php echo $image_cap; ?></figcaption><?php } ?>
    </a>
    <div class="gallery-content <?php echo 'gallery-' . $uniqueID; ?>">
      <div class="video"><?php echo $embedCode; ?></div>
    </div>
  <?php } // end if image or video ?>
<?php } // endwhile ?>
</div>
<?php } // endif ?>
