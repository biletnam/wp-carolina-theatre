<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 */

/**
 * Global Variables
 */
global $upcomingEventIDs;
$upcomingEventIDs = false;

global $accordionCount;
$accordionCount = 0;

global $galleryCount;
$galleryCount = 0;

global $sliderCount;
$sliderCount = 0;


/**
 * Set up theme defaults and register support for various WordPress features.
 */
function carolinatheatre_setup() {
	load_theme_textdomain( 'carolinatheatre' );
	add_theme_support( 'automatic-feed-links' );	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'title-tag' ); // WP manages the document title, so there is no hard-coded <title>
	add_theme_support( 'post-thumbnails' ); // Enable support for Post Thumbnails on posts and pages.
	
	// Custom Images Sizes
	add_image_size( 'gallery-thumb', 700, 400, true ); // 2x actual size
	add_image_size( 'gallery-full', 1440, false ); // large enough for all sizes
	
	// same ratios, different sizes, for easy uploading and use throughout site
	add_image_size( 'hero-default', 1440, 810, true ); // large enough for all sizes
	add_image_size( 'hero-small', 1280, 720, true ); // large enough for all sizes
	add_image_size( 'event-thumb', 500, 280, true ); // 2x actual size
	// add_image_size( 'event-hero', 800, 450, true ); // actual size

	// Registering menu locations for the theme
	register_nav_menus( array(
		'header-topleft'  => __( 'Header - Top Left', 'carolinatheatre' ),
		'header-topright' => __( 'Header - Top Right', 'carolinatheatre' ),
		'header-main'   	=> __( 'Header - Main', 'carolinatheatre' ),
		'header-cta' 			=> __( 'Header - Call to Action Button' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );
}
add_action( 'after_setup_theme', 'carolinatheatre_setup' );

/**
 * Allow SVG file uploads to Media Library
 */
function add_file_types_to_uploads($file_types){
  $new_filetypes = array();
  $new_filetypes['svg'] = 'image/svg+xml';
  $file_types = array_merge($file_types, $new_filetypes );

  return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');


/*
 * Adding an ACF Theme Options page in the Dashboard
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'general-settings',
		'capability'	=> 'edit_posts',
		// 'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'parent_slug'	=> 'general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Seating Chart',
		'menu_title'	=> 'Seating Chart',
		'parent_slug'	=> 'general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Social Media',
		'menu_title'	=> 'Social Media',
		'parent_slug'	=> 'general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Default Link Blocks',
		'menu_title'	=> 'Link Blocks',
		'parent_slug'	=> 'general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Page Footer',
		'menu_title'	=> 'Page Footer',
		'parent_slug'	=> 'general-settings',
	));

		acf_add_options_sub_page(array(
		'page_title' 	=> 'Scripts & Styles',
		'menu_title'	=> 'Advanced',
		'parent_slug'	=> 'general-settings',
	));
}

/**
 * Register widget areas.
 */
function carolinatheatre_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'carolinatheatre' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'carolinatheatre' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'carolinatheatre_widgets_init' );

/**
 * Register custom taxonomies
 */
function carolinatheatre_custom_taxonomies() {  
  register_taxonomy(  
    'event_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
    'event',        // post type name
    array(  
      'hierarchical' => true,  
      'label' => 'Event Filters',  //Display name
      'query_var' => true,
    )  
  ); 
  register_taxonomy(  
    'film_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
    'film',        // post type name
    array(  
      'hierarchical' => true,  
      'label' => 'Film Categories',  //Display name
      'query_var' => true,
    )  
  ); 
}  
add_action( 'init', 'carolinatheatre_custom_taxonomies');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function carolinatheatre_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'carolinatheatre_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function carolinatheatre_scripts() {
	// Theme stylesheet.
	wp_enqueue_style( 'main-styles', get_template_directory_uri() . '/dist/styles.css', array(), null);
	
	// IE 9 and below styles
	wp_enqueue_style( 'ie-styles', get_stylesheet_directory_uri() . "/dist/ie-styles.css", array( 'main-styles' ) );
	wp_style_add_data( 'ie-styles', 'conditional', 'IE' );
	// All being pulled into and minified to 'scripts-min.js' thru Codekit
	// wp_enqueue_script( 'events-script', get_template_directory_uri() . '/src/js/event-filter.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/src/js/slick-min.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'slick-script', get_template_directory_uri() . '/src/js/slick-init.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'single-film-read-more', get_template_directory_uri() . '/src/js/singleFilmReadMore.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'film-festival-tabs', get_template_directory_uri() . '/src/js/filmFestivalTabs.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'featherlight', get_template_directory_uri() . '/src/js/featherlight.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'featherlight-gallery', get_template_directory_uri() . '/src/js/featherlight.gallery.js', array('jquery'
	// ), null, true );

	wp_enqueue_script( 'main-scripts', get_template_directory_uri() . '/dist/scripts-min.js', array('jquery'), null, true );
	wp_enqueue_script('jquery');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'carolinatheatre_scripts' );


