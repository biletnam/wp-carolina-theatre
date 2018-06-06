<?php
/**
 * The main sidebar
 */
?>
<aside class="mainContent__sidebar">
	<div class="container">    
    <?php // get furthest ancestor of current page
			$parent = $post->ID;
			if ($post->post_parent)	{
				$ancestors = get_post_ancestors($post->ID);
				$root = count($ancestors)-1;
				$parent = $ancestors[$root];
			}
		?>
		<?php if($post->ID != $parent){ ?>
		<div class="sidebar__menus">
			<div class="sidebar__menu">
				<p class="h3"><?php echo get_the_title($parent); ?></p>
				<ul>
				<?php 
					wp_list_pages(array(
				    'child_of' => $parent,
				    'post_status' => 'publish',
				    'title_li' => null,
				    'depth' => 1
					));
				?>
				</ul>
			</div>
		</div>
		<?php } // endif this page doesnt equal parent ?>

    <?php // TO-DO: ACF - Sidebar Additional Textblock ?>
    <div class="sidebar__text small">
    	random text goes here.
    </div>
    <?php // TO-DO: ACF - Sidebar Link Blocks ?>
    <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>

	</div>
</aside>