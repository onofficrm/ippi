<?php

/**
 * Ample functions related to defining constants, adding files and WordPress core functionality.
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( !isset( $content_width ) ) {
    $content_width = 710;
}
/* pixels */
add_action( 'template_redirect', 'ample_content_width' );
/**
 * $content_width global variable adjustment as per layout option.
 */
function ample_content_width()
{
    global  $content_width ;
    $layout = ample_sidebar_layout();
    
    if ( $layout == 'no_sidebar_full_width' ) {
        $content_width = 1100;
        /* pixels */
    } elseif ( $layout == 'both_sidebar' ) {
        $content_width = 500;
        /* pixels */
    } else {
        $content_width = 710;
        /* pixels */
    }

}

add_action( 'after_setup_theme', 'ample_setup' );
if ( !function_exists( 'ample_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     */
    function ample_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain( 'ample', get_template_directory() . '/languages' );
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
        // Gutenberg layout support.
        add_theme_support( 'align-wide' );
        //Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );
        // Cropping the images to different sizes to be used in the theme
        add_image_size(
            'ample-featured-blog-large',
            710,
            300,
            true
        );
        add_image_size(
            'ample-featured-blog-small',
            230,
            230,
            true
        );
        add_image_size(
            'ample-portfolio-image',
            330,
            330,
            true
        );
        add_image_size(
            'ample-service-image',
            450,
            300,
            true
        );
        // Registering navigation menus.
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'ample' ),
            'footer'  => __( 'Footer Menu', 'ample' ),
        ) );
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ) );
        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'ample_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );
        // Adds the support for the Custom Logo introduced in WordPress 4.5
        add_theme_support( 'custom-logo', array(
            'flex-width'  => true,
            'flex-height' => true,
        ) );
        // Adding excerpt option box for pages as well
        add_post_type_support( 'page', 'excerpt' );
        // Added WooCommerce support.
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
        // Selective refresh widgets support
        add_theme_support( 'customize-selective-refresh-widgets' );
    }

}
// ample_setup
/**
 * Register widget area.
 *
 */
require get_template_directory() . '/inc/widgets/widgets.php';
/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/functions.php';
/**
 * Functions related to header.
 */
require get_template_directory() . '/inc/header-functions.php';
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';
/**
 * Add meta Box
 */
require get_template_directory() . '/inc/admin/meta-boxes.php';
//require get_template_directory() . '/license.php';
/**
 * Add customizer
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Detect plugin. For use on Front End only.
 */
include_once ABSPATH . 'wp-admin/includes/plugin.php';
/**
 * Load Ample Pro Demo Importer compatibility file.
 */
require get_template_directory() . '/inc/demo-importer/class-demo-importer.php';
/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require_once get_template_directory() . '/inc/jetpack.php';
}
#--------------------------------------------------------------------------------
#region Freemius
#--------------------------------------------------------------------------------
class FS_ThemeGrill
{
    /**
     * @var Freemius
     */
    private static  $fs ;
    /**
     * @return Freemius
     */
    public static function freemius()
    {
        return self::$fs;
    }
    
    private function __construct()
    {
    }
    
    /**
     * @param string $id
     * @param string $slug
     * @param string $public_key
     * @param string $name
     *
     * @return \Freemius
     */
    public static function init(
        $id,
        $slug,
        $public_key,
        $name = ''
    )
    {
        
        if ( !isset( self::$fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            self::$fs = fs_dynamic_init( array(
                'id'              => $id,
                'slug'            => $slug,
                'premium_slug'    => "{$slug}-pro",
                'type'            => 'theme',
                'public_key'      => $public_key,
                'is_premium'      => true,
                'is_premium_only' => true,
                'premium_suffix'  => 'Pro',
                'has_addons'      => false,
                'has_paid_plans'  => true,
                'menu'            => array(
                'slug'    => 'themegrill_submenu',
                'support' => false,
                'parent'  => array(
                'slug' => 'options-general.php',
            ),
            ),
                'is_live'         => true,
            ) );
            // Signal that SDK was initiated.
            do_action( "{$slug}_fs_loaded" );
            require_once dirname( __FILE__ ) . '/inc/freemius-migration.php';
            if ( empty($name) ) {
                $name = ucwords( str_replace( '-', ' ', $slug ) );
            }
            new FS_ThemeGrill_License_Menu( $name, $slug );
            new FS_ThemeGrill_License_Migration( self::$fs, "api_manager_theme_{$slug}", $slug );
        }
        
        return self::$fs;
    }

}
FS_ThemeGrill::init(
    '4213',
    'ample',
    'pk_8cdee14ea6e7fc9263af2ec1a0014',
    'Ample'
);
#endregion