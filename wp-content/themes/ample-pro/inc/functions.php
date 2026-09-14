<?php
/**
 * Ample functions and definitions
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0
 */

if ( ! function_exists( 'ample_option' ) ) :
	/**
	 * Ample options
	 */
	function ample_option( $name, $default = false ) {

		$ample_options = get_option( 'ample' );

		if ( isset( $ample_options[ $name ] ) ) {
			return $ample_options[ $name ];
		} else {
			return $default;
		}
	}
endif;

add_action( 'wp_enqueue_scripts', 'ample_scripts' );
/**
 * Enqueue scripts and styles.
 */
function ample_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	// Load bxslider CSS
	wp_register_style( 'ample-bxslider', get_template_directory_uri() . '/js/jquery.bxslider/jquery.bxslider' . $suffix . '.css', array(), '4.2.12' );

	// Load Google Fonts
	$ample_googlefonts = array();
	array_push( $ample_googlefonts, ample_option( 'ample_site_title_font', 'Roboto+Slab:700,400' ) );
	array_push( $ample_googlefonts, ample_option( 'ample_site_tagline_font', 'Roboto+Slab:700,400' ) );
	array_push( $ample_googlefonts, ample_option( 'ample_primary_menu_font', 'Roboto:400,300,100' ) );
	array_push( $ample_googlefonts, ample_option( 'ample_titles_font', 'Roboto+Slab:700,400' ) );
	array_push( $ample_googlefonts, ample_option( 'ample_content_font', 'Roboto:400,300,100' ) );

	// Assign required fonts from database in array and make it unique.
	$ample_googlefonts          = array_unique( $ample_googlefonts );
	$ample_google_fonts         = ample_google_fonts();
	$ample_standard_fonts_array = ample_standard_fonts_array();

	// Check for the Google Fonts arrays.
	foreach ( $ample_googlefonts as $ample_googlefont ) {

		// If the array_key_exists for currently selected fonts,
		// then only proceed to create new array to include,
		// only the required Google fonts.
		// For Standard fonts, no need for loading up the Google Fonts array.
		if ( array_key_exists( $ample_googlefont, $ample_google_fonts ) ) {
			$ample_googlefont_lists[] = $ample_googlefont;
		}

	}

	// Check for the Standard Fonts arrays.
	foreach ( $ample_googlefonts as $ample_standard_font ) {

		// If the array_key_exists for currently selected fonts,
		// then only proceed to create new array to include,
		// only the required Standard fonts,
		// in order to enqueue to Google Fonts only when,
		// no theme_mods data is altered.
		if ( array_key_exists( $ample_standard_font, $ample_standard_fonts_array ) ) {
			$ample_standard_font_lists[] = $ample_standard_font;
		}

	}

	// Proceed only if the Google Fonts array is available,
	// to enqueue the Google Fonts.
	if ( isset( $ample_googlefont_lists ) ) :

		$ample_googlefont_lists = implode( "|", $ample_googlefont_lists );

		wp_register_style( 'ample_googlefonts', '//fonts.googleapis.com/css?family=' . $ample_googlefont_lists );
		wp_enqueue_style( 'ample_googlefonts' );

	// Proceed only if the theme is installed first time,
	// or the theme_mods data for typography is not changed.
	elseif ( ! isset( $ample_standard_font_lists ) ) :

		$ample_googlefonts = implode( "|", $ample_googlefonts );

		wp_register_style( 'ample_googlefonts', '//fonts.googleapis.com/css?family=' . $ample_googlefonts );
		wp_enqueue_style( 'ample_googlefonts' );

	endif;

	// Load fontawesome
	wp_enqueue_style( 'ample-fontawesome', get_template_directory_uri() . '/font-awesome/css/font-awesome' . $suffix . '.css', array(), '4.7.0' );

	/**
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'ample-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register bxslider Script
	wp_register_script( 'ample-bxslider', get_template_directory_uri() . '/js/jquery.bxslider/jquery.bxslider' . $suffix . '.js', array( 'jquery' ), '4.2.12', true );
	// Waypoints Script
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/waypoints' . $suffix . '.js', array( 'jquery' ), '2.0.3', true );
	// CounterUp Script
	wp_enqueue_script( 'counterup', get_template_directory_uri() . '/js/jquery.counterup' . $suffix . '.js', array( 'jquery' ), false, true );

	$slider        = 0;
	$num_of_slides = ample_option( 'ample_slider_number', '4' );
	for ( $i = 1; $i <= $num_of_slides; $i ++ ) {
		$slider_image = ample_option( 'ample_slider_image' . $i, '' );
		if ( ! empty( $slider_image ) ) {
			$slider ++;
		}
	}

	if ( ( $slider > 1 ) && ample_option( 'ample_activate_slider', '0' ) == '1' && ( is_front_page() || ample_option( 'ample_slider_status', 'front_page' ) == 'all_page' ) ) {
		wp_enqueue_script( 'ample-bxslider' );
		wp_enqueue_style( 'ample-bxslider' );
	}

	wp_enqueue_script( 'ample-navigation', get_template_directory_uri() . '/js/navigation' . $suffix . '.js', array( 'jquery' ), false, true );

	if ( is_front_page() && ample_option( 'ample_activate_sticky_menu', 0 ) == 1 ) {
		wp_enqueue_script( 'ample-smooth-scroll', get_template_directory_uri() . '/js/jquery.malihu.PageScroll2id' . $suffix . '.js', array( 'jquery' ), '1.5.7', true );
	}

	wp_enqueue_script( 'ample-custom', get_template_directory_uri() . '/js/theme-custom' . $suffix . '.js', array( 'jquery' ), false, true );

	// Skip link focus fix JS enqueue.
	wp_enqueue_script( 'ample-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), false, true );

	$enable_sticky_menu = ample_option( 'ample_activate_sticky_menu', '0' );
	wp_localize_script(
		'ample-custom',
		'ampleScriptParam',
		array( 'enable_sticky_menu' => $enable_sticky_menu )
	);

	// Theia Sticky Sidebar enqueue
	if ( ample_option( 'ample_sticky_content_sidebar', '0' ) == '1' ) {
		wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar/theia-sticky-sidebar' . $suffix . '.js', array( 'jquery' ), '1.7.0', true );
		wp_enqueue_script( 'ResizeSensor', get_template_directory_uri() . '/js/theia-sticky-sidebar/ResizeSensor' . $suffix . '.js', array( 'jquery' ), false, true );
	}
}

add_action( 'wp_enqueue_scripts', 'ample_custom_js', 100 );
/**
 * Enqueue scripts and styles.
 */
