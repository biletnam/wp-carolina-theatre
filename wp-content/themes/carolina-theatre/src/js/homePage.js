jQuery(function($) {
	$(document).ready(function() {
		$(".hero-block__go-to-btn").on("mouseenter", function() {
            $(this).next().show();
        });
        $(".hero-block__go-to-btn").on("mouseleave", function() {
            $(this).next().hide();
        });

        $(".hero-block__stats-item").on("mouseenter", function() {
            $(this).children().first().hide();
            $(this).children().last().show();
        });

        $(".hero-block__stats-item").on("mouseleave", function() {
            $(this).children().last().hide();
            $(this).children().first().show();
        });
    });
});
