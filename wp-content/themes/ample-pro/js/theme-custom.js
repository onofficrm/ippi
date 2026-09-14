/* global ample_slider_value, ampleScriptParam, team_carousel_obj*/
jQuery( document ).ready( function () {

	if ( ampleScriptParam.enable_sticky_menu === '1' ) {
		var headerheight = jQuery( '.header' ).outerHeight();
		jQuery( '#masthead' ).css( 'height', headerheight );
	}

	// For one page active menu item.
	jQuery( '.main-navigation div ul li' ).click( function () {
		jQuery( '.main-navigation div ul li' ).removeClass( 'current-one-page-menu-item' );
		jQuery( this ).addClass( 'current-one-page-menu-item' );
	} );

	//toggle menu when menu items clicked for one page
	jQuery( '.page-template-onepage .menu-primary-container li' ).click( function () {
		jQuery( '#site-navigation' ).addClass( 'main-navigation' ).removeClass( 'main-small-navigation' );
	} );

	// For smooth scroll
	if ( typeof jQuery.fn.mPageScroll2id !== 'undefined' ) {
		jQuery( 'a[href*="#"]' ).mPageScroll2id();
		jQuery( 'a[rel="m_PageScroll2id"]' ).mPageScroll2id( {
			offset: '#masthead'
		} );
	}

	// For Search Icon Toggle effect added at the top
	var hideSearchForm = function () {
		jQuery( '#masthead .search-form-top' ).removeClass( 'show' );
	};

	jQuery( '.search-top' ).click( function () {
		jQuery( '#masthead .search-form-top' ).toggleClass( 'show' );

		// focus after some time to fix conflict with toggleClass.
		setTimeout(  function(){
			jQuery( '#masthead .search-form-top.show input' ).focus();
		}, 200 );

		// For esc key press.
		jQuery( document ).on( 'keyup', function( e ) {
			
			//on esc key press.
			if( 27 === e.keyCode ){
				//if search box is opened.
				if( jQuery( '.search-form-top' ).hasClass( 'show' ) ){
					hideSearchForm();
				}
			}
		} );

		// For click out of search box.
		jQuery( document ).on( 'click.outEvent', function( e ){
			if ( e.target.closest('.search-form-top') || e.target.closest('.search-top') ) {
				return;
			}

			hideSearchForm();

			// Unbind current click event.
			jQuery( document ).off( 'click.outEvent' );
		} );

	} );

	// For Scroll to top button
	jQuery( '#scroll-up' ).hide();
	jQuery( function () {
		jQuery( window ).scroll( function () {
			if ( jQuery( this ).scrollTop() > 1000 ) {
				jQuery( '#scroll-up' ).fadeIn();
			} else {
				jQuery( '#scroll-up' ).fadeOut();
			}
		} );
		jQuery( 'a#scroll-up' ).click( function () {
			jQuery( 'body,html' ).animate( {
				scrollTop: 0
			}, 800 );
			return false;
		} );
	} );

	// Bxslider Setting
	if ( typeof jQuery.fn.bxSlider !== 'undefined' ) {
		// Team widget slider settings.
		if ( typeof team_carousel_obj !== 'undefined' ) {
			jQuery( '.team-slider' ).bxSlider( {
				minSlides: 1,
				maxSlides: team_carousel_obj.carouselnum,
				slideWidth: 1100 / team_carousel_obj.carouselnum - 30,
				slideMargin: 30,
				auto: true,
				controls: false
			} );
		}

		// Header slider settings.
		if ( typeof ample_slider_value !== 'undefined' ) {
			var transition_effect = ample_slider_value.transition_effect;
			var transition_delay = ample_slider_value.transition_delay;
			var transition_duration = ample_slider_value.transition_duration;

			var slider = jQuery( '.big-slider' ).bxSlider( {
				mode: transition_effect,
				speed: parseInt( transition_duration, 10 ),
				auto: true,
				pause: parseInt( transition_delay, 10 ),
				adaptiveHeight: true,
				nextText: '',
				prevText: '',
				nextSelector: '.slide-next',
				prevSelector: '.slide-prev',
				pager: false,
				autoHover: true
			} );
			jQuery( '.bx-next, .bx-prev' ).click( function () {
				slider.stopAuto();
				setTimeout( function () {
						slider.startAuto();
					}, 1000
				);
				return false;
			} );
		}

		// Clients slider
		jQuery( '.slider-clients' ).bxSlider( {
			minSlides: 2,
			maxSlides: 5,
			slideWidth: 170,
			slideMargin: 10,
			moveSlides: 1,
			pager: false,
			nextText: '<i class="fa fa-arrow-right"></i>',
			prevText: '<i class="fa fa-arrow-left"></i>'
		} );
	}

	// CounterUP
	if ( typeof jQuery.fn.counterUp !== 'undefined' ) {
		jQuery( '.counter' ).counterUp( {
			delay: 10,
			time: 2000
		} );
	}

	// fixed sidebar js
	if ( ( typeof jQuery.fn.theiaStickySidebar !== 'undefined' ) && ( typeof ResizeSensor !== 'undefined' ) ) {

		// Calculate the whole height of sticky menu
		var height = jQuery( '.one-page-menu-active #masthead' ).outerHeight();

		// Assign height value to 0 if it returns null
		if ( height === null ) {
			height = 0;
		}

		jQuery( '#primary, #secondary, #tertiary' ).theiaStickySidebar( {
			additionalMarginTop: 40 + height
		} );
	}
} );
