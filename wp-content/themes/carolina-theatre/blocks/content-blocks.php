<?php 
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
                get_template_part( 'blocks/content-blocks', 'gallery' );
                break;
            case 'link_block':
                get_template_part( 'blocks/content-blocks', 'link-block' );
                break;
            case 'accordion':
                get_template_part( 'blocks/content-blocks', 'accordion' );
                break;
            case 'section_divide':
                get_template_part( 'blocks/content-blocks', 'section-divide' );
                break;
            default:
                echo "No Content Found";
                break;
        }  
    }
}

wp_reset_postdata();
?>