"use strict";

jQuery(window).load(function() {
    $(".loader-centered").fadeOut();
    $(".loader").delay(400).fadeOut("slow");
});

$(document).ready(function() {

	// --------------------------------------------------------
	//	Navigation Bar
	// -------------------------------------------------------- 		
	$(window).scroll(function(){	
		var scroll = $(window).scrollTop();
		if( scroll > 10 ){		
			$(".navbar").addClass("scroll-fixed-navbar");				
		} else {
			$(".navbar").removeClass("scroll-fixed-navbar");
		}
	});	
	
	// --------------------------------------------------------
	// Pretty Photo for Lightbox Image
	// -------------------------------------------------------- 
    $("a[data-gal^='prettyPhoto']").prettyPhoto(); 
	
	// --------------------------------------------------------
	//	Smooth Scrolling
	// -------------------------------------------------------- 	
	$(".navbar-nav li a[href^='#']").on('click', function(e) {
		e.preventDefault();
		var hash = this.hash;
		$('html, body').animate({
			scrollTop: $(hash).offset().top
			}, 1000, function(){
			window.location.hash = hash;
		});
	});
	
	// --------------------------------------------------------
	//	Scroll Up
	// -------------------------------------------------------- 	
	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			$('.scroll-up').fadeIn();
		} else {
			$('.scroll-up').fadeOut();
		}
	});

	$('.scroll-up').on('click', function(e) {
		$("html, body").animate({
			scrollTop: 0
		}, 600);
		return false;
	});
	
	// --------------------------------------------------------
	//	Collapse Navigation (Mobile) on click
	// -------------------------------------------------------- 	
	$(document).on('click','.navbar-collapse.in',function(e) {
		if( $(e.target).is('a') ) {
			$(this).collapse('hide');
		}
	});
	
});
