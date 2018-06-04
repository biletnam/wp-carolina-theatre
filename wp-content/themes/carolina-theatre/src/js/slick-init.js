jQuery(function($) {
	$(document).ready(function() {
		// generic content-blocks-slider.php & other sliders
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
				adaptiveHeight: true,
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

		// fancy slider for homepage
		$(".heroSlider").slick({
			dots: true,
      arrows: false,
      rows: 0, // removes extra 'div'
			autoplay: true,
			autoplaySpeed: 3000,
			speed: 800,
			pauseOnHover: true,
      customPaging : function(slider, i) {
      	var $slide = $(slider.$slides[i]);
	      console.log($slide);
	      var thumb = $slide.data('thumb');
	      return '<button class="thumbnail"><img src="'+thumb+'"></button>';
    	}
		});

		// slider for upcoming events and latest news (homepage & event dropdown)
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
		}); // end .cardSlider
  }); // end document ready
}); // end jquery
