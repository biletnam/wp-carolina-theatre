<?php 
	// $external_links = get_field('external_links');									// repeater
	// $external_link_icon = get_sub_field('external_link_icon'); 		// text | Font Awesome class 'fa-link'
	// $external_link_label = get_sub_field('external_link_label'); 	// text
	// $external_link_url = get_sub_field('external_link_url'); 			// url - returns url
	// $external_link_file = get_sub_field('external_link_file'); 		// file - returns url
	// $external_link_type = get_sub_field('external_link_type'); 		// true = url | false = file
 ?>
<?php if (have_rows('external_links')) { ?>
	<div class="externalLinks">
    <?php while (have_rows('external_links')) { the_row();
      $external_link_icon = get_sub_field('external_link_icon');
			$external_link_label = get_sub_field('external_link_label');
			$external_link_type = get_sub_field('external_link_type');
			$external_link_url = '';

			if($external_link_type) { // true is URL
				$external_link_url = get_sub_field('external_link_url');
			} else { // false is File
				$external_link_url = get_sub_field('external_link_file');
			}
		?>
    <p>
    	<i class="<?php echo $external_link_icon; ?>"></i>
    	<a href="<?php echo $external_link_url; ?>" target="_blank"><?php echo $external_link_label; ?></a>
    </p>
    <?php } // end while ?>
	</div>
<?php } // end if ?>