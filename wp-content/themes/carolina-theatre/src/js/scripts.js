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
	var $mobileNav = $('#header__mobileNav--menu');
	var $mobileMenuTrigger = $('#mobileNavTrigger');
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

		// toggle the mobile dropdown menus as accordions
		$('.header__mobileNav--menu .dropdown_icon').click(function(){
			$(this).closest('.menu-item').toggleClass('open');
		});
		
		//// Desktop Event Calendar Dropdown
		var $edTrigger = $('.header__mainMenu .header__event__trigger');
		var $ed = $('#eventsDropdown');
		
			// 1 - enter trigger = show dropdown
			$edTrigger.on('mouseover touch', function(e) {
			  $ed.addClass('show');	
			});
			// 2 - leave trigger, enter dropdown = show dropdown
			$edTrigger.on('mouseleave touch', function(e) {
				// e.relatedTarget – is the new under-the-pointer element (that mouse left for).
				if (!$ed.is(e.relatedTarget) && $ed.has(e.relatedTarget).length === 0) {
				  $ed.removeClass('show');
				}
			});
			// 3 - leave dropdown = hide dropdown
			$ed.on('mouseleave', function(e) {
			  $ed.removeClass('show');	
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