/**
 * Debugging function, prints errors to the debug.log file
 * Works with below settings in wp-config.php
 *		define( 'WP_DEBUG',          true ); 
 *		define( 'WP_DEBUG_DISPLAY',  false );
 *		define( 'WP_DEBUG_LOG',      true ); 
 */
if(!function_exists('log_it')){
 function log_it( $message ) {
   if( WP_DEBUG === true ){
     if( is_array( $message ) || is_object( $message ) ){
       error_log( print_r( $message, true ) );
     } else {
       error_log( $message );
     }
   }
 }
}

/**
 * Update 'start_date' and 'end_date' on updating the post
 * Fields are used for querying posts efficiently
 * ACF - save last 'showtime' repeater's 'date' value as 'end_date'
 * ACF - save first 'showtime' repeater's 'date' value as 'start_date'
 */
function showtime_hiddendates_acf_save_post( $post_id ) {
  date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));
	$hidden_StartDate = false;
 	$hidden_EndDate = false;
 	$hidden_SoonestDate = false;
 	$hidden_pastEvent = false;
 	$showtimesRepeater = false;
 	$dateField = false;
 	$soonest_date = '';

 	// use correct field keys based on post type
 	if(get_post_type($post_id) === 'film'){
		$hidden_StartDate = 'field_5b1fd9a877928';
	 	$hidden_EndDate = 'field_5b1fd9a87793e';
	 	$hidden_SoonestDate = 'field_5b1fe30bf5482';
		$hidden_pastEvent = 'field_5b2072317ae0e';
		$showtimesRepeater = 'field_5b1fd9a877954';
	 	$dateField = 'field_5b1fd9a89011c';
 	} else if(get_post_type($post_id) === 'event'){
 		$hidden_StartDate = 'field_5b1fc25272946';
	 	$hidden_EndDate = 'field_5b1fc114473dc';
	 	$hidden_SoonestDate = 'field_5b1fe0b09ca96';
	 	$hidden_pastEvent = 'field_5b20715304d4b';
	 	$showtimesRepeater = 'field_5b195c4bbdc42';
	 	$dateField = 'field_5b195c4be0546';
 	}

  // bail early if no ACF data
  if( empty($_POST['acf']) ) {
    return;
  }

  // Get all the 'showtime' repeater rows using the field key
  if (isset($_POST['acf'][$showtimesRepeater])){
	  $repeater_rows = $_POST['acf'][$showtimesRepeater];  	
		if (count($repeater_rows) > 0){    
	    
	    // Find the upcoming date, closest to today
	    date_default_timezone_set('America/New_York');
	    $today = date("Ymd", strtotime('today'));
	    
	    // default is set to yesterday, so querying ignores this post
	    // if no dates are greater than or equal to today
	    $soonest_date = $today - 1; 
	    
	    // Find the first row (for start date) and then the 'date' field
	    $first_row = reset( $repeater_rows );
	    $start_date = $first_row[$dateField];

	    // Find the last row (for end date) and then the 'date' field
	    $last_row = end( $repeater_rows );
	    $end_date = $last_row[$dateField];

	    if($end_date < $today) { // event is in the past
	    	$soonest_date = $end_date; 
	    } else { // there are more dates upcoming
	    	foreach($repeater_rows as $row){
		    	// get the date field for each 'showtime' row
		    	$date = $row[$dateField];

		    	// check if the date is today, or close to today.
		    	if($date < $today){
						$soonest_date = $date;
		    	}
		    	if($date >= $today){
		    		$soonest_date = $date;
		    		
		    		// break the loop once we find the closest date
		    		break;
		    	}
		    }
	    }
	  }

    // Assign the dates to the hidden text fields.
    $_POST['acf'][$hidden_EndDate] = $end_date;
    $_POST['acf'][$hidden_StartDate] = $start_date;
    $_POST['acf'][$hidden_SoonestDate] = $soonest_date;
  } else {
  	return;
  }
} add_action('acf/save_post', 'showtime_hiddendates_acf_save_post', 1);


/**
 * ACF - save event categories and associated event into a repeater
 * allowing for easy access to display active filters on the Event's page.
 * (template-events.php)
 */
