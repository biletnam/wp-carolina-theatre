<?php
$link_type = get_sub_field('link_type');
$href = "";
if ($link_type == 'external_link') {
    $href = get_sub_field('external_link');
} else if ($link_type == 'internal_link') {
    $href = get_sub_field('internal_link');
}
?>
<section class="block__cta">
  <a href="<?php echo $href; ?>">
    <div>
    	<h3><?php echo get_sub_field('icon'); echo get_sub_field('title'); ?></h3>
   		<p><?php echo get_sub_field('description'); ?></p>
    </div>
  </a>
</section>
