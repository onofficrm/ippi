<?php
/**
 * Functions for configuring demo importer.
 *
 * @package Importer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Setup demo importer config.
 *
 * @deprecated 1.5.0
 *
 * @param  array $demo_config Demo config.
 *
 * @return array
 */
function ample_demo_importer_config( $demo_config ) {
	$new_demo_config = array(
		/**
		 * Ample Pro demos
		 */
		'ample-pro' => array(
			'name'                   => __( 'Ample Pro', 'ample' ),
			'demo_url'               => 'https://demo.themegrill.com/ample-pro/',
			'demo_pack'              => false,
			'theme'                  => 'Ample Pro',
			'template'               => 'ample-pro',
			'core_options'           => array(
				'blogname'       => 'Ample Pro',
				'page_on_front'  => 'Business page',
				'page_for_posts' => 'Blog',
			),
			'widgets_data_update'    => array(

				/**
				 * Dropdown Pages - Handles widgets Page ID.
				 *
				 * 1. ample_service_widget
				 * 2. ample_team_widget
				 */
				'dropdown_pages'      => array(
					'ample_service_widget' => array(
						2 => array(
							'page_id1' => 'Rich Features',
							'page_id3' => 'Exclusive Support',
							'page_id5' => 'Fully Responsive',
						),
					),
					'ample_team_widget'    => array(
						3 => array(
							'page_0' => 'Brandon Reed',
							'page_1' => 'Amanda Hayes',
							'page_2' => 'Shirley King',
						),
					),
				),

				/**
				 * Dropdown Categories - Handles widgets Category ID.
				 *
				 * A. Core Post Category:
				 *    1. ample_featured_posts_widget
				 *    2. ample_portfolio_widget
				 *
				 * Note: Supported Taxonomy:
				 *    A. Core Post Category - category
				 */
				'dropdown_categories' => array(
					'category' => array(
						'ample_featured_posts_widget' => array(
							2 => array(
								'category' => 'Featured',
							),
						),
						'ample_portfolio_widget'      => array(
							2 => array(
								'category' => 'Portfolio',
							),
						),
					),
				),
			),
			'customizer_data_update' => array(
				'nav_menu_locations' => array(
					'primary' => 'Menu',
					'footer'  => 'Footer Menu',
				),
			),
			'plugins_list'           => array(
				'required'    => array(
					'everest-forms' => array(
						'name' => __( 'Everest Forms – Easy Contact Form and Form Builder', 'ample' ),
						'slug' => 'everest-forms/everest-forms.php',
					),
				),
				'recommended' => array(
					'breadcrumb-navxt' => array(
						'name' => __( 'Breadcrumb NavXT', 'ample' ),
						'slug' => 'breadcrumb-navxt/breadcrumb-navxt.php',
					),
					'woocommerce'      => array(
						'name' => __( 'WooCommerce', 'ample' ),
						'slug' => 'woocommerce/woocommerce.php',
					),
				),
			),
		),

		'ample-pro-one-page' => array(
			'name'                   => __( 'Ample Pro One Page', 'ample' ),
			'demo_url'               => 'https://demo.themegrill.com/ample-pro-one-page/',
			'demo_pack'              => false,
			'theme'                  => 'Ample Pro',
			'template'               => 'ample-pro',
			'core_options'           => array(
				'blogname'      => 'Ample Pro One Page',
				'page_on_front' => 'Parallax',
			),
			'widgets_data_update'    => array(

				/**
				 * Dropdown Pages - Handles widgets Page ID.
				 *
				 * 1. ample_service_widget
				 * 2. ample_team_widget
				 */
				'dropdown_pages'      => array(
					'ample_service_widget' => array(
						2 => array(
							'page_id1' => 'One Click Demo',
							'page_id3' => 'Truly Responsive',
							'page_id5' => 'MultiPurpose Theme',
						),
					),
					'ample_team_widget'    => array(
						3 => array(
							'page_0' => 'Amanda Hayes',
							'page_1' => 'Brandon Reed',
							'page_2' => 'Shirley King',
						),
					),
				),

				/**
				 * Dropdown Categories - Handles widgets Category ID.
				 *
				 * A. Core Post Category:
				 *    1. ample_featured_posts_widget
				 *    2. ample_portfolio_widget
				 *
				 * Note: Supported Taxonomy:
				 *    A. Core Post Category - category
				 */
				'dropdown_categories' => array(
					'category' => array(
						'ample_featured_posts_widget' => array(
							2 => array(
								'category' => 'News',
							),
						),
						'ample_portfolio_widget'      => array(
							2 => array(
								'category' => 'Portfolio',
							),
						),
					),
				),
			),
			'customizer_data_update' => array(
				'nav_menu_locations' => array(
					'primary' => 'One Page',
				),
			),
			'plugins_list'           => array(
				'required' => array(
					'everest-forms' => array(
						'name' => __( 'Everest Forms – Easy Contact Form and Form Builder', 'ample' ),
						'slug' => 'everest-forms/everest-forms.php',
					),
				),
			),

		),

		/**
		 * Ample Free demos
		 */
		'ample-free'         => array(
			'name'                   => __( 'Ample Free', 'ample' ),
			'demo_url'               => 'https://demo.themegrill.com/ample/',
			'demo_pack'              => false,
			'theme'                  => 'Ample Pro',
			'template'               => 'ample-pro',
			'core_options'           => array(
				'blogname'       => 'Ample',
				'page_on_front'  => 'Business',
				'page_for_posts' => 'Blog',
			),
			'widgets_data_update'    => array(

				/**
				 * Dropdown Categories - Handles widgets Category ID.
				 *
				 *   1. ample_portfolio_widget
				 *
				 */
				'dropdown_categories' => array(
					'category' => array(
						'ample_portfolio_widget' => array(
							3 => array(
								'category' => 'Portfolio',
							),
						),
					),
				),

				/**
				 * Dropdown Pages - Handles widgets Page ID.
				 *
				 * 1. ample_service_widget
				 */
				'dropdown_pages'      => array(
					'ample_service_widget' => array(
						2 => array(
							'page_id1' => 'Active Support',
							'page_id3' => 'Responsive Design',
							'page_id5' => 'Robust Features',
						),
					),
				),
			),
			'customizer_data_update' => array(
				'nav_menu_locations' => array(
					'primary' => 'Primary',
					'footer'  => 'Footer',
				),
			),
			'plugins_list'           => array(
				'required'    => array(
					'everest-forms' => array(
						'name' => __( 'Everest Forms – Easy Contact Form and Form Builder', 'ample' ),
						'slug' => 'everest-forms/everest-forms.php',
					),
				),
				'recommended' => array(
					'woocommerce'        => array(
						'name'     => 'WooCommerce',
						'slug'     => 'woocommerce/woocommerce.php',
						'required' => false,
					),
					'breadcrumb-navxt'   => array(
						'name'     => 'Breadcrumb NavXT',
						'slug'     => 'breadcrumb-navxt/breadcrumb-navxt.php',
						'required' => false,
					),
					'google-maps-widget' => array(
						'name'     => 'Google Maps Widget',
						'slug'     => 'google-maps-widget/google-maps-widget.php',
						'required' => false,
					),
				),
			),
		),
	);

	return array_merge( $new_demo_config, $demo_config );
}

