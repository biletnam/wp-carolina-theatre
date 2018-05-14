<?php 
// generates content for tabs on single-film.php and single-series.php pages based on 
// content type
if (have_rows('content_block_type')) {
    while (have_rows('content_block_type')) {
        the_row();
       
        $fc = get_row_layout();
        switch ($fc) {
            case 'default':
                get_template_part( 'blocks/content-blocks', 'wysiwyg' );
                break;
            case 'slider':
                get_template_part( 'blocks/content-blocks', 'slider' );
                break;
            case 'full_width_image':
                get_template_part( 'blocks/content-blocks', 'full-width-image');
                break;
            case 'popup_overlay':
                get_template_part( 'blocks/content-blocks', 'popup-overlay' );
                break;
            case 'link_block':
                get_template_part( 'blocks/content-blocks', 'link-block' );
                break;
            case 'accordion':
                get_template_part( 'blocks/content-blocks', 'accordion' );
                break;
            case 'layout_post_card':
                // malfunctioning
                get_template_part( 'blocks/content-blocks', 'post-card' ); 
                break;
            default:
                echo "No Content Found";
                break;
        }  
    }
}

wp_reset_postdata();
?>