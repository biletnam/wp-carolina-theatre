jQuery(function($) {
	$(document).ready(function() {
		$(".carousel, .hero-slider").slick({
            dots: true,
            arrows: true
        });

        $(".hero-block__slider").slick({
            dots: true,
            arrows: true
        });

        $(".hp-news__slider, .hp-upcoming__slider").slick({
            dots: true,
            arrows: true,
            slidesToShow: 3//,
            // appendArrows: ".hp-upcoming__slider--arrows"
        });
	});
});
