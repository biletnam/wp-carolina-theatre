<?php
$link_type = get_sub_field('link_type');
$href = "";
if ($link_type == 'external_link') {
    $href = get_sub_field('external_link');
} else if ($link_type == 'internal_link') {
    $href = get_sub_field('internal_link');
}
?>

<div>
    <a href=<?php echo $href;?> style="border: none" target="_blank">
    <?php echo get_sub_field('icon'); echo get_sub_field('title'); ?>
    </a>
    <p><?php echo get_sub_field('description'); ?></p>
</div>