<?php 
	$ticket_link = get_field('ticket_link'); 												// url
	$tickets_onsaledate = get_field('tickets_onsaledate'); 					// 2018-06-06 20:55:09  |  Y-m-d H:i:s
	$tickets_presaledate = get_field('tickets_presaledate'); 				// 2018-06-06 20:55:09  |  Y-m-d H:i:s
	
	date_default_timezone_set('America/New_York');
	$dateTime_now = date('Y-m-d H:i:s');

	$event_soldout = get_field('event_soldout');
?>
<?php if($ticket_link){ ?>
	<?php if(!$event_soldout){ ?>
		<?php if($tickets_onsaledate == NULL || $tickets_onsaledate <= $dateTime_now ){ ?>
    	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Tickets to <?php the_title(); ?>" class="button"><i class="far fa-ticket-alt"></i> Buy Tickets</a>
    <?php } else if($tickets_presaledate != NULL && $tickets_presaledate <= $dateTime_now) { ?>
    	<a href="<?php echo $ticket_link; ?>" target="_blank" title="Purchase Presale Tickets to <?php the_title(); ?>" class="button"><i class="far fa-ticket-alt"></i> Presale Tickets</a>
    	<p class="small"><i><strong>General Tickets</strong> <?php echo date('F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?></i></p>

  	<?php } else if ($tickets_presaledate > $dateTime_now){ ?>
			<a title="Presale tickets go on sale <?php echo date('l, F j', strtotime($tickets_presaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_presaledate)); ?>" class="button disabled"><i class="far fa-ticket-alt"></i> Presale Begins <?php echo date('n/j', strtotime($tickets_presaledate)); ?></a>
    	<p class="small"><i><strong>General Tickets</strong> <?php echo date('F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?></i></p>
  	<?php } else { ?>
  		<a title="Tickets available <?php echo date('l, F j', strtotime($tickets_onsaledate)); ?> at <?php echo date('g:ia', strtotime($tickets_onsaledate)); ?>" class="button disabled"><i class="far fa-ticket-alt"></i> Tickets <?php echo date('n/j', strtotime($tickets_onsaledate)); ?></a>
  	<?php } ?>
	<?php } else { ?> 
  	<a title="Tickets are sold out." class="button disabled"><i class="far fa-ticket-alt"></i> Sold Out</a>
	<?php } // if event's sold out or not ?>
<?php } else { ?>
	<a title="Tickets to be announced." class="button disabled"><i class="far fa-ticket-alt"></i> Tickets TBA</a>
<?php } // if there's a main ticket link ?>