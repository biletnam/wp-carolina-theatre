<?php
get_header();

$id = get_the_id();

$events_query_args = array(
    'post_id' => $id,
);

$events_query = new WP_Query($events_query_args);
$content = get_post($id);

// convert date strings to integers for sorting
$event_dates = array();
if (have_rows('showtimes')) {
    while (have_rows('showtimes')) {
        the_row();
        $event_date = strtotime(get_sub_field('dates'));
        array_push($event_dates, $event_date);
    }
}

// pick the min/max and covert to string 
$start_date = date("F d, Y", min($event_dates));
$end_date = date("F d, Y", max($event_dates));
?>
<div class="clearfix">
    <div class="single-event__container">
        <div class="single-event__left-col">
            <section class="single-event__header">
                <p class="single-event__category"><?php echo get_post_type() ?></p>
                <div class="single-event__image">
                    <img src="<?php echo get_field('event_image')["url"]; ?>" alt="the poster for the film">
                    <div class="single-event__image--date"><?php echo $start_date . ' - ' . $end_date ?></div>
                </div>
                <p>The Carolina Theatre Presents...
                <h2 class="single-event__title"><?php echo the_title() ?></h2>
                <p class="single-event__subtitle"><?php echo get_field('event_subtitle') ?></p>
                <br/>
                <div class="single-event__event-info">
                    <ul>
                        <li>
                            <?php 
                            echo '<i class="fa fa-calendar" aria-hidden="true"></i>' . $start_date . ' - ' . $end_date;
                            ?>
                        </li>
                        <li>
                            <?php
                            $locations = get_field('location');
                            echo '<i class="fa fa-map-marker" aria-hidden="true"></i>' . join($locations, ', ');    
                            ?>                    
                        </li>
                    </ul>
                </div>
                <div class="single-event__description"><?php echo $content->post_content; ?></div>
                <div class="single-event__read-more">
                    <hr />
                    <p>Read More</p>
                </div>
                <div class="single-event__videos">
                    <div class="single-event__videos--one">
                        <?php the_field('video_1_link'); ?>
                        <p><?php the_field('video_1_caption') ?></p>
                    </div>
                    <div class="single-event__videos--two">
                        <?php the_field('video_2_link'); ?>
                        <p><?php the_field('video_2_caption') ?></p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="single-event__sidebar">
        <div class="single-event__sidebar--container">
            <div class="single-event__sidebar--show-info">
                <br>
                <div class="single-event__button"><button>On Sale</button></div>
                <div class="single-event__button"><button>Member Tickets</button></div>
                <ul>
                <?php 
                    // output all dates for a show
                    if (have_rows('showtimes')) {
                        while (have_rows('showtimes')) {
                            the_row();
                            $showdate = get_sub_field('dates');
                        ?>
                            <li>
                        <?php 
                                echo '<i class="fa fa-calendar" aria-hidden="true"></i>' . $showdate; 
                        ?>
                            </li>
                        <?php
                            // output all times for a given date
                            if (have_rows('times')) {
                                while (have_rows('times')) {
                                    the_row();
                                ?>
                                    <li>
                                <?php 
                                        $doors_open = get_sub_field('doors_open');
                                        $showtime = get_sub_field('time');
                                        echo '<i class="fa fa-clock-o" aria-hidden="true"></i>Doors Open ' . $doors_open . ' | Showtime ' . $showtime; 
                                ?>      &nbsp;<i class="fas fa-ticket-alt"></i>
                                    </li>
                                <?php
                                }
                            }
                        }
                    }
                    // append ticket prices
                    $price_vals = array();
                    if (have_rows('ticket_prices')) {
                        while (have_rows('ticket_prices')) {
                            the_row();
                            $price = get_sub_field('price');
                            array_push($price_vals, $price);
                        }
                    }
                    ?>
                        <li>
                            <?php echo '<i class="fa fa-ticket" aria-hidden="true"></i> $' . join($price_vals, ' | '); ?>
                        </li>
                        <li>
                            <?php echo '<i class="fa fa-map-marker" aria-hidden="true"></i>' . join($locations, ', '); ?>
                        </li>
                </ul>
            </div>
            
            <div class="single-event__sidebar--social-media">
                <?php
                    if (have_rows('social_media_link')) {
                        while (have_rows('social_media_link')) {
                            the_row();
                            $icon = get_sub_field('icon');
                            $url = get_sub_field('link_url');
                            $link_text = get_sub_field('link_description');
                        ?>
                            <p>
                                <?php echo $icon; ?>
                                <a href="<?php echo $url; ?>"><?php echo $link_text; ?></a>
                            </p>
                        <?php
                        }
                    }
                ?>
            </div>
            <div class="single-event__sidebar--ctas">
                <div class="single-event__sidebar--cta-card">
                    <h2>Seating Chart >></h2>
                    <p>See the stage from all angles. There's not a bad seat in the house.
                    </p>
                </div>
                <div class="single-event__sidebar--cta-card">
                    <h2>Plan Your Visit >></h2>
                    <p>What to bring, where to eat, where to stay, where to park and more...
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>