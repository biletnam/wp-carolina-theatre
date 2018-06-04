<?php if ( have_rows('popup_overlay') ) { ?>
<div class="block__gallery">
<?php while ( have_rows('popup_overlay') ) { the_row(); ?>
  <?php $media = get_sub_field('media_type'); ?>
  
  <?php if ($media == 'image_upload') { ?>
  	<?php $image = get_sub_field('image');?>
    <?php // TO-DO: create custom size for thumbnails and use here ?>
    <a class="gallery" href="<?php echo $image['url']; ?>">
      <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
    </a>
  <?php
  } else if ($media == 'video_link') {
    $video = get_sub_field('video');
  ?>
    <a class="gallery" href="<?php echo '.inline-' . $video['preview_image']['ID'] ;?>">
      <img src="<?php echo $video['preview_image']['sizes']['medium'];?>" alt="<?php echo $video['preview_image']['alt']; ?>" />
    </a>
    <div class="gallery-content <?php echo 'inline-' . $video['preview_image']['ID']; ?>">
      <div class="video"><?php echo $video['iframe_text']; ?></div>
    </div>
  <?php } // end if image or video ?>
<?php } // endwhile ?>
</div>
<?php } // endif ?>
