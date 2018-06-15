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
			<?php 
			$i = count(get_the_category());
			foreach((get_the_category()) as $category){
        echo '<em>'.$category->name.'</em>';
        if($i > 1){
        echo ', ';
        }
        $i--;
      } 
      ?>
			</div>
      <?php } ?>
    </div>
    <div class="button card__button"><span>Read More <i class="fas fa-arrow-right"></i></span></div>
  </a>
</div>