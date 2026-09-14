<?php
/**
 * Contains all the fucntions and components related to header part.
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0
 */

/****************************************************************************************/

if ( ! function_exists( 'ample_social_links' ) ) :
	/**
	 * This function is for social links display on header.
	 *
	 * Get links and respective font-awesome icon class through Theme Options.
	 */
	function ample_social_links() { ?>
		<div class="social-links clearfix">
			<ul>
				<?php
				$ample_links_output = '';
				for ( $i = 1; $i <= 10; $i ++ ) {
					$link       = ample_option( 'ample_social_icon_link' . $i, '' );
					$icon_class = ample_option( 'ample_icon_class' . $i, '' );
					if ( ! empty( $link ) ) {
						if ( ample_option( 'ample_social_new_tab' . $i, '0' ) == '1' ) {
							$new_tab = ' target="_blank"';
						} else {
							$new_tab = '';
						}
						$ample_links_output .=
							'<li><a href="' . esc_url( $link ) . '"' . $new_tab . '><i class="fa fa-' . strtolower( $icon_class ) . '"></i></a></li>';
					}
				}
				echo $ample_links_output;
				?>
			</ul>
		</div><!-- .social-links -->
		<?php
	}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_header_info_text' ) ) :
	/**
	 * Shows the small info text on top header part
	 */
	function ample_header_info_text() {
		if ( ample_option( 'ample_header_info_text', '' ) == '' ) {
			return;
		}

		$ample_header_info_text = '<div class="small-info-text"><p>' . ample_option( 'ample_header_info_text', '' ) . '</p></div>';
		echo do_shortcode( $ample_header_info_text );
	}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_pass_slider_parameters' ) ) :
	/**
	 * Function to pass the slider effect parameters from php file to js file.
	 */
	function ample_pass_slider_parameters() {
		$transition_effect = ample_option( 'ample_slider_transition_effect', 'fade' );

		$transition_delay    = ample_option( 'ample_slider_transition_delay', 4 );
		$transition_duration = ample_option( 'ample_slider_transition_length', 1 );
		$transition_delay    = intval( $transition_delay );
		$transition_duration = intval( $transition_duration );

		if ( $transition_delay != 0 ) {
			$transition_delay = $transition_delay * 1000;
		} else {
			$transition_delay = 4000;
		}
		if ( $transition_duration != 0 ) {
			$transition_duration = $transition_duration * 1000;
		} else {
			$transition_duration = 1000;
		}

		wp_localize_script(
			'ample-custom',
			'ample_slider_value',
			array(
				'transition_effect'   => $transition_effect,
				'transition_delay'    => $transition_delay,
				'transition_duration' => $transition_duration,
			)
		);
	}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_featured_image_slider' ) ):
	/**
	 * Display the slider.
	 */
	function ample_featured_image_slider() { ?>
		<div class="big-slider-wrapper">
			<div class="big-slider">
				<?php
				$num_of_slides = ample_option( 'ample_slider_number', '4' );
				for ( $i = 1; $i <= $num_of_slides; $i ++ ) {
					$ample_slider_image       = ample_option( 'ample_slider_image' . $i, '' );
					$ample_slider_title       = ample_option( 'ample_slider_title' . $i, '' );
					$ample_slider_button_text = ample_option( 'ample_slider_button_text' . $i, '' );
					$ample_slider_link        = ample_option( 'ample_slider_link' . $i, '' );
					$attachment_post_id       = attachment_url_to_postid( $ample_slider_image );
					$image_attributes         = wp_get_attachment_image_src( $attachment_post_id, 'full');

					if ( ! empty( $ample_slider_image ) ) {
						// For WPML plugin compatibility
						if ( function_exists( 'icl_register_string' ) ) {
							icl_register_string( 'Ample Pro', 'Slider Image ' . $i, $ample_slider_image );
							icl_register_string( 'Ample Pro', 'Slider Title ' . $i, $ample_slider_title );
							icl_register_string( 'Ample Pro', 'Slider Button Text ' . $i, $ample_slider_button_text );
							icl_register_string( 'Ample Pro', 'Slider Link ' . $i, $ample_slider_link );
						}

						if ( function_exists( 'icl_t' ) ) {
							$ample_slider_image       = icl_t( 'Ample Pro', 'Slider Image ' . $i, $ample_slider_image );
							$ample_slider_title       = icl_t( 'Ample Pro', 'Slider Title ' . $i, $ample_slider_title );
							$ample_slider_button_text = icl_t( 'Ample Pro', 'Slider Button Text ' . $i, $ample_slider_button_text );
							$ample_slider_link        = icl_t( 'Ample Pro', 'Slider Link ' . $i, $ample_slider_link );
						}
						?>
						<div class="slides">
							<?php if ( ! empty( $ample_slider_title ) ) { ?>
								<div class="slider-entry-container">
									<h3 class="entry-title">
										<a href="<?php echo esc_url( $ample_slider_link ); ?>"
										   title="<?php echo esc_attr( $ample_slider_title ); ?>"><?php echo $ample_slider_title; ?></a>
									</h3>
									<?php if ( ! empty( $ample_slider_button_text ) ) : ?>
										<div class="slider-link-btn">
											<a class="slider-button" href="<?php echo esc_url( $ample_slider_link ); ?>"
											   title="<?php echo esc_attr( $ample_slider_title ); ?>"> <?php echo( $ample_slider_button_text ); ?>
											</a>
										</div>
									<?php endif; ?>
								</div>
							<?php } ?>
							<figure>
								<?php if ( ample_option( 'ample_slider_image_link_option', 0 ) == 1 ) { ?>
								<a href="<?php echo esc_url( $ample_slider_link ); ?>"
								   title="<?php echo esc_attr( $ample_slider_title ); ?>">
									<?php } ?>

									<?php $img_altr = get_post_meta( $attachment_post_id, '_wp_attachment_image_alt', true );
									$img_alt  = ! empty( $img_altr ) ? $img_altr : $ample_slider_title; ?>
									<img width="<?php echo esc_attr($image_attributes[1]); ?>" height="<?php echo esc_attr($image_attributes[2]); ?>" alt="<?php echo esc_attr( $img_alt ); ?>"
									     src="<?php echo esc_url( $ample_slider_image ); ?>">

									<?php if ( ample_option( 'ample_slider_image_link_option', 0 ) == 1 ) { ?>
								</a>
							<?php } ?>
							</figure>
						</div>
					<?php }
				} ?>
			</div>
			<div class="slide-next"></div>
			<div class="slide-prev"></div>
		</div><!-- .big-slider-wrapper -->
	<?php }
