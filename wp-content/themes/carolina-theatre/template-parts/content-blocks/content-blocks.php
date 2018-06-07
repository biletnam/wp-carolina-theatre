<?php 
if (have_rows('content_block_type')) {
    while (have_rows('content_block_type')) {
        the_row();
       
        $fc = get_row_layout();
        switch ($fc) {
            case 'default':
                get_template_part( 'template-parts/content-blocks/block', 'wysiwyg' );
                break;
            case 'slider':
                get_template_part( 'template-parts/content-blocks/block', 'slider' );
                break;
            case 'full_width_image':
                get_template_part( 'template-parts/content-blocks/block', 'full_width_image');
                break;
            case 'popup_overlay':
                get_template_part( 'template-parts/content-blocks/block', 'gallery' );
                break;
            case 'link_block':
                get_template_part( 'template-parts/content-blocks/block', 'link_block' );
                break;
            case 'accordion':
                get_template_part( 'template-parts/content-blocks/block', 'accordion' );
                break;
            case 'section_divide':
                get_template_part( 'template-parts/content-blocks/block', 'section_divide' );
                break;
            default:
                echo "No Content Found";
                break;
        }  
    }
}

wp_reset_postdata();
?>