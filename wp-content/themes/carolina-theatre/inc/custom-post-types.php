<?php
/*
 * Register Film Festivals Post Types
 */
function festival_create_post_type() {
	$labels = array(
		'name' => 'Film Festivals',
		'singular_name' => 'Film Festival',
		'add_new' => 'Add Festival',
		'all_items' => 'All Film Festivals',
		'add_new_item' => 'Add Film Festival',
		'edit_item' => 'Edit Film Festival',
		'new_item' => 'New Film Festival',
		'view_item' => 'View Film Festival',
		'search_items' => 'Search Film Festivals',
		'not_found' => 'No Film Festivals found',
		'not_found_in_trash' => 'No Film Festivals found in trash',
		'parent_item_colon' => 'Parent Film Festival',
		'menu_name' => 'Film Festivals'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'show_in_nav_menus' => true,
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
		'menu_position' => 9,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-video-alt2',
	);
	register_post_type( 'festival', $args );
} add_action( 'init', 'festival_create_post_type', 0 );

/*
 * Register Film Series Post Types
 */
function series_create_post_type() {
	$labels = array(
		'name' => 'Film Series',
		'singular_name' => 'Film Series',
		'add_new' => 'Add Film Series',
		'all_items' => 'All Film Series',
		'add_new_item' => 'Add Film Series',
		'edit_item' => 'Edit Film Series',
		'new_item' => 'New Film Series',
		'view_item' => 'View Film Series',
		'search_items' => 'Search Film Series',
		'not_found' => 'No Film Series found',
		'not_found_in_trash' => 'No Film Series found in trash',
		'parent_item_colon' => 'Parent Film Series',
		'menu_name' => 'Film Series'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'show_in_nav_menus' => true,
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
		'menu_position' => 9,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-video-alt3',
	);
	register_post_type( 'series', $args );
} add_action( 'init', 'series_create_post_type', 0 );

/*
 * Register Education Series Post Types
 */
function education_create_post_type() {
	$labels = array(
		'name' => 'Education Series',
		'singular_name' => 'Education Series',
		'add_new' => 'Add Education Series',
		'all_items' => 'All Education Series',
		'add_new_item' => 'Add Education Series',
		'edit_item' => 'Edit Education Series',
		'new_item' => 'New Education Series',
		'view_item' => 'View Education Series',
		'search_items' => 'Search Education Series',
		'not_found' => 'No Education Series found',
		'not_found_in_trash' => 'No Education Series found in trash',
		'parent_item_colon' => 'Parent Education Series',
		'menu_name' => 'Education Series'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'show_in_nav_menus' => true,
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
		'menu_position' => 9,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-welcome-learn-more',
	);
	register_post_type( 'education', $args );
} add_action( 'init', 'education_create_post_type', 0 );


/*
 * Register Live Event Post Types
 */
function event_create_post_type() {
	$labels = array(
		'name' => 'Live Events',
		'singular_name' => 'Live Event',
		'add_new' => 'Add Live Event',
		'all_items' => 'All Live Events',
		'add_new_item' => 'Add Live Event',
		'edit_item' => 'Edit Live Event',
		'new_item' => 'New Live Event',
		'view_item' => 'View Live Event',
		'search_items' => 'Search Live Events',
		'not_found' => 'No Live Events found',
		'not_found_in_trash' => 'No Live Events found in trash',
		'parent_item_colon' => 'Parent Live Event',
		'menu_name' => 'Live Events'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'show_in_nav_menus' => true,
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
		'menu_position' => 7,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-format-audio',
	);
	register_post_type( 'event', $args );
} add_action( 'init', 'event_create_post_type', 0 );

/*
 * Register Film Post Types
 */
function film_create_post_type() {
	$labels = array(
		'name' => 'Films',
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
		'menu_name' => 'Films'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'show_in_nav_menus' => true,
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
		'menu_position' => 8,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-editor-video',
	);
	register_post_type( 'film', $args );
} add_action( 'init', 'film_create_post_type', 0 );

/*
 * Register Alert Banner Posts
 */
function alertbanner_create_post_type() {
	$labels = array(
		'name' => 'Alert Banners',
		'singular_name' => 'Alert Banner',
		'add_new' => 'Add Banner',
		'all_items' => 'All Banner',
		'add_new_item' => 'Add Banner',
		'edit_item' => 'Edit Banner',
		'new_item' => 'New Banner',
		'view_item' => 'View Banner',
		'search_items' => 'Search Banners',
		'not_found' => 'No Films found',
		'not_found_in_trash' => 'No Banners found in trash',
		'parent_item_colon' => 'Parent Banner',
		'menu_name' => 'Alert Banners'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		'publicly_queryable' => false,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'show_in_nav_menus' => false,
		'hierarchical' => false,
		'supports' => array(
			'title',
			// 'editor',
			// 'excerpt',
			// 'thumbnail',
			//'author',
			//'trackbacks',
			//'custom-fields',
			//'comments',
			'revisions',
			//'page-attributes', // (menu order, hierarchical must be true to show Parent option)
			//'post-formats',
		),
		'taxonomies' => array(), // add default post categories and tags
		'menu_position' => 20,
		'exclude_from_search' => true,
		'menu_icon' => 'dashicons-info',
	);
	register_post_type( 'alertbanner', $args );
} add_action( 'init', 'alertbanner_create_post_type', 0 );