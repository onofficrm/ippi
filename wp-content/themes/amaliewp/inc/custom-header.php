<?php
/**
 * Custom Header functionality for amalie
 *
 * @package Amalie
 * @since Amalie 1.0
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses amalie_header_style()
 */
function amalie_custom_header_setup() {

	/**
	 * Filter Amalie custom-header support arguments.
	 *
	 * @since Amalie 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type int    $width                  Width in pixels of the custom header image. Default 954.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 1300.
	 *     @type string $wp-head-callback       Callback function used to styles the header image and text
	 *                                          displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'amalie_custom_header_args', array(
		'default-text-color'     => '333333',
		'width'                  => 954,
		'height'                 => 1300,
		'wp-head-callback'       => 'amalie_header_style',
		'admin-head-callback'    => 'amalie_admin_header_style',
		'admin-preview-callback' => 'amalie_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'amalie_custom_header_setup' );


if ( ! function_exists( 'amalie_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @since Amalie 1.0
 *
 * @see amalie_custom_header_setup()
 */
function amalie_header_style() {
	$header_image = get_header_image();
	$header_text_color = get_header_textcolor();
	
	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && display_header_text() ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="amalie-header-css">
	<?php
		// Short header for when there is no Custom Header and Header Text is hidden.
		if ( empty( $header_image ) && ! display_header_text() ) :
	?>
		.site-header {
			padding-top: 14px;
			padding-bottom: 14px;
		}

		.site-branding {
			min-height: 42px;
		}

		@media screen and (min-width: 46.25em) {
			.site-header {
				padding-top: 21px;
				padding-bottom: 21px;
			}
			.site-branding {
				min-height: 56px;
			}
		}
		@media screen and (min-width: 55em) {
			.site-header {
				padding-top: 25px;
				padding-bottom: 25px;
			}
			.site-branding {
				min-height: 62px;
			}
		}
		@media screen and (min-width: 59.6875em) {
			.site-header {
				padding-top: 0;
				padding-bottom: 0;
			}
			.site-branding {
				min-height: 0;
			}
		}
	<?php
		endif;

		// Has a Custom Header been added?
		if ( ! empty( $header_image ) ) :
	?>
		.site-header {
			background: url(<?php header_image(); ?>) no-repeat 50% 50%;
			-webkit-background-size: cover;
			-moz-background-size:    cover;
			-o-background-size:      cover;
			background-size:         cover;
		}

		@media screen and (min-width: 59.6875em) {
			body:before {
				background: #fff;
				background: url(<?php header_image(); ?>) no-repeat 100% 50%;
				-webkit-background-size: cover;
				-moz-background-size:    cover;
				-o-background-size:      cover;
				background-size:         cover;
				border-right: 0;
			}

			.site-header {
				background: transparent;
			}
		}
		@media screen and (max-width: 59.6875em) {
			body:before {
				background: #fff;
			}

			.site-header {
				background: #fff;
			}
		}
	.site-description,
	.site-title a,
	.site-title {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-title a,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-title,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // amalie_header_style