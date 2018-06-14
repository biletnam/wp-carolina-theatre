<?php
/**
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
<?php get_template_part( 'template-parts/part', 'breadcrumb' ); ?>
<section class="featuredEvent_carousel">
  <div class="container contain">
  	<h1>News & Press</h1>
  	<?php if(is_category()){ ?>
  	<h3>Category: <?php single_cat_title(); ?></h3>
  	<?php } ?>
  	<?php if(is_archive() && !is_category()){ ?>
  	<h3>Posts from: <?php echo trim(single_month_title(' ',false)); ?></h3>
  	<?php } ?>
  </div>
</section>
<section class="mainContent upcoming-events contain">
  <div class="mainContent__content">
    <div class="container">
    	<?php
			// The Loop
			if (have_posts()) { ?>
	      <div class="card__wrapper">
					<?php while (have_posts()) { the_post(); ?>
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

<?php get_footer();
