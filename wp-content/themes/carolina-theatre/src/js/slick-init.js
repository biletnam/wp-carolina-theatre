jQuery(function($) {
	$(document).ready(function() {
		$(".carousel").slick({
            dots: true,
            arrows: true
        });

        $(".hero-block__slider").slick({
            // dots: true,
            // arrows: false,
            // appendArrows: $(".hero-block__slider--arrows")
        });

        $(".hero-block__go-to-btn[data-slide]").on("click", function(e) {
            e.preventDefault();
            var slidePosition = $(this).data('slide');
            $(".hero-block__slider").slick("slickGoTo", slidePosition - 1);
            // alert($(this).data('slide'));
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
            appendArrows: $(".hp-news__slider--arrows")
        });
    });
});
