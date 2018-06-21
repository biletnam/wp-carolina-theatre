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
  	?>
   	<?php if($sidebar_menu){ ?>
    <div class="sidebar__menus">
			<div class="sidebar__menu">
				<?php if ($sidebar_menu_title){ ?>
				<p class="h3"><?php echo $sidebar_menu_title; ?></p>
				<?php } //endif ?>				
				<?php echo $sidebar_menu; ?>
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