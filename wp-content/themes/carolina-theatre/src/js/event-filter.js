jQuery(function($) {
	function removeActiveFilter(className) {
		for (var i = 0; i < $(className).children().length; i++) {
			var target = $(className).children()[i];
			if ($(target).hasClass("active-filter")) {
				$(target).removeClass("active-filter");
			}
		}
	}
	$(document).ready(function() {
		var upcomingEvent = "all";
		$(".upcoming-events__type li").on("click", function() {
			// remove active-filter class from type and filter elements
			removeActiveFilter(".upcoming-events__type");
			removeActiveFilter(".upcoming-events__filters");
			// add active-filter class to event type that was clicked on
			$(this).addClass("active-filter");

			// reset event filter to any when event type is changed
			var subfilter = $(".upcoming-events__filters").children()[0];
			$(subfilter).addClass("active-filter");

			var filter = $(this)
				.text()
				.toLowerCase()
				.split(" ")
				.join("-");
			upcomingEvent = filter;

			if (filter === "all") {
				for (var i = 0; i < $(".events").children().length; i++) {
					var target = $(".events").children()[i];
					$(target).show();
				}
			} else {
				for (var i = 0; i < $(".events").children().length; i++) {
					var target = $(".events").children()[i];

					if ($(target).hasClass(filter)) {
						$(target).show();
					} else {
						$(target).hide();
					}
				}
			}

			if (filter === "film") {
				$(".filmFilter").css("display", "inline-block");
			} else {
				$(".filmFilter").css("display", "none");
			}

		});

		$(".upcoming-events__filters li").on("click", function() {
			var filter = $(this)
				.text()
				.toLowerCase()
				.split(" ")
				.join("-");
			removeActiveFilter(".upcoming-events__filters");
			$(this).addClass("active-filter");

			for (var i = 0; i < $(".events").children().length; i++) {
				var target = $(".events").children()[i];

				if (upcomingEvent === "all" && filter === "any") {
					$(target).show();
				} else if (upcomingEvent === "all" && $(target).hasClass(filter)) {
					$(target).show();
				} else if (filter === "any" && $(target).hasClass(upcomingEvent)) {
					$(target).show();
				} else if (
					$(target).hasClass(upcomingEvent) &&
					$(target).hasClass(filter)
				) {
					$(target).show();
				} else {
					$(target).hide();
				}
			}
		});
	});
});