endif;

/****************************************************************************************/
// Filter the get_header_image_tag() for option of displaying the header image in old way
function ample_header_image_markup( $html, $header, $attr ) {
	$output       = '';
	$header_image = get_header_image();

	if ( ! empty( $header_image ) ) {

		if ( ample_option( 'ample_header_image_link', 0 ) == 1 ) {
			$output .= '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
		}

		if ( ( ample_option( 'ample_header_link_to_url' ) ) && ( ample_option( 'ample_header_image_link', 0 ) == 0 ) ) {
			$output .= '<a href="' . esc_url( ample_option( 'ample_header_link_to_url' ) ) . '" target="_blank">';
		}

		$output .= '<img src="' . esc_url( $header_image ) . '" class="header-image"
                         width="' . get_custom_header()->width . '" height="' . get_custom_header()->height . '"
                         alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';

		if ( ( ample_option( 'ample_header_link_to_url' ) ) || ( ample_option( 'ample_header_image_link', 0 ) == 1 ) ) {
			$output .= '</a>';
		}
	}

	return $output;
}

function ample_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'ample_header_image_markup', 10, 3 );
}

add_action( 'ample_header_image_markup_render', 'ample_header_image_markup_filter' );

/****************************************************************************************/

if ( ! function_exists( 'ample_render_header_image' ) ) :
	/**
	 * Display the header image.
	 */
	function ample_render_header_image() {
		if ( function_exists( 'the_custom_header_markup' ) ) {
			do_action( 'ample_header_image_markup_render' );
			the_custom_header_markup();
		} else {
			$header_image = get_header_image();
			if ( ! empty( $header_image ) ) {

				if ( ample_option( 'ample_header_image_link', 0 ) == 1 ) {
					echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
				}

				if ( ( ample_option( 'ample_header_link_to_url' ) ) && ( ample_option( 'ample_header_image_link', 0 ) == 0 ) ) {
					echo '<a href="' . esc_url( ample_option( 'ample_header_link_to_url' ) ) . '" target="_blank">';
				} ?>

				<img src="<?php echo esc_url( $header_image ); ?>" class="header-image"
				     width="<?php echo get_custom_header()->width; ?>"
				     height="<?php echo get_custom_header()->height; ?>"
				     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">

				<?php if ( ( ample_option( 'ample_header_link_to_url' ) ) || ( ample_option( 'ample_header_image_link', 0 ) == 1 ) ) {
					echo '</a>';
				}
			}
		}
	}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_header_title' ) ) :
	/**
	 * Show the title in header
	 */
	function ample_header_title() {
		if ( is_archive() ) {
			if ( is_category() ) :
				$ample_header_title = single_cat_title( '', false );

			elseif ( is_tag() ) :
				$ample_header_title = single_tag_title( '', false );

			elseif ( is_author() ) :
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				*/
				the_post();
				$ample_header_title = sprintf( __( 'Author: %s', 'ample' ), '<span class="vcard">' . get_the_author() . '</span>' );
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();

			elseif ( is_day() ) :
				$ample_header_title = sprintf( __( 'Day: %s', 'ample' ), '<span>' . get_the_date() . '</span>' );

			elseif ( is_month() ) :
				$ample_header_title = sprintf( __( 'Month: %s', 'ample' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

			elseif ( is_year() ) :
				$ample_header_title = sprintf( __( 'Year: %s', 'ample' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

			elseif ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) :
				$ample_header_title = woocommerce_page_title( false );

			else :
				$ample_header_title = __( 'Archives', 'ample' );

			endif;
		} elseif ( is_404() ) {
			$ample_header_title = __( 'Page NOT Found', 'ample' );
		} elseif ( is_search() ) {
			$ample_header_title = sprintf( __( 'Search Results For: %s', 'ample' ), '<span>' . get_search_query() . '</span>' );
		} elseif ( is_page() ) {
			$ample_header_title = get_the_title();
		} elseif ( is_single() ) {
			$ample_header_title = get_the_title();
		} elseif ( is_home() ) {
			$queried_id         = get_option( 'page_for_posts' );
			$ample_header_title = get_the_title( $queried_id );
		} else {
			$ample_header_title = '';
		}

		return $ample_header_title;
	}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_breadcrumb' ) ) :
	/**
	 * Display breadcrumb on header.
	 *
	 * If the page is home or front page, slider is displayed.
	 * In other pages, breadcrumb will display if breadcrumb NavXT plugin exists.
	 */
	function ample_breadcrumb() {
		if ( function_exists( 'bcn_display' ) ) {
			echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
			echo '<span class="breadcrumb-title">' . __( 'You are here:', 'ample' ) . '</span>';
			bcn_display();
			echo '</div> <!-- .breadcrumb -->';
		}
	}
endif; ?>
