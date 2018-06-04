<?php
$image_url = get_sub_field('image')['url'];
$image_alt = get_sub_field('image')['alt'];
?>
<div class="block__fullImage">
	<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
</div>