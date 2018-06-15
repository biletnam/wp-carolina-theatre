// jQuery(function($) {
	
// 	// TO-DO: GET THIS WORKING WITH $_GET
// 	function filterCards(filterObj){
// 		var filter = filterObj.data('filter');
// 		var eventCard = '.events .eventCard';
// 		// console.log(filter);
// 		if(filter === 'all'){
// 			$(eventCard).each(function(i){
// 				$(this).show();
// 			});
// 		} else {
// 			filter = ' '+filter+' ';	// so events with tag 'anime-magic' dont get included with filter 'magic'
// 			matchingCards = $(eventCard + '[data-filterme*="'+filter+'"]');
			
// 			$(eventCard).each(function(i){
// 				$(this).hide(); // hide all cards
// 			});
// 			matchingCards.each(function(i){
// 				$(this).show(); // show all cards with matching filter
// 			});
// 		}
// 	}

// 	$(document).ready(function() {
// 		$(".upcoming-events__type li").on("click touch", function(clicked) {
// 			filterCards($(this));
			
// 			if ($(this).data('filter') === "film") {
// 				$(".filmFilters").css("display", "block");
// 			} else {
// 				$(".filmFilters").css("display", "none");
// 			}
// 		});

// 		$(".filmFilters li").on("click touch", function(clicked) {
// 			filterCards($(this));
// 			$(".filmFilters").css("display", "block");
// 			$(".upcoming-events__type > .tabbedContent__tab[data-filter='film']").addClass('active-link');
// 		});
// 	});
// });
