<?php
/**
 * Amalie functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Amalie
 * @since Amalie 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Amalie 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 792;
}
if ( ! function_exists( 'amalie_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Amalie 1.0
 */
function amalie_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on amalie, use a find and replace
	 * to change 'amalie' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'amalie', get_template_directory() . '/languages' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 990, 510, true );
	// Grid Page thumbnail
	add_image_size( 'amalie-grid-image', 400, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu',      'amalie' ),
		'social'  => esc_html__( 'Social Links Menu', 'amalie' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );
	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'amalie_custom_background_args', array(
		'default-color'      => '#2b2a26',
		'default-attachment' => 'fixed',
	) ) );
	
	/*
	 * Enable support for custom logo.
	 *
	 *  @since Didi 1.0.7
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 9999,
		'width'       => 9999,
		'flex-height' => true,
	) );
	
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', amalie_fonts_url() ) );
	
	// Adding support for core block visual styles.
	add_theme_support( 'wp-block-styles' );
	
	// Add support for custom color scheme.
	add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'Green', 'amalie' ),
				'slug'  => 'strong-green',
				'color' => '#98b84c',
			),
		) );
}
endif; // amalie_setup
add_action( 'after_setup_theme', 'amalie_setup' );
/**
 * Register widget area.
 *
 * @since Amalie 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function amalie_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Widget Area', 'amalie' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'amalie' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'amalie_widgets_init' );
if ( ! function_exists( 'amalie_fonts_url' ) ) :
/**
 * Register Google fonts for amalie.
 *
 * @since Amalie 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function amalie_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';
	/* translators: If there are characters in your language that are not supported by Noto Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Noto Sans font: on or off', 'amalie' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}
	/* translators: If there are characters in your language that are not supported by Playfair Display, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Playfair Display font: on or off', 'amalie' ) ) {
		$fonts[] = 'Playfair+Display:400,700,900,400italic,700italic,900italic';
	}
	/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
	$subset = esc_html_x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'amalie' );
	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}
	return $fonts_url;
}
endif;
/**
 * Enqueue scripts and styles.
 *
 * @since Amalie 1.0
 */
function amalie_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'amalie-fonts', amalie_fonts_url(), array(), null );
	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );
	// Load our main stylesheet.
	wp_enqueue_style( 'amalie-style', get_stylesheet_uri() );
	wp_enqueue_script( 'amalie-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'amalie-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}
	wp_enqueue_script( 'amalie-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20141212', true );
	wp_localize_script( 'amalie-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'amalie' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'amalie' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'amalie_scripts' );

/**
 * Enqueue theme styles within Gutenberg.
 */
function amalie_gutenberg_styles() {

	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'amalie-gutenberg', get_theme_file_uri( '/editor.css' ), false, '1.1.1', 'all' );

	// Add custom fonts to Gutenberg.
	wp_enqueue_style( 'amalie-fonts', amalie_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'amalie_gutenberg_styles' );

if (!function_exists('amalie_admin_scripts')) {
	function amalie_admin_scripts($hook) {
		if ('appearance_page_blog' === $hook) {
			wp_enqueue_style('amalie-admin', get_template_directory_uri() . '/admin/admin.css');
		}
	}
}
add_action('admin_enqueue_scripts', 'amalie_admin_scripts');

if (is_admin()) {
	require get_template_directory() . '/admin/admin.php';
}
/**
* JavaScript Detection.
*
* Adds a `js` class to the root `<html>` element when JavaScript is detected.
*
* @since Amalie 1.0
 */
function amalie_javascript_detection() {
 	echo "<script>(function(){document.documentElement.className='js'})();</script>\n";
}
add_action( 'wp_head', 'amalie_javascript_detection', 0 );
/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Amalie 1.0
 *
 * @see wp_add_inline_style()
 */
function amalie_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';
	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}
	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}
	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}
	wp_add_inline_style( 'amalie-style', $css );
}
add_action( 'wp_enqueue_scripts', 'amalie_post_nav_background' );
/**
 * Display descriptions in main navigation.
 *
 * @since Amalie 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function amalie_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'amalie_nav_description', 10, 4 );
/**
 * Theme Update Script
 *
 * Runs if version number saved in theme_mod "version" doesn't match current theme version.
 */
