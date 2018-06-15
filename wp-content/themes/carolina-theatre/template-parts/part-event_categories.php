<p class="event__categories">
<?php
	$custom_taxonomy = 'event_categories';
	if (get_post_type() == 'film') {
		$custom_taxonomy = 'film_categories';
	}

	// SHOW YOAST PRIMARY CATEGORY, OR FIRST CATEGORY
	$category = get_the_terms( $post->ID, $custom_taxonomy );

	// If post has a category assigned.
	if ($category){
		$category_display = '';
		if ( class_exists('WPSEO_Primary_Term') ){
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) { 
				$category_display = $category[0]->name; // Default to first category (not Yoast) if an error is returned
			} else { 
				$category_display = $term->name; // Yoast Primary category
			}
		} else {
			$category_display = $category[0]->name;
		}
		// Display category
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