 
;(function ($) {
    "use strict";

    /* ------------------------------------
        COMMON VARIABLES
    ------------------------------------ */
    var $wn = $(window),
        $body = $('body');

    /* ------------------------------------
        CHECK DATA
    ------------------------------------ */
    var checkData = function (data, value) {
        return typeof data === 'undefined' ? value : data;
    };

    $(function () {
        /* ------------------------------------
            BACKGROUND IMAGE
        ------------------------------------ */
        var $bgImg = $('[data-bg-img]');

        $bgImg.each(function () {
            var $t = $(this);

            $t.css('background-image', 'url(' + $t.data('bg-img') + ')').addClass('bg--img').removeAttr('data-bg-img');
        });

        /* ------------------------------------
            BACKGROUND PARALLAX
        ------------------------------------ */
        var $bgParallax = $('[data-bg-parallax]');

        $bgParallax.each(function () {
            var $t = $(this);

            $t.parallax({
                imageSrc: $t.data('bg-parallax')
            }).addClass('bg--overlay').removeAttr('data-bg-parallax');
        });

        $wn.on('resize', function() {
            $wn.trigger('resize.px.parallax');
        });

        /* ------------------------------------
            STICKY JS
        ------------------------------------ */
        var $sticky = $('[data-sticky]');
        
        $sticky.each(function () {
            var $t = $(this);

            $t.sticky({
                zIndex: $t.data('sticky')
            });
        });

        /* ------------------------------------
            MAGNIFIC POPUP
        ------------------------------------ */
        var $popupImg = $('[data-popup="img"]');

        if ( $popupImg.length ) {
            $popupImg.magnificPopup({
                type: 'image',
                zoom: {
                    enabled: true,
                    opener: function( $el ) {
                        return $el.parent('.info').siblings('img');
                    }
                }
            });
        }

        var $popupDelegateImg = $('[data-popup-delegate="img"]');

        if ( $popupDelegateImg.length ) {
            $popupDelegateImg.magnificPopup({
                delegate: 'a[data-popup="delegate"]',
                type: 'image'
            });
        }
        
        var $popupVideo = $('[data-popup="video"]');
        
        if ( $popupVideo.length ) {
            $popupVideo.magnificPopup({
                type: 'iframe'
            });
        }

        /* ------------------------------------
            COUNTER
        ------------------------------------ */
        var $counterUp = $('[data-counter-up="number"]');

        if ( $counterUp.length ) {
            $counterUp.counterUp({
                delay: 10,
                time: 1000
            });
        }

        /* ------------------------------------
            FORM VALIDATION
        ------------------------------------ */
        var $formValidation = $('[data-form="validate"]');

        $formValidation.each(function () {
            $(this).validate({
                errorPlacement: function () {
                    return false;
                }
            });
        });

        var $formMailchimpAjax = $('[data-form="mailchimpAjax"]');

        $formMailchimpAjax.each(function () {
            $(this).validate({
                errorPlacement: function () {
                    return false;
                },
                submitHandler: function (el) {
                    var $form = $(el),
                        formData = $form.serialize(),
                        formURL = $form.attr('action').replace('/post?', '/post-json?').concat('&c=?'),
                        $formBtnIcon = $form.find('button[type="submit"] .fa'),
                        formIconClass = function () {
                            if ( $formBtnIcon.hasClass('fa-send-o') ) {
                                return 'fa-send-o';
                            } else if ( $formBtnIcon.hasClass('fa-close') ) {
                                return 'fa-close';
                            } else if ( $formBtnIcon.hasClass('fa-check') ) {
                                return 'fa-check';
                            }
                        };

                    $formBtnIcon.toggleClass(formIconClass() + ' fa-spinner fa-spin');

                    $.getJSON(formURL, formData, function (res) {
                        res.fa = res.result === 'error' ? 'fa-close' : 'fa-check';

                        $formBtnIcon.toggleClass( 'fa-spinner fa-spin ' + res.fa );
                    });
                }
            });
        });

		/* ------------------------------------
            CONTACT FORM
        ------------------------------------ */
		
		function isValidEmail(emailAddress) {
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
		$("#contact-form").on('submit', function(e) {
			e.preventDefault();
			var success = $(this).find('.email-success'),
				failed = $(this).find('.email-failed'),
				loader = $(this).find('.email-loading'),
				postUrl = $(this).attr('action');

			var data = {
				name: $(this).find('.contact-name').val(),
				email: $(this).find('.contact-email').val(),
				subject: $(this).find('.contact-subject').val(),
				message: $(this).find('.contact-message').val()
			};
			if (isValidEmail(data['email']) && (data['message'].length > 1) && (data['name'].length > 1)) {
				$.ajax({
					type: "POST",
					url: postUrl,
					data: data,
					beforeSend: function() {
						loader.fadeIn(1000);
					},
					success: function(data) {
						loader.fadeOut(1000);
						success.delay(500).fadeIn(1000);
						failed.fadeOut(500);
					},
					error: function(xhr) { // if error occured
						loader.fadeOut(1000);
						failed.delay(500).fadeIn(1000);
						success.fadeOut(500);
					},
					complete: function() {
						loader.fadeOut(1000);
					}
				});
			} else {
				loader.fadeOut(1000);
				failed.delay(500).fadeIn(1000);
				success.fadeOut(500);
			}
			return false;
		});
		
		
        /* ------------------------------------
            ANIMATE SCROLL
        ------------------------------------ */
        var $animateScrollParent = $('[data-animate-scroll="a"]'),
            animateScrolling = function (e) {
                e.href = $(this).attr('href');

                if ( e.href.charAt(0) === '#' && e.href.length > 1 ) {
                    $( e.href ).animatescroll({
                        padding: checkData( $body.data('offset'), 59 ),
                        easing: 'easeInOutExpo',
                        scrollSpeed: 2000
                    });

                    return false;
                }
            };

        $animateScrollParent.on('click', 'a', animateScrolling);

        /* ------------------------------------
            HEADER SECTION
        ------------------------------------ */
        var $header = $('.header--section');

        /* ------------------------------------
            BANNER SECTION
        ------------------------------------ */
        var $banner = $('.banner--section'),
            $bannerSlider = $banner.find('.banner--slider'),
            $bannerItem = $('.banner--item');

        $bannerSlider.on('initialized.owl.carousel', function (e) {
            $banner.css({
                'min-height': function () { 
                    var height = $wn.outerHeight() - $header.outerHeight(),
                        minHeight = $( e.target ).outerHeight() 
                    // return height < minHeight ? minHeight : height;
                    return 350;
                }
            });
        });

        /* ------------------------------------
            SKILLS SECTION
        ------------------------------------ */
        var $skills = $('.skills--section'),
            $skillProgressBars = $skills.find('.progress-bars');

        $skillProgressBars.find('.progress-bar').each(function () {
            var $t = $(this);

            $t.css('width', 0);
            
            $t.waypoint(function () {
                $t.css('width', $t.data('value') + '%');
            }, {
                triggerOnce: true,
                offset: 'bottom-in-view'
            });
        });

        /* ------------------------------------
            TESTIMONIAL SECTION
        ------------------------------------ */
        var $testimonial = $('.testimonial--section'),
            $testimonialClients = $testimonial.find('.testimonial--clients'),
            testimonialClientsI = $testimonialClients.data('increment');

        $testimonialClients.on('changed.owl.carousel', function (e) {
            var item = $(e.currentTarget).find('.owl-item')[ e.item.index + testimonialClientsI ],
                target = $( item ).children().data('target');

            $( item ).children('.item').tab('show');
        });

        $testimonialClients.on('click', '[data-toggle="tab"]', function () {
            var i = $(this).data('owl-item') + 1;

            $testimonialClients.trigger( 'to.owl.carousel', i );
        });

        /* ------------------------------------
            OWL CAROUSEL
        ------------------------------------ */
        var $owlCarousel = $('.owl-carousel');

        $owlCarousel.each(function () {
            var $t = $(this);

            $t.owlCarousel({
                items: checkData( $t.data('owl-items'), 1 ),
                margin: checkData( $t.data('owl-margin'), 0 ),
                loop: checkData( $t.data('owl-loop'), true ),
                smartSpeed: checkData( $t.data('owl-speed'), 2000 ),
                autoplay: checkData( $t.data('owl-autoplay'), true ),
                autoplaySpeed: checkData( $t.data('owl-speed'), 2000 ),
                autoplayTimeout: checkData( $t.data('owl-interval'), 5000 ),
                nav: checkData( $t.data('owl-nav'), false ),
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                dots: checkData( $t.data('owl-dots'), false ),
                mouseDrag: checkData( $t.data('owl-drag'), true ),
                animateIn: checkData( $t.data('owl-animate-in'), false ),
                animateOut: checkData( $t.data('owl-animate-out'), false ),
                responsive: checkData( $t.data('owl-responsive'), {} )
            });
        });

        /* ------------------------------------
            MAP
        ------------------------------------ */
        var $contact = $('.contact--section'),
            $contactMap = $contact.find('#map'),
            contactMap, contactMapData;

        if ( $contactMap.length && typeof google !== 'undefined' ) {
            contactMap = new google.maps.Map($contactMap[0], {
                center: {lat: $contactMap.data('map-latitude'), lng: $contactMap.data('map-longitude')},
                zoom: $contactMap.data('map-zoom'),
                scrollwheel: false,
                disabledDefaultUI: true,
                zoomControl: true
            });

            if ( typeof $contactMap.data('map-marker') !== 'undefined' ) {
                contactMapData = $contactMap.data('map-marker');

                for ( var i = 0; i < contactMapData.length; i++ ) {
                    new google.maps.Marker({
                        position: {lat: contactMapData[i][0], lng: contactMapData[i][1]},
                        map: contactMap,
                        animation: google.maps.Animation.DROP,
                        draggleable: true
                    });
                }
            }
        }
    });

    $wn.on('load', function () {
        /* ------------------------------------
            BODY SCROLLING
        ------------------------------------ */
        var isBodyScrolling = function () {
            return $wn.scrollTop() > 1 ? $body.addClass('is-scrolling') : $body.removeClass('is-scrolling') ;
        };

        isBodyScrolling();
        $wn.on('scroll', isBodyScrolling);

        /* ------------------------------------
            ADJUST ROW
        ------------------------------------ */
        var $adjustRow = $('.AdjustRow');

        if ( $adjustRow.length ) {
            $adjustRow.isotope({ layoutMode: 'fitRows' });
        }

        /* ------------------------------------
            PORTFOLIO SECTION
        ------------------------------------ */
        var $portfolio = $('.portfolio--section'),
            $portfolioFilter = $portfolio.find('.portfolio--filter-menu'),
            $portfolioItems = $portfolio.find('.portfolio--items'),
            $portfolioItem = $portfolioItems.children('.portfolio--item');

        $portfolioItem.each(function () {
            var $el = $(this).children('.img');

            $el.children('.popup-btn').css( 'height', $el.children('.info').outerHeight() );
        });

        if ( $portfolioItems.length ) {
            $portfolioItems.isotope({
                animationEngine: 'best-available',
                itemSelector: '.portfolio--item'
            });

            $portfolioFilter.on('click', 'li', function () {
                var $t = $(this),
                    target = $t.data('target'),
                    cat = (target !== '*') ? '[data-cat~="'+ target +'"]' : target;

                $portfolioItems.isotope({
                    filter: cat
                });

                $t.addClass('active').siblings().removeClass('active');
            });
        }

        /* ------------------------------------
            PRELOADER
        ------------------------------------ */
        var $preloader = $('#preloader');
        
        if ( $preloader.length ) {
            $preloader.fadeOut('slow');
        }
    });

})(jQuery);