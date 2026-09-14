/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function ( $ ) {

	// Site title
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-title a' ).text( to );
		} );
	} );

	// Site description.
	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-description' ).text( to );
		} );
	} );

	// Header background color.
	wp.customize( 'ample[ample_header_background_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.header, .one-page-menu-active .header' ).css( 'background-color', to );
		} );
	} );

	// Site title color.
	wp.customize( 'ample[ample_site_title_text_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-title a' ).css( 'color', to );
		} );
	} );

	// Site Tagline color.
	wp.customize( 'ample[ample_site_tagline_text_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-description' ).css( 'color', to );
		} );
	} );

	// Primary menu background color.
	wp.customize( 'ample[ample_primary_menu_background_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.main-navigation' ).css( 'background-color', to );
		} );
	} );

	// Primary menu selected/hovered item text color.
	wp.customize( 'ample[ample_primary_menu_selected_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.main-navigation a:hover, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-item a::after, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-ancestor a::after, .main-navigation ul li.current_page_item a::after, .main-navigation ul li.current_page_item a, .main-navigation ul li.current_page_ancestor a, .main-navigation ul li.current_page_ancestor a::after, .main-navigation ul li:hover > a, .main-navigation li.menu-item-has-children:hover > a::after, .main-navigation li.page_item_has_children:hover > a::after,  .main-navigation ul li ul li a:hover, .main-navigation ul li ul li:hover > a, .main-navigation ul li.current-menu-item ul li a:hover' ).css( 'color', to );

			$( '.main-navigation ul.menu > li.current-menu-item, .main-navigation ul.menu > li.current-menu-ancestor, .main-navigation .menu > ul > li.current_page_item, .main-navigation .menu > ul > li.current_page_ancestor, .main-navigation ul.menu > li:hover, .main-navigation .menu > ul > li:hover' ).css( 'border-top-color', to );


		} );
	} );

	// Primary menu (unselected/unhovered) text color.
	wp.customize( 'ample[ample_primary_menu_text_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.main-navigation a, .main-navigation ul li ul li a,.main-navigation ul li.current-menu-item ul li a' ).css( 'color', to );
		} );
	} );

	// Header top bar text color.
	wp.customize( 'ample[ample_top_bar_text_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.small-info-text p' ).css( 'color', to );
		} );
	} );

	// Slider title text color.
	wp.customize( 'ample[ample_slider_title_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.big-slider .entry-title a' ).css( 'color', to );
		} );
	} );

	// Slider title hover text color.
	wp.customize( 'ample[ample_slider_title_hover_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.big-slider .entry-title a:hover' ).css( 'color', to );
		} );
	} );

	// Slider button text color.
	wp.customize( 'ample[ample_slider_button_text_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.slider-button' ).css( 'color', to );
		} );
	} );

	// Slider button hover background color.
	wp.customize( 'ample[ample_slider_button_background_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.slider-button:hover' ).css( 'background-color', to );
		} );
	} );

	// Header Title Bar background color.
	wp.customize( 'ample[ample_title_bar_background_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.header-post-title-container' ).css( 'background-color', to );
		} );
	} );

	// Header Title Bar text color.
	wp.customize( 'ample[ample_header_title_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.header-post-title-class, .breadcrumb' ).css( 'color', to );
		} );
	} );

	// Header Title Bar link text color.
	wp.customize( 'ample[ample_header_title_link_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.breadcrumb a' ).css( 'color', to );
		} );
	} );

	// Content section text color.
	wp.customize( 'ample[ample_content_text_color]', function ( value ) {
		value.bind( function ( to ) {
			$( 'body, button, input, select, textarea, p' ).css( 'color', to );
		} );
	} );

	// Post title color for Posts Page.
	wp.customize( 'ample[ample_post_page_title_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.hentry .entry-title a' ).css( 'color', to );
		} );
	} );

	// Post meta color.
	wp.customize( 'ample[ample_post_meta_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.entry-meta a' ).css( 'color', to );
		} );
	} );

	// Read more text color.
	wp.customize( 'ample[ample_readmore_text_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.more-link span' ).css( 'color', to );
		} );
	} );

	// Read more background color.
	wp.customize( 'ample[ample_readmore_background_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '.more-link span' ).css( 'background-color', to );
		} );
	} );

	// Left and Right sidebar widget title color.
	wp.customize( 'ample[ample_sidebar_widget_title_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#secondary .widget-title, #tertiary .widget-title' ).css( 'color', to );
		} );
	} );

	// Footer background color.
	wp.customize( 'ample[ample_footer_background_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon' ).css( 'background-color', to );
		} );
	} );

	// Footer widget background color.
	wp.customize( 'ample[ample_footer_widget_background_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon .tg-one-fourth' ).css( 'background-color', to );
		} );
	} );

	// Footer widget title color.
	wp.customize( 'ample[ample_footer_widget_title_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon .widget-title' ).css( 'color', to );
		} );
	} );

	// Footer content color.
	wp.customize( 'ample[ample_footer_content_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon, #colophon .footer-widgets-area,#colophon p' ).css( 'color', to );
		} );
	} );

	// Footer content link text color.
	wp.customize( 'ample[ample_footer_link_color]', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon a, #colophon .copyright-info a, #colophon .footer-nav ul li a' ).css( 'color', to );
		} );
	} );

	// Header Top Bar Font Size.
	wp.customize( 'ample[ample_header_top_bar_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.small-info-text p' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Site title font size.
	wp.customize( 'ample[ample_site_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-title a' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Site tagline font size.
	wp.customize( 'ample[ample_tagline_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '#site-description' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Primary menu font size.
	wp.customize( 'ample[ample_primary_menu_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.main-navigation ul.menu li a' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Primary sub menu font size.
	wp.customize( 'ample[ample_primary_sub_menu_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.main-navigation ul.menu li ul.sub-menu li a' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Slider title.
	wp.customize( 'ample[ample_slider_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.big-slider .entry-title' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Slider button.
	wp.customize( 'ample[ample_slider_button_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.slider-button' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Heading h1 tag font size.
	wp.customize( 'ample[ample_h1_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'h1' ).css( 'fontSize', parseInt( to ) );
		} );
	} );
	// Heading h2 tag font size.
	wp.customize( 'ample[ample_h2_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'h2' ).css( 'fontSize', parseInt( to ) );
		} );
	} );
	// Heading h3 tag font size.
	wp.customize( 'ample[ample_h3_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'h3' ).css( 'fontSize', parseInt( to ) );
		} );
	} );
	// Heading h4 tag font size.
	wp.customize( 'ample[ample_h4_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'h4' ).css( 'fontSize', parseInt( to ) );
		} );
	} );
	// Heading h5 tag font size.
	wp.customize( 'ample[ample_h5_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'h5' ).css( 'fontSize', parseInt( to ) );
		} );
	} );
	// Heading h6 tag font size.
	wp.customize( 'ample[ample_h6_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'h6' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Widget Titles.
	wp.customize( 'ample[ample_widget_titles_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'h3.widget-title, #secondary .widget-title, #tertiary .widget-title' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Widget Description.
	wp.customize( 'ample[ample_widget_description_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.widget .services-main-description p, .widget .portfolio-main-description p, .widget .featured-posts-main-description p, .widget .testimonials-main-description p, .widget .clients-main-description p' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// TG: Call to Action widget text.
	wp.customize( 'ample[ample_call_to_action_widget_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.call-to-action-content-wrapper h3' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Header Title Bar.
	wp.customize( 'ample[ample_header_title_bar_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.header-post-title-class' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Post Title of Posts Page.
	wp.customize( 'ample[ample_posts_page_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.hentry .entry-title' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Comment Title.
	wp.customize( 'ample[ample_comment_title_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.comments-title' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Content Font Size Options.
	wp.customize( 'ample[ample_content_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( 'body, button, input, select, textarea, p, dl, .ample-button, input[type="reset"], input[type="button"], input[type="submit"], button, .previous a, .next a, .nav-previous a, .nav-next a, #respond h3#reply-title #cancel-comment-reply-link, #respond form input[type="text"], #respond form textarea, #secondary .widget, .error-404 .widget' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Post meta font size
	wp.customize( 'ample[ample_post_meta_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.entry-meta' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// 	Footer widget Titles.
	wp.customize( 'ample[ample_footer_widget_titles_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon .widget-title' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Footer widget content font size.
	wp.customize( 'ample[ample_footer_widget_content_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '.footer-widgets-area, #colophon .footer-widgets-area a' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Footer copyright text font size.
	wp.customize( 'ample[ample_footer_copyright_text_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon .copyright, #colophon .copyright a, #colophon .copyright p' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Footer small menu.
	wp.customize( 'ample[ample_small_footer_menu_font_size]', function ( value ) {
		value.bind( function ( to ) {
			$( ' #colophon .menu-footer-menu-container, #colophon .menu-footer-menu-container a, #colophon .footer-nav a' ).css( 'fontSize', parseInt( to ) );
		} );
	} );

	// Site layout option.
	wp.customize( 'ample[ample_site_layout]', function ( value ) {
		value.bind(
			function ( layout ) {
				var layout_options = layout;

				if ( layout_options == 'wide' ) {

					$( 'body' ).addClass( 'wide' );

				} else if ( layout_options == 'box' ) {

					$( 'body' ).removeClass( 'wide' );
				}
			}
		);
	} );

} )( jQuery );
