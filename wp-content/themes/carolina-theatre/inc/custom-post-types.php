<?php
/*
 * Register Film Series & Festiavls Post Types
 */
function festival_create_post_type() {
	$labels = array(
		'name' => 'Series/Festivals',
		'singular_name' => 'Film Series/Festival',
		'add_new' => 'Add Series/Festival',
		'all_items' => 'All Film Series/Festivals',
		'add_new_item' => 'Add Film Series/Festival',
		'edit_item' => 'Edit Series/Festival',
		'new_item' => 'New Series/Festival',
		'view_item' => 'View Film Series/Festival',
		'search_items' => 'Search Film Series/Festivals',
		'not_found' => 'No Film Series/Festivals found',
		'not_found_in_trash' => 'No Film Series/Festivals found in trash',
		'parent_item_colon' => 'Parent Film Series/Festival',
		'menu_name' => 'Series/Festivals'
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
		'menu_position' => 9,
		'exclude_from_search' => false,
		'menu_icon' => 'dashicons-awards',
	);
	register_post_type( 'festival', $args );
} add_action( 'init', 'festival_create_post_type', 0 );

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
		'menu_icon' => 'dashicons-admin-media',
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

/*
 * Rename "Posts" to "News" in WordPress Dashboard
 */
function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );