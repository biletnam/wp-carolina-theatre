<?php
/**
 * The main sidebar
 */
?>
<aside class="mainContent__sidebar">
	<div class="container">    
    <?php 
    	$sidebar_menu = get_field('sidebar_menu'); 
    	$sidebar_menu_title = get_field('sidebar_menu_title'); 

    	// get furthest ancestor of current page (for fallback menu)
    	$parent = $post->ID;
			if ($post->post_parent)	{
				$ancestors = get_post_ancestors($post->ID);
				$root = count($ancestors)-1;
				$parent = $ancestors[$root];
			}
  	?>
   	<?php if($sidebar_menu){ ?>
    <div class="sidebar__menus">
			<div class="sidebar__menu">
				<p class="h3"><?php echo $sidebar_menu_title; ?></p>
				<?php echo $sidebar_menu; ?>
			</div>
		</div>
    <?php } elseif($post->ID != $parent){ ?>
		<div class="sidebar__menus">
			<div class="sidebar__menu">
				<?php if ($sidebar_menu_title){ ?>
				<p class="h3"><?php echo $sidebar_menu_title; ?></p>
				<?php } else { ?>
				<p class="h3"><?php echo get_the_title($parent); ?></p>
				<?php } //endif ?>
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
		<?php } // endif sidebar menus ?>
   	
   	

    <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
    <?php get_template_part( 'template-parts/event', 'external_links' ); ?>

    <?php 
    	$additional_text = get_field('sidebar_additional_text');
   		if($additional_text){
   	?>
    <div class="sidebar__text">
    	<p class="small"><?php echo $additional_text; ?><p>
    </div>
    <?php } // endif additional text ?>
	</div>
</aside>