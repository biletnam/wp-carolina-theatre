jQuery(function($) {
	function removeActiveFilter(className) {
		for (var i = 0; i < $(className).children().length; i++) {
			var target = $(className).children()[i];
			if ($(target).hasClass("active-link")) {
				$(target).removeClass("active-link");
			}
		}
	}
	// TO-DO: GET THIS ALL CLEANED UP & WORKING WITH $_GET
	$(document).ready(function() {
		var upcomingEvent = "all";
		$(".upcoming-events__type li").on("click", function() {
			// remove active class from type and filter elements
			removeActiveFilter(".upcoming-events__type");
			removeActiveFilter(".upcoming-events__type--secondary");
			
			// add active class to event type that was clicked on
			$(this).addClass("active-link");

			// reset event filter to any when event type is changed
			// var subfilter = $(".upcoming-events__type--secondary").children()[0];
			// $(subfilter).addClass("active-link");

			var filter = $(this).data('filter');;
			upcomingEvent = filter;

			if (filter === "all") {
				$(".events").show();
			} else {
				num_events = $(".events").children().length;
				for (var i = 0; i < num_events; i++) {
					var target = $(".events").children()[i];
					var targets_filters = $(target).data('filterme')
					if (targets_filters.indexOf(filter) != -1) {
						$(target).show();
					} else {
						$(target).hide();
					}
				}
			}

			// show secondary row of filters if main level 'Film' is active
			if (filter === "film") {
				$(".filmFilters").css("display", "block");
			} else {
				$(".filmFilters").css("display", "none");
			}
		});


		$(".upcoming-events__type--secondary li").on("click", function() {
			// var filter = $(this).data('filter');
			// removeActiveFilter(".upcoming-events__type--secondary");
			// $(this).addClass("active-link");

			var num_events = $(".events").children().length;
			for (var i = 0; i < num_events; i++) {
				var target = $(".events").children()[i];

				if (upcomingEvent === "all" && filter === "any") {
					$(target).show();
				} else if (upcomingEvent === "film" && filter === "all-films" && $(target).hasClass('film')) {
					$(target).show();
				} else if (upcomingEvent === "all" && $(target).hasClass(filter)) {
					$(target).show();
				} else if (filter === "any" && $(target).hasClass(upcomingEvent)) {
					$(target).show();
				} else if ( $(target).hasClass(upcomingEvent) && $(target).hasClass(filter) ) {
					$(target).show();
				} else {
					$(target).hide();
				}
			}
		});
	});
});
