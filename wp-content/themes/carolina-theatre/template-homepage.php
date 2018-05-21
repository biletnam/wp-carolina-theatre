<?php
// Template name: Homepage Template
get_header();

?>

<div class="hpwrapper">
    <div class="hero-block">
        <div class="hero-block__slider-wrapper clearfix">
            <div class="hero-block__slider">
                <?php
                    if (have_rows("slider")) {
                        while (have_rows("slider")) {
                            the_row();
                        ?>
                            <div class="hero-block__card">
                                <img 
                                    src="<?php echo get_sub_field("image")[url]; ?>" 
                                    alt="live show"
                                />
                                <div class="hero-block__card--content">
                                    <?php echo get_sub_field("content"); ?>
                                </div>
                            </div>
                        <?php
                        }
                    }
                ?>
                <!-- <div class="hero-block__card">
                    <img 
                        src="https://static.boredpanda.com/blog/wp-content/uploads/2015/11/reflection-landscape-photography-jaewoon-u-36.jpg"
                        alt="landscape on the lake in fall"
                    />
                </div>
                <div class="hero-block__card">
                    <img 
                        src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260"
                        alt="landscape on the lake in fall"
                    />
                </div>
                <div class="hero-block__card">
                    <img 
                        src="https://storage.googleapis.com/proudcity/deleontx/uploads/2016/12/preview-wattpad-cover-maker-thumbnail.jpg"
                        alt="landscape on the lake in fall"
                    />
                </div>
                <div class="hero-block__card">
                    <img 
                        src="https://images.template.net/wp-content/uploads/2014/11/Cute-Chick-Friends-Facebook-Cover.jpg"
                        alt="landscape on the lake in fall"
                    />
                </div> -->
            </div>
        
            <div class="hero-block__stats">
                <ul>
                    <!-- <li>
                        <div class="stats-block">
                            <p class="show-stat">Showing text</p>
                            <p class="hide-stat">Hiding text</p>
                        </div>
                    </li>
                    <li>
                        <div class="stats-block">
                            <p class="show-stat">Showing text</p>
                            <p class="hide-stat">Hiding text</p>
                        </div>
                    </li>
                    <li>
                        <div class="stats-block">
                            <p class="show-stat">Showing text</p>
                            <p class="hide-stat">Hiding text</p>
                        </div>
                    </li> -->
                <?php
                    if (have_rows("statistics")) {
                        while (have_rows("statistics")) {
                            the_row();
                        ?>
                            <li class="hero-block__stats-item">
                                <div class="hero-block__stats--normal">
                                    <p><?php echo get_sub_field("stat_value"); ?></p>
                                    <p><?php echo get_sub_field("stat_description") ?></p>
                                </div>
                                <div class="hero-block__stats--hover">
                                    <p><?php echo get_sub_field("hover_description"); ?></p>
                                    <p>
                                        <a href="<?php echo get_sub_field("link")["url"]; ?>">
                                          <?php echo get_sub_field("link")["title"]; ?>  
                                          Link
                                        </a>
                                    </p>
                                </div>
                            </li>
                        <?php
                        }
                    }
                ?>
                </ul>
            </div>
        </div>
        <div class="hero-block__slider--nav clearfix">
            <div class="hero-block__slider--arrows">
                <?php
                    $slide_number = 1;
                    if (have_rows("slider")) {
                        while (have_rows("slider")) {
                            the_row();
                            // print_r(get_sub_field("image")["sizes"]["thumbnail"]);
                        ?>
                            <div class="hero-block__btn-block">
                                <button class="hero-block__go-to-btn" data-slide="<?php echo $slide_number; ?>">
                                    Slide <?php echo $slide_number; ?>
                                </button>
                                <img 
                                    class="hero-block__thumbnail" 
                                    src="<?php echo get_sub_field("image")["sizes"]["thumbnail"]; ?>" 
                                    alt="small poster of event"/>
                            </div>
                        <?php
                            $slide_number++;
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="hp-upcoming">
        <h1 class="hp-upcoming__header">Upcoming Events</h1>
        <div class="hp-upcoming__slider">
            <div class="hp-upcoming__card">
                <img 
                    src="https://static.boredpanda.com/blog/wp-content/uploads/2015/11/reflection-landscape-photography-jaewoon-u-36.jpg"
                    alt="landscape on the lake in fall"
                />
            </div>
            <div class="hp-upcoming__card">
                <img 
                    src="https://static.boredpanda.com/blog/wp-content/uploads/2015/11/reflection-landscape-photography-jaewoon-u-36.jpg"
                    alt="landscape on the lake in fall"
                />
            </div>
            <div class="hp-upcoming__card">Panel 3</div>
            <div class="hp-upcoming__card">Panel 4</div>
            <div class="hp-upcoming__card">Panel 5</div>
        </div>

        <div class="hp-upcoming__slider--nav">
            <div class="hp-upcoming__slider--arrows">
                <a href="/events" ><button>See All Events -></button></a>
            </div>
        </div>
    </div>
    <div class="hp-ctas">
        <div class="hp-ctas__card">
            <h2>Plan Your Visit >></h2>
            <p>Shows and fills for all ages, all tastes, and all people. Give the gift that's sure to please.
            </p>
        </div>
        <div class="hp-ctas__card">
            <h2>Become a Member >></h2>
            <p>Shows and fills for all ages, all tastes, and all people. Give the gift that's sure to please.
            </p>
        </div>
        <div class="hp-ctas__card">
            <h2>The History of CTD >></h2>
            <p>Shows and fills for all ages, all tastes, and all people. Give the gift that's sure to please.
            </p>
        </div>
    </div>
    <div class="hp-news">
    <h1 class="hp-news__header">New &amp; Press</h1>
        <div class="hp-news__slider">
            <div class="hp-news__card">
                <img 
                    src="https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260"
                    alt="landscape on the lake in fall"
                />
            </div>
            <div class="hp-news__card">
                <img 
                    src="https://static.boredpanda.com/blog/wp-content/uploads/2015/11/reflection-landscape-photography-jaewoon-u-36.jpg"
                    alt="landscape on the lake in fall"
                />
            </div>
            <div class="hp-news__card">Panel 3</div>
            <div class="hp-news__card">Panel 4</div>
            <div class="hp-news__card">Panel 5</div>
        </div>
        <div class="hp-news__slider--nav">
            <button class="hp-news__see-all-btn">See All News -></button>
            <div class="hp-news__slider--arrows">
                Arrows
            </div>
        </div>
    </div>
</div> <!-- hpwrapper -->

<?php
get_footer();
?>
