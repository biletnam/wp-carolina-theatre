jQuery(function($) {
  $(document).ready(function() {
    $('.singleEvent__read-more').on('click', function() {
  		// TO-DO: only show 'read more' if text is long enough
      if ($(this).text().trim() === "Read More") {
        $(this).html("<hr/><p>Read Less</p>");
        $(".singleEvent__description").addClass("singleEvent__reveal");
      } else {
        $(this).html("<hr/><p>Read More</p>");
        $(".singleEvent__description").removeClass("singleEvent__reveal");
      } 
    });
  });
});

