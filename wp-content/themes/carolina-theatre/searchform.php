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

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <label>
    <span class="screen-reader-text"><?php echo _x( 'Search Sitewide for:', 'label' ) ?></span>
    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Sitewide…', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search Sitewide for:', 'label' ) ?>" />
    <input type="hidden" name="search-type" value="normal" />
  </label>
  <button type="submit" class="search-submit" ><i class="fas fa-search"></i><span class="screen-reader-text">Submit Sitewide Search</span></button>
</form>