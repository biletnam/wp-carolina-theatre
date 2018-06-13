jQuery(function($) {
	
	// TO-DO: GET THIS ALL CLEANED UP & WORKING WITH $_GET
	function filterCards(filterObj){
		var filter = filterObj.data('filter');
		var eventCard = '.events .eventCard';
		// console.log(filter);
		
		$(eventCard).each(function(i){
      var filterMe = $(this).data('filterme');                
			if(filter === 'all'){
				$(this).show();
			} else if (filterMe.indexOf(filter) != -1) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	}

	$(document).ready(function() {
		$(".upcoming-events__type li").on("click touch", function(clicked) {
			filterCards($(this));
			
			if ($(this).data('filter') === "film") {
				$(".filmFilters").css("display", "block");
			} else {
				$(".filmFilters").css("display", "none");
			}
		});

		$(".filmFilters li").on("click touch", function(clicked) {
			filterCards($(this));
			$(".filmFilters").css("display", "block");
			$(".upcoming-events__type > .tabbedContent__tab[data-filter='film']").addClass('active-link');
		});
	});
});
