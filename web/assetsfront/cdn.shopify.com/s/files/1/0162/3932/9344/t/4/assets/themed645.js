(function($) {
  "use strict";

  jQuery(document).ready(function(){


  
  
	/*---------------------------------
	Search slideToggle
	-----------------------------------*/
	$(".search-wrapper > a").on("click", function() {
		$('.search-form').toggleClass('active');
	}); 

	/*---------------------------------
	Setting slideToggle
	-----------------------------------*/
	$(".settings-wrapper > a").on("click", function() {
		$('.settings-content').toggleClass('active');
	}); 


	/*---------------------------------
	Menu Sticky
	-----------------------------------*/
	var $windows = $(window);
	var sticky = $('.header-sticky');
	$windows.on('scroll', function() {
		var scroll = $windows.scrollTop();
		if (scroll < 300) {
			sticky.removeClass('sticky');
		}else{
			sticky.addClass('sticky');
		}
	});

	/*------------------------------------
	Mobile Menu
	--------------------------------------*/
	$('#mobile-menu-active').meanmenu({
		meanScreenWidth: "991",
		meanMenuContainer: ".mobile-menu-area .mobile-menu",
	}); 

	
	/*--------------------------------------
	Product Slider Two
	----------------------------------------*/
	var productSliderTwo = $('.product-carousel-two'); 
	productSliderTwo.slick({
		arrows: true,
		infinite: true,
		slidesToShow: 6,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
		responsive: [
			{
				breakpoint: 1400,
				settings: {
					slidesToShow: 5,
				}
			},
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 479,
				settings: {
					slidesToShow: 1,
				}
			}
		]
	});
	
	
	
	
	/*--------------------------------------
	Modal Slick Slider
	-----------------------------------------*/
	$('.single-slide-menu').slick({
		dots: false,
		arrows: false,
		slidesToShow: 4,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			}
		]
	});
	$('.modal').on('shown.bs.modal', function (e) {
		$('.single-slide-menu').resize();
	})
	$('.single-slide-menu a').on('click',function(e){
		e.preventDefault();
		var $href = $(this).attr('href');
		$('.single-slide-menu a').removeClass('active');
		$(this).addClass('active');
		$('.product-details-large .tab-pane').removeClass('active show');
		$('.product-details-large '+ $href ).addClass('active show');
	});

	/*------------------------------------
	Scroll Up
	--------------------------------------*/
	$.scrollUp({
		scrollText: '<i class="fa fa-angle-up"></i>',
		easingType: 'linear',
		scrollSpeed: 900,
		animation: 'fade'
	}); 

		

	/*-------------------------------------
	Price Slider
	---------------------------------------*/  
	$( "#slider-range" ).slider({
		range: true,
		min: 55,
		max: 1000,
		values: [ 55, 1000 ],
		slide: function( event, ui ) {
			$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		}
	});
	$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
	   " - $" + $( "#slider-range" ).slider( "values", 1 ) );  

	/*--------------------------------------
	EasyZoom instances
	----------------------------------------*/  
	$('.easyzoom').easyZoom();

	/*---------------------------------------
	Login Toggle
	-----------------------------------------*/
	$( '#showlogin' ).on('click', function() {
		$( '#checkout-login' ).slideToggle(900);
	}); 

	/*----------------------------------------
	Coupon Toggle
	------------------------------------------*/
	$( '#showcoupon' ).on('click', function() {
		$( '#checkout_coupon' ).slideToggle(900);
	});

	/*-----------------------------------------
	Account Toggle
	-------------------------------------------*/
	$( '#cbox' ).on('click', function() {
		$( '#cbox_info' ).slideToggle(900);
	});

	/*-----------------------------------------
	Ship Address Toggle
	--------------------------------------------*/
	$( '#ship-box' ).on('click', function() {
		$( '#ship-box-info' ).slideToggle(1000);
	});	

	/*----------------------------------------
	Scroll Down
	------------------------------------------*/  
	$('.scroll-down').on('click', function() {
		$('html, body').animate({scrollTop: $('.scroll-area').offset().top - 100 }, 'slow');
		return false;
	});
  
  
  
  
  
  

  });
  
})(jQuery);
