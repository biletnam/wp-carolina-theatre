<?php
/**
 * Template Name: News & Press
 * The template for displaying archived blog pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) { the_post(); ?>

<section class="featuredEvent_carousel">
  <div class="container contain">
  	<h1>News & Press</h1>
    <?php get_template_part('template-parts/part', 'featured_news'); ?>
  </div>
</section>
<section class="mainContent upcoming-events contain">
  <div class="mainContent__content">
    <div class="container">

    	<?php // The Query
 			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
      $limit = 9;
			$post_query_args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'paged' => $paged,
				'orderby' => 'date',
				'order' => 'DESC'
			);

			// The Loop
			$posts_query = new WP_Query($post_query_args);
			if ($posts_query->have_posts()) { ?>
	      <div class="card__wrapper">
					<?php while ($posts_query->have_posts()) { $posts_query->the_post(); ?>
					  <div class="card newsCard">
					  	<a href="<?php echo get_page_link(get_the_id()); ?>">
						  	<div class="card__infoWrapper">
									<p class="card__subtitle h5"><?php echo get_the_date('F j'); ?></p>
									<p class="card__title"><?php the_title(); ?></p>
									<div class="card__info">
										<div class="card__excerpt small"><?php the_excerpt(); ?></div>	
									</div>
									<?php if(get_the_category()){ ?>
									<div class="card__categories">
									<i class="far fa-tag"></i>
									<?php foreach((get_the_category()) as $category){
						        echo '<em>'.$category->name.'</em>';
					        } ?>
									</div>
					        <?php } ?>
			          </div>
					      <div class="button card__button"><span>Read More <i class="fas fa-arrow-right"></i></span></div>
					    </a>
					  </div>
		  		<?php } // endwhile have_posts posts_query ?>
	 			</div>

				<div class="paginate">
			    <?php 
		        $paginate_links = paginate_links( array(
	            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
	            'total'        => $posts_query->max_num_pages,
	            'current'      => max( 1, get_query_var( 'paged' ) ),
	            'format'       => '?paged=%#%',
	            'show_all'     => false,
	            'type'         => 'array',
	            'end_size'     => 1,
	            'mid_size'     => 0,
	            'prev_next'    => true,
	            'prev_text'    => '<i class="fas fa-chevron-left"></i>',
	            'next_text'    => '<i class="fas fa-chevron-right"></i>',
	            'add_args'     => false,
	            'add_fragment' => '',
		        ) );

		        $paginate_next       = '';
						$paginate_current    = '1';
						$paginate_prev       = '';
						$paginate_pages			 = '1';

						if($posts_query->max_num_pages != 0) {
							$paginate_pages = $posts_query->max_num_pages;
						}

						foreach( $paginate_links as $link ) {           
					    if( false !== strpos( $link, 'prev ' ) ){
				        $paginate_prev = $link;
					    } else if( false !== strpos( $link, ' current' ) ){
				        $paginate_current = $link;       
					    } else if( false !== strpos( $link, 'next ' ) ){
				        $paginate_next = $link;
					    }
						}
			    ?>
			    <div class="paginate__prev"><?php echo $paginate_prev; ?></div>
			    <div class="paginate__current"><?php echo 'Page '. $paginate_current . ' of '. $paginate_pages; ?></div>
			    <div class="paginate__next"><?php echo $paginate_next; ?></div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php } else { ?>
			<div class="card__wrapper">
			 No news at this time.
			</div>
			<?php } // endif have_posts posts_query ?>
    </div><!-- .container -->
  </div><!-- .mainContent__content -->
  <?php get_sidebar('news'); ?>
</section>
<?php } // endwhile; ?>

<?php get_footer();
