jQuery(function($) {
	$(document).ready(function() {
		$(".carousel").slick({
				infinite: true,	
				pauseOnHover: false,
				slidesToScroll: 1,
				draggable: true,
				swipe: true,
				speed: 900,
        dots: true,
				arrows: false,
				swipeToSlide: true,
				// lazyLoad: 'progressive',
				// variableWidth: true,
				// centerMode: false,
				// centerPadding: '0',
				// autoplay: autoplay,
				// autoplaySpeed: 5000,
				// fade: true,
				// cssEase: 'ease',
				// responsive:[
				// 	{
				// 		breakpoint: 640,
				// 		settings: {
				// 			arrows: true,
				// 			dots: false
				// 		}
				// 	}
				// ]
    });

		$(".heroSlider").slick({
			dots: true,
      arrows: false,
      rows: 0, // removes extra 'div'
      customPaging : function(slider, i) {
      	var $slide = $(slider.$slides[i]);
	      console.log($slide);
	      var thumb = $slide.data('thumb');
	      return '<button class="thumbnail"><img src="'+thumb+'"></button>';
    	}
		});

    $('.cardSlider').each(function (idx, item) {
		    var carouselId = "carousel-" + idx;
		    this.id = carouselId;
		    $(this).slick({
		        appendArrows: $("#" + carouselId + " ~ .cardSlider__nav .cardSlider__arrows"),
		        arrows: true,
		        dots: false,
		        slidesToShow: 5,
		        swipeToSlide: true,
		        infinite: false,
		        variableWidth: true,
		        responsive:[
					    {
					      breakpoint: 1280,
					      settings: {
					        slidesToShow: 4
					      }
					    },
					    {
					      breakpoint: 900,
					      settings: {
					        slidesToShow: 3
					      }
					    },
					    {
					      breakpoint: 640,
					      settings: {
					        slidesToShow: 2
					      }
					    },
					    {
					      breakpoint: 500,
					      settings: {
					        slidesToShow: 1,
					        slidesToScroll: 1
					      }
					    },
					  ]
		    });
		});

    // $(".cardSlider").slick({
    //     appendArrows: $(" .cardSlider__arrows"),
    //     dots: true,
    //     slidesToShow: 5,
    //     swipeToSlide: true,

    //     responsive:[
			 //    {
			 //      breakpoint: 320,
			 //      settings: {
			 //        slidesToShow: 1
			 //      }
			 //    },
			 //    {
			 //      breakpoint: 640,
			 //      settings: {
			 //        slidesToShow: 3
			 //      }
			 //    }
			 //  ]
    // });

    // $(".hp-upcoming__slider").slick({
    //     appendArrows: $("#hp-upcomingEvents__arrows"),
    //     dots: false,
    //     slidesToShow: 5,
    //     swipeToSlide: true,

    //     responsive:[
			 //    {
			 //      breakpoint: 320,
			 //      settings: {
			 //        slidesToShow: 1
			 //      }
			 //    },
			 //    {
			 //      breakpoint: 640,
			 //      settings: {
			 //        slidesToShow: 3
			 //      }
			 //    }
			 //  ]
    // });

    // $(".hp-news__slider").slick({
    //     appendArrows: $("#hp-recentNews__arrows"),
    //     dots: false,
    //     slidesToShow: 5,
    //     swipeToSlide: true,

    //     responsive:[
			 //    {
			 //      breakpoint: 320,
			 //      settings: {
			 //        slidesToShow: 1
			 //      }
			 //    },
			 //    {
			 //      breakpoint: 640,
			 //      settings: {
			 //        slidesToShow: 3
			 //      }
			 //    }
			 //  ]
    // });
  });
});
