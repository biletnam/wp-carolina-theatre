<?php 
// function carolinatheatre_search_where($where){
//   global $wpdb;

//   if ( is_search() )
//     $where .= "OR (t.name LIKE '%".get_search_query() . "%' AND {$wpdb->posts} . post_status = 'publish')";

//   return $where;
// }

// function carolinatheatre_search_join($join){
//   global $wpdb;

//   if ( is_search() )
//     $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
//   return $join;
// }

// function carolinatheatre_search_groupby($groupby){
//   global $wpdb;

//   // we need to group on post ID
//   $groupby_id = "{$wpdb->posts} . ID";
//   if ( ! is_search() || strpos($groupby, $groupby_id) !== false )
//     return $groupby;

//   // groupby was empty, use ours
//   if ( ! strlen( trim($groupby) ) )
//     return $groupby_id;

//   // wasn't empty, append ours
//   return $groupby . ", " . $groupby_id;
// }

// add_filter('posts_where', 'carolinatheatre_search_where');
// add_filter('posts_join', 'carolinatheatre_search_join');
// add_filter('posts_groupby', 'carolinatheatre_search_groupby');



// function searchfilter($query) {
// 	if ($query->is_search && !is_admin() ) {
//     if(isset($_GET['post_type'])) {
//       $type = $_GET['post_type'];
//       if($type == 'events') {
//         $query->set('post_type', array('film', 'event'));
//       } 
//     }       
// 	}
// return $query;
// }
// add_filter('pre_get_posts','searchfilter');
?>


