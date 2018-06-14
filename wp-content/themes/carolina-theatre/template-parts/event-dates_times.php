<?php // EVENT DATES & TIMES
date_default_timezone_set('America/New_York');
$today = date("Ymd", strtotime('today'));
$i = 0;
if (have_rows('showtimes')) { // output all dates for a show
  while (have_rows('showtimes')) { the_row();
    	$date = get_sub_field('date');
			$times = get_sub_field('times');
			$classes = '';
			
			if($date < $today){
				$classes = ' past';
			} 
		?>
	  <li class="showInfo__date<?php echo $classes; ?>">
			<?php 
			if($i == 0){ 
				echo '<i class="far fa-calendar-alt"></i>';
			} 
			
			echo date('D, F j', strtotime($date));

  	  if (have_rows('times')) { // output all times for a given date
				$num_times = count($times);
				$j = 0;
				while (have_rows('times')) { the_row(); 
					if($j == 0){ echo ' at '; }
					echo date('g:ia', strtotime(get_sub_field('time')));
					if($j < $num_times - 1){ echo ', '; }
					$j++;
				} // endwhile times
			} // endif times
			$i++; 
			?>
	  </li>
  <?php 
 	} // endwhile showtimes
} //endif showtimes
?>   