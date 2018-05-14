<?php
// Template name: Events Template
get_header();
?>
<div class="container">
        <section class="featured">
            <h2>Featured Events</h2>
            <div class="featured__container">
                <div class="carousel">
                    <?php
                    $featured = get_field('featured_events');

                    foreach($featured as $feature_obj) { 
                        $featured_ID = $feature_obj->ID;
                        ?>
                        <div class="featured__container--event">
                            <div class="featured__image">
                                <img src="<?php  echo get_field('event_image', $featured_ID)["url"];?>"
                                    alt="event poster" />
                                    
                            </div>
                            <div class="featured__event-info">
                                <div class="featured__event-info--content">
                                    <h5>
                                        <?php 
                                             
                                            if (get_post_type($featured_ID) == "film") {
                                                echo "Film";
                                            } else {
                                                echo join(get_field('single_event_type', $featured_ID), ', ');
                                            }
                                        ?>
                                    </h5>
                                    <h3><?php echo $feature_obj->post_title; ?></h3>
                                    <p><?php echo $feature_obj->post_content; ?></p>
                                    <ul>
                                        <li>
                                            <i class="fa fa-calendar"></i>
                                            <?php
                                                // convert date strings to integers for sorting
                                                $featured_event_dates = array();
                                                if (have_rows('showtimes', $featured_ID)) {
                                                    while (have_rows('showtimes', $featured_ID)) {
                                                        the_row();
                                                        $featured_event_date = strtotime(get_sub_field('dates'));
                                                        array_push($featured_event_dates, $featured_event_date);
                                                    }
                                                }

                                                $featured_start_date = min($featured_event_dates);
                                                $featured_end_date = max($featured_event_dates);
                                                $featured_start_date_string = date("F d, Y", min($featured_event_dates));
                                                $featured_end_date_string = date("F d, Y", max($featured_event_dates));
                                                echo $featured_start_date_string . ' - ' . $featured_end_date_string;
                                            ?> 
                                        </li>
                                        <li>
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <?php 
                                                $featured_location = get_field('location', $featured_ID);
                                                 
                                                if (count($featured_location) > 1) {
                                                    echo join(", ", $featured_location);
                                                } else {
                                                    echo $featured_location[0];
                                                }
                                            ?>
                                        </li>
                                        <li>
                                            <i class="fa fa-ticket" aria-hidden="true"></i>
                                            <?php 
                                                $multiple_ticket_prices = array();
                                                if (have_rows('ticket_prices', $featured_ID)) {
                                                    while (have_rows('ticket_prices', $featured_ID)) {
                                                        the_row();
                                                        $price = get_sub_field('price');
                                                        array_push($multiple_ticket_prices, $price);
                                                    }
                                                }
                                                echo '$' . join(', ', $multiple_ticket_prices);
                                            ?>
                                        </li>
                                    </ul>
                                    <a href="<?php echo get_page_link($featured_ID); ?>"><button>More Info</button></a>
                                    <button>Tickets</button>
                                </div> <!-- "featured__event-info- -content" -->
                            </div> <!-- "featured__event-info" -->
                        </div> <!-- "featured__container- -event" -->
                    <?php 
                    } ?>
                </div> <!-- "carousel" -->
            </div> <!-- "featured__container" -->
        </section>
        <section class="upcoming-events shows clearfix">
            <div class="upcoming-events__event-cards">
                <div class="cards__header">
                    <h2>Upcoming Events</h2>
                    <?php 
                        
                        
                    ?>
                    <ul class='upcoming-events__type'>
                        <li class='active-filter'>All</li>
                        <li>Film</li>
                        <li>Music</li>
                        <li>Comedy</li>
                        <li>Theater</li>
                        <li>Discussion</li>
                        <li>Dance</li>
                        <li>Family Saturday</li>
                        <?php 
                            $standard_events = array("Music", "Comedy", "Theater", "Discussion", "Dance", "Family Saturday");
                            $custom_events = array();

                            // filter events only to check for custom event types
                            $filter_query_args = array(
                                'post_type' => 'event');
                            
                            $filter_query = new WP_Query($filter_query_args);
                            
                            if ($filter_query->have_posts()) {
                                while ($filter_query->have_posts()) {
                                    $filter_query->the_post();
                                    // assumes 'End Date' and last 'Showtime' are the same in the dashboard
                                    $last_date = get_field('end_date');

                                    // if event is playing or will be in the future, append custom
                                    // event type to array
                                    if (strtotime($last_date) >= strtotime('today')) {
                                        $event_types = get_field("single_event_type");
                                        // loop thru all event types associated with post,
                                        // check if they are in $standard_events and $custom_events, if not
                                        // in either add to $custom_events
                                        foreach($event_types as $et) {
                                            if (!in_array($et, $standard_events) && !in_array($et, $custom_events)) {
                                                array_push($custom_events, $et);
                                            }
                                        }
                                    }  
                                }
                            }
                            // append $custom_events to filter list of standard events
                            if (count($custom_events) > 0) {
                                foreach($custom_events as $ce) { ?>
                                    <li><?php echo $ce ?></li>
                          <?php }
                            }
                            wp_reset_postdata();
                        ?>
                    </ul>
                    <ul class='upcoming-events__filters'>
                        <li class="active-filter">Any</li>
                        <li>Now Playing</li>
                        <li>Coming Soon</li>
                        <li class="filmFilter">Retro Epics</li>
                        <li class="filmFilter">Anime-Magic</li>
                        <li class="filmFilter">SplatterFlix</li>
                        <li class="filmFilter">Realistic Realm</li>
                        <li class="filmFilter">Retro Art House</li>
                    </ul>
                </div>
                <div class="events">
                <?php


