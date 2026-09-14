<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles processing of data migration & upgrade routines.
 *
 * @since 1.3.0
 */
class PUM_EIP_Upgrades {

	/**
	 * @var self
	 */
	public static $instance;

	/**
	 * Popup Maker version.
	 *
	 * @var    string
	 */
	private $version;

	/**
	 * Popup Maker version.
	 *
	 * @var    string
	 */
	private $db_version;

	/**
	 * Popup Maker upgraded from version.
	 *
	 * @var    string
	 */
	private $upgraded_from;

	/**
	 * Popup Maker initial version.
	 *
	 * @var    string
	 */
	private $initial_version;

	public static function init() {
		self::instance();
	}

	/**
	 * Gets everything going with a singleton instance.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Sets up the Upgrades class instance.
	 */
	public function __construct() {
		// Update stored plugin version info.
		$this->update_plugin_version();

		add_action( 'pum_register_upgrades', array( $this, 'register_processes' ) );
	}

	/**
	 * Update version info.
	 */
	public function update_plugin_version() {
		$this->version         = get_option( 'pum_eip_ver' );
		$this->db_version      = get_option( 'pum_eip_db_ver', false );
		$this->upgraded_from   = get_option( 'pum_eip_ver_upgraded_from' );
		$this->initial_version = get_option( 'pum_eip_initial_version' );

		/**
		 * If no version set check if a deprecated one exists.
		 */
		if ( empty( $this->version ) ) {
			$deprecated_ver = get_site_option( 'popmake_eip_version', false );
			// set to the deprecated version or last version that didn't have the version option set
			$this->version = $deprecated_ver ? $deprecated_ver : PUM_EIP::$VER; // Since we had versioning in v1 if there isn't one stored its a new install.
		}

		/**
		 * Back fill the initial version with the oldest version we can detect.
		 */
		if ( ! get_option( 'pum_eip_initial_version' ) ) {

			$oldest_known = PUM_EIP::$VER;

			if ( $this->version && version_compare( $this->version, $oldest_known, '<' ) ) {
				$oldest_known = $this->version;
			}

			if ( $this->upgraded_from && version_compare( $this->upgraded_from, $oldest_known, '<' ) ) {
				$oldest_known = $this->upgraded_from;
			}

			if ( get_site_option( 'popmake_eip_version', false ) && version_compare( 1.1, $oldest_known, '<' ) ) {
				$oldest_known = 1.1;
			}

			$this->initial_version = $oldest_known;

			// Only set this value if it doesn't exist.
			update_option( 'pum_eip_initial_version', $oldest_known );
		}

		if ( version_compare( $this->version, PUM_EIP::$VER, '<' ) ) {
			// Allow processing of small core upgrades
			do_action( 'pum_update_eip_version', $this->version );

			// Save Upgraded From option
			update_option( 'pum_eip_ver_upgraded_from', $this->version );
			update_option( 'pum_eip_ver', PUM_EIP::$VER );
			$this->upgraded_from = $this->version;
			$this->version       = PUM_EIP::$VER;

			// Reset JS/CSS assets for regeneration.
			pum_reset_assets();
		}

		if ( ! $this->db_version ) {
			// If no updated install then this is fresh, no need to do anything.
			if ( ! $this->upgraded_from ) {
				$this->db_version = 3;
			} else {
				if ( version_compare( '1.1.1', $this->upgraded_from, '>=' ) ) {
					$this->db_version = 2;
				} else {
					$this->db_version = 3;
				}
			}

			update_option( 'pum_eip_db_ver', $this->db_version );
		}
	}

	/**
	 * @param PUM_Upgrade_Registry $registry
	 */
	public function register_processes( PUM_Upgrade_Registry $registry ) {
		// v1.2 Upgrades
		$registry->add_upgrade( 'eip-v1_2-popups', array(
			'rules' => array(
				version_compare( $this->upgraded_from, '1.2', '<' ),
				version_compare( $this->initial_version, '1.2', '<' ),
			),
			'class' => 'PUM_EIP_Upgrade_v1_2_Popups',
			'file'  => PUM_EIP::$DIR . 'includes/upgrades/class-upgrade-v1_2-popups.php',
		) );
	}

}
