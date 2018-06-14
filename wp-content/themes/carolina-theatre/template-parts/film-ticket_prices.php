<?php // FILM TICKET PRICES ?>
<?php 
	$ticket_string = '';
	if(have_rows('ticket_prices')){ 
		$i = 0;
		while(have_rows('ticket_prices')){ the_row();
			$ticket_price = get_sub_field('ticket_price');
			$ticket_label = get_sub_field('ticket_label'); 
			
			if($i == 0) {
				$ticket_string .= '<p class="primary">';
			} else if($i == 1) {								
				$ticket_string .= '<p class="small"><span>';
			} else {
				$ticket_string .= '<span>';
			}
			$ticket_string .= '$'.$ticket_price;

			if($ticket_label){
				$ticket_string .= ' ' . $ticket_label;
			}
			if($i == 0){
				$ticket_string .= '</p>';
			} else {
				$ticket_string .= '</span>';
			}
			$i++;
		}
		$ticket_string .= '</p>';

	}
?>
<div class="ticket__prices"><?php echo $ticket_string; ?></div>