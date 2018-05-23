<div class="externalLinks">
  <?php if (have_rows('social_media_link')) {
    while (have_rows('social_media_link')) { the_row();
      $icon = get_sub_field('icon');
      $url = get_sub_field('link_url');
      $link_text = get_sub_field('link_description');
    ?>
    <p><?php echo $icon; ?> <a href="<?php echo $url; ?>"><?php echo $link_text; ?></a></p>
    <?php } // end while ?>
  <?php } // end if ?>
</div>