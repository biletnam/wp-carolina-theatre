<?php
/**
 * Registers an editor stylesheet for the theme.
 * Add styles to TinyMCE WYSIWIG
 */
function mrc_custom_editor_styles() {
	add_editor_style('dist/editor-style.css');
} 
add_action( 'admin_init', 'mrc_custom_editor_styles' );

/**
 * Add 'style select' button to TinyMCE WYSIWIG
 */
function add_style_select_button($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
} 
add_filter('mce_buttons', 'add_style_select_button');

// 
/**
 * Add custom styles to 'style select' button in TinyMCE WYSIWIG
 */
function custom_styles_wysiwyg( $init_array ) {
	$style_formats = array(	// custom styles
		array(
			'title' => 'Page Introduction',
			'inline' => 'span',
			'classes' => 'h3',
			'wrapper' => true,
		),
		array(
			'title' => 'Small Text',
			'inline' => 'span',
			'classes' => 'small',
			'wrapper' => true,
		),
		array(
			'title' => 'Button - Default',
			'inline' => 'span',
			'classes' => 'button',
			'wrapper' => true,
		),
		array(
			'title' => 'Button - Secondary',
			'inline' => 'span',
			'classes' => 'button secondary',
			'wrapper' => true,
		),
		array(
			'title' => 'Button - Gray',
			'inline' => 'span',
			'classes' => 'button gray',
			'wrapper' => true,
		),
	);

	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );
	return $init_array;
} 
add_filter( 'tiny_mce_before_init', 'custom_styles_wysiwyg' );

?>