<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<!-- <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text">Search for...</span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><i class="far fa-search"></i><span class="screen-reader-text">Search</span></button>
</form> -->


<!-- <form role="search" method="get" id="search-form" action="<?php bloginfo('url'); ?>" >
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text">Search for...</span>
	</label>
	<input type="text" placeholder="Search Events..." value="" onfocus="this.value='';" name="s" id="s" />
	<input type="hidden" name="post_type[]" value="event" />
	<input type="hidden" name="post_type[]" value="film" />
  <button type="submit" class="search-submit"><i class="far fa-search"></i><span class="screen-reader-text">Search Live Events & Films</span></button>
</form> -->

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <label>
    <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
  </label>
  <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
</form>