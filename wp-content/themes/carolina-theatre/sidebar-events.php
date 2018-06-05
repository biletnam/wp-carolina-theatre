<?php
/**
 * The Events (and Films) Template sidebar
 */
?>
<aside class="mainContent__sidebar">
	<div class="container">
    <?php // TO-DO: Get search setup ?>
    <div class="upcoming-events__sidebar--search">
      <input type="text" placeholder="Search..." />
      <button>Search Events</button>
    </div>
    <?php // TO-DO: Get sidebars setup ?>

    <div class="sidebar__menus">
    	<div class="sidebar__menu">
        <p class="h3">Upcoming Film Series</p>
        <ul>
            <li><a href="#" title="">Retro Epics ››</a></li>
            <li><a href="#" title="">Anime-Magic ››</a></li>
            <li><a href="#" title="">SplatterFlix ››</a></li>
            <li><a href="#" title="">Fantastic Realm ››</a></li>
            <li><a href="#" title="">Retro ArtHouse ››</a></li>
        </ul>
      </div>
      <div class="sidebar__menu">
        <p class="h3">Upcoming Film Festivals</p>
        <ul>
          <li><a href="#" title="">NC Gay &amp; Lesbian Film Festival >></a></li>
          <li><a href="#" title="">Nevermore ››</a></li>
          <li><a href="#" title="">Full Frame ››</a></li>
        </ul>
      </div>
    </div>
    
    <?php get_template_part( 'blocks/content-blocks', 'link-block' ); ?>
	</div>
</aside>