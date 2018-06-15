<?php
/**
 * The main sidebar
 */
?>
<aside class="mainContent__sidebar">
	<div class="container">    
		<div class="sidebar__menu">
			<h3>Recent Posts</h3>
			<?php 
			$this_post = $post->ID;
			$recentPosts_args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 4,
			);
			$recentPosts_query = new WP_Query($recentPosts_args); ?>
			<?php if ($recentPosts_query->have_posts()) { ?>
				<ul>
				<?php while ($recentPosts_query->have_posts()) { $recentPosts_query->the_post(); ?>
					<li<?php if($this_post == get_the_ID()){ echo ' class="current-page-item"'; }?>><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
				<?php } ?>
				</ul>
				<?php wp_reset_postdata(); ?>
			<?php } else { ?>
			 No recent posts.
			<?php } // endif have_posts recentPosts_query ?>
		</div>
   	<div>
   		<h3>Archives</h3>
   		<?php $args = array(
				'type'            => 'monthly',
				'limit'           => '',
				'format'          => 'option', 
				'before'          => '',
				'after'           => '',
				'show_post_count' => 0,
				'echo'            => 1,
				'order'           => 'DESC',
        'post_type'     	=> 'post'
			);
			?>
			<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
			  <option value=""><?php echo esc_attr( __( '- Select Month -' ) ); ?></option> 
			  <?php wp_get_archives( $args ); ?>
			</select>
   	</div>
   	<div>
   		<h3>Categories</h3>
   		<?php $args = array(
				'show_option_all'    => '',
				'show_option_none'   => '- Select Category -',
				'option_none_value'  => '-1',
				'orderby'            => 'name',
				'order'              => 'ASC',
				'show_count'         => 0,
				'hide_empty'         => 1,
				'child_of'           => 0,
				'exclude'            => '',
				'include'            => '',
				'echo'               => 1,
				'selected'           => 'term_id',
				'hierarchical'       => 0,
				'name'               => 'cat',
				'id'                 => '',
				'class'              => 'postform',
				'depth'              => 0,
				'tab_index'          => 0,
				'taxonomy'           => 'category',
				'hide_if_empty'      => true,
				'value_field'	     	 => 'term_id',
			); ?>
	    <?php wp_dropdown_categories( $args ); ?>
			<script type="text/javascript">
		    var dropdown = document.getElementById("cat");
		    function onCatChange() {
	        if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
            location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat="+dropdown.options[dropdown.selectedIndex].value;
	        }
		    }
		    dropdown.onchange = onCatChange;
			</script>
   	</div>
		<?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
	</div>
</aside>