add_filter( 'themegrill_demo_importer_config', 'ample_demo_importer_config' );

/**
 * Set categories checkbox to hide from blog page settings in theme customizer.
 *
 * Note: Used rarely, if `ample_option` keys are based on term ID.
 *
 * @param  array  $data
 * @param  array  $demo_data
 * @param  string $demo_id
 *
 * @return array
 */
function ample_set_cat_hide( $data, $demo_data, $demo_id ) {
	// Format the data based on demo ID.
	switch ( $demo_id ) {
		case 'ample-pro':
			$wp_categories = array(
				2 => 'Portfolio',
			);
			break;

		case 'ample-pro-one-page':
			$wp_categories = array(
				1 => 'Uncategorized',
			);
			break;

		case 'ample-free':
			$wp_categories = array(
				5 => 'Portfolio',
			);
			break;
	}

	// Fetch categories selected and assign it to new category generated on demo import.
	foreach ( $wp_categories as $term_id => $term_name ) {
		if ( ! empty( $data['options']['ample[ample_hide_category]'] ) ) {
			$term = get_term_by( 'name', $term_name, 'category' );
			if ( is_object( $term ) && $term->term_id ) {
				$data['options']['ample[ample_hide_category]'] = $term->term_id;
			}
		}
	}

	return $data;
}

add_filter( 'themegrill_customizer_demo_import_settings', 'ample_set_cat_hide', 20, 3 );
