(function ($) {
	"use strict";

	/*------------------------------------------------------------------
	[Table of contents]

	custom function
	portfolio gird
	banner slider
	single item slider
	number counter and skill bar animation
	skill bar and number counter
	mega navigation menu init
	countdown timer
	back to top
	insta feed
	video popup
	image popup
	map window opener add class
	Code For Switching Style (FOR DEMO)
	Contact From dynamic
	XpeedStudio multipile Maps
	XpeedStudio Maps


	 
	-------------------------------------------------------------------*/

	/*==========================================================
				custom function
	======================================================================*/
	function xsFunction() {
		var xsContact = $('.xs-contact-form-wraper'),
			xsMap = $('.map-wraper-v2');

		xsMap.css('height', xsContact.outerHeight());
	}

	function email_patern(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}

	$(window).on('load', function () {

		// custom xs function init
		xsFunction();

		setTimeout(function () {
			$('#preloader').addClass('loaded');
		}, 500);

		/*==========================================================
				portfolio gird
		======================================================================*/
		if ($('.xs-portfolio-grid').length > 0) {
			var $portfolioGrid = $('.xs-portfolio-grid'),
				colWidth = function () {
					var w = $portfolioGrid.width(),
						columnNum = 1,
						columnWidth = 0;
					if (w > 1200) {
						columnNum = 3;
					} else if (w > 900) {
						columnNum = 3;
					} else if (w > 600) {
						columnNum = 2;
					} else if (w > 450) {
						columnNum = 2;
					} else if (w > 385) {
						columnNum = 1;
					}
					columnWidth = Math.floor(w / columnNum);
					$portfolioGrid.find('.xs-portfolio-grid-item').each(function () {
						var $item = $(this),
							multiplier_w = $item.attr('class').match(/xs-portfolio-grid-item-w(\d)/),
							multiplier_h = $item.attr('class').match(/xs-portfolio-grid-item-h(\d)/),
							width = multiplier_w ? columnWidth * multiplier_w[1] : columnWidth,
							height = multiplier_h ? columnWidth * multiplier_h[1] * 0.4 - 12 : columnWidth * 0.5;
						$item.css({
							width: width,
						});
					});
					return columnWidth;
				},
				isotope = function () {
					$portfolioGrid.isotope({
						resizable: false,
						itemSelector: '.xs-portfolio-grid-item',
						masonry: {
							columnWidth: colWidth(),
							gutterWidth: 3
						}
					});
				};
			isotope();
			$(window).resize(isotope);
		} // End is_exists

	}); // END load Function 

	$(document).ready(function () {

		// custom xs function init
		xsFunction();



		if ($('#volunteer_cv').length > 0) {
			$('#volunteer_cv').on('change', function (e) {
				var getValue = $(this).val(),
					fileName = getValue.replace(/C:\\fakepath\\/i, '');
				$(this).parent().parent().find('label').html(fileName);
			});

		}


		/*==========================================================
				banner slider
		======================================================================*/

		/*==========================================================
					single item slider
		======================================================================*/
		if ($('.xs-single-item-slider').length > 0) {
			var singleItemSlider = $(".xs-single-item-slider");
			singleItemSlider.owlCarousel({
				items: 1,
				loop: true,
				mouseDrag: true,
				touchDrag: true,
				dots: false,
				nav: true,
				navText: ['<i class="fa fa-arrow-left xs-square-nav"></i>', '<i class="fa fa-arrow-right xs-square-nav"></i>'],
				autoplay: true,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				animateOut: 'fadeOut',
				animateIn: 'fadeIn',
				responsive: {
					// breakpoint from 0 up
					0: {
						nav: false,
					},
					// breakpoint from 480 up
					480: {
						nav: false,
					},
					// breakpoint from 768 up
					768: {
						nav: true,
					}
				}
			});
		}


		/*==========================================================
				number counter and skill bar animation
		=======================================================================*/

		var number_percentage = $(".number-percentage");

		function animateProgressBar() {
			number_percentage.each(function () {
				$(this).animateNumbers($(this).attr("data-value"), true, parseInt($(this).attr("data-animation-duration"), 10));
				var value = $(this).attr("data-value");
				var duration = $(this).attr("data-animation-duration");
				$(this).closest('.xs-skill-bar').find('.xs-skill-track').animate({
					width: value + '%'
				}, 4500);
			});
		}


		if ($('.waypoint-tigger').length > 0) {
			var waypoint = new Waypoint({
				element: document.getElementsByClassName('waypoint-tigger'),
				handler: function (direction) {
					animateProgressBar();
				}
			});
		}

		/*==========================================================
				skill bar and number counter
		=======================================================================*/

		$.fn.animateNumbers = function (stop, commas, duration, ease) {
			return this.each(function () {
				var $this = $(this);
				var start = parseInt($this.text().replace(/,/g, ""), 10);
				commas = (commas === undefined) ? true : commas;
				$({
					value: start
				}).animate({
					value: stop
				}, {
					duration: duration == undefined ? 500 : duration,
					easing: ease == undefined ? "swing" : ease,
					step: function () {
						$this.text(Math.floor(this.value));
						if (commas) {
							$this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
						}
					},
					complete: function () {
						if (parseInt($this.text(), 10) !== stop) {
							$this.text(stop);
							if (commas) {
								$this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
							}
						}
					}
				});
			});
		};


		/*==========================================================
				mega navigation menu init
		======================================================================*/
		if ($('.xs-menus').length > 0) {
			$('.xs-menus').xs_nav({
				mobileBreakpoint: 992,
			});
		}

		/*==========================================================
				back to top
		======================================================================*/
		$(document).on('click', '.xs-back-to-top', function (event) {
			event.preventDefault();
			/* Act on the event */

			$('html, body').animate({
				scrollTop: 0,
			}, 1000);
		});


		/*=============================================================
						video popup
		=========================================================================*/
		if ($('.xs-video-popup').length > 0) {
			$('.xs-video-popup').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false
			});
		}

		/*=============================================================
						image popup
		=========================================================================*/
		$('.xs-image-popup').magnificPopup({
			type: 'image',
			closeOnContentClick: false,
			closeBtnInside: false,
			mainClass: 'mfp-with-zoom mfp-img-mobile',
			gallery: {
				enabled: true
			},
			zoom: {
				enabled: true,
				duration: 300, // don't foget to change the duration also in CSS
			}

		});

		/*==========================================================
				map window opener add class
		======================================================================*/
		$(document).on('click', '.xs-window-opener', function () {
			// body...
			event.preventDefault();

			var main_wraper = $('.xs-widnow-wraper'),
				active_class = 'active';

			if ($(this).parent().parent().hasClass(active_class)) {
				$(this).parent().parent().removeClass(active_class);
			} else {
				$(this).parent().parent().addClass(active_class);
			}
		});


		if ($('.navsearch-button').length > 0) {
			$('.navsearch-button').on('click', function (e) {
				e.preventDefault();

				if (!($('.navsearch-form')).is(":visible")) {
					$(this).find('i').removeClass('fa-search').addClass('fa-search-minus');
				} else {
					$(this).find('i').removeClass('fa-search-minus').addClass('fa-search');
				}
				$(this).parent().parent().find('.navsearch-form').slideToggle(300);
			});
		}

		$(".someTimer").each(function () {
			var hour = $(this).data('date-hour'),
				minute = $(this).data('date-minute'),
				second = $(this).data('date-second'),
				day = $(this).data('date-day');
			var timeCircles = $(this).TimeCircles({
				circle_bg_color: "#40494c",
				fg_width: 0.041,
				bg_width: 0,
				direction: "Clockwise",
				time: { //  a group of options that allows you to control the options of each time unit independently.
					Days: {
						show: true,
						text: day,
						color: "#f7a900"
					},
					Hours: {
						show: true,
						text: hour,
						color: "#2cc391"
					},
					Minutes: {
						show: true,
						text: minute,
						color: "#9064bf"
					},
					Seconds: {
						show: true,
						text: second,
						color: "#e23e57"
					}
				}
			});
		})

		$('[data-toggle="popover"]').popover({
			html: true,
			content: function () {
				return $(this).next().html();
			}
		});
		$('[data-toggle="popover"]').on('click', function () {
			if (!$(this).hasClass('is-active')) {
				$(this).addClass('is-active');
			} else {
				$(this).removeClass('is-active');
			}
		})

		$('.preloader-cancel-btn').on('click', function (event) {
			event.preventDefault();
			if (!$('#preloader').hasClass('loaded')) {
				$('#preloader').addClass('loaded');
			}
		});
	}); // end ready function

	$(window).on('scroll', function () {

	}); // END Scroll Function 

	$(window).on('resize', function () {
		// custom xs function init
		xsFunction();
	}); // End Resize

	/*==========================================================
				XpeedStudio multipile Maps
	======================================================================*/

	var multimap_count = $('.xs-multiple-map').length;
	if (multimap_count > 0) {
		$('.xs-multiple-map').each(function () {
			var id = $(this).attr('id');


			var geocoder = new google.maps.Geocoder();
			var address = $(this).attr('title');

			geocoder.geocode({
				'address': address
			}, function (results, status) {

				if (status == google.maps.GeocoderStatus.OK) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();

				}

				var latlng = new google.maps.LatLng(latitude, longitude);
				var myOptions = {
					zoom: 3,
					center: latlng,
					scrollwheel: false,
					navigationControl: false,
					mapTypeControl: true,
					scaleControl: false,
					draggable: true,
					disableDefaultUI: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
				};
				var map = new google.maps.Map(document.getElementById(id), myOptions);
				var myMarker = new google.maps.Marker({
					position: latlng,
					map: map,
					title: address
				});
			});
		});
	}
	/*==========================================================
				XpeedStudio Event Maps
	======================================================================*/

	var eventmap_count = $('.xs-event-map').length;
	if (eventmap_count > 0) {
		$('.xs-event-map').each(function () {
			var id = $(this).attr('id');


			var geocoder = new google.maps.Geocoder();
			var address = $(this).attr('title');

			geocoder.geocode({
				'address': address
			}, function (results, status) {

				if (status == google.maps.GeocoderStatus.OK) {
					var latitude = results[0].geometry.location.lat();
					var longitude = results[0].geometry.location.lng();

				}

				var latlng = new google.maps.LatLng(latitude, longitude);

				var myOptions = {
					zoom: 3,
					center: latlng,
					scrollwheel: false,
					navigationControl: false,
					mapTypeControl: true,
					scaleControl: false,
					draggable: true,
					disableDefaultUI: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					styles: [{
						"featureType": "administrative",
						"elementType": "all",
						"stylers": [{
							"saturation": "-100"
						}]
					}, {
						"featureType": "administrative.province",
						"elementType": "all",
						"stylers": [{
							"visibility": "off"
						}]
					}, {
						"featureType": "landscape",
						"elementType": "all",
						"stylers": [{
							"saturation": -100
						}, {
							"lightness": 65
						}, {
							"visibility": "on"
						}]
					}, {
						"featureType": "poi",
						"elementType": "all",
						"stylers": [{
							"saturation": -100
						}, {
							"lightness": "50"
						}, {
							"visibility": "simplified"
						}]
					}, {
						"featureType": "road",
						"elementType": "all",
						"stylers": [{
							"saturation": "-100"
						}]
					}, {
						"featureType": "road.highway",
						"elementType": "all",
						"stylers": [{
							"visibility": "simplified"
						}]
					}, {
						"featureType": "road.arterial",
						"elementType": "all",
						"stylers": [{
							"lightness": "30"
						}]
					}, {
						"featureType": "road.local",
						"elementType": "all",
						"stylers": [{
							"lightness": "40"
						}]
					}, {
						"featureType": "transit",
						"elementType": "all",
						"stylers": [{
							"saturation": -100
						}, {
							"visibility": "simplified"
						}]
					}, {
						"featureType": "water",
						"elementType": "geometry",
						"stylers": [{
							"hue": "#ffff00"
						}, {
							"lightness": -25
						}, {
							"saturation": -97
						}]
					}, {
						"featureType": "water",
						"elementType": "labels",
						"stylers": [{
							"lightness": -25
						}, {
							"saturation": -100
						}]
					}]
				};
				var map = new google.maps.Map(document.getElementById(id), myOptions);

				var myMarker = new google.maps.Marker({
					position: latlng,
					map: map,
					title: address
				});
			});
		});
	}
