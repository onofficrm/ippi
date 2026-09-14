<?php
/*******************************************************************************
 * Copyright (c) 2017, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_EIP_Triggers
 */
class PUM_EIP_Triggers {

	/**
	 *
	 */
	public static function init() {
		add_filter( 'pum_registered_triggers', array( __CLASS__, 'register_triggers' ) );
	}

	/**
	 * @param array $triggers
	 *
	 * @return array
	 */
	public static function register_triggers( $triggers = array() ) {

		$icons = array(
			'desktop' => '<span class="dashicons dashicons-desktop" style="font-size: 16px;"></span>',
			'laptop'  => '<span class="dashicons dashicons-laptop" style="font-size: 16px;"></span>',
			'tablet'  => '<span class="dashicons dashicons-tablet" style="font-size: 16px;"></span>',
			'mobile'  => '<span class="dashicons dashicons-smartphone" style="font-size: 16px;"></span>',
		);

		return array_merge( $triggers, array(
			'exit_intent'     => array(
				'name'        => __( 'Exit Intent', 'popup-maker-exit-intent-popups' ),
				'modal_title' => sprintf( __( '%s Settings', 'popup-maker-exit-intent-popups' ), __( 'Exit Intent', 'popup-maker-exit-intent-popups' ) ),
				//'settings_column' => sprintf( '<strong>%1$s</strong>: %2$s', __( 'Methods', 'popup-maker-exit-intent-popups' ), '{{data.top_sensitivity}}', __( 'Delay', 'popup-maker-exit-intent-popups' ), '{{data.delay_sensitivity}}' ),
				'fields'      => array(
					'general'  => array(
						'methods' => array(
							'label'   => __( 'Methods', 'popup-maker-exit-intent-popups' ),
							'type'    => 'multicheck',
							'options' => array(
								'mouseleave'   => __( 'Mouse Leave', 'popup-maker-exit-intent-popups' ) . ' ' . $icons['desktop'],
								'lostfocus'    => __( 'Lost Browser Focus', 'popup-maker-exit-intent-popups' ) . ' ' . $icons['desktop'] . $icons['mobile'],
								'backbutton'   => __( 'Back Button', 'popup-maker-exit-intent-popups' ) . ' ' . $icons['desktop'] . $icons['mobile'],
								'linkclick'    => __( 'Link Click', 'popup-maker-exit-intent-popups' ) . ' ' . $icons['desktop'] . $icons['mobile'],
								'mobiletime'   => __( 'Time Delay', 'popup-maker-exit-intent-popups' ) . ' ' . $icons['mobile'],
								'mobilescroll' => __( 'Mobile Scroll', 'popup-maker-exit-intent-popups' ) . ' ' . $icons['mobile'],
							),
							'doclink' => 'https://docs.wppopupmaker.com/article/517-trigger-exit-intent---methods',
							'std'     => array( 'mouseleave', 'lostfocus' ),
						),
					),
					'advanced' => array(
						'advanced_heading'           => array(
							'type' => 'heading',
							'desc' => __( 'Advanced Options', 'popup-maker-exit-intent-popups' ),
						),
						'advanced_desc'              => array(
							'type'    => 'html',
							'content' => '<p>' . __( 'Additional advanced settings for the various available methods.', 'popup-maker-exit-intent-popups' ) . '</p>',
						),
						'mouseleave_options'         => array(
							'desc'         => __( 'Mouse Leave Options', 'popup-maker-exit-intent-popups' ),
							'type'         => 'separator',
							'dependencies' => array(
								'methods' => 'mouseleave',
							),
						),
						'top_sensitivity'            => array(
							'label'        => __( 'Top Sensitivity', 'popup-maker-exit-intent-popups' ),
							'desc'         => __( 'The distance from the top of the browser window where the users mouse movement is detected.', 'popup-maker-exit-intent-popups' ),
							'type'         => 'rangeslider',
							'std'          => 10,
							'step'         => 1,
							'min'          => 1,
							'max'          => 50,
							'unit'         => __( 'px', 'popup-maker' ),
							'dependencies' => array(
								'methods' => 'mouseleave',
							),
						),
						'delay_sensitivity'          => array(
							'label'        => __( 'False Positive Delay', 'popup-maker-exit-intent-popups' ),
							'desc'         => __( 'The delay used for false positive detection. A higher value reduces false positives, but increases chances of not opening in time.', 'popup-maker-exit-intent-popups' ),
							'type'         => 'rangeslider',
							'std'          => 350,
							'step'         => 25,
							'min'          => 100,
							'max'          => 750,
							'unit'         => __( 'ms', 'popup-maker' ),
							'dependencies' => array(
								'methods' => 'mouseleave',
							),
						),
						'backbutton_options'         => array(
							'desc'         => __( 'Back Button Options', 'popup-maker-exit-intent-popups' ),
							'type'         => 'separator',
							'dependencies' => array(
								'methods' => 'backbutton',
							),
						),
						'continue_back_on_close'     => array(
							'label'        => __( 'Continue on close', 'popup-maker-exit-intent-popups' ),
							'desc'         => __( 'If enabled will continue to the users intended destination (back) after closing the popup.', 'popup-maker-exit-intent-popups' ),
							'type'         => 'checkbox',
							'dependencies' => array(
								'methods' => 'backbutton',
							),
						),
						'linkclick_options'          => array(
							'desc'         => __( 'Link Click Options', 'popup-maker-exit-intent-popups' ),
							'type'         => 'separator',
							'dependencies' => array(
								'methods' => 'linkclick',
							),
						),
						'linkclick_targeting'        => array(
							'label'        => __( 'Targeting', 'popup-maker-exit-intent-popups' ),
							'type'         => 'multicheck',
							'options'      => array(
								'external' => __( 'External Links', 'popup-maker-exit-intent-popups' ),
								'internal' => __( 'Internal Links', 'popup-maker-exit-intent-popups' ),
								'custom'   => __( 'Custom', 'popup-maker-exit-intent-popups' ),
							),
							'std'          => array( 'mouseleave' ),
							'dependencies' => array(
								'methods' => 'linkclick',
							),
						),
						'linkclick_custom_targeting' => array(
							'label'        => __( 'Enter a valid CSS selector to target your specific links.', 'popup-maker-exit-intent-popups' ),
							'type'         => 'text',
							'dependencies' => array(
								'methods'             => 'linkclick',
								'linkclick_targeting' => 'custom',
							),
						),
						'link_hover_delay'           => array(
							'label'        => __( 'Delay after hovering a link', 'popup-maker-exit-intent-popups' ),
							'desc'         => __( 'Studies show if users hover a link longer than 300ms there is a 50% change they are going to click it.', 'popup-maker-exit-intent-popups' ),
							'type'         => 'rangeslider',
							'std'          => 300,
							'step'         => 25,
							'min'          => 100,
							'max'          => 750,
							'unit'         => __( 'ms', 'popup-maker' ),
							'dependencies' => array(
								'methods' => 'linkclick',
							),
						),
						'mobiletime_options'         => array(
							'desc'         => __( 'Mobile Time Delay Options', 'popup-maker-exit-intent-popups' ),
							'type'         => 'separator',
							'dependencies' => array(
								'methods' => 'mobiletime',
							),
						),
						'mobile_time_delay'          => array(
							'label'        => __( 'Mobile device time delay', 'popup-maker-exit-intent-popups' ),
							'type'         => 'rangeslider',
							'std'          => 500,
							'step'         => 25,
							'min'          => 100,
							'max'          => 750,
							'unit'         => __( 'ms', 'popup-maker' ),
							'dependencies' => array(
								'methods' => 'mobiletime',
							),
						),
						'mobilescroll_options'       => array(
							'desc'         => __( 'Mobile Scroll Options', 'popup-maker-exit-intent-popups' ),
							'type'         => 'separator',
							'dependencies' => array(
								'methods' => 'mobilescroll',
							),
						),
						'mobilescroll_up_percent'    => array(
							'label'        => __( 'Mobile scroll up percentage', 'popup-maker-exit-intent-popups' ),
							'type'         => 'rangeslider',
							'std'          => 10,
							'step'         => 1,
							'min'          => 0,
							'max'          => 100,
							'unit'         => __( '%', 'popup-maker' ),
							'dependencies' => array(
								'methods' => 'mobilescroll',
							),
						),
					),
				),
			),
			'exit_prevention' => array(
				'name'            => __( 'Exit Prevention', 'popup-maker-exit-intent-popups' ),
				'modal_title'     => __( 'Exit Prevention Settings', 'popup-maker-exit-intent-popups' ),
				'settings_column' => sprintf( '<strong>%1$s</strong>: %2$s', __( 'Message', 'popup-maker-exit-intent-popups' ), '{{data.message}}' ),
				'fields'          => array(
					'general' => array(
						'message' => array(
							'label' => __( 'Prompt Message', 'popup-maker-exit-intent-popups' ),
							'desc'  => __( 'Due to changes in modern browser security it is no longer possible to change the prompt message.', 'popup-maker-exit-intent-popups' ),
							'type'  => 'html',
						),

					),
				),
			),
		) );
	}
}
