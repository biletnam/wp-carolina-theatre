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
		'page_title' 	=> 'Scripts & Styles',
		'menu_title'	=> 'Scripts & Styles',
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
 * Have 'event' and 'film' post types share a template
 */
add_filter( 'single_template', function( $template ) {
  $cpt = [ 'event', 'film' ];
  return in_array( get_queried_object()->post_type, $cpt, true )
    ? get_stylesheet_directory() . '/template-single_events.php'
    : $template;
} );

/**
 * Have 'series', 'festival' and 'education' post types share a template
 */
add_filter( 'single_template', function( $template ) {
  $cpt = [ 'series', 'festival', 'education' ];
  return in_array( get_queried_object()->post_type, $cpt, true )
    ? get_stylesheet_directory() . '/template-parent_events.php'
    : $template;
} );


/**
 * Debugging
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
 * FOR LIVE EVENT POSTS
 * ACF - save last 'showtime' repeater's 'date' value as 'end_date'
 * ACF - save first 'showtime' repeater's 'date' value as 'start_date'
 */
function liveevent_showtime_hiddendates_acf_save_post( $post_id ) {
	$hidden_StartDate = 'field_5b1fc25272946';
 	$hidden_EndDate = 'field_5b1fc114473dc';
 	$hidden_SoonestDate = 'field_5b1fe0b09ca96';
 	$showtimesRepeater = 'field_5b195c4bbdc42';
 	$dateField = 'field_5b195c4be0546';

  // bail early if no ACF data
  if( empty($_POST['acf']) ) {
    return;
  }

  if ($_POST['acf'][$showtimesRepeater]){
  	// Get all the 'showtime' repeater rows using the field key
    $repeater_rows = $_POST['acf'][$showtimesRepeater];
    
    // Fine the upcoming date, closest to today
    $today = date("Ymd", strtotime('today'));
    
    // default is set to yesterday, so querying ignores this post
    // if no dates are greater than or equal to today
    $soonest_date = $today - 1; 
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

    // Find the first row (for start date) and then the 'date' field
    $first_row = reset( $repeater_rows );
    $start_date = $first_row[$dateField];

    // Find the last row (for end date) and then the 'date' field
    $last_row = end( $repeater_rows );
    $end_date = $last_row[$dateField];

    // Assign the dates to the hidden text fields.
    $_POST['acf'][$hidden_EndDate] = $end_date;
    $_POST['acf'][$hidden_StartDate] = $start_date;
    $_POST['acf'][$hidden_SoonestDate] = $soonest_date;
  } else {
  	return;
  }
} add_action('acf/save_post', 'liveevent_showtime_hiddendates_acf_save_post', 1);

/**
 * FOR FILM POSTS
 * ACF - save last 'showtime' repeater's 'date' value as 'end_date'
 * ACF - save first 'showtime' repeater's 'date' value as 'start_date'
 */
function films_showtime_hiddendates_acf_save_post( $post_id ) {
	$hidden_StartDate = 'field_5b1fd9a877928';
 	$hidden_EndDate = 'field_5b1fd9a87793e';
 	$hidden_SoonestDate = 'field_5b1fe30bf5482';
 	$showtimesRepeater = 'field_5b1fd9a877954';
 	$dateField = 'field_5b1fd9a89011c';

  // bail early if no ACF data
  if( empty($_POST['acf']) ) {
    return;
  }

	if ($_POST['acf'][$showtimesRepeater]){
  	// Get all the 'showtime' repeater rows using the field key
    $repeater_rows = $_POST['acf'][$showtimesRepeater];
    
    // Fine the upcoming date, closest to today
    $today = date("Ymd", strtotime('today'));
    
    // default is set to yesterday, so querying ignores this post
    // if no dates are greater than or equal to today
    $soonest_date = $today - 1; 
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

    // Find the first row (for start date) and then the 'date' field
    $first_row = reset( $repeater_rows );
    $start_date = $first_row[$dateField];

    // Find the last row (for end date) and then the 'date' field
    $last_row = end( $repeater_rows );
    $end_date = $last_row[$dateField];

    // Assign the dates to the hidden text fields.
    $_POST['acf'][$hidden_EndDate] = $end_date;
    $_POST['acf'][$hidden_StartDate] = $start_date;
    $_POST['acf'][$hidden_SoonestDate] = $soonest_date;
  } else {
  	return;
  }
} add_action('acf/save_post', 'films_showtime_hiddendates_acf_save_post', 1);

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
 * Global Variables
 */
global $accordionCount;
$accordionCount = 0;

global $galleryCount;
$galleryCount = 0;

global $sliderCount;
$sliderCount = 0;

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

