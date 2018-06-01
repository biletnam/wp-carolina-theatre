jQuery(function($) {
	$(document).ready(function() {
		$(".hero-block__go-to-btn").on("mouseenter", function() {
        $(this).next().show();
    });
    $(".hero-block__go-to-btn").on("mouseleave", function() {
        $(this).next().hide();
    });
  });
});
