// TO-DO: setup filtering to occur on page load, so when ctd.org/events&filter=films is loaded, the films are filtered.

// AJAX Functions for getting the filters and upcoming events for template-events.php
// This file ties into event-filter.js, functions.php, and template-events.php

jQuery(function($){
    //Load posts on document ready
    event_get_posts();

    // If list item is clicked, trigger input change and add css class
    $('#event-filter li').on('click touch', function(){
        var input = $(this).find('input');
 				
 				// clear all filters
        $('#event-filter li').removeClass('active-link').find('input').prop('checked',false);

        // determine what filter was clicked
        if ( $(this).data('filter') === 'all' ){
          event_get_posts(); // load all posts
          $(this).addClass('active-link');
        } else {
          input.prop('checked', true);
          $(this).addClass('active-link');
        }

				// controls show/hide of secondary film filters
      	if ($(this).data('filter') === "film") {
					$(".filmFilters").css("display", "block");
					$(this).addClass('active-link');
				} else if ($(this).hasClass('filmFilter')) {
					$(".filmFilters").css("display", "block");
					$("#event-filter").find("li[data-filter='film']").addClass('active-link');
				} else {
					$(".filmFilters").css("display", "none");
				}
				
        input.trigger("change");
    });
 
    // If input is changed, load posts
    $('#event-filter input').on('change', function(){
        event_get_posts(); // Load Posts
    });
 
    // Find Selected Events
    function getSelectedEvents(){
        var allEvents = ''; //Setup empty array
 
        $("#event-filter li input:checked").each(function() {
            allEvents = $(this).val();
        });

        return allEvents; //Return all of the selected Events in an array
    }
 
    // If pagination is clicked, load correct posts
    $('#event-results').on('click touch', '#event-filter-navigation a', function(e){
        e.preventDefault();

        var url = $(this).attr('href'); //Grab the URL destination as a string
        var paged = url.split('&paged='); //Split the string at the occurance of &paged=
 				
 				$('html,body').animate({scrollTop: $('#upcoming-events').offset().top },'slow');

        event_get_posts(paged[1]); //Load Posts (feed in paged value)
    });
 
    //Main ajax function
    function event_get_posts(paged){
        var paged_value = paged; //Store the paged value if it's being sent through when the function is called
	      var ajax_url = ajax_event_params.ajax_url; //Get ajax url (added through wp_localize_script)

	      $filterClicked = getSelectedEvents();

        $.ajax({
            type: 'GET',
            url: ajax_url,
            data: {
                action: 'event_filter',
                events: $filterClicked, //Get values from previous function
                paged: paged_value //If paged value is being sent through with function call, store here
            },
            beforeSend: function() {
                $("#loader").show();
            },
            success: function(data) {
                $('#event-results').html(data);
                
                // hide not 'now-playing' films if filter is clicked
                if($filterClicked === 'now-playing'){
									$("#event-results .eventCard").hide();
									$("#event-results .eventCard[data-filterme*='now-playing']").show();
                }
            },
            complete: function() {
            		$("#loader").hide();//Hide loader here
            },
            error: function() {
                //If an ajax error has occured, do something here...
                $("#event-results").html('<p>There has been an error</p>');
            }
        });
    }
 
});