<?php
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