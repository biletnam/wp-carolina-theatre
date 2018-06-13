<?php 
// Get soonest date
$start_date = get_field('start_date'); 	
$showtime_soonestDate = $start_date; 	
$showtime_soonestTime = ''; 
$upcoming_showtimes = array();
$showtimes = get_field('showtimes');

if(is_array($showtimes) || is_object($showtimes)){
	$i = 0;
	foreach($showtimes as $showtime){	
		if ($showtime['date'] >= $today){	
		  $j = 0;	
			$upcoming_showtimes[$i]['date'] = $showtime['date'];	
	  	$times = $showtime['times'];	
	  	
	  	if(is_array($times) || is_object($times)){
		  	foreach($times as $time) {	
					$upcoming_showtimes[$i]['times'][$j] = $time;	
				  $j++;	
		  	}	
		  }
		  $i++;	
	  }	
	}
	$showtime_soonestDate = $upcoming_showtimes[0]['date']; 	
	
	if($showtime_soonestTime != NULL){
		$showtime_soonestTime = $upcoming_showtimes[0]['times'][0]['time']; 	
	}
}
?>