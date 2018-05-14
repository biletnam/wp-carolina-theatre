jQuery(function($) {
    $(document).ready(function() {
        $('.single-film__read-more').on('click', function() {

            if ($(this).text().trim() === "Read More") {
                $(this).html("<hr/><p>Read Less</p>");
                $(".single-film__description").addClass("single-film__reveal");
            } else {
                $(this).html("<hr/><p>Read More</p>");
                $(".single-film__description").removeClass("single-film__reveal");
            } 
        });

        $('.single-event__read-more').on('click', function() {

            if ($(this).text().trim() === "Read More") {
                $(this).html("<hr/><p>Read Less</p>");
                $(".single-event__description").addClass("single-event__reveal");
            } else {
                $(this).html("<hr/><p>Read More</p>");
                $(".single-event__description").removeClass("single-event__reveal");
            }
        });
    });
});

