<?php // for Community & Education pages, show Education Series pages
function if_community_education_page($parent){
	$communityeducation_id = 575;
	if(is_page($communityeducation_id) || $parent == $communityeducation_id){
		$educationseries_args = array(
			'post_type' => array('education'),
			'post_status' => 'publish',
			'posts_per_page' => -1,
	    'order' => 'ASC',
		);

		$educationseries_loop = new WP_Query($educationseries_args);
	  if( $educationseries_loop->have_posts() ) { ?>
	    <?php while( $educationseries_loop->have_posts() ){ $educationseries_loop->the_post(); ?>
    	<li class="page_item"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
	    <?php } // endwhile;
 		} wp_reset_postdata();
	}
}

function if_events_page($parent){
	$event_id = 4;
	if (is_page($event_id) || $parent == $event_id){ ?>	
	<li class="page_item"><a href="<?php echo get_the_permalink($event_id); ?>">All Events</a></li>
	<?php
	}
}
?>

<section class="pageHeading contain">
	<div class="container">
		<?php 
			$children = get_pages( array( 'child_of' => $post->ID ) ); 
			$parent = $post->post_parent;

			// Get ID of the 'top most' page 
			// $parents = get_post_ancestors( $post->ID );
			// $ancestor = ($parents) ? $parents[count($parents)-1]: 0;
		?>
		<?php if(count($children) > 0){ ?>
		<h1 class="pageTitle"><?php echo get_the_title(); ?></h1>
		<div class="tabbedContent__tabs relatedPages children">
			<ul>
				<?php if_events_page($parent); ?>
				<?php // show children of current page
					wp_list_pages(array(
				    'child_of' => $post->ID,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
				<?php if_community_education_page($parent); ?>
			</ul>
		</div>
		<?php } else if($parent){ ?>
		<h1 class="pageTitle"><?php echo get_the_title($parent); ?></h1>
		<div class="tabbedContent__tabs relatedPages siblings">
			<ul>
				<?php if_events_page($parent); ?>
				<?php // if current post has no children, show siblings
					wp_list_pages(array(
				    'child_of' => $post->post_parent,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
				<?php if_community_education_page($parent); ?>
			</ul>
		</div>
		<?php } else { ?>
		<h1 class="pageTitle"><?php echo get_the_title(); ?></h1>
		<?php } ?>
	</div>
</section>