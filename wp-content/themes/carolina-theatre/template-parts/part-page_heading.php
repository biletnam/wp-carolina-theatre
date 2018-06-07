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
				<?php // show children of current page
					wp_list_pages(array(
				    'child_of' => $post->ID,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
			</ul>
		</div>
		<?php } else if($parent){ ?>
		<h1 class="pageTitle"><?php echo get_the_title($parent); ?></h1>
		<div class="tabbedContent__tabs relatedPages siblings">
			<ul>
				<?php // if current post has no children, show siblings
					wp_list_pages(array(
				    'child_of' => $post->post_parent,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
			</ul>
		</div>
		<?php } else { ?>
		<h1 class="pageTitle"><?php echo get_the_title(); ?></h1>
		<?php } ?>
	</div>
</section>