function ample_custom_js() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'ample-custom', get_template_directory_uri() . '/js/theme-custom' . $suffix . '.js', array( 'jquery' ), false, true );
}

/**************************************************************************************/

add_action( 'admin_enqueue_scripts', 'ample_image_uploader' );
/**
 * Add admin scripts
 */
if ( ! function_exists( 'ample_image_uploader' ) ) :
	function ample_image_uploader( $hook ) {
		global $post_type;
		if ( $hook == 'widgets.php' || $hook == 'customize.php' ) {
			//For image uploader
			wp_enqueue_media();
			wp_enqueue_script( 'ample-script', get_template_directory_uri() . '/js/image-uploader.js', false, '1.0', true );

			//For Color Picker
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'ample-color-picker', get_template_directory_uri() . '/js/color-picker.js', array( 'wp-color-picker' ), false );
		}
	}
endif;

/**************************************************************************************/

add_action( 'pre_get_posts', 'ample_exclude_category' );
/**
 * Function to exclude category
 */
function ample_exclude_category( $query ) {
	$ample_hide_categories = array();
	$ample_cat_num         = ample_option( 'ample_hide_category', '' );
	if ( ! empty( $ample_cat_num ) ) {
		if ( is_array( $ample_cat_num ) ) {
			foreach ( $ample_cat_num as $key => $value ) {
				if ( $value ) {
					array_push( $ample_hide_categories, $key );
				}
			}
		} else {
			$ample_hide_categories = explode( ',', $ample_cat_num );
		}
	}

	if ( $query->is_home() && $query->is_main_query() ) {
		$query->set( 'category__not_in', $ample_hide_categories );
	}
}

/**************************************************************************************/

// Adding the support for the entry-title tag for Google Rich Snippets
function ample_add_mod_hatom_data( $content ) {
	$title = get_the_title();
	if ( is_single() ) {
		$content .= '<div class="extra-hatom-entry-title"><span class="entry-title">' . $title . '</span></div>';
	}

	return $content;
}

add_filter( 'the_content', 'ample_add_mod_hatom_data' );

/****************************************************************************************/

if ( ! function_exists( 'ample_font_size_range_generator' ) ) :
	/**
	 * Function to generate font size range for font size options.
	 */
	function ample_font_size_range_generator( $start_range, $end_range ) {
		$range_string = array();
		for ( $i = $start_range; $i <= $end_range; $i ++ ) {
			$range_string[ $i ] = $i;
		}

		return $range_string;
	}
endif;

/**************************************************************************************/

/* Register shortcodes. */
add_action( 'init', 'ample_add_shortcodes' );
/**
 * Creates new shortcodes for use in any shortcode-ready area.  This function uses the add_shortcode()
 * function to register new shortcodes with WordPress.
 *
 * @uses add_shortcode() to create new shortcodes.
 */
function ample_add_shortcodes() {
	/* Add theme-specific shortcodes. */
	add_shortcode( 'the-year', 'ample_the_year_shortcode' );
	add_shortcode( 'site-link', 'ample_site_link_shortcode' );
	add_shortcode( 'wp-link', 'ample_wp_link_shortcode' );
	add_shortcode( 'tg-link', 'ample_themegrill_link_shortcode' );
}

/**
 * Shortcode to display the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function ample_the_year_shortcode() {
	return date( 'Y' );
}

/**
 * Shortcode to display a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function ample_site_link_shortcode() {
	return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}

/**
 * Shortcode to display a link to WordPress.org.
 *
 * @return string
 */
