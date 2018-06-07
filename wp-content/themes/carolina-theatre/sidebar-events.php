<?php
/**
 * The Events (and Films) Template sidebar
 */
?>
<aside class="mainContent__sidebar">
	<div class="container">
    <?php // TO-DO: Get search setup ?>
    <div class="upcoming-events__sidebar--search">
      <input type="text" placeholder="Search..." />
      <button>Search Events</button>
    </div>
    <?php // TO-DO: Get sidebars setup ?>

    <div class="sidebar__menus">
      <?php $today = date("Ymd", strtotime('today')); ?>
      <?php 
        $festival_query_args = array(
					'post_type' => array('festival'),
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'meta_query'	=> array(
						'relation' => 'OR',
						'start_clause' => array( // if event hasn't started yet
							'key'		=> 'start_date', 
							'compare'	=> '>=',
							'value'		=> $today,
						),
						'end_clause' => array( // if event hasn't ended yet
							'key'		=> 'end_date',
							'compare'	=> '>=',
							'value'		=> $today,
						),
					),
					'orderby' => 'ASC',
				);
      ?>
			
			<?php $festival_query = new WP_Query($festival_query_args); ?>
			<?php if ($festival_query->have_posts()) { ?>
    	<div class="sidebar__menu">
        <p class="h3">Upcoming Film Festivals</p>
				<ul>
					<?php while ($festival_query->have_posts()) { $festival_query->the_post(); ?>
          <li><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
          <?php } // end while ?>
        </ul>
      </div>
      <?php } // end if festivals ?>

      <?php 
        $filmseries_query_args = array(
					'post_type' => array('series'),
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'meta_query'	=> array(
						'relation' => 'OR',
						'start_clause' => array( // if event hasn't started yet
							'key'		=> 'start_date', 
							'compare'	=> '>=',
							'value'		=> $today,
						),
						'end_clause' => array( // if event hasn't ended yet
							'key'		=> 'end_date',
							'compare'	=> '>=',
							'value'		=> $today,
						),
					),
					'orderby' => 'ASC',
				);
      ?>
			
			<?php $filmseries_query = new WP_Query($filmseries_query_args); ?>
			<?php if ($filmseries_query->have_posts()) { ?>
    	<div class="sidebar__menu">
        <p class="h3">Upcoming Film Series</p>
				<ul>
					<?php while ($filmseries_query->have_posts()) { $filmseries_query->the_post(); ?>
          <li><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
          <?php } // end while ?>
        </ul>
      </div>
      <?php } // end if film series ?>
    </div>
    
    <?php get_template_part( 'template-parts/content-blocks/block', 'link_block' ); ?>
	</div>
</aside>