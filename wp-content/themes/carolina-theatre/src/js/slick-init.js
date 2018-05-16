jQuery(function($) {
	$(document).ready(function() {
		$(".carousel, .hero-slider").slick({
            dots: true,
            arrows: true
        });

        var heroBlock = $(".hero-block__slider").slick({
            dots: true,
            // arrows: false,
            // prevArrow: ".hero-block__slider--arrows",
            appendArrows: $(".hero-block__slider--arrows")
            // appendArrows: ".hero-block__slider--arrows"
        });

        $(".hp-upcoming__slider").slick({
            dots: true,
            arrows: true,
            slidesToShow: 3,
            appendArrows: $(".hp-upcoming__slider--arrows")
        });

        $(".hp-news__slider").slick({
            dots: true,
            slidesToShow: 3,
            // appendArrows: $(".hp-upcoming__slider--arrows")
        });
    });
});
