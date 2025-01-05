$(document).ready(function() {
	
	$('.slider').slick({
	  dots: false,
	  infinite: false,
	  speed: 300,
	  slidesToShow: 2,
    prevArrow: '<button type="button" class="slick-prev pull-left"><svg fill="none" height="35" viewBox="0 0 35 35" width="35" xmlns="http://www.w3.org/2000/svg"><circle cx="17.5" cy="17.5" fill="#f2a900" r="17.5"/><path d="m13.3359 10.6704 7.0942 7.0941-7.0942 7.0942 2.3367 2.3366 9.4307-9.4308-9.4307-9.43073z" fill="#fff"/></svg></button>',
    nextArrow: '<button type="button" class="slick-next pull-right"><svg fill="none" height="35" viewBox="0 0 35 35" width="35" xmlns="http://www.w3.org/2000/svg"><circle cx="17.5" cy="17.5" fill="#f2a900" r="17.5"/><path d="m13.3359 10.6704 7.0942 7.0941-7.0942 7.0942 2.3367 2.3366 9.4307-9.4308-9.4307-9.43073z" fill="#fff"/></svg></button>',
		responsive: [
	    {
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 1
	      }
	    },
	  ]
	});	

	$('.t-slider').slick({
	  dots: false,
	  infinite: false,
	  speed: 300,
	  slidesToShow: 1,
    prevArrow: '<button type="button" class="slick-prev pull-left"><svg fill="none" height="35" viewBox="0 0 35 35" width="35" xmlns="http://www.w3.org/2000/svg"><circle cx="17.5" cy="17.5" fill="#f2a900" r="17.5"/><path d="m13.3359 10.6704 7.0942 7.0941-7.0942 7.0942 2.3367 2.3366 9.4307-9.4308-9.4307-9.43073z" fill="#fff"/></svg></button>',
    nextArrow: '<button type="button" class="slick-next pull-right"><svg fill="none" height="35" viewBox="0 0 35 35" width="35" xmlns="http://www.w3.org/2000/svg"><circle cx="17.5" cy="17.5" fill="#f2a900" r="17.5"/><path d="m13.3359 10.6704 7.0942 7.0941-7.0942 7.0942 2.3367 2.3366 9.4307-9.4308-9.4307-9.43073z" fill="#fff"/></svg></button>',
	});

	$('.e-slider').slick({
	  dots: false,
	  infinite: false,
	  speed: 300,
	  slidesToShow: 1,
	  variableWidth: true,
    prevArrow: '<button type="button" class="slick-prev pull-left"><svg fill="none" height="35" viewBox="0 0 35 35" width="35" xmlns="http://www.w3.org/2000/svg"><circle cx="17.5" cy="17.5" fill="#f2a900" r="17.5"/><path d="m13.3359 10.6704 7.0942 7.0941-7.0942 7.0942 2.3367 2.3366 9.4307-9.4308-9.4307-9.43073z" fill="#fff"/></svg></button>',
    nextArrow: '<button type="button" class="slick-next pull-right"><svg fill="none" height="35" viewBox="0 0 35 35" width="35" xmlns="http://www.w3.org/2000/svg"><circle cx="17.5" cy="17.5" fill="#f2a900" r="17.5"/><path d="m13.3359 10.6704 7.0942 7.0941-7.0942 7.0942 2.3367 2.3366 9.4307-9.4308-9.4307-9.43073z" fill="#fff"/></svg></button>',
	});

	// Affix actions
	// $(window).on('scroll', function(event) {
	// 	var scrollValue = $(window).scrollTop();
	// 	if (scrollValue > 0) {
	// 		$('#header').addClass('affix');
	// 	} else {
	// 		$('#header').removeClass('affix');
	// 	}
	// });


	// Slide Out Menu
	// $('#hamburger').click(function() {

	// 	$('#slide-out').toggleClass('active');
	// 	$('body').toggleClass('slide-out-open');
	// });

	// $('#slide-out ul li.menu-item-has-children > a').click(function() {
	// 	$(this).find('.sub-menu').slideUp();

	// 	if ( $(this).hasClass( "active" ) ) {
	// 		$(this).parent().find('.sub-menu').first().slideUp();
	// 		$(this).removeClass('active');
	// 	} else {
	// 		$(this).parent().find('.sub-menu').first().slideDown();
	// 		$(this).addClass('active');
	// 	}
	// 	return false;
	// });
	// End slide out menu

});









