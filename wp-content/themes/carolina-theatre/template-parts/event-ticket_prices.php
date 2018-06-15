<?php // EVENT TICKET PRICES ?>
<?php 
	$ticket_prices = get_field('ticket_prices'); // repeater 
	$ticket_string = 'TBA';
	
	if($ticket_prices){ 
		$pricesOrdered = array(); // array to reorder ticket prices
		foreach( $ticket_prices as $i => $price ) { // add each ticket price to the order array
			$pricesOrdered[ $i ] = $price['ticket_price'];
		}
  	// put prices in order, low to high
	  sort($pricesOrdered, SORT_NUMERIC);

	  // if a valid ticket price, make string
	  if(is_array($pricesOrdered) || is_object($pricesOrdered)){
			$ticket_string = '$';
			$ticket_string .= $pricesOrdered[0]; // use the lowest price 				
			if(count($pricesOrdered) > 1){  // and if there are more prices, add a plus sign
				$ticket_string .= '+'; 
			} 
		}
	}
?>
<p><i class="far fa-ticket-alt"></i><?php echo $ticket_string; ?></p>