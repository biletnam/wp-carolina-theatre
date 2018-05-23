<div class="block__ctas">
	<?php
		$link_type = get_sub_field('link_type');
		$href = "";
		if ($link_type == 'external_link') {
		    $href = get_sub_field('external_link');
		} else if ($link_type == 'internal_link') {
		    $href = get_sub_field('internal_link');
		}
	?>
	<div class="cta__card">
	  <a href="<?php echo $href; ?>">
	  	<p class="h3"><?php echo get_sub_field('icon'); echo get_sub_field('title'); ?></p>
	 		<p><?php echo get_sub_field('description'); ?></p>
	  </a>
	</div>
</div>