// The Query

$events_query_args = array(
    'post_type' => array('event', 'film'),
    'meta_query' => array(
        'start_clause' => array('key' => 'start_date'),
        'end_clause' => array('key' => 'end_date')
    ),
    'orderby' => array(
        'relation' => 'AND',
        'start_clause' => 'ASC',
        'end_clause' => 'ASC'
    )
);

$events_query = new WP_Query($events_query_args);

// The Loop
if ($events_query->have_posts()) {
    while ($events_query->have_posts()) {
        $events_query->the_post();
        // print_r($events_query);
        $date_range = get_field('showtimes');
        $event_dates = array();
        $post_ID = get_the_ID();

        if ($date_range != NULL) {
         
            $start_date_string = get_field('start_date');
            $end_date_string = get_field('end_date');
            $start_date = strtotime($start_date_string);
            $end_date = strtotime($end_date_string);
            $today = strtotime('today');

            // only construct events if they are playing or coming soon
            if ($end_date >= $today) {
                // test for event type
                $class_names = "";
                if (get_post_type() == "film") {
                    $class_names = get_field('film_type');
                    array_push($class_names, "film"); // add 'film' to list of classes for html template below
                } else if (get_post_type() == "event") {
                    $class_names = get_field('single_event_type');
                }

                // transform human readable classes to html classes with hyphens
                $class_string = '';
                for ($i = 0; $i < count($class_names); $i++) {
                    $transform_class = strtolower($class_names[$i]);
                    $transform_class = str_replace(' ', '-', $transform_class);
                    $class_string .= $transform_class . ' ';
                }

                if ($start_date <= $today and $today <= $end_date) {
                    $class_string .= ' now-playing';
                } else if ($today < $start_date) {
                    $class_string .= ' coming-soon';
                }    
            ?>

        <div class="<?php echo 'events__event-card ' . $class_string; ?> ">
                        <div class="event-card__front card">
                            <div class="event-image-container">
                                <img src="<?php  echo get_field('event_image')["url"];?>"
                                    alt="death proof poster" />
                                <div class="event-date">
                                    <?php 
                                    if ($start_date_string == $end_date_string) {
                                        echo $start_date_string;
                                    } else {
                                        echo "$start_date_string - $end_date_string";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="event-content-container">
                                <p><?php the_field('single_event_type');?></p>
                                <h3><?php the_title();?></h3>
                                <p><?php the_content();?></p>
                            </div>
                        </div>
                        <div class="event-card__back card">
                            <img src="<?php  echo get_field('event_image')["url"];?>"
                                alt="movie poster">
                            <div class="image-only__content-container">
                                <ul>
                                    <li>
                                        <i class="fas fa-calendar-alt"></i>
                                        <?php 
                                            if ($start_date_string == $end_date_string) {
                                                echo $start_date_string;
                                            } else {
                                                echo "$start_date_string - $end_date_string";
                                            }
                                        ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-map-marker"></i><?php the_field('location'); ?>
                                    </li>
                                    <li>
                                        <i class="fas fa-ticket-alt"></i>
                                        <?php 
                                            $prices = array();
                                            if (have_rows('ticket_prices')) {
                                                while (have_rows('ticket_prices')) {
                                                    the_row();
                                                    $price = get_sub_field('price');
                                                    array_push($prices, $price);
                                                }
                                            }
                                            echo '$ ' . join(", ", $prices);
                                        ?>
                                    </li>
                                </ul>
                                <a href="<?php echo get_page_link(get_the_id()); ?>"><button>More Info</button></a>
                            </div>
                        </div>
                    </div>
        <?php }
        }
    }
    // Restore original Post Data
    wp_reset_postdata();
} else {
    echo 'No events at this time';
}
?>


                </div>
            </div>
            <div class="upcoming-events__sidebar">
                <!-- <div class="upcoming-events__sidebar- -container"> -->
                    <div class="upcoming-events__sidebar--search">
                        <input type="text" placeholder="Search..." />
                        <button>Search Events</button>
                    </div>
                <!-- </div> -->
                <div class="upcoming-events__list">
                    <p class="upcoming-list__title">Upcoming Film Series</p>
                    <ul>
                        <li>Retro Epics >></li>
                        <li>Anime-Magic >></li>
                        <li>SplatterFlix >></li>
                        <li>Fantastic Realm >></li>
                        <li>Retro ArtHouse >></li>
                    </ul>
                </div>
                <div class="upcoming-events__list">
                    <p class="upcoming-list__title">Upcoming Film Festivals</p>
                    <ul>
                        <li>NC Gay &amp; Lesbian Film Festival >></li>
                        <li>Nevermore >></li>
                        <li>Full Frame >></li>
                    </ul>
                </div>
                <div class="upcoming-events__cta-card">
                    <h2>Gift Cards >></h2>
                    <p>Shows and fills for all ages, all tastes, and all people. Give the gift that's sure to please.
                    </p>
                </div>
                <div class="upcoming-events__cta-card">
                    <h2>Gift Cards >></h2>
                    <p>Shows and fills for all ages, all tastes, and all people. Give the gift that's sure to please.
                    </p>
                </div>
                <div class="upcoming-events__cta-card">
                    <h2>Gift Cards >></h2>
                    <p>Shows and fills for all ages, all tastes, and all people. Give the gift that's sure to please.
                    </p>
                </div>
            </div>
        </section>
<?php
get_footer();
?>