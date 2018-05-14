<?php

// echo "I'm a post object";
// print_r(get_sub_field('content_block_type')[0]);

// echo get_field('start_date');
// echo get_post_type();
// $post_cards = get_sub_field('content_block_type')[0];
// print_r($post_cards);
// echo get_the_ID();
// if (have_rows('post_item')) {
//     echo 'true';
// }
// echo get_the_ID();
// print_r(get_sub_field('layout_post_card'));
$items = get_sub_field('single_post_item');
// print_r($items);
// echo count($items);
// print_r(the_row());

print_r(have_rows($items));
// foreach($items as $i) {
//     print_r($i);
//     echo $i['single_post']->post_content;
// }

// if (have_rows('single_post_item')) {
    // while( have_rows('single_post_item')) {
    //     the_row();
    //     echo get_sub_field('single_post');
    // }
// }

// print_r(have_rows('tabs', 183));


?>

                   