// Fundrising countdown
    let count_down = jQuery(".countdown-container");

	if(count_down.length > 0 ){
        let ful_date = count_down.data('countdown');
        count_down.countdown(ful_date, function(event) {

            var $this = $(this).html(event.strftime(' '
                + '<div class="xs-timer-container"><span class="timer-count">%-D </span><span class="timer-text">' + countdown_variable.days + '</span></div>'
                + '<div class="xs-timer-container"><span class="timer-count">%H </span><span class="timer-text">' + countdown_variable.hours + '</span></div>'
                + '<div class="xs-timer-container"><span class="timer-count">%M </span><span class="timer-text">' + countdown_variable.minutes + '</span></div>'
                + '<div class="xs-timer-container"><span class="timer-count">%S </span><span class="timer-text">' + countdown_variable.seconds + '</span></div>'));
            });
    }
    var border_color =  $('.xs_donate_chart').data('bordercolor');

    $('.xs_donate_chart').easyPieChart({
        easing: 'easeOutBounce',
        barColor: border_color,
        trackColor: '#E5E5E5',
        lineWidth: 6,
        scaleColor: 'transparent',
        size: 200,
        lineCap: 'round',
        duration: 4500,
        enabled: true,
    });
//  wp fundrising 

 const tabmenu = $('.wfp-tab');
 const tabcontent = $('.wfp-tab-content-wraper');
 const contentReward = $('.wfp-single-tabs + .wfp-single-pledges');

 tabmenu.remove();
 tabcontent.remove();
 contentReward.removeClass('xs-col-lg-4')
  $('.wfp-single-item:first-child').append(tabmenu);
  $('.wfp-single-item:first-child').append(tabcontent);
  $('.wfp-goal-wraper').append(contentReward);

})(jQuery);