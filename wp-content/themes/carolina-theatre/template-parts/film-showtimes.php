<?php 
	date_default_timezone_set('America/New_York');
	$today = date("Ymd", strtotime('today'));	
?>
<ul class="showInfo__showdates">
	<?php if (have_rows('showtimes')) { // output all dates for a show
    while (have_rows('showtimes')) { the_row(); ?>
    	<?php 
      	$date = get_sub_field('date');
				$times = get_sub_field('times');
				$classes = '';
				
				if($date < $today){
					$classes = ' past';
				} 
			?>
    <li class="showInfo__date<?php echo $classes; ?>"><span class="date"><?php echo date('D, M j', strtotime($date)); ?></span>
    <?php if (have_rows('times')) { // output all times for a given date ?>
    	<ul class="showInfo__times">
        <?php while (have_rows('times')) { the_row(); ?>
        	<?php $time = get_sub_field('time'); ?>
       	 	<li>
       	 		<span class="time"><?php echo date('g:ia', strtotime($time)); ?></span>
       	 		<a href="<?php echo $ticket_link; ?>" target="_blank"></a>
       	 	</li>
        <?php } // endwhile times ?>
      </ul>
     <?php } // endif times ?>
     </li>
   <?php } // endwhile showtimes ?>
  <?php } //endif showtimes ?>
</ul>
