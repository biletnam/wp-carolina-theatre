<?php

if( ! function_exists( 'festival_create_post_type' ) ) {
	function festival_create_post_type() {
		$labels = array(
			'name' => 'Film Festival',
			'singular_name' => 'Film Festival',
			'add_new' => 'Add Film Festival',
			'all_items' => 'All Film Festivals',
			'add_new_item' => 'Add Film Festival',
			'edit_item' => 'Edit Film Festival',
			'new_item' => 'New Film Festival',
			'view_item' => 'View Film Festival',
			'search_items' => 'Search Film Festivals',
			'not_found' => 'No Film Festivals found',
			'not_found_in_trash' => 'No Film Festivals found in trash',
			'parent_item_colon' => 'Parent Film Festival',
			'menu_name' => 'Film Festival'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				//'author',
				//'trackbacks',
				//'custom-fields',
				//'comments',
				'revisions',
				//'page-attributes', // (menu order, hierarchical must be true to show Parent option)
				//'post-formats',
			),
			'taxonomies' => array( 'category', 'post_tag' ), // add default post categories and tags
			'menu_position' => 5,
			'exclude_from_search' => false
		);
		register_post_type( 'festival', $args );
	}
}

if( ! function_exists( 'event_create_post_type' ) ) {
	function event_create_post_type() {
		$labels = array(
			'name' => 'Event',
			'singular_name' => 'Event',
			'add_new' => 'Add Event',
			'all_items' => 'All Events',
			'add_new_item' => 'Add Event',
			'edit_item' => 'Edit Event',
			'new_item' => 'New Event',
			'view_item' => 'View Event',
			'search_items' => 'Search Events',
			'not_found' => 'No Events found',
			'not_found_in_trash' => 'No Events found in trash',
			'parent_item_colon' => 'Parent Event',
			'menu_name' => 'Event'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				//'author',
				//'trackbacks',
				//'custom-fields',
				//'comments',
				'revisions',
				//'page-attributes', // (menu order, hierarchical must be true to show Parent option)
				//'post-formats',
			),
			'taxonomies' => array( 'category', 'post_tag' ), // add default post categories and tags
			'menu_position' => 5,
			'exclude_from_search' => false
		);
		register_post_type( 'event', $args );
	}
}

if( ! function_exists( 'film_create_post_type' ) ) {
	function film_create_post_type() {
		$labels = array(
			'name' => 'Film',
			'singular_name' => 'Film',
			'add_new' => 'Add Film',
			'all_items' => 'All Films',
			'add_new_item' => 'Add Film',
			'edit_item' => 'Edit Film',
			'new_item' => 'New Film',
			'view_item' => 'View Film',
			'search_items' => 'Search Films',
			'not_found' => 'No Films found',
			'not_found_in_trash' => 'No Films found in trash',
			'parent_item_colon' => 'Parent Film',
			'menu_name' => 'Film'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				//'author',
				//'trackbacks',
				//'custom-fields',
				//'comments',
				'revisions',
				//'page-attributes', // (menu order, hierarchical must be true to show Parent option)
				//'post-formats',
			),
			'taxonomies' => array( 'category', 'post_tag' ), // add default post categories and tags
			'menu_position' => 5,
			'exclude_from_search' => false
		);
		register_post_type( 'film', $args );
	}
}
add_action( 'init', 'festival_create_post_type' );
add_action( 'init', 'event_create_post_type' );
add_action( 'init', 'film_create_post_type' );
?>