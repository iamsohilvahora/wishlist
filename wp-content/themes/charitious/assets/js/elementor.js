( function ( $, elementor ) {
    "use strict";

    var Charitious = {

        init: function () {
 
            var widgets = {
                'xs-testimonial.default': Charitious.Testimonial,
                'xs-contact-info.default': Charitious.ContactInfo,
                'xs-slider.default': Charitious.SliderOne,
                'xs-event.default': Charitious.Event,
                'xs-charitious-campaign-list.default': Charitious.Campaign,
            };

            $.each( widgets, function ( widget, callback ) {
                elementor.hooks.addAction( 'frontend/element_ready/' + widget, callback );
            } );

        },

        SliderOne: function ( $scope ) {
            var bannerSlider = $scope.find( '.xs-banner-slider' );

            bannerSlider.owlCarousel( {
                items: 1,
                loop: true,
                mouseDrag: true,
                touchDrag: true,
                dots: false,
                nav: true,
                navText: [ '<i class="fa fa-angle-left xs-round-nav"></i>', '<i class="fa fa-angle-right xs-round-nav"></i>' ],
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
                    991: {
                        nav: true,
                    }
                }
            } );
        },
        Event: function ( $scope ) {

            var $container = $scope.find( '.xs-countdown-timer[data-countdown]' );
            $container.each(function() {
                var hour = $(this).data('date-hour'),
                minute = $(this).data('date-minute'),
                second = $(this).data('date-second'),
                day = $(this).data('date-day');
                var $this = jQuery(this),
                    finalDate = jQuery(this).data('countdown');

                $this.countdown(finalDate, function(event) {
                    var $this = jQuery(this).html(event.strftime(' '
                        + '<span class="timer-count">%-D <span class="timer-text">' + day + '</span></span>  '
                        + '<span class="timer-count">%H <span class="timer-text">' + hour + '</span></span> '
                        + '<span class="timer-count">%M <span class="timer-text">' + minute + '</span></span> '
                        + '<span class="timer-count">%S <span class="timer-text">' + second + '</span></span>'));
                });
            });
        },
        ContactInfo: function ( $scope ) {
            var $container = $scope.find( '.xs-multiple-map' );

            if ( !window.google ) {
                return;
            }
            $container.each(function(){
                var id = $(this).attr('id');
        
        
                var geocoder = new google.maps.Geocoder();
                var address = $(this).attr('title');
        
                geocoder.geocode( { 'address': address}, function(results, status) {
        
                    if (status == google.maps.GeocoderStatus.OK) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();
        
                    }
        
                    var latlng = new google.maps.LatLng(latitude,longitude);
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
                    var map = new google.maps.Map(document.getElementById(`${id}`), myOptions);
                    var myMarker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title:address
                    });
                });
            });

        },
        Testimonial: function ( $scope ) {
            var carousel = $scope.find( '.xs-testimonial-slider.slider-double-item' );
            if ( !carousel.length ) {
                return;
            }
            carousel.owlCarousel( {
                items: 2,
                loop: true,
                mouseDrag: true,
                touchDrag: true,
                dots: true,
                nav: false,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    // breakpoint from 0 up
                    0: {
                        items: 1,
                    },
                    // breakpoint from 480 up
                    480: {
                        items: 1,
                    },
                    // breakpoint from 768 up
                    768: {
                        items: 2,
                    }
                }
            } );
        },
        Campaign:  function ( $scope ) {
            var campainPie = $scope.find( '.xs_donate_chart_shotcode' );
            var boderColor = campainPie.data('barcolor');
            var trackColours = campainPie.data('trackcolor')

            if ( !campainPie.length ) {
                return;
            }
            campainPie.easyPieChart({
                barColor: boderColor,
                trackColor: trackColours,
                scaleColor: false,
                lineWidth: 9,
                lineCap: 'round',
                animate: 2000
            });
        }

    };

    $( window ).on( 'elementor/frontend/init', Charitious.init );

}( jQuery, window.elementorFrontend ) );