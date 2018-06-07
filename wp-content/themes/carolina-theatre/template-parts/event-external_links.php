<?php if (have_rows('external_links')) { ?>
	<div class="externalLinks">
    <?php while (have_rows('external_links')) { the_row();
      $external_link_icon = get_sub_field('external_link_icon');
			$external_link_label = get_sub_field('external_link_label');
			$external_link_url = get_sub_field('external_link_url');
    ?>
    <p>
    	<i class="far <?php echo $external_link_icon; ?>"></i>
    	<a href="<?php echo $external_link_url; ?>" target="_blank"><?php echo $external_link_label; ?></a>
    </p>
    <?php } // end while ?>
	</div>
<?php } // end if ?>