function amalie_update_check() {
	
// Return if update has already been run
	if ( -1 == get_theme_mod( 'custom_logo', -1 ) ) {
		return;
	}
	
	// If we're not on 3.5 yet, exit now
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	}
	// If a logo has been set previously, update to use logo feature introduced in WordPress 4.5
	if ( function_exists( 'the_custom_logo' ) && get_theme_mod( 'amalie_logo', false ) ) {
		// Since previous logo was stored a URL, convert it to an attachment ID
		$logo = attachment_url_to_postid( get_theme_mod( 'amalie_logo' ) );
		if ( is_int( $logo ) ) {
			set_theme_mod( 'custom_logo', attachment_url_to_postid( get_theme_mod( 'amalie_logo' ) ) );
		}
		remove_theme_mod( 'amalie_logo' );
	}
}
add_action( 'after_setup_theme', 'amalie_update_check' );
/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Amalie 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function amalie_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'amalie_search_form_modify' );
/**
 * Implement the Custom Header feature.
 *
 * @since Amalie 1.0
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Custom template tags for this theme.
 *
 * @since Amalie 1.0
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Customizer additions.
 *
 * @since Amalie 1.0
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Load Jetpack compatibility file.
 *
 * @since Amalie 1.0
 */
require( get_template_directory() . '/inc/jetpack.php' );
/**
 * Remove More Jump Link.
 *
 * @since Amalie 1.2.1
 */
function remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');
/**
 * WooCommerce
 *
 * Unhook sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
/**
  * WooCommerce: change products per page
  * @return int
  */
function amalie_loop_shop_per_page() {
	return -1; //return any number, -1 === show all
};
add_filter('loop_shop_per_page', 'amalie_loop_shop_per_page', 40, 0);

/**
 * TGM Plugin Activation
 */
require get_template_directory() . '/assets/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'amalie_require_plugins' );

function amalie_require_plugins() {

	$plugins = array(
		// One Click Demo Import
		array(
			'name'      => esc_html__( 'One Click Demo Import', 'amalie' ),
			'slug'      => 'one-click-demo-import',
			'required'  => false,
		),
		// Woocommerce
		array(
			'name'      => esc_html__( 'WooCommerce', 'amalie' ),
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		// Contact Form 7
		array(
			'name'      => esc_html__( 'Contact Form 7', 'amalie' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		// Email Subscribers & Newsletter
		array(
			'name'      => esc_html__( 'Email Subscribers & Newsletter', 'amalie' ),
			'slug'      => 'email-subscribers',
			'required'  => false,
		),
		// Soliloquy Slider
		array(
			'name'      => esc_html__( 'Slider by Soliloquy', 'amalie' ),
			'slug'      => 'soliloquy-lite',
			'required'  => false,
		),

);
		$config = array(
		'id'           => 'amalie',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		);
	tgmpa( $plugins, $config );
}

/**
 * One Click Demo Import
 */
function amalie_ocdi_import_files() {
	return array(
		array(
			'import_file_name'           => esc_html__( 'Demo Import', 'amalie' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo/amalie-demo-content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/amalie-widgets.json',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo/amalie-customizer.dat',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'amalie_ocdi_import_files' );
function amalie_ocdi_after_import_setup() {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Menu 1', 'nav_menu' );
	$social_menu = get_term_by( 'name', 'Social Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'primary' => $main_menu->term_id,
		'social' => $social_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title (esc_html__( 'Front Page', 'amalie' ));
	$blog_page_id  = get_page_by_title (esc_html__( 'Blog', 'amalie' ));

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'amalie_ocdi_after_import_setup' );
function amalie_ocdi_plugin_intro_notice ( $default_text ) {
	return wp_kses_post( str_replace ( 'Before you begin, make sure all the required plugins are activated.', esc_html__( 'Before you begin, make sure all the recommended plugins are activated.', 'amalie'), $default_text ) );
}
add_filter( 'pt-ocdi/plugin_intro_text', 'amalie_ocdi_plugin_intro_notice' );