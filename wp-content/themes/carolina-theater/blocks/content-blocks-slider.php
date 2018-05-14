<!-- 
    check for media type (image, wysiwyg, video) and construct html for slider 
    for single-film.php and single-series.php
-->

<div style='background-color: darkseagreen;'>
    <div class="hero-slider" >
    <?php

    if (have_rows('panel_content')) {
        while (have_rows('panel_content')) {
            the_row();
            $media_type = get_sub_field('media_type');
            switch ($media_type) {
                case 'image_upload':
                    ?>
                    <div>
                        <img src="<?php echo get_sub_field('image')['url'];?>" alt="poster" />
                    </div>
                    <?php
                    break;
                case 'video_link':
                    ?>
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
            }
        }
    }
    ?> 
    </div>
</div>
