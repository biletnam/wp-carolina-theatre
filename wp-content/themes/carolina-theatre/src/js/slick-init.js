jQuery(function($) {
	$(document).ready(function() {
		$(".carousel, .hero-slider").slick({
            dots: true,
            arrows: true
        });
        $(".hero-block__slider, .hp-upcoming__slider").slick({
            dots: true,
            arrows: true
        });
	});
});
