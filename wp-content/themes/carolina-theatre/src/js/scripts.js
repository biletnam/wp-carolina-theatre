// Pulling in all javascript files and being minified with Codekit

// smooth scroll to just above anchor points
// (function($){

// 	$(function(){
// 		$('a[href*="#"]:not([href="#"]):not([href*="popup"])').click(function() {
// 			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
// 				var target = $(this.hash);
// 				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
// 				if (target.length) {
// 					$('html, body').animate({
// 						scrollTop: target.offset().top
// 					}, 1000);
// 					return false;
// 				}
// 			}
// 		});
// 	});

// })(jQuery);
(function($){
	var $ww = $(window).width();
	var $header = $('#header');
	var $mobileNav = $('#header__mobileNav');
	var $mobileMenuTrigger = $('#mobileNav__openBtn');
	var $mobileMenuClose = $('#mobileNav__closeBtn');
	var stickyMenuCtrl = new ScrollMagic.Controller(); 

	$(document).ready(function() {
		// make .header-menu sticky on scroll
		var stickyHeaderMenuScene = new ScrollMagic.Scene({
				triggerElement: '#header__main',
				offset: 0,
				triggerHook: 'onLeave'
			})
			.setPin("#header__main")
			.setClassToggle("#header__main", 'sticky')
			.addTo(stickyMenuCtrl);

		// MOBILE - open and close menu when "Main Menu" button is triggered
		$mobileMenuTrigger.on('click touch', function(){
			if($('body').hasClass('shift')){
				closeMobileMenu();	
			} else {
				openMobileMenu();
			}
		});

		// close Mobile Menu when window is resized
		$(window).on('resize', function(){
			$ww = $(window).width();
			closeMobileMenu();
		});

		// close mobile menu using the X button
		$mobileMenuClose.on('click touch', function(){
			closeMobileMenu();
		});

		// close the mobile menu by clicking outside of the menu
		$('.mainWrapper').click(function() {
		  if($('body').hasClass('shift')){
				closeMobileMenu();	
			}
		});

		// prevent the mobile menu trigger from closing the menu
		$mobileMenuTrigger.click(function(event){
	    event.stopPropagation();
		});
	});

	/*
	 * Mobile Menu Help Functions 
	 */
	function openMobileMenu(){
		$('body').addClass('shift');
		$mobileMenuTrigger.addClass('open');
		// console.log('i should open the menu');
	}
	function closeMobileMenu(){
		$('body').removeClass('shift');
		$mobileMenuTrigger.removeClass('open');		
		// console.log('i should close the menu');
	}

})(jQuery);