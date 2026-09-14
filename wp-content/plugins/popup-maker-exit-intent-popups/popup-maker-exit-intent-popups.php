<?php
/**
 * Plugin Name:  Popup Maker - Exit Intent Popups
 * Plugin URI:   https://wppopupmaker.com/extensions/exit-intent-popups/
 * Description:
 * Version:      1.4.0
 * Author:       WP Popup Maker
 * Author URI:   https://wppopupmaker.com/
 * Text Domain:  popup-maker-exit-intent-popups
 *
 * @author       WP Popup Maker
 * @copyright    Copyright (c) 2018, WP Popup Maker
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param array $autoloaders
 *
 * @return array
 */
function pum_eip_autoloader( $autoloaders = array() ) {
	return array_merge( $autoloaders, array(
		array(
			'prefix' => 'PUM_EIP_',
			'dir'    => dirname( __FILE__ ) . '/classes/',
		),
	) );
}

add_filter( 'pum_autoloaders', 'pum_eip_autoloader' );


/**
 * Class PUM_EIP
 */
class PUM_EIP {

	/**
	 * @var int $download_id for EDD.
	 */
	public static $ID = 25;

	/**
	 * @var string
	 */
	public static $NAME = 'Exit Intent Popups';

	/**
	 * @var string Plugin Version
	 */
	public static $VER = '1.4.0';

	/**
	 * @var string Required Version of Popup Maker
	 */
	public static $REQUIRED_CORE_VER = '1.7.29';

	/**
	 * @var int DB Version
	 */
	public static $DB_VER = 3;

	/**
	 * @var string Plugin Directory
	 */
	public static $DIR;

	/**
	 * @var string Plugin URL
	 */
	public static $URL;

	/**
	 * @var string Plugin FILE
	 */
	public static $FILE;

	/**
	 * @var self $instance
	 */
	private static $instance;

	/**
	 * @return self
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
			self::$instance->setup_constants();
			self::$instance->load_textdomain();
			self::$instance->includes();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Set up plugin constants.
	 */
	public function setup_constants() {
		self::$DIR  = plugin_dir_path( __FILE__ );
		self::$URL  = plugins_url( '/', __FILE__ );
		self::$FILE = __FILE__;
	}

	/**
	 * Internationalization
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'popup-maker-exit-intent-popups', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Include required files
	 */
	private function includes() {
	}

	/**
	 * Initialize the plugin.
	 */
	private function init() {
		// Get things running.
		PUM_EIP_Site::init();
		PUM_EIP_Triggers::init();
		PUM_EIP_Upgrades::init();
	}
}

/**
 * Get the ball rolling.
 */
function pum_eip_init() {
	if ( ! class_exists( 'PUM_Extension_Activator' ) ) {
		require_once 'includes/pum-sdk/class-pum-extension-activator.php';
	}

	$activator = new PUM_Extension_Activator( 'PUM_EIP' );
	$activator->run();
}

add_action( 'plugins_loaded', 'pum_eip_init', 11 );

if ( ! class_exists( 'PUM_EIP_Activator' ) ) {
	require_once 'classes/Activator.php';
}
register_activation_hook( __FILE__, 'PUM_EIP_Activator::activate' );

if ( ! class_exists( 'PUM_EIP_Deactivator' ) ) {
	require_once 'classes/Deactivator.php';
}
register_deactivation_hook( __FILE__, 'PUM_EIP_Deactivator::deactivate' );
