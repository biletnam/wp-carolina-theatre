<?php
/**
 * The main sidebar
 */
?>
<aside class="mainContent__sidebar">
	<div class="container">    
		<div>
			<h3>Recent Posts</h3>
		</div>
   	<div>
   		<h3>Archives</h3>
   	</div>
   	<div>
   		<h3>Categories</h3>
   	</div>
   	<?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
	</div>
</aside>