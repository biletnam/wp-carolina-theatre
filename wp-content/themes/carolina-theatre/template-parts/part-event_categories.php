<p class="event__categories">
	<?php 
	// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
	$category = get_the_category();
	$useCatLink = false;
	
	if ($category){
		$category_display = '';
		// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
		if ( class_exists('WPSEO_Primary_Term') ) {
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) {  // Default to first category (not Yoast) if an error is returned
				$category_display = $category[0]->name;
			} else {  // Yoast Primary category
				$category_display = $term->name;
			}
		} 
		else { // Default, display the first category in WP's list of assigned categories
			$category_display = $category[0]->name;
		}

		if ( !empty($category_display) ){
			echo htmlspecialchars($category_display);
		}
	} else {
	 	if (get_post_type() == 'film') {
  		echo 'Film';
  	} else if (get_post_type() == 'event') {
			echo 'Live Event';
		} 
	}
?>
</p>