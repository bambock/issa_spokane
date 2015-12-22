(function ($) {

	new WOW().init();

	jQuery(window).load(function() { 
		jQuery("#preloader").delay(100).fadeOut("slow");
		jQuery("#load").delay(100).fadeOut("slow");
		if($(location).attr('pathname').match(/bylaws/g)) {
			$(".navbar-fixed-top").addClass("top-nav-collapse");
			$(".navbar-brand h1").css('color','#fff');
		}
	});


	//jQuery to collapse the navbar on scroll
	$(window).scroll(function() {
		if ( $(".navbar").offset().top > 50 ) {
			$(".navbar-fixed-top").addClass("top-nav-collapse");
		} else {
			if(!$(location).attr('pathname').match(/bylaws/g)) {
				$(".navbar-fixed-top").addClass("top-nav-collapse");
				$(".navbar-brand h1").css("color", "#fff");
			}
		}
	});

	
	//jQuery for page scrolling feature - requires jQuery Easing plugin
	$(function() {
		$('.navbar-nav li a').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
		$('.page-scroll a').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
	});

})(jQuery);
