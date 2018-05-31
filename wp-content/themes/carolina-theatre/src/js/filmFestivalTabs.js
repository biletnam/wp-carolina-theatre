jQuery(function($) {
	$(document).ready(function() {
    // on page load check for url urlAnchor
    urlAnchor = window.location.href.match(/[#].*/);
    
    if(urlAnchor !== null) { // check if there is a hash
			anchorName = urlAnchor[0].replace(/#/, '');

			// create array of all tabbed content names
			var tabIds = [];
			$('.tabbedContent__tab').each( function(i,e) {
			    tabIds.push($(e).data('tab'));
			});

			if ($.inArray(anchorName, tabIds) > -1) { // check if the url anchor matches any of the tabb content
			  $('.tabbedContent__tab').removeClass('active-link'); // remove all active tab styling
			  $('li[data-tab="'+anchorName+'"]').addClass("active-link"); // add active styling to active tab
			  $('.tabbedContent__content').addClass('hide-tab-content'); // hide all content panels
			  className = urlAnchor[0].replace(/#/, '.'); // turn hash into class name (#anchor to .anchor)
			  $(className).removeClass('hide-tab-content'); // show content panel for active tab
			}

			// change active link onclick, show content for active link only
			$(".tabbedContent__tab").on("click", function() {
			    $(".tabbedContent__tab").removeClass("active-link");
			    $(this).addClass("active-link");

			    className = '.' + $(this).data('tab');
			    $(".tabbedContent__content").addClass("hide-tab-content");
			    $(className).removeClass("hide-tab-content");
			});
    }
	});
});
