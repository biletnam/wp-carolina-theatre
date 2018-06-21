<?php
/**
 * The Events (and Films) Template sidebar
 */
?>
<aside class="mainContent__sidebar">
	<div class="container">		

    <div class="upcoming-events__sidebar--search">
			<h3>Search Sitewide</h3>
			<?php get_template_part('/searchform'); ?>
    </div>

    <div class="upcoming-events__sidebar--search">
			<h3>Search Events</h3>
			<?php get_template_part('/searchform', 'events'); ?>
    </div>
 
 	</div>
</aside>