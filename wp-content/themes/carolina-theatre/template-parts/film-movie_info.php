<?php
	$film_director = get_field('director'); 												// text
	$film_release_country = get_field('release_country'); 					// text
	$film_release_year = get_field('release_year'); 								// text
	$film_runtime = get_field('runtime'); 													// text
	$film_rating = get_field('rating');															// select
?>

<?php if ($film_director) { ?>
<div>
    <h5>Director</h5>
    <p><?php echo $film_director; ?></p>
</div>
<?php } ?>
<?php if ($film_release_year) { ?>
<div>
    <h5>Release Year</h5>
    <p><?php echo $film_release_year; ?></p>
</div>
<?php } ?>
<?php if ($film_release_country) { ?>
<div>
    <h5>Release Country</h5>
    <p><?php echo $film_release_country; ?></p>
</div>
<?php } ?>
<?php if ($film_runtime) { ?>
<div>
    <h5>Runtime</h5>
    <p><?php echo $film_runtime; ?> min</p>
</div>
<?php } ?>
<?php if ($film_rating) { ?>
<div>
    <h5>MPAA Rating</h5>
    <p><?php echo $film_rating; ?></p>
</div>
<?php } ?>