function event_filters_acf_save_post( $post_id ) {
	$associated_event_key = false;
 	$repeater = 'event_filters'; // repeater
 	$repeater_key = false;
 	$filters_string = '';
 	$filter_key = false;
	
	if(get_post_type($post_id) === 'film'){
	  $associated_event_key = 'field_5b2152924ece6';
	 	$repeater_key = 'field_5b21522123429'; // repeater
		
		// create string of filters for AJAX query
		$filters_string = ',film,';
		$filter_key = 'field_5b23f33f8cd1e'; // event_filter_string

 	} else if(get_post_type($post_id) === 'event'){
 		$associated_event_key = 'field_5b195c4bbde0e';
	 	$repeater_key = 'field_5b21353324ed5'; // repeater
	 	
	 	// create string of filters for AJAX query
		$filters_string = ',event,';
		$filter_key = 'field_5b23f28123e0b'; // event_filter_string
 	}

	// bail early if no ACF data
  if( empty($_POST['acf']) ) {
    return;
  }

  if (isset($_POST['acf'][$repeater_key])){
	  // Delete all rows, so repeater is empty
	  $repeater_rows = $_POST['acf'][$repeater_key]; 
	  $rows_count = 0;

	  if($repeater_rows != null){
		  $rows_count = count($repeater_rows);
			
			for ($i = $rows_count; $i >= 0; $i--) {
				delete_row( $repeater_key, $i, $post_id );
		  }
	  }
	  add_action('acf/save_post', 'event_filters_acf_save_post');

		// Live Events only - Add new rows for each event category 
		if(get_post_type($post_id) === 'event'){
	    $event_categories = get_the_terms( $post_id , 'event_categories'); // custom taxonomy
			if($event_categories != null){
			  $cat_count = count($event_categories);

			  for ($j = 0; $j < $cat_count; $j++) {
				  $filters_string .= $event_categories[$j]->slug . ',';

				  $row = array(
						'slug'	=> $event_categories[$j]->slug,
						'name'	=> $event_categories[$j]->name
					);
				  add_row( $repeater_key, $row, $post_id);
			  }
			}
		  add_action('acf/save_post', 'event_filters_acf_save_post');
		}

		// Add a new row if there's an associated event. 
	  $associated_event = $_POST['acf'][$associated_event_key];
	 	if($associated_event != null){
		  $filters_string .= get_post_field( 'post_name', $associated_event ) . ',';

		  $row = array(
				'slug'	=> get_post_field( 'post_name', $associated_event ),
				'name'	=> get_the_title($associated_event)
			);
		  add_row( $repeater_key, $row, $post_id);
		}
	  add_action('acf/save_post', 'event_filters_acf_save_post');

	  // update the filters with the new string
	  update_field($filter_key, $filters_string, $post_id);
	}
}
add_action('acf/save_post', 'event_filters_acf_save_post', 1);

/**
 * Creates a cron job (an automatic update) to run the 
 * day after 'end_date' (when an event ends), that
 * automatically updates the ACF 'past_event' boolean field.
 * Allows for events to easily be ignored in querying all event posts.
 */
function set_expiry_date( $post_id ) {
 	// Find the upcoming date, closest to today
  date_default_timezone_set('America/New_York');
  $today = date("Ymd", strtotime('today'));
 	$hidden_EndDate = false;
 	$hidden_pastEvent = false;

 	// use correct field keys based on post type
 	if(get_post_type($post_id) === 'film'){
		$hidden_EndDate = 'field_5b1fd9a87793e';
		$hidden_pastEvent = 'field_5b2072317ae0e';
 	} else if(get_post_type($post_id) === 'event'){
 		$hidden_EndDate = 'field_5b1fc114473dc';
 		$hidden_pastEvent = 'field_5b20715304d4b';
 	}

 	// if no dates have been given, set past_event to false and return
 	if(isset($_POST['acf'][$hidden_EndDate]) == null){
  	if(isset($_POST['acf'][$hidden_pastEvent]) == true) {
  		if($_POST['acf'][$hidden_pastEvent] == true) {
	  		update_field($hidden_pastEvent, false, $post_id); 	
	  		return;
	  	}
  	}
 	}

	if (isset($_POST['acf'][$hidden_EndDate])){
    $end_date = $_POST['acf'][$hidden_EndDate];

    // update the 'past_event' field if a former past event gets a new upcoming date
    if($_POST['acf'][$hidden_pastEvent] < $today) {
    	if($_POST['acf'][$hidden_pastEvent] == true) {
    		update_field($hidden_pastEvent, false, $post_id); 	
    	}
    }

	  // Convert our date to the correct format
	  $unix_acf_end_date = strtotime( $end_date );
	  $gmt_end_date = gmdate( 'Ymd', $unix_acf_end_date );
	  $unix_gmt_end_date = strtotime( $gmt_end_date );

	  $delay = 24 * 60 * 60;  // Get the number of seconds in a day (24 hours * 60 minutes * 60 seconds)
	  $day_after_event = $unix_gmt_end_date + $delay;  // Add 1 day to the end date to get the day after the event

	  // If a CRON job exists with this post_id them remove it
	  wp_clear_scheduled_hook( 'make_past_event', array( $post_id ) );

	  // Add the new CRON job to run the day after the event with the post_id as an argument
	  wp_schedule_single_event( $day_after_event , 'make_past_event', array( $post_id ) );
  }
} 
add_action( 'acf/save_post', 'set_expiry_date', 20 );

// Create a function that updates 'past_event' boolean field, hooked into by above function, set_expiry_date()
function set_past_event_field( $post_id ){
	$hidden_pastEvent = false;
 	if(get_post_type($post_id) === 'film'){
		$hidden_pastEvent = 'field_5b2072317ae0e';
 	} else if(get_post_type($post_id) === 'event'){
 		$hidden_pastEvent = 'field_5b20715304d4b';
 	}

  // Set the past event boolean field  to true
  update_field($hidden_pastEvent, true, $post_id); 	
} 
add_action( 'make_past_event', 'set_past_event_field' );


/**
 * Load Link Block defaults from options page into the selector for Link Block Content Types
 */
function acf_load_linkBlockDefault_field_choices($field){
  $field['choices'] = array();

  if(have_rows('lbd_repeater', 'option')){
    while(have_rows('lbd_repeater', 'option')){ the_row();
      $label = get_sub_field('title');

      // convert each future class name to lowercase
			$value = strtolower($label);
			// replace all characters except letters, replace with dash
		  $value = preg_replace('/[^a-z]+/i', '-', $value);

      // append to choices
      $field['choices'][ $value ] = $label;
    }
  }
  $field['choices']['custom'] = 'Custom';
  return $field;
}
add_filter('acf/load_field/name=link_block_select', 'acf_load_linkBlockDefault_field_choices');


/**
 * Clear Transient Cache when a new 'film or 'event' post is added
 * This allows for the query of relevant posts/filters to be updated.
 */
function ctdEvent_delete_query_transient( $post_id, $post ) {
  delete_transient( 'upcoming_event_ids_query_cache' ); // Upcoming Events Slider cache
  delete_transient( 'event_filtering_html_cache' ); // Event Template Filters cache
} add_action( 'publish_event', 'ctdEvent_delete_query_transient', 10, 2 );

function ctdFilm_delete_query_transient( $post_id, $post ) {
  delete_transient( 'upcoming_event_ids_query_cache' ); // Upcoming Events Slider cache
  delete_transient( 'event_filtering_html_cache' ); // Event Template Filters cache
} add_action( 'publish_film', 'ctdFilm_delete_query_transient', 10, 2 );


/**
 * CACHE THE IDs OF ALL UPCOMING EVENTS 
 * This speeds up page load tremendously
 *
 * Used for the menu dropdown, homepage slider, and events main page
 * The cache is cleared when an 'event' or 'film' post is added or updated
 * 
 * functions.php clears the cache when a post is added/updated
 * thru the ctdEvent_delete_query_transient and ctdFilm_delete_query_transient functions.
 */
function getUpcomingEventIDs(){
	// create a cache-key to use later when we set the transient cache
	$cache_key = 'upcoming_event_ids_query_cache';

	// check to see if the key has been set yet.
	if(!$upcomingEventIDs = get_transient($cache_key)){  
	  date_default_timezone_set('America/New_York');
	  $today = date("Ymd", strtotime('today'));

		$upcoming_event_args = array(
			'fields' => 'ids',
			'post_type' => array('event', 'film'),
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'ignore_sticky_posts'  => true,
			'meta_query'	=> array(
				array (
					'key'		=> 'end_date', // double check that end date hasnt happened yet
					'compare'	=> '>=',
					'value'		=> $today,  
				),
			),
			'meta_key' => 'soonest_date', // order by the soonest date (may not be most recent, but close enough)
	    'orderby' => 'meta_value_num', // 'soonest_date' is a number (ie 20180704)
	    'order' => 'ASC',
		);
		$upcomingEventIDs_query = new WP_Query($upcoming_event_args);
	  $upcomingEventIDs = $upcomingEventIDs_query->posts;

	  // set the cache
	  set_transient( $cache_key, $upcomingEventIDs, 60*60*12 ); // 6 hours = 60*60*6
	  wp_reset_postdata();
		
	}
	return $upcomingEventIDs;
}

/**
 * 1 - Reorder Menu Items in WordPress Dashboard
 * 2 - Add Columns to Custom Post Types
 */
require get_template_directory() . '/inc/admin-dashboard.php';

/**
 * Instantiate Custom Post Types
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Custom Walker for Main Mobile Menu
 */
require get_template_directory() . '/inc/custom_walker-icon.php';

/**
 * Extra buttons, styles, and styling of TinyMCE WYSIWYG
 */
require get_template_directory() . '/inc/tinymce.php';

/**
 * Filtering Upcoming Events/Films using AJAX
 */
require get_template_directory() . '/inc/event-filtering-and-querying.php';

/**
 * Seating Chart Shortcode
 */
require get_template_directory() . '/inc/seating-chart.php';