function ample_wp_link_shortcode() {
	return '<a href="' . esc_url( 'http://wordpress.org' ) . '" target="_blank" title="' . esc_attr__( 'WordPress', 'ample' ) . '"><span>' . __( 'WordPress', 'ample' ) . '</span></a>';
}

/**
 * Shortcode to display a link to ample.com.
 *
 * @return string
 */
function ample_themegrill_link_shortcode() {
	return '<a href="' . esc_url( 'https://themegrill.com' ) . '" target="_blank" title="' . esc_attr__( 'ThemeGrill', 'ample' ) . '" ><span>' . __( 'ThemeGrill', 'ample' ) . '</span></a>';
}

add_action( 'ample_footer_copyright', 'ample_footer_copyright', 10 );
/**
 * Function to show the footer info, copyright information
 */
if ( ! function_exists( 'ample_footer_copyright' ) ) :
	function ample_footer_copyright() {
		$default_footer_value   = ample_option( 'ample_footer_editor', __( 'Copyright &copy; ', 'ample' ) . '[the-year] [site-link] ' . __( 'Theme by: ', 'ample' ) . '[tg-link] ' . __( 'Powered by: ', 'ample' ) . '[wp-link]' );
		$ample_footer_copyright = '<div class="copyright">' . $default_footer_value . '</div>';
		echo do_shortcode( $ample_footer_copyright );
	}
endif;

/**************************************************************************************/

add_filter( 'excerpt_length', 'ample_excerpt_length' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function ample_excerpt_length( $length ) {
	$excerpt_length = ample_option( 'ample_excerpt_words', '40' );

	return $excerpt_length;
}

add_filter( 'excerpt_more', 'ample_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function ample_continue_reading() {
	return '<a class="more-link" href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"><span>' . ample_option( 'ample_read_more_text', __( 'Read more', 'ample' ) ) . '</span></a>';
}

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function ample_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
		'size' => 'medium',
	), $atts );

	$out['size'] = $atts['size'];

	return $out;
}

add_filter( 'shortcode_atts_gallery', 'ample_gallery_atts', 10, 3 );

/****************************************************************************************/

if ( ! function_exists( 'ample_sidebar_layout' ) ) :
	/**
	 * Select sidebar based on post meta and customizer default settings
	 */
	function ample_sidebar_layout() {
		global $post;

		$layout = ample_option( 'ample_default_layout', 'right_sidebar' );

		// Get Layout meta for posts
		if ( $post ) {
			$layout_meta = get_post_meta( $post->ID, 'ample_page_layout', true );
		}

		// Home page if Posts page is assigned
		if ( is_home() && ! ( is_front_page() ) ) {
			$queried_id  = get_option( 'page_for_posts' );
			$layout_meta = get_post_meta( $queried_id, 'ample_page_layout', true );

			if ( $layout_meta != 'default_layout' && $layout_meta != '' ) {
				$layout = $layout_meta;
			}
		} elseif ( is_page() ) {
			$layout = ample_option( 'ample_pages_default_layout', 'right_sidebar' );
			if ( $layout_meta != 'default_layout' && $layout_meta != '' ) {
				$layout = $layout_meta;
			}
		} elseif ( is_single() ) {
			$layout = ample_option( 'ample_single_posts_default_layout', 'right_sidebar' );
			if ( $layout_meta != 'default_layout' && $layout_meta != '' ) {
				$layout = $layout_meta;
			}
		} elseif ( function_exists( 'ample_is_in_woocommerce_page' ) && ample_is_in_woocommerce_page() ) {
			$layout = ample_option( 'ample_woocommerce_layout', 'right_sidebar' );
			if ( $layout_meta != 'default_layout' && $layout_meta != '' ) {
				$layout = $layout_meta;
			}
		}

		return $layout;
	}
endif;

/**************************************************************************************/

add_filter( 'body_class', 'ample_body_class' );
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function ample_body_class( $classes ) {
	$layout = ample_sidebar_layout();

	switch ( $layout ) {
		case 'right_sidebar' :
			$classes[] = '';
			break;
		case 'left_sidebar' :
			$classes[] = 'left-sidebar';
			break;
		case 'no_sidebar_full_width' :
			$classes[] = 'no-sidebar-full-width';
			break;
		case 'no_sidebar_content_centered' :
			$classes[] = 'no-sidebar';
			break;
		case 'both_sidebar' :
			$classes[] = 'both-sidebar';
			break;
	}

	if ( ample_option( 'ample_site_layout', 'wide' ) == 'wide' ) {
		$classes[] = 'wide';
	}

	if ( is_page_template( 'page-templates/template-business.php' ) ) {
		$classes[] = 'business-template';
	}

	if ( ample_option( 'ample_activate_sticky_menu', '0' ) == '1' ) {
		$classes[] = 'one-page-menu-active';
	}

	if ( ample_option( 'ample_new_menu_design', '0' ) == 1 ) {
		$classes[] = 'better-responsive-menu';
	}

	// For background image clickable.
	$background_image_url_link = ample_option( 'ample_background_image_link' );
	if ( $background_image_url_link ) {
		$classes[] = 'clickable-background-image';
	}

	return $classes;
}

/****************************************************************************************/

