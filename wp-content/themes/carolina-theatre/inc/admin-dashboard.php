<?php

/*
 * Add/Remove custom columns to 'series' post type:
 */
add_filter( 'manage_series_posts_columns', 'set_custom_edit_series_columns' );
function set_custom_edit_series_columns($columns) {
  unset( $columns['tags'] );
  unset( $columns['categories'] );
  unset( $columns['date'] );

  return $columns;
}

/*
 * Add/Remove custom columns to 'festival' post type:
 */
add_filter( 'manage_festival_posts_columns', 'set_custom_edit_festival_columns' );
function set_custom_edit_festival_columns($columns) {
  unset( $columns['tags'] );
  unset( $columns['categories'] );
  unset( $columns['date'] );

  return $columns;
}

/*
 * Add/Remove custom columns to 'education' post type:
 */
add_filter( 'manage_education_posts_columns', 'set_custom_edit_education_columns' );
function set_custom_edit_education_columns($columns) {
  unset( $columns['tags'] );
  unset( $columns['categories'] );
  unset( $columns['date'] );

  return $columns;
}


/*
 * Add/Remove custom columns to 'film' post type:
 */
add_filter( 'manage_film_posts_columns', 'set_custom_edit_film_columns' );
function set_custom_edit_film_columns($columns) {
  unset( $columns['tags'] );
  unset( $columns['categories'] );
  unset( $columns['date'] );
  $columns['upcoming'] = __( 'Upcoming', 'carolinatheatre' );
  $columns['start_date'] = __( 'Starting', 'carolinatheatre' );
  $columns['end_date'] = __( 'Ending', 'carolinatheatre' );
  $columns['parent_event'] = __( 'Parent Event', 'carolinatheatre' );
  // $columns['thumbnail'] = __( 'Thumbnail', 'carolinatheatre' );

  return $columns;
}

// Add the data to the custom columns for the 'film' post type:
add_action( 'manage_film_posts_custom_column' , 'custom_film_column', 10, 2 );
function custom_film_column( $column, $post_id ) {
  switch ( $column ) {

    case 'parent_event' :
      $festival_id = get_field('associated_event', $post_id);
      $festival_name = get_the_title($festival_id);

      if($festival_id){
        echo $festival_name;
      } else {
        echo '';
      }
      break;

    case 'upcoming' :
      $today = date("Ymd", strtotime('today'));
      $start_date = get_field('start_date', $post_id);
      $end_date = get_field('end_date', $post_id);
      if($end_date == NULL) { $end_date = $start_date; }
      
      if($today >= $start_date && $today < $end_date){
      	echo 'Now Playing';
      } else if ($end_date == $today) {
      	echo 'Ends Today';
      } else if ($end_date > $today){
	      echo 'Upcoming';
      } else {
      	echo 'Past Event';
      }
      break;

    case 'start_date' :
      $start_date = get_field('start_date', $post_id);
      
      if ($start_date){
	      echo date("M j, Y", strtotime($start_date));
      } else {
      	echo '';
      }
      break;

   	case 'end_date' :
      $end_date = get_field('end_date', $post_id);

      if ($end_date){
	      echo date("M j, Y", strtotime($end_date));
      } else {
      	echo '';
      }
      break;

		// case 'thumbnail' :
		// 	if (have_rows('event_hero')){
		// 		$slideRepeater = get_field('panel_content', $post_id);
		// 		$image = $slideRepeater[0]['image'];

		// 		if($image){ 
		// 			$image_url = $image['sizes']['thumbnail'];
		// 			$image_alt = $image['alt'];
		// 			echo '<img src="'.$image_url.'" alt="'.$image_alt.'" />';
		// 		}
		// 	} 
		// 	break;
  }
}

// Make custom columns sortable
add_filter( 'manage_edit-film_sortable_columns', 'sortable_film_columns' );
function sortable_film_columns( $columns ) {
  $columns['parent_event'] = 'parent_event';
  $columns['upcoming'] = 'upcoming';
  $columns['start_date'] = 'start_date';
  $columns['end_date'] = 'end_date';
  return $columns;
}

