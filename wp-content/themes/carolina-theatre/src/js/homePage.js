jQuery(function($) {
	$(document).ready(function() {
		$(".hero-block__go-to-btn").on("hover", function() {
            $(this).next().show();
            // $(this).next().css("display", "block");
        });
        $(".hero-block__go-to-btn").on("mouseleave", function() {
            // $(this).next().css("display", "none");
            $(this).next().hide();
        });
    });
});
