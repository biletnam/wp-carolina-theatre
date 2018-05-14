<div class="accordion half">
<?php
$panel_count = 0;
if (have_rows('panel')) {
    while(have_rows('panel')) {
        the_row();
    ?>
        <div class="panel">
            <input id="panel-<?php echo $panel_count;?>" type="checkbox" name="panels">
            <label for="panel-<?php echo $panel_count;?>"><?php echo get_sub_field('title'); ?></label>
            <div class="panel-content">
            <?php 

                if (have_rows('content')) {
                    while(have_rows('content')) {
                        the_row();
                        get_template_part( 'blocks/content-blocks' );
                    }
                }
            ?> 
            </div>
        </div>
    <?php       
        $panel_count++;
        }
    }
wp_reset_postdata();
?>

</div>
