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
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function carolinatheatre_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/carolinatheatre
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'carolinatheatre' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'carolinatheatre' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'carolinatheatre-featured-image', 2000, 1200, true );
	add_image_size( 'carolinatheatre-thumbnail-avatar', 100, 100, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'carolinatheatre' ),
		'social' => __( 'Social Links Menu', 'carolinatheatre' ),
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
	 *
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
 * Registers an editor stylesheet for the theme.
 * Add styles to TinyMCE WYSIWIG
 */
function mrc_custom_editor_styles() {
	add_editor_style('dist/editor-style.css');
}
add_action( 'admin_init', 'mrc_custom_editor_styles' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
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

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'carolinatheatre' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'carolinatheatre' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'carolinatheatre' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'carolinatheatre' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'carolinatheatre_widgets_init' );

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


	wp_enqueue_script( 'main-scripts', get_template_directory_uri() . '/dist/scripts-min.js', array('jquery'
	), null, true );

	wp_enqueue_script('jquery');


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'carolinatheatre_scripts' );


/**
 * Instantiate Custom Post Types
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Reorder Menu Items in WordPress Dashboard
 */
function custom_menu_order($menu_ord) {
    if (!$menu_ord) return true;
     
    return array(
        'index.php', // Dashboard
        'upload.php', // Media
        'separator1', // First separator
        'edit.php?post_type=page', // Pages
        'edit.php?post_type=event', // Pages
        'edit.php?post_type=film', // Pages
        'edit.php?post_type=festival', // Pages
        'edit.php', // Posts
        'separator2', // Second separator
        'themes.php', // Appearance
        'plugins.php', // Plugins
        'users.php', // Users
        'tools.php', // Tools
        'options-general.php', // Settings
        'edit-comments.php', // Comments
        'separator-last', // Last separator
    );
}
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');