if ( ! function_exists( 'ample_both_sidebar_select' ) ) :
	/**
	 * Fucntion to select the sidebar
	 */
	function ample_both_sidebar_select() {
		$layout = ample_sidebar_layout();

		if ( $layout == 'both_sidebar' ) {
			get_sidebar( 'both' );
		}
	}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_sidebar_select' ) ) :
	/**
	 * Fucntion to select the sidebar
	 */
	function ample_sidebar_select() {
		$layout = ample_sidebar_layout();

		if ( $layout == 'right_sidebar' || $layout == 'both_sidebar' ) {
			get_sidebar();
		}
		if ( $layout == 'left_sidebar' ) {
			get_sidebar( 'left' );
		}
	}
endif;

/**************************************************************************************/

if ( ! function_exists( 'ample_meta_select' ) ) :
	/**
	 * Fucntion to select Meta
	 */
	function ample_meta_select( $clearfix = true ) {
		if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta <?php echo $clearfix ? 'clearfix' : ''; ?>">
			<span class="author vcard"><i class="fa fa-aw fa-user"></i>
				<span class="fn"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
			</span>

				<?php
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
				if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
				}
				$time_string = sprintf( $time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() ),
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date() )
				);
				printf( __( '<span class="entry-date"><i class="fa fa-aw fa-calendar-o"></i> <a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span>', 'ample' ),
					esc_url( get_permalink() ),
					esc_attr( get_the_time() ),
					$time_string
				); ?>

				<?php if ( has_category() ) { ?>
					<span class="category"><i class="fa fa-aw fa-folder-open"></i><?php the_category( ', ' ); ?></span>
				<?php } ?>

				<?php if ( comments_open() ) { ?>
					<span class="comments"><i class="fa fa-aw fa-comment"></i><?php comments_popup_link( __( 'No Comments', 'ample' ), __( '1 Comment', 'ample' ), __( '% Comments', 'ample' ), '', __( 'Comments Off', 'ample' ) ); ?></span>
				<?php } ?>
			</div>
		<?php endif;
	}
endif;

/**************************************************************************************/

add_action( 'admin_init', 'ample_textarea_sanitization_change', 100 );
/**
 * Override the default textarea sanitization.
 */
function ample_textarea_sanitization_change() {
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'ample_sanitize_textarea_custom' );
}

/**
 * sanitize the input
 */
function ample_sanitize_textarea_custom( $input ) {
	$output = wp_filter_nohtml_kses( $input );

	return $output;
}

/**************************************************************************************/

