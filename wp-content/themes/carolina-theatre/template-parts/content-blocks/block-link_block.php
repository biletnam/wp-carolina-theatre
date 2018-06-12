<?php if (have_rows("link_blocks")) { ?>
<div class="block__ctas">
	<?php while (have_rows("link_blocks")) { the_row(); ?>
  <?php
		$type = get_sub_field('link_block_select'); // returns the Label (ie. 'Plan Your Visit' or 'Custom')
		$link = get_sub_field('link'); 
		$title = get_sub_field('title');
		$description = get_sub_field('description');

		if($type !== 'Custom'){
			if(have_rows('lbd_repeater', 'option')){
		    while(have_rows('lbd_repeater', 'option')){ the_row();
		      if($type === get_sub_field('title')){
		      	$link = get_sub_field('link', 'option'); 
						$title = get_sub_field('title', 'option');
						$description = get_sub_field('description', 'option');
		      }
		    } 
		  }
		}
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
