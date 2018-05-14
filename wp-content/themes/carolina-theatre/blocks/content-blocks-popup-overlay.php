<?php
// construct html for popup-overlay components for single-film.php and single-series.php
if ( have_rows('popup_overlay') ) {
    while ( have_rows('popup_overlay') ) {
        the_row();
        $media = get_sub_field('media_type');
        
        if ($media == 'image_upload') {
        ?>
            <a href="<?php echo get_sub_field('image')['url'];?>" data-featherlight>
                <img src="<?php echo get_sub_field('image')['sizes']['medium']; ?>" alt="anime poster" />
            </a>
        <?php
        } else if ($media == 'video_link') {
            $video = get_sub_field('video');
        ?>
            <a href="<?php echo '.inline-' . $video['preview_image']['ID'] ;?>" data-featherlight>
                <img src="<?php echo $video['preview_image']['sizes']['medium'];?>" alt='anime preview' />
            </a>
            <div style="overflow: hidden;" class="<?php echo 'inline-' . $video['preview_image']['ID']; ?>">
                <?php echo $video['iframe_text']; ?>
            </div>
        <?php
        }
    }
}
?>