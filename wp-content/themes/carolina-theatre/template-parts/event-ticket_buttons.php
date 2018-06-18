<?php 
	$tickets = get_field('event_areticketsbeingsold');
	$ticket_link = get_field('ticket_link'); 												// url
	$tickets_onsaledate = get_field('tickets_onsaledate'); 					// 2018-06-06 20:55:09  |  Y-m-d H:i:s
	$tickets_presaledate = get_field('tickets_presaledate'); 				// 2018-06-06 20:55:09  |  Y-m-d H:i:s
	
	date_default_timezone_set('America/New_York');
	$dateTime_now = date('Y-m-d H:i:s');

	$event_soldout = get_field('event_soldout');
?>

<?php if(!$event_soldout){ ?>
	<?php 
	if ($tickets_presaledate > $dateTime_now){ ?>
		<a title="Presale tickets go on sale <?php echo date('l, F j', strtotime($tickets_presaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_presaledate)); ?>" class="button disabled"><i class="far fa-ticket-alt"></i> Presale Begins <?php echo date('n/j', strtotime($tickets_presaledate)); ?></a>
  	<p class="small"><i><strong>General Tickets</strong> <?php echo date('F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?></i></p>
	<?php } 
  else if($tickets_presaledate <= $dateTime_now && $tickets_presaledate != NULL) { ?>
  	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Presale Tickets to <?php the_title(); ?>" class="button"><i class="far fa-ticket-alt"></i> Presale Tickets</a>
  	<p class="small"><i><strong>General Tickets</strong> <?php echo date('F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?></i></p>
	<?php }
	else if($tickets_onsaledate > $dateTime_now){ ?>
		<a title="Tickets available <?php echo date('l, F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?>" class="button disabled"><i class="far fa-ticket-alt"></i> Tickets <?php echo date('n/j', strtotime($tickets_onsaledate)); ?></a>
	<?php } 
	else if($tickets_onsaledate <= $dateTime_now && $tickets_onsaledate != NULL){ ?>
  	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button"><i class="far fa-ticket-alt"></i> Buy Tickets</a> 
	<?php } 
	else if($ticket_link != NULL && $tickets_onsaledate == NULL){ ?>
  	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button"><i class="far fa-ticket-alt"></i> Buy Tickets</a> 
	<?php }
	else if($tickets) { ?> 
  	<a target="_blank" title="Tickets To Be Announced" class="button disabled"><i class="far fa-ticket-alt"></i> Tickets TBA</a> 
	<?php
	} 
} else { ?> 
	<a title="Tickets are sold out." class="button disabled"><i class="far fa-ticket-alt"></i> Sold Out</a>
<?php } // if event's sold out or not ?>
