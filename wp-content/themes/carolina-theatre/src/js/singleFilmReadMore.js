jQuery(function($) {
    $(document).ready(function() {
        $('.singleEvent__read-more').on('click', function() {

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