if ( ! function_exists( 'ample_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function ample_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'ample' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'ample' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<header class="comment-meta comment-author vcard">
						<?php
						echo get_avatar( $comment, 74 );
						printf( '<div class="comment-author-link"><i class="fa fa-user"></i>%1$s%2$s</div>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'ample' ) . '</span>' : ''
						);
						printf( '<div class="comment-date-time"><i class="fa fa-calendar-o"></i>%1$s</div>',
							sprintf( __( '%1$s at %2$s', 'ample' ), get_comment_date(), get_comment_time() )
						);
						printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link"></i>Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
						edit_comment_link();
						?>
					</header><!-- .comment-meta -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ample' ); ?></p>
					<?php endif; ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
						<?php comment_reply_link( array_merge( $args, array(
							'reply_text' => __( 'Reply', 'ample' ),
							'after'      => '',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						) ) ); ?>
					</section>

				</article><!-- #comment -->
				<?php
				break;
		endswitch; // end comment_type check
	}
endif;

/**************************************************************************************/

/**
 * Change hex code to RGB
 * Source: https://css-tricks.com/snippets/php/convert-hex-to-rgb/#comment-1052011
 */
function ample_hex2rgb( $hexstr ) {
	$int = hexdec( $hexstr );
	$rgb = array( "red" => 0xFF & ( $int >> 0x10 ), "green" => 0xFF & ( $int >> 0x8 ), "blue" => 0xFF & $int );
	$r   = $rgb['red'];
	$g   = $rgb['green'];
	$b   = $rgb['blue'];

	return "rgba($r,$g,$b, 0.85)";
}

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function ample_darkcolor( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( - 255, min( 255, $steps ) );

	// Normalize into a six character long hex string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Split into three parts: R, G and B
	$color_parts = str_split( $hex, 2 );
	$return      = '#';

	foreach ( $color_parts as $color ) {
		$color  = hexdec( $color ); // Convert to decimal
		$color  = max( 0, min( 255, $color + $steps ) ); // Adjust color
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $return;
}

/**************************************************************************************/

add_action( 'wp_head', 'ample_custom_css', 100 );
/**
 * Hooks the Custom Internal CSS to head section
 */
function ample_custom_css() {
	$ample_internal_css = '';
	$primary_color      = ample_option( 'ample_primary_color', '#80abc8' );
	$primary_opacity    = ample_hex2rgb( $primary_color );
	$primary_dark       = ample_darkcolor( $primary_color, - 50 );
	if ( $primary_color != '#80abc8' ) {
		$ample_internal_css = ' .comments-area .comment-author-link span,.more-link span:hover,.single-service:hover .icons,.moving-box a,.slide-next,.slide-prev,.header-post-title-container,.slider-button:hover,.ample-button,button,input[type=button],input[type=reset],input[type=submit]{background-color:' . $primary_color . '}blockquote{border-left:3px solid ' . $primary_color . '} .more-link span,.widget_team_block .team-social-icon a:hover{border:1px solid ' . $primary_color . '} .main-navigation .menu>ul>li.current_page_ancestor,.main-navigation .menu>ul>li.current_page_item,.main-navigation .menu>ul>li:hover,.main-navigation ul.menu>li.current-menu-ancestor,.main-navigation ul.menu>li.current-menu-item,.main-navigation ul.menu>li:hover{border-top:2px solid ' . $primary_color . '}a,.big-slider .entry-title a:hover,.main-navigation a:hover,.main-navigation li.menu-item-has-children:hover>a:after,.main-navigation li.page_item_has_children:hover>a:after,.main-navigation ul li ul li a:hover,.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,.main-navigation ul li.current-menu-ancestor a:after,.main-navigation ul li.current-menu-item a,.main-navigation ul li.current-menu-item a:after,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current_page_ancestor a,.main-navigation ul li.current_page_ancestor a:after,.main-navigation ul li.current_page_item a,.main-navigation ul li.current_page_item a:after,.main-navigation ul li:hover>a,.main-navigation ul li.current-menu-ancestor ul li.current-menu-item> a,.single-post-content a,.single-post-content .entry-title a:hover,.single-service i,.one-page-menu-active .main-navigation div ul li a:hover, .one-page-menu-active .main-navigation div ul li.current-one-page-menu-item a,#secondary .widget li a,#tertiary .widget li a,.fa.search-top,.widget_service_block h5 a:hover,#site-title a:hover,.hentry .entry-title a:hover,.single-header h2,.single-page p a,#comments i,.comments-area .comment-author-link a:hover,.comments-area a.comment-edit-link:hover,.comments-area a.comment-permalink:hover,.comments-area article header cite a:hover,.entry-meta .fa,.entry-meta a:hover,.nav-next a,.nav-previous a,.next a,.previous a,.comment .comment-reply-link,.widget_fun_facts .counter-icon{color:' . $primary_color . '}.services-header h2{border-bottom:4px solid ' . $primary_color . '}#colophon .copyright-info a:hover,#colophon .footer-nav ul li a:hover,#colophon a:hover,.comment .comment-reply-link:before,.comments-area article header .comment-edit-link:before,.copyright-info ul li a:hover,.footer-widgets-area a:hover,.menu-toggle:before,a#scroll-up i{color:' . $primary_color . '}.one-page-menu-active .main-navigation div ul li a:hover, .one-page-menu-active .main-navigation div ul li.current-one-page-menu-item a { color: ' . $primary_color . '; }.woocommerce #content input.button,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce-page #content input.button,.woocommerce-page #respond input#submit,.woocommerce-page a.button,.woocommerce-page button.button,.woocommerce-page input.button{color:' . $primary_color . ';border:1px solid ' . $primary_color . '}.woocommerce #content input.button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce-page #content input.button:hover,.woocommerce-page #respond input#submit:hover,.woocommerce-page a.button:hover,.woocommerce-page button.button:hover,.woocommerce-page input.button:hover,.widget_team_block .team-social-icon a:hover{background-color:' . $primary_color . '}.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt{color:' . $primary_color . '}.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.widget_team_block .bx-wrapper .bx-pager.bx-default-pager a.active,.widget_team_block .bx-wrapper .bx-pager.bx-default-pager a:hover{background-color:' . $primary_color . '}.woocommerce ul.products li.product .price,.widget_team_block .team-title a:hover{color:' . $primary_color . '}.woocommerce .woocommerce-message{border-top-color:' . $primary_color . '}.woocommerce .woocommerce-message::before,.woocommerce div.product p.price,.woocommerce div.product span.price{color:' . $primary_color . '}.ample-button:hover, input[type="reset"]:hover, input[type="button"]:hover, input[type="submit"]:hover, button:hover{background-color:' . $primary_dark . '}.single-service:hover .icons, .moving-box a,.slider-button:hover,.call-to-action-button:hover,.portfolio-button:hover{background:' . $primary_opacity . '}.single-page p a:hover,.comment .comment-reply-link:hover,.previous a:hover, .next a:hover {color:' . $primary_dark . '}.slider-button:hover,.call-to-action-button:hover,.portfolio-button:hover { border-color: ' . $primary_color . '}@media screen and (max-width: 767px){.better-responsive-menu .sub-toggle{background-color:' . $primary_dark . '}}';
	}
	// Header Title Bar Background Image
	if ( ample_option( 'ample_header_title_background_image' ) ) {
		$ample_internal_css .= ' .header-post-title-container { background-image: url("' . ample_option( 'ample_header_title_background_image' ) . '");background-size:cover; }';
	}
	// Header Section Background Image
	if ( ample_option( 'ample_header_background_image' ) ) {
		if ( ample_option( 'ample_header_background_image_full_width', '0' ) == 1 ) {
			$ample_internal_css .= ' .main-head-wrap { background-image: url("' . ample_option( 'ample_header_background_image' ) . '");background-size:cover; }';
		} else {
			$ample_internal_css .= ' .header { background-image: url("' . ample_option( 'ample_header_background_image' ) . '");background-size:cover; }';
		}
	}
	// Hide Top Border of Primary Menu
	if ( ample_option( 'ample_hide_menu_top_border' ) ) {
		$ample_internal_css .= ' .main-navigation ul.menu > li.current-menu-item, .main-navigation ul.menu > li.current-menu-ancestor, .main-navigation .menu > ul > li.current_page_item, .main-navigation .menu > ul > li.current_page_ancestor, .main-navigation ul.menu > li:hover, .main-navigation .menu > ul > li:hover { border-top: 2px solid transparent;margin-top: -2px; }';
	}
	// Google Fonts
	if ( ample_option( 'ample_site_title_font', 'Roboto+Slab:700,400' ) != 'Roboto+Slab:700,400' ) {
		$ample_internal_css .= ' #site-title a { font-family: ' . ample_option( 'ample_site_title_font', 'Roboto+Slab:700,400' ) . '; }';
	}
	if ( ample_option( 'ample_site_tagline_font', 'Roboto+Slab:700,400' ) != 'Roboto+Slab:700,400' ) {
		$ample_internal_css .= ' #site-description { font-family: ' . ample_option( 'ample_site_tagline_font', 'Roboto+Slab:700,400' ) . '; }';
	}
	if ( ample_option( 'ample_primary_menu_font', 'Roboto:400,300,100' ) != 'Roboto:400,300,100' ) {
		$ample_internal_css .= ' .main-navigation li { font-family: ' . ample_option( 'ample_primary_menu_font', 'Roboto:400,300,100' ) . '; }';
	}
	if ( ample_option( 'ample_titles_font', 'Roboto+Slab:700,400' ) != 'Roboto+Slab:700,400' ) {
		$ample_internal_css .= ' h1, h2, h3, h4, h5, h6 { font-family: ' . ample_option( 'ample_titles_font', 'Roboto+Slab:700,400' ) . '; }';
	}
	if ( ample_option( 'ample_content_font', 'Roboto:400,300,100' ) != 'Roboto:400,300,100' ) {
		$ample_internal_css .= ' body, button, input, select, textarea, p, .entry-meta, .read-more, .more-link { font-family: ' . ample_option( 'ample_content_font', 'Roboto:400,300,100' ) . '; }';
	}

	//Font size option
	$ample_fonts_size_custom = ample_font_size_func();

	foreach ( $ample_fonts_size_custom as $ample_font ) {

		$ample_font_size_setting = $ample_font['ample_font_size_setting'];
		foreach ( $ample_font_size_setting as $ample_font_size_css ) {

			if ( ample_option( $ample_font_size_css['id'], $ample_font_size_css['default'] ) != $ample_font_size_css['default'] ) {
				$ample_internal_css .= $ample_font_size_css['custom_css'] . '{ font-size: ' . ample_option( $ample_font_size_css['id'], $ample_font_size_css['default'] ) . 'px; }';
			}
		}
	} // End of Font Size Options

	// Color Options
	$ample_color_custom = ample_color_func();

	foreach ( $ample_color_custom as $ample_color ) {

		$ample_color_settings = $ample_color['ample_color_settings'];
		foreach ( $ample_color_settings as $ample_color_css ) {

			if ( ample_option( $ample_color_css['id'], $ample_color_css['default'] ) != $ample_color_css['default'] ) {
				$ample_internal_css .= $ample_color_css['color_custom_css'] . ample_option( $ample_color_css['id'], $ample_color_css['default'] ) . '; }';
				if ( array_key_exists( 'color_custom_css_two', $ample_color_css ) ) {
					$ample_internal_css .= $ample_color_css['color_custom_css_two'] . ample_option( $ample_color_css['id'], $ample_color_css['default'] ) . '; }';
				}
			}
		}
	} // End of Color Options

	if ( ! empty( $ample_internal_css ) ) {
		?>
		<style type="text/css"><?php echo $ample_internal_css; ?></style>
		<?php
	}

	$ample_custom_css = ample_option( 'ample_custom_css' );
	if ( $ample_custom_css && ! function_exists( 'wp_update_custom_css_post' ) ) {
		?>
		<style type="text/css"><?php echo $ample_custom_css; ?></style>
		<?php
	}
}

/**************************************************************************************/

/**
 * Making the theme Woocommrece compatible
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_filter( 'woocommerce_show_page_title', '__return_false' );

add_action( 'woocommerce_before_main_content', 'ample_wrapper_start', 10 );
add_action( 'woocommerce_before_main_content', 'ample_inner_wrapper_start', 15 );
add_action( 'woocommerce_after_main_content', 'ample_inner_wrapper_end', 10 );
add_action( 'woocommerce_sidebar', 'ample_wrapper_end', 20 );

function ample_wrapper_start() {
	echo '<div class="single-page"> <div class="inner-wrap">';
}

function ample_inner_wrapper_start() {
	echo '<div id="primary"><div id="content">';
}

function ample_inner_wrapper_end() {
	echo '</div>';
	ample_both_sidebar_select();
	echo '</div>';
}

function ample_wrapper_end() {
	echo '</div></div>';
}

if ( ! function_exists( 'ample_woo_related_products_limit' ) ) {

	/**
	 * WooCommerce Extra Feature
	 * --------------------------
	 *
	 * Change number of related products on product page
	 * Set your own value for 'posts_per_page'
	 *
	 */
	function ample_woo_related_products_limit() {
		global $product;
		$args = array(
			'posts_per_page' => 4,
			'columns'        => 4,
			'orderby'        => 'rand',
		);

		return $args;
	}
}
add_filter( 'woocommerce_output_related_products_args', 'ample_woo_related_products_limit' );


if ( class_exists( 'woocommerce' ) && ! function_exists( 'ample_is_in_woocommerce_page' ) ):
	/*
	 * woocommerce - conditional to check if woocommerce related page showed
	 */
	function ample_is_in_woocommerce_page() {
		return ( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) ? true : false;
	}
endif;

/**
 * Migrate any existing theme CSS codes added in Customize Options to the core option added in WordPress 4.7
 */
function ample_custom_css_migrate() {
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = ample_option( 'ample_custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $custom_css );

			if ( ! is_wp_error( $return ) ) {

				$theme_options = get_option( 'ample' );

				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				foreach ( $theme_options as $option_key => $option_value ) {
					if ( in_array( $option_key, array( 'ample_custom_css' ) ) ) {
						unset( $theme_options[ $option_key ] );
					}
				}
				// Finally, update ample theme options.
				update_option( 'ample', $theme_options );
			}
		}
	}
}