// Tell WP how to sort the custom columns with weird meta_keys
add_action( 'pre_get_posts', 'manage_wp_film_posts_pre_get_posts', 1 );
function manage_wp_film_posts_pre_get_posts( $query ) {
   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
      switch( $orderby ) {
         case 'start_date':
            $query->set( 'meta_key', 'start_date' );
            $query->set( 'orderby', 'meta_value' );      
            break;

        case 'end_date':
            $query->set( 'meta_key', 'end_date' );
            $query->set( 'orderby', 'meta_value' );      
            break;
      }
   }
}



/*
 * Add/Remove custom columns to 'event' post type:
 */
add_filter( 'manage_event_posts_columns', 'set_custom_edit_event_columns' );
function set_custom_edit_event_columns($columns) {
  unset( $columns['tags'] );
  unset( $columns['categories'] );
  unset( $columns['date'] );
  $columns['upcoming'] = __( 'Upcoming', 'carolinatheatre' );
  $columns['start_date'] = __( 'Starting', 'carolinatheatre' );
  $columns['end_date'] = __( 'Ending', 'carolinatheatre' );

  return $columns;
}

// Add the data to the custom columns for the 'event' post type:
add_action( 'manage_event_posts_custom_column' , 'custom_event_column', 10, 2 );
function custom_event_column( $column, $post_id ) {
  switch ( $column ) {
  	case 'upcoming' :
      $today = date("Ymd", strtotime('today'));
      $start_date = get_field('start_date', $post_id);
      $end_date = get_field('end_date', $post_id);
      if($end_date == NULL) { $end_date = $start_date; }
      
      if($today >= $start_date && $today < $end_date){
      	echo 'Now Playing';
      } else if ($end_date == $today) {
      	echo 'Ends Today';
      } else if ($end_date > $today){
	      echo 'Upcoming';
      } else {
      	echo 'Past Event';
      }
      break;

    case 'start_date' :
      $start_date = get_field('start_date', $post_id);
      
      if ($start_date){
	      echo date("M j, Y", strtotime($start_date));
      } else {
      	echo '';
      }
      break;

   	case 'end_date' :
      $end_date = get_field('end_date', $post_id);

      if ($end_date){
	      echo date("M j, Y", strtotime($end_date));
      } else {
      	echo '';
      }
      break;
  }
}

// Make custom columns sortable
add_filter( 'manage_edit-event_sortable_columns', 'sortable_event_columns' );
function sortable_event_columns( $columns ) {
  $columns['upcoming'] = 'upcoming';
  $columns['start_date'] = 'start_date';
  $columns['end_date'] = 'end_date';
  return $columns;
}

// Tell WP how to sort the custom columns with weird meta_keys
add_action( 'pre_get_posts', 'manage_wp_event_posts_pre_get_posts', 1 );
function manage_wp_event_posts_pre_get_posts( $query ) {
   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
      switch( $orderby ) {
         case 'start_date':
            $query->set( 'meta_key', 'start_date' );
            $query->set( 'orderby', 'meta_value' );      
            break;

        case 'end_date':
            $query->set( 'meta_key', 'end_date' );
            $query->set( 'orderby', 'meta_value' );      
            break;
      }
   }
}


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

/**
 * Reorder Menu Items in WordPress Dashboard
 */
function custom_menu_order($menu_ord) {
    if (!$menu_ord) return true;
     
    return array(
        'index.php', // Dashboard
        'upload.php', // Media
        'edit.php?post_type=page', // Pages
				'separator1', // First separator
				// 'edit.php?post_type=blog', // News Posts
        'edit.php?post_type=event', // // Custom Post: Live Events
        'edit.php?post_type=film', // // Custom Post: Films
        'edit.php?post_type=series', // // Custom Post: Film Series
        'edit.php?post_type=festival', // Custom Post: Film Festivals
        'edit.php?post_type=education', // // Custom Post: Education Series
        'separator2', // Second separator
        'edit.php', // Posts
        'edit.php?post_type=alertbanner', // Custom Post: Alert Banners
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
?>