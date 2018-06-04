<?php
$image_url = get_sub_field('image')['url'];
$image_alt = get_sub_field('image')['alt'];
$image_cap = get_sub_field('image')['caption'];
?>
<div class="block__fullImage">
	<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
	<?php if($image_cap) { ?><figcaption class="small caption"><?php echo $image_cap; ?></figcaption><?php } ?>
</div>