<?php if (have_rows("link_blocks")) { ?>
<div class="block__ctas">
	<?php while (have_rows("link_blocks")) { the_row(); ?>
  <?php
		$link = get_sub_field('link');
		$title = get_sub_field('title');
		$description = get_sub_field('description');
	?>
	<div class="cta__card">
	  <a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
	  	<p class="h3"><?php echo $title; ?></p>
	 		<p class="small"><?php echo $description; ?></p>
	  </a>
	</div>
  <?php } // endwhile ?>
</div>  
<?php } // endif ?>
