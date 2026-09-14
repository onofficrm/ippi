<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Implements a batch processor for migrating existing popups to new data structure.
 *
 * @since 1.3.0
 *
 * @see   PUM_Abstract_Upgrade_Popups
 */
class PUM_EIP_Upgrade_v1_2_Popups extends PUM_Abstract_Upgrade_Popups {

	/**
	 * Batch process ID.
	 *
	 * @var    string
	 */
	public $batch_id = 'eip-v1_2-popups';

	/**
	 * Only load popups with specific meta keys.r
	 *
	 * @return array
	 */
	public function custom_query_args() {
		return array(
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key'     => 'popup_exit_intent',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => 'popup_exit_intent_enabled',
					'compare' => 'EXISTS',
				),
			),
		);
	}


	/**
	 * Process needed upgrades on each popup.
	 *
	 * @param int $popup_id
	 */
	public function process_popup( $popup_id = 0 ) {

		$popup = pum_get_popup( $popup_id );

		$exit_intent = popmake_get_popup_meta( 'exit_intent', $popup->ID );

		if ( ! $exit_intent || empty( $exit_intent['enabled'] ) || ! $exit_intent['enabled'] ) {
			return;
		}

		$triggers = array();

		$cookies = array();

		$type = $exit_intent['type'];

		// Set the new cookie name.
		$cookie_name = 'popmake-exit-intent-' . $popup->ID . ( ! empty( $exit_intent['cookie_key'] ) ? '-' . $exit_intent['cookie_key'] : '' );

		// Store cookie_trigger for reuse.
		$cookie_trigger = $exit_intent['cookie_trigger'];

		// Create empty trigger cookie in case of disabled trigger.
		$trigger_cookie = null;

		// If cookie trigger not disabled create a new cookie and add it to the auto open trigger.
		if ( $cookie_trigger != 'disabled' ) {

			// Add the new cookie to the auto open trigger.
			$trigger_cookie = array( $cookie_name );

			// Set the event based on the original option.
			switch ( $cookie_trigger ) {
				case 'close':
					$event = 'on_popup_close';
					break;
				case 'open':
					$event = 'on_popup_close';
					break;
				default:
					$event = $cookie_trigger;
					break;
			}

			// Add the new cookie to the cookies array.
			$cookies[] = array(
				'event'    => $event,
				'settings' => array(
					'name'    => $cookie_name,
					'key'     => '',
					'time'    => $exit_intent['cookie_time'],
					'path'    => isset( $exit_intent['cookie_path'] ) ? 1 : 0,
					'session' => isset( $exit_intent['session_cookie'] ) ? 1 : 0,
				),
			);
		}

		if ( 'soft' == $type || 'both' == $type ) {
			// Add the new auto open trigger to the triggers array.
			$triggers[] = array(
				'type'     => 'exit_intent',
				'settings' => array(
					'top_sensitivity'   => ! empty( $exit_intent['top_sensitivity'] ) ? absint( $exit_intent['top_sensitivity'] ) : 10,
					'delay_sensitivity' => ! empty( $exit_intent['delay_sensitivity'] ) ? absint( $exit_intent['delay_sensitivity'] ) : 350,
					'cookie_name'       => $trigger_cookie,
				),
			);
		}

		if ( 'hard' == $type || 'both' == $type ) {
			$triggers[] = array(
				'type'     => 'exit_prevention',
				'settings' => array(
					'message'     => ! empty( $exit_intent['hard_message'] ) ? $exit_intent['delay'] : __( 'Please take a moment to check out a special offer just for you!', 'popup-maker-exit-intent-popups' ),
					'cookie_name' => $trigger_cookie,
				),
			);
		}

		$settings = $popup->get_settings();

		foreach ( $cookies as $cookie ) {
			$settings['cookies'][] = $cookie;
		}

		foreach ( $triggers as $trigger ) {
			$settings['triggers'][] = $trigger;
		}

		$popup->update_settings( $settings, false );
	}

	/**
	 *
	 */
	public function finish() {
		global $wpdb;

		$meta_keys = implode( "','", array(
			'popup_exit_intent',
			'popup_exit_intent_enabled',
			'popup_exit_intent_type',
			'popup_exit_intent_hard_message',
			'popup_exit_intent_cookie_trigger',
			'popup_exit_intent_cookie_time',
			'popup_exit_intent_cookie_path',
			'popup_exit_intent_cookie_key',
			'popup_exit_intent_top_sensitivity',
			'popup_exit_intent_delay_sensitivity',
			'popup_exit_intent_defaults_set',
		) );

		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key IN('$meta_keys');" );
	}
}