add_action( 'after_setup_theme', 'ample_custom_css_migrate' );

if ( ! function_exists( 'ample_pingback_header' ) ) :

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function ample_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

endif;

add_action( 'wp_head', 'ample_pingback_header' );

if ( ! function_exists( 'ample_the_custom_logo' ) ) {
	/**
	 * Displays the optional custom logo.
	 */
	function ample_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
}

/**
 * List of allowed social protocols in HTML attributes.
 * @ param  array $protocols Array of allowed protocols.
 * @ return array
 */
function ample_allowed_social_protocols( $protocols ) {
	$social_protocols = array(
		'skype',
	);

	return array_merge( $protocols, $social_protocols );
}

add_filter( 'kses_allowed_protocols', 'ample_allowed_social_protocols' );

if ( ! function_exists( 'ample_rlated_posts_function' ) ) {

	/**
	 * Display the related posts.
	 */
	function ample_rlated_posts_function() {
		wp_reset_postdata();
		global $post;

		// Define shared post arguments.
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'         => ample_option( 'ample_related_posts_number_display', '3' ),
		);

		// Related by categories.
		if ( ample_option( 'ample_related_posts', 'categories' ) == 'categories' ) {
			$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
			$args['category__in'] = $cats;
		}

		// Related by tags.
		if ( ample_option( 'ample_related_posts', 'categories' ) == 'tags' ) {
			$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
			$args['tag__in'] = $tags;

			// If no tags added, return.
			if ( ! $tags ) {
				$break = true;
			}
		}

		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query;

		return $query;
	}

}

