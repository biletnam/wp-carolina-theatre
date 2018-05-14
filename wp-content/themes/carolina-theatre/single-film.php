<?php

get_header();

$id = get_the_id();

$events_query_args = array(
    'post_id' => $id,
);

$events_query = new WP_Query($events_query_args);
$content = get_post($id);

// get all dates and showtimes
$date_range = get_field('showtimes');
$event_dates = array();
if (have_rows('showtimes')) {
    while (have_rows('showtimes')) {
        the_row();
        $event_date = strtotime(get_sub_field('dates'));
        array_push($event_dates, $event_date);
    }
}
// convert to string and pick the min/max
$start_date = date("F d, Y", min($event_dates));
$end_date = date("F d, Y", max($event_dates));
?>
<div class="clearfix">
    <div class="single-film__container">
        <div class="single-film__left-col">
            <section class="single-film__header">
                <p class="single-film__category"><?php echo get_post_type() ?></p>
                <div class="single-film__image">
                    <img src="<?php echo get_field('event_image')["url"]; ?>" alt="the poster for the film">
                    <div class="single-film__image--date"><?php echo $start_date . ' - ' . $end_date ?></div>
                </div>
                <p>The Carolina Theatre Presents...
                <h2 class="single-film__title"><?php echo the_title() ?></h2>
                <p class="single-film__subtitle"><?php echo get_field('event_subtitle') ?></p>
                <br/>
                <div class="single-film__description"><?php echo $content->post_content; ?></div>
                <div class="single-film__read-more">
                    <hr />
                    <p>Read More</p>
                </div>
                <div class="single-film__videos">
                    <div class="single-film__videos--one">
                        <?php the_field('video_1_link'); ?>
                        <p><?php the_field('video_1_caption') ?></p>
                    </div>
                    <div class="single-film__videos--two">
                        <?php the_field('video_2_link'); ?>
                        <p><?php the_field('video_2_caption') ?></p>
                    </div>
                </div>
            </section>
        </div>
    </div>  

    <div class="single-film__sidebar">
        <div class="single-film__sidebar--container">
            <div class="single-film__sidebar--show-info">
                <br>
                <div class="single-film__button"><button>Buy Tickets</button></div>
                <h3><i class="fa fa-clock-o" aria-hidden="true"></i>Showtimes &amp; Tickets</h3>
                <ul>
                <?php 
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
                            <?php echo '$' . join($price_vals, ' | '); ?>
                        </li>
                    <?php

                    // output all dates for a show
                    if (have_rows('showtimes')) {
                        while (have_rows('showtimes')) {
                            the_row();
                            $showdate = get_sub_field('dates');
                        ?>
                            <li><?php echo $showdate; ?></li>
                        <?php
                            // output all times for a given date
                            if (have_rows('times')) {
                                while (have_rows('times')) {
                                    the_row();
                                ?>
                                    <li>
                                <?php 
                                        $showtime = get_sub_field('time');
                                        echo $showtime . '<i class="fa fa-ticket" aria-hidden="true"></i>'; 
                                ?>      
                                    </li>
                                <?php
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="single-film__sidebar--film-info">
                <h3>Movie Info</h3>
                <div>
                    <p>Director</p>
                    <p>
                        <?php 
                            $movie_info = get_field('film_information'); 
                            echo $movie_info["director"];
                        ?>
                    </p>
                </div>
                <div>
                    <p>Release Year</p>
                    <p>
                        <?php 
                            echo $movie_info["release_year"];
                        ?>
                    </p>
                </div>
                <div>
                    <p>Release Country</p>
                    <p>
                        <?php 
                            echo $movie_info["release_country"];
                        ?>
                    </p>
                </div>
                <div>
                    <p>Rating</p>
                    <p>
                        <?php 
                            echo $movie_info["rating"];
                        ?>
                    </p>
                </div>
                <div>
                    <p>Runtime</p>
                    <p>
                        <?php 
                            echo $movie_info["runtime"] . ' min';
                        ?>
                    </p>
                </div>
            </div>
            <div class="single-film__sidebar-social-media">
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
            <div class="single-film__sidebar--ctas">
                <div class="single-film__sidebar--cta-card">
                    <h2>Seating Chart >></h2>
                    <p>See the stage from all angles. There's not a bad seat in the house.
                    </p>
                </div>
                <div class="single-film__sidebar--cta-card">
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
