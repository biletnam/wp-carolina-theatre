<?php
/**
 * Reorder Menu Items in WordPress Dashboard
 */
function custom_menu_order($menu_ord) {
    if (!$menu_ord) return true;
     
    return array(
        'index.php', // Dashboard
        'upload.php', // Media
				'separator1', // First separator
				// 'edit.php?post_type=blog', // News Posts
        'edit.php?post_type=page', // Pages
        'edit.php?post_type=event', // // Custom Post: Live Events
        'edit.php?post_type=film', // // Custom Post: Films
        'edit.php?post_type=festival', // Custom Post: Festivals
        'edit.php', // Posts
        'edit.php?post_type=alertbanner', // Custom Post: Alert Banners
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
?>