/*
 * Adding the Custom Generated User Field
 */
add_action( 'show_user_profile', 'ample_extra_user_field' );
add_action( 'edit_user_profile', 'ample_extra_user_field' );

function ample_extra_user_field( $user ) {
	?>
	<h3><?php _e( 'User Social Links', 'ample' ); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="ample_twitter"><?php _e( 'Twitter', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_twitter" id="ample_twitter" value="<?php echo esc_attr( get_the_author_meta( 'ample_twitter', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="ample_facebook"><?php _e( 'Facebook', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_facebook" id="ample_facebook" value="<?php echo esc_attr( get_the_author_meta( 'ample_facebook', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="ample_google_plus"><?php _e( 'Google Plus', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_google_plus" id="ample_google_plus" value="<?php echo esc_attr( get_the_author_meta( 'ample_google_plus', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="ample_flickr"><?php _e( 'Flickr', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_flickr" id="ample_flickr" value="<?php echo esc_attr( get_the_author_meta( 'ample_flickr', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="ample_linkedin"><?php _e( 'LinkedIn', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_linkedin" id="ample_linkedin" value="<?php echo esc_attr( get_the_author_meta( 'ample_linkedin', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="ample_instagram"><?php _e( 'Instagram', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_instagram" id="ample_instagram" value="<?php echo esc_attr( get_the_author_meta( 'ample_instagram', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="ample_tumblr"><?php _e( 'Tumblr', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_tumblr" id="ample_tumblr" value="<?php echo esc_attr( get_the_author_meta( 'ample_tumblr', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th><label for="ample_youtube"><?php _e( 'Youtube', 'ample' ); ?></label></th>
			<td>
				<input type="text" name="ample_youtube" id="ample_youtube" value="<?php echo esc_attr( get_the_author_meta( 'ample_youtube', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
	</table>
	<?php
}

// Saving the user field used above
add_action( 'personal_options_update', 'ample_extra_user_field_save_option' );
add_action( 'edit_user_profile_update', 'ample_extra_user_field_save_option' );

function ample_extra_user_field_save_option( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	update_user_meta( $user_id, 'ample_twitter', wp_filter_nohtml_kses( $_POST['ample_twitter'] ) );
	update_user_meta( $user_id, 'ample_facebook', wp_filter_nohtml_kses( $_POST['ample_facebook'] ) );
	update_user_meta( $user_id, 'ample_google_plus', wp_filter_nohtml_kses( $_POST['ample_google_plus'] ) );
	update_user_meta( $user_id, 'ample_flickr', wp_filter_nohtml_kses( $_POST['ample_flickr'] ) );
	update_user_meta( $user_id, 'ample_linkedin', wp_filter_nohtml_kses( $_POST['ample_linkedin'] ) );
	update_user_meta( $user_id, 'ample_instagram', wp_filter_nohtml_kses( $_POST['ample_instagram'] ) );
	update_user_meta( $user_id, 'ample_tumblr', wp_filter_nohtml_kses( $_POST['ample_tumblr'] ) );
	update_user_meta( $user_id, 'ample_youtube', wp_filter_nohtml_kses( $_POST['ample_youtube'] ) );
}

// fucntion to show the profile field data
function ample_author_social_link() {
	?>
	<ul class="author-social-sites">
	<?php if ( get_the_author_meta( 'ample_twitter' ) ) { ?>
		<li class="twitter-link">
			<a href="https://twitter.com/<?php the_author_meta( 'ample_twitter' ); ?>"><i class="fa fa-twitter"></i></a>
		</li>
	<?php } // End check for twitter ?>
	<?php if ( get_the_author_meta( 'ample_facebook' ) ) { ?>
		<li class="facebook-link">
			<a href="https://facebook.com/<?php the_author_meta( 'ample_facebook' ); ?>"><i class="fa fa-facebook"></i></a>
		</li>
	<?php } // End check for facebook ?>
	<?php if ( get_the_author_meta( 'ample_google_plus' ) ) { ?>
		<li class="google_plus-link">
			<a href="https://plus.google.com/<?php the_author_meta( 'ample_google_plus' ); ?>"><i class="fa fa-google-plus"></i></a>
		</li>
	<?php } // End check for google_plus ?>
	<?php if ( get_the_author_meta( 'ample_flickr' ) ) { ?>
		<li class="flickr-link">
			<a href="https://flickr.com/<?php the_author_meta( 'ample_flickr' ); ?>"><i class="fa fa-flickr"></i></a>
		</li>
	<?php } // End check for flickr ?>
	<?php if ( get_the_author_meta( 'ample_linkedin' ) ) { ?>
		<li class="linkedin-link">
			<a href="https://linkedin.com/<?php the_author_meta( 'ample_linkedin' ); ?>"><i class="fa fa-linkedin"></i></a>
		</li>
	<?php } // End check for linkedin ?>
	<?php if ( get_the_author_meta( 'ample_instagram' ) ) { ?>
		<li class="instagram-link">
			<a href="https://instagram.com/<?php the_author_meta( 'ample_instagram' ); ?>"><i class="fa fa-instagram"></i></a>
		</li>
	<?php } // End check for instagram ?>
	<?php if ( get_the_author_meta( 'ample_tumblr' ) ) { ?>
		<li class="tumblr-link">
			<a href="https://tumblr.com/<?php the_author_meta( 'ample_tumblr' ); ?>"><i class="fa fa-tumblr"></i></a>
		</li>
	<?php } // End check for tumblr ?>
	<?php if ( get_the_author_meta( 'ample_youtube' ) ) { ?>
		<li class="youtube-link">
			<a href="https://youtube.com/<?php the_author_meta( 'ample_youtube' ); ?>"><i class="fa fa-youtube"></i></a>
		</li>
	<?php } // End check for youtube ?>
	</ul><?php
}

/*
 * Addition of cart icon
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'ample_woocommerce_header_add_to_cart_fragment' );

function ample_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<div class="ample-cart-views">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="wcmenucart-contents">
			<i class="fa fa-shopping-cart"></i>
			<span class="cart-value"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
		</a> <!-- quick wishlist end -->
		<div class="my-cart-wrap">
			<div class="my-cart"><?php esc_html_e( 'Total', 'ample' ); ?></div>
			<div class="cart-total"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></div>
		</div>
	</div>
	<?php

	$fragments['div.ample-cart-views'] = ob_get_clean();

	return $fragments;
}

if ( ample_option( 'ample_content_read_more_tag_display', 0 ) == 1 ) {
	add_filter( 'the_content_more_link', 'ample_remove_more_jump_link' );
}


/**
 * Removing the more link jumping to middle of content
 */
function ample_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ( $offset ) {
		$end = strpos( $link, '"', $offset );
	}
	if ( $end ) {
		$link = substr_replace( $link, '', $offset, $end - $offset );
	}

	return $link;
}
