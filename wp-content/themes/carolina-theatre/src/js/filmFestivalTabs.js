jQuery(function($) {
	$(document).ready(function() {
    // on page load check for url anchor
    anchor = window.location.href.match(/[#].*/);
    if (anchor === null) {
        $("#overview").addClass("active-link");
        $(".overview").removeClass("hide-tab-content");
    } else {
        // use anchor for active-link tab
        $(anchor[0]).addClass("active-link");
        $('.tab-content').addClass('hide-tab-content');
        if (anchor[0] !== "#") {
            className = anchor[0].replace(/#/, '.');
            $(className).removeClass('hide-tab-content');
        }
    }
    
    // change active link onclick, show content for active link only
		$(".tab-link").on("click", function() {
        $(".tab-link").removeClass("active-link");
        $(this).addClass("active-link");

        className = '.' + $(this).attr('id');
        $(".tab-content").addClass("hide-tab-content");
        $(className).removeClass("hide-tab-content");
    });
	});
});
