<?php
/**
 * Ample Pro Theme Customizer
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0.3
 */

function ample_customize_register( $wp_customize ) {

	require get_template_directory() . '/inc/customize-controls/class-ample-controls-multicheck-control.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-custom-css-control.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-custom-information.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-editor-control.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-image-radio-control.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-important-links.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-typography-control.php';

	// Transport postMessage variable set
	$customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '#site-title a',
			'render_callback' => 'ample_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '#site-description',
			'render_callback' => 'ample_customize_partial_blogdescription',
		) );
	}

// Header Options Area
	$wp_customize->add_panel( 'ample_header', array(
		'title'      => __( 'Header', 'ample' ),
		'capabitity' => 'edit_theme_options',
		'priority'   => 300,
	) );

// Header logo and text display type option
	$wp_customize->add_section( 'ample_header_logo_text', array(
		'title'    => __( 'Show', 'ample' ),
		'priority' => 20,
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_show_header_logo_text]', array(
		'default'           => 'text_only',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_show_header_logo_text]', array(
		'type'    => 'radio',
		'label'   => __( 'Choose the option that you want.', 'ample' ),
		'section' => 'title_tagline',
		'choices' => array(
			'logo_only' => __( 'Header Logo Only', 'ample' ),
			'text_only' => __( 'Header Text Only', 'ample' ),
			'both'      => __( 'Show Both', 'ample' ),
			'none'      => __( 'Disable', 'ample' ),
		),
	) );

// Header Top bar activate option
	$wp_customize->add_section( 'ample_activate_top_header_bar_setting', array(
		'priority' => 22,
		'title'    => __( 'Activate Header Top Bar', 'ample' ),
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_activate_top_header_bar]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_activate_top_header_bar]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to show top header bar. The top header bar includes Social icons area and Small text area.', 'ample' ),
		'section' => 'ample_activate_top_header_bar_setting',
	) );

// Selective refresh for top header bar
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'ample[ample_activate_top_header_bar]', array(
			'selector'        => '#header-meta',
			'render_callback' => '',
		) );
	}

// Header area small text option
	$wp_customize->add_section( 'ample_header_info_text_setting', array(
		'priority' => 24,
		'title'    => __( 'Header Info Text', 'ample' ),
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_header_info_text]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'transport'         => $customizer_selective_refresh,
		'sanitize_callback' => 'ample_editor_sanitize',
	) );
	$wp_customize->add_control(
		new AMPLE_Editor_Control( $wp_customize, 'ample[ample_header_info_text]', array(
			'label'   => __( 'You can add phone numbers, other contact info here as you like. This box also accepts shortcodes.', 'ample' ),
			'section' => 'ample_header_info_text_setting',
			'setting' => 'ample[ample_header_info_text]',
		) )
	);

// Selective refresh for footer copyright information
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'ample[ample_header_info_text]', array(
			'selector'        => '.small-info-text',
			'render_callback' => 'ample_header_info_text',
		) );
	}

// Header Title Bar Background Image upload option
	$wp_customize->add_section( 'ample_header_title_bar', array(
		'title'    => __( 'Header Title Bar Background Image', 'ample' ),
		'priority' => 30,
		'panel'    => 'ample_header',
	) );
	$wp_customize->add_setting( 'ample[ample_header_title_background_image]', array(
		'default'              => '',
		'capability'           => 'edit_theme_options',
		'type'                 => 'option',
		'sanitize_callback'    => 'ample_sanitize_url',
		'sanitize_js_callback' => 'ample_sanitize_js_url',
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize, 'ample[ample_header_title_background_image]', array(
			'label'    => __( 'Upload Background Image for Header Title Bar.', 'ample' ),
			'section'  => 'ample_header_title_bar',
			'settings' => 'ample[ample_header_title_background_image]',
		) )
	);

// Header Image Position
	$wp_customize->add_section( 'ample_header_image_position_setting', array(
		'title'    => __( 'Header Image Position', 'ample' ),
		'priority' => 40,
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_header_image_position]', array(
		'default'           => 'above',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_header_image_position]', array(
		'type'    => 'radio',
		'label'   => __( 'Choose top header image display position.', 'ample' ),
		'section' => 'ample_header_image_position_setting',
		'choices' => array(
			'above' => __( 'Position Above (Default): Display the Header image just above the site title and main menu part.', 'ample' ),
			'below' => __( 'Position Below: Display the Header image just below the site title and main menu part.', 'ample' ),
		),
	) );

// Header Background Image upload option
	$wp_customize->add_section( 'ample_header_background_image_setting', array(
		'title'    => __( 'Header Background Image', 'ample' ),
		'priority' => 50,
		'panel'    => 'ample_header',
	) );
	$wp_customize->add_setting( 'ample[ample_header_background_image]', array(
		'default'              => '',
		'capability'           => 'edit_theme_options',
		'type'                 => 'option',
		'sanitize_callback'    => 'ample_sanitize_url',
		'sanitize_js_callback' => 'ample_sanitize_js_url',
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize, 'ample[ample_header_background_image]', array(
			'label'    => __( 'Header contain Logo, Site Title, Tagline and Menu.', 'ample' ),
			'section'  => 'ample_header_background_image_setting',
			'settings' => 'ample[ample_header_background_image]',
		) )
	);

	$wp_customize->add_setting( 'ample[ample_header_background_image_full_width]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_header_background_image_full_width]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to display header background image inside inner-wrap ', 'ample' ),
		'section' => 'ample_header_background_image_setting',
	) );

// Header Background Image upload option
	$wp_customize->add_section( 'ample_header_search_icon_setting', array(
		'title'    => esc_html__( 'Dispaly Search Icon To Main Menu', 'ample' ),
		'priority' => 60,
		'panel'    => 'ample_header',
	) );
	$wp_customize->add_setting( 'ample[ample_header_display_search_icon]', array(
		'default'           => 1,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_header_display_search_icon]', array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Check to enable a search icon in main manu that allow user to perform Search.', 'ample' ),
		'section' => 'ample_header_search_icon_setting',
	) );

//Responsive menu options
	$wp_customize->add_section( 'ample_responsive_menu_section', array(
		'priority' => 55,
		'title'    => esc_html__( 'Responsive Menu Style', 'ample' ),
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_new_menu_design]', array(
		'default'           => '0',
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_new_menu_design]', array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Switch to new responsive menu', 'ample' ),
		'section' => 'ample_responsive_menu_section',
		'setting' => 'ample[ample_new_menu_design]',
	) );

// Header Image link.
	$wp_customize->add_setting( 'ample[ample_header_image_link]', array(
		'default'           => 0,
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_header_image_link]', array(
		'label'   => esc_html__( 'Check to enable Home link in Header Image.', 'ample' ),
		'section' => 'header_image',
		'setting' => 'ample[ample_header_image_link]',
		'type'    => 'checkbox',
	) );

// Custom header link.
	$wp_customize->add_setting( 'ample[ample_header_link_to_url]', array(
		'default'           => '',
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'ample[ample_header_link_to_url]', array(
		'label'   => esc_html__( 'Custom link to Header Image.', 'ample' ),
		'section' => 'header_image',
		'setting' => 'ample[ample_header_link_to_url]',
	) );

	if ( class_exists( 'woocommerce' ) ) {
		// To display cart icon.
		$wp_customize->add_section( 'ample_cart_icon_option', array(
			'title'    => esc_html__( 'Cart Icon', 'ample' ),
			'priority' => 60,
			'panel'    => 'ample_header',
		) );

		$wp_customize->add_setting( 'ample[ample_cart_icon_setting]', array(
			'default'           => 0,
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'ample_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'ample[ample_cart_icon_setting]', array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Check to enable cart icon', 'ample' ),
			'section' => 'ample_cart_icon_option',
			'setting' => 'ample[ample_cart_icon_setting]',
		) );
	}
// End of the Header Options

	/**************************************************************************************/

// Design Options Area
	$wp_customize->add_panel( 'ample_design_options', array(
		'title'      => __( 'Design', 'ample' ),
		'capabitity' => 'edit_theme_options',
		'priority'   => 310,
	) );

// Site Layout
	$wp_customize->add_section( 'ample_site_layout_setting', array(
		'title'    => __( 'Site Layout', 'ample' ),
		'priority' => 10,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_site_layout]', array(
		'default'           => 'wide',
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );

	$wp_customize->add_control( 'ample[ample_site_layout]', array(
		'type'    => 'radio',
		'label'   => __( 'Choose your site layout. The change is reflected in whole site.', 'ample' ),
		'section' => 'ample_site_layout_setting',
		'choices' => array(
			'wide' => __( 'Wide layout', 'ample' ),
			'box'  => __( 'Boxed layout', 'ample' ),
		),
	) );

// Default layout
	$wp_customize->add_section( 'ample_default_layout_setting', array(
		'title'    => __( 'Default layout', 'ample' ),
		'priority' => 20,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_default_layout]', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control(
		new AMPLE_Image_Radio_Control( $wp_customize, 'ample[ample_default_layout]', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout. This layout will be reflected in whole site archives, search etc. The layout for a single post and page can be controlled from below options.', 'ample' ),
			'section' => 'ample_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => get_template_directory_uri() . '/inc/admin/images/right-sidebar.png',
				'left_sidebar'                => get_template_directory_uri() . '/inc/admin/images/left-sidebar.png',
				'no_sidebar_full_width'       => get_template_directory_uri() . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => get_template_directory_uri() . '/inc/admin/images/no-sidebar-content-centered-layout.png',
				'both_sidebar'                => get_template_directory_uri() . '/inc/admin/images/both-sidebar.png',
			),
		) )
	);

// Default layout for pages only
	$wp_customize->add_section( 'ample_pages_default_layout_setting', array(
		'title'    => __( 'Default layout for pages only', 'ample' ),
		'priority' => 30,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_pages_default_layout]', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control(
		new AMPLE_Image_Radio_Control( $wp_customize, 'ample[ample_pages_default_layout]', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page.', 'ample' ),
			'section' => 'ample_pages_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => get_template_directory_uri() . '/inc/admin/images/right-sidebar.png',
				'left_sidebar'                => get_template_directory_uri() . '/inc/admin/images/left-sidebar.png',
				'no_sidebar_full_width'       => get_template_directory_uri() . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => get_template_directory_uri() . '/inc/admin/images/no-sidebar-content-centered-layout.png',
				'both_sidebar'                => get_template_directory_uri() . '/inc/admin/images/both-sidebar.png',
			),
		) )
	);

// Default layout for single posts only
	$wp_customize->add_section( 'ample_single_posts_default_layout_setting', array(
		'title'    => __( 'Default layout for single posts only', 'ample' ),
		'priority' => 40,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_single_posts_default_layout]', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control(
		new AMPLE_Image_Radio_Control( $wp_customize, 'ample[ample_single_posts_default_layout]', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post.', 'ample' ),
			'section' => 'ample_single_posts_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => get_template_directory_uri() . '/inc/admin/images/right-sidebar.png',
				'left_sidebar'                => get_template_directory_uri() . '/inc/admin/images/left-sidebar.png',
				'no_sidebar_full_width'       => get_template_directory_uri() . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => get_template_directory_uri() . '/inc/admin/images/no-sidebar-content-centered-layout.png',
				'both_sidebar'                => get_template_directory_uri() . '/inc/admin/images/both-sidebar.png',
			),
		) )
	);

	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {

		$wp_customize->add_section( 'ample_custom_css_setting', array(
			'priority' => 60,
			'title'    => __( 'Custom CSS', 'ample' ),
			'panel'    => 'ample_design_options',
		) );

		$wp_customize->add_setting( 'ample[ample_custom_css]', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'type'                 => 'option',
			'sanitize_callback'    => 'ample_sanitize_escaping',
			'sanitize_js_callback' => 'ample_sanitize_escaping',
		) );
		$wp_customize->add_control(
			new AMPLE_Custom_CSS_Control( $wp_customize, 'ample[ample_custom_css]', array(
				'label'    => __( 'Write your custom css.', 'ample' ),
				'section'  => 'ample_custom_css_setting',
				'settings' => 'ample[ample_custom_css]',
			) )
		);
	}
// End of the Design Options

	/**************************************************************************************/

	/* Social Link Area */
	$wp_customize->add_panel( 'ample_social_link_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 315,
		'title'      => __( 'Social Links', 'ample' ),
	) );

// Social links activate option
	$wp_customize->add_section( 'ample_activate_social_links_setting', array(
		'priority' => 10,
		'title'    => __( 'Activate Social Links Area', 'ample' ),
		'panel'    => 'ample_social_link_options',
	) );

	$wp_customize->add_setting( 'ample[ample_activate_social_links]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_activate_social_links]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to activate social links area. You also need to activate the Header Top Bar section in Header options to show this Social Links area.', 'ample' ),
		'section' => 'ample_activate_social_links_setting',
	) );

// Selective refresh for social links enable
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'ample[ample_activate_social_links]', array(
			'selector'        => '.social-links',
			'render_callback' => '',
		) );
	}

	$social_links = array(
		'facebook',
		'twitter',
		'google-plus',
		'instagram',
		'skype',
		'gitHub',
		'linkedIn',
		'pinterest',
		'wordpress',
		'youtube',
	);

	for ( $i = 1; $i <= 10; $i ++ ) {
		$j = $i - 1;
		$wp_customize->add_section( 'ample_icon_class_setting' . $i, array(
			'priority' => 20 + $i,
			'title'    => __( 'Social Link ', 'ample' ) . $i,
			'panel'    => 'ample_social_link_options',
		) );

		$wp_customize->add_setting( 'ample[ample_icon_class' . $i . ']', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'ample_sanitize_escaping',
		) );
		$wp_customize->add_control( 'ample[ample_icon_class' . $i . ']', array(
			'label'   => __( 'Add any font awesome icon class. Example ', 'ample' ) . $social_links[ $j ],
			'section' => 'ample_icon_class_setting' . $i,
		) );

		$wp_customize->add_setting( 'ample[ample_social_icon_link' . $i . ']', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'type'                 => 'option',
			'sanitize_callback'    => 'ample_sanitize_url',
			'sanitize_js_callback' => 'ample_sanitize_js_url',
		) );
		$wp_customize->add_control( 'ample[ample_social_icon_link' . $i . ']', array(
			'label'   => __( 'Add Link', 'ample' ),
			'section' => 'ample_icon_class_setting' . $i,
		) );

		$wp_customize->add_setting( 'ample[ample_social_new_tab' . $i . ']', array(
			'default'           => 0,
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'ample_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'ample[ample_social_new_tab' . $i . ']', array(
			'type'    => 'checkbox',
			'label'   => __( 'Check to open in new tab', 'ample' ),
			'section' => 'ample_icon_class_setting' . $i,
		) );
	}
// End of the Social Links Options

	/**************************************************************************************/

	/* Slider Options Area */
	$wp_customize->add_panel( 'ample_slider_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 320,
		'title'      => __( 'Slider', 'ample' ),
	) );

// Slider activate option
	$wp_customize->add_section( 'ample_activate_slider_setting', array(
		'title'    => __( 'Activate slider', 'ample' ),
		'priority' => 10,
		'panel'    => 'ample_slider_options',
	) );

	$wp_customize->add_setting( 'ample[ample_activate_slider]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_activate_slider]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to activate slider.', 'ample' ),
		'section' => 'ample_activate_slider_setting',
	) );

// Selective refresh for activation of slider
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'ample[ample_activate_slider]', array(
			'selector'        => '.big-slider-wrapper',
			'render_callback' => '',
		) );
	}

// Slider status option
	$wp_customize->add_section( 'ample_slider_status_setting', array(
		'title'    => __( 'Slider Status', 'ample' ),
		'priority' => 12,
		'panel'    => 'ample_slider_options',
	) );

	$wp_customize->add_setting( 'ample[ample_slider_status]', array(
		'default'           => 'front_page',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_slider_status]', array(
		'label'   => __( 'Choose the slider status that you want.', 'ample' ),
		'type'    => 'radio',
		'section' => 'ample_slider_status_setting',
		'choices' => array(
			'front_page' => __( 'Slider on Front page', 'ample' ),
			'all_page'   => __( 'Slider on all pages', 'ample' ),
		),
	) );

// Slider Setting
	$wp_customize->add_section( 'ample_slider_setting', array(
		'title'    => __( 'Slider Settings', 'ample' ),
		'priority' => 14,
		'panel'    => 'ample_slider_options',
	) );

	$wp_customize->add_setting( 'ample[ample_slider_transition_effect]', array(
		'default'           => 'fade',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_slider_transition_effect]', array(
		'label'   => __( 'Slider transition effect. Choose the transition effect that you like. Default is "fade".', 'ample' ),
		'type'    => 'select',
		'section' => 'ample_slider_setting',
		'choices' => array(
			'fade'       => __( 'Fade', 'ample' ),
			'horizontal' => __( 'Horizontal', 'ample' ),
			'vertical'   => __( 'Vertical', 'ample' ),
		),
	) );

// Slider transition delay time
	$wp_customize->add_setting( 'ample[ample_slider_transition_delay]', array(
		'default'           => '4',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_integer_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_slider_transition_delay]', array(
		'label'   => __( 'Slider transition delay time. Add number in seconds. Default is 4.', 'ample' ),
		'section' => 'ample_slider_setting',
		'type'    => 'number',
	) );

// Slider transition length time
	$wp_customize->add_setting( 'ample[ample_slider_transition_length]', array(
		'default'           => '1',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_integer_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_slider_transition_length]', array(
		'label'   => __( 'Slider transition length time. Add number in seconds. Default is 1.', 'ample' ),
		'section' => 'ample_slider_setting',
		'type'    => 'number',
	) );

// Number of slider
	$wp_customize->add_setting( 'ample[ample_slider_number]', array(
		'default'           => '4',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_integer_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_slider_number]', array(
		'label'   => __( 'Number of slides Enter the number of slides you want then click "Save Options".', 'ample' ),
		'section' => 'ample_slider_setting',
	) );

// Slider image as link option
	$wp_customize->add_setting( 'ample[ample_slider_image_link_option]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_slider_image_link_option]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to make the slider images link back to respective links.', 'ample' ),
		'section' => 'ample_slider_setting',
	) );

	$num_of_slides = ample_option( 'ample_slider_number', '4' );

// Slide options
	for ( $i = 1; $i <= $num_of_slides; $i ++ ) {
		// Slider Image upload
		$wp_customize->add_section( 'ample_slider_image_setting' . $i, array(
			'title'    => sprintf( __( 'Slider #%1$s', 'ample' ), $i ),
			'priority' => $i + 50,
			'panel'    => 'ample_slider_options',
		) );

		$wp_customize->add_setting( 'ample[ample_slider_image' . $i . ']', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'type'                 => 'option',
			'sanitize_callback'    => 'ample_sanitize_url',
			'sanitize_js_callback' => 'ample_sanitize_js_url',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, 'ample[ample_slider_image' . $i . ']', array(
				'label'    => __( 'Upload image', 'ample' ),
				'section'  => 'ample_slider_image_setting' . $i,
				'settings' => 'ample[ample_slider_image' . $i . ']',
			) )
		);

		// Slider Title
		$wp_customize->add_setting( 'ample[ample_slider_title' . $i . ']', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'ample_sanitize_escaping',

		) );
		$wp_customize->add_control( 'ample[ample_slider_title' . $i . ']', array(
			'label'    => __( 'Enter title for this slide', 'ample' ),
			'section'  => 'ample_slider_image_setting' . $i,
			'settings' => 'ample[ample_slider_title' . $i . ']',
		) );

		// Button Text
		$wp_customize->add_setting( 'ample[ample_slider_button_text' . $i . ']', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'ample_sanitize_escaping',

		) );
		$wp_customize->add_control( 'ample[ample_slider_button_text' . $i . ']', array(
			'label'    => __( 'Enter button text', 'ample' ),
			'section'  => 'ample_slider_image_setting' . $i,
			'settings' => 'ample[ample_slider_button_text' . $i . ']',
		) );

		// Button Link
		$wp_customize->add_setting( 'ample[ample_slider_link' . $i . ']', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'type'                 => 'option',
			'sanitize_callback'    => 'ample_sanitize_url',
			'sanitize_js_callback' => 'ample_sanitize_js_url',

		) );
		$wp_customize->add_control( 'ample[ample_slider_link' . $i . ']', array(
			'label'    => __( 'Enter link to redirect', 'ample' ),
			'section'  => 'ample_slider_image_setting' . $i,
			'settings' => 'ample[ample_slider_link' . $i . ']',
		) );
	}
// End of the Slider Options

// Start of the WordPress default options.
// Background image clickable
	$wp_customize->add_setting( 'ample[ample_background_image_link]', array(
		'default'           => '',
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'ample[ample_background_image_link]', array(
		'label'           => esc_html__( 'Add the background link url.', 'ample' ),
		'section'         => 'background_image',
		'setting'         => 'ample[ample_background_image_link]',
		'active_callback' => 'ample_background_image',
	) );

	/**
	 * Check if the background image is set or not.
	 *
	 * @return bool
	 */
	function ample_background_image() {
		$background_image = get_background_image();
		if ( $background_image ) {
			return true;
		}

		return false;
	}

// End of the WordPress default options.

	/**************************************************************************************/
	/* Footer Options.*/
	$wp_customize->add_panel( 'ample_footer_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 330,
		'title'      => __( 'Footer', 'ample' ),
	) );

// Footer editor option
	$wp_customize->add_section( 'ample_footer_editor_setting', array(
		'title'    => __( 'Footer Copyright Editor', 'ample' ),
		'priority' => 80,
		'panel'    => 'ample_footer_options',
	) );

	$wp_customize->add_setting( 'ample[ample_footer_editor]', array(
		'default'           => __( 'Copyright &copy; ', 'ample' ) . '[the-year] [site-link] ' . __( 'Theme by: ', 'ample' ) . '[tg-link] ' . __( 'Powered by: ', 'ample' ) . '[wp-link]',
		'transport'         => $customizer_selective_refresh,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_editor_sanitize',
	) );

	$wp_customize->add_control(
		new AMPLE_Editor_Control( $wp_customize, 'ample[ample_footer_editor]', array(
			'label'   => __( 'Edit the Copyright information in your footer. You can also use shortcodes [the-year], [site-link], [wp-link], [tg-link] for current year, your site link, WordPress site link and ThemeGrill site link respectively.', 'ample' ),
			'section' => 'ample_footer_editor_setting',
			'setting' => 'ample[ample_footer_editor]',
		) )
	);

// Selective refresh for footer copyright information
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'ample[ample_footer_editor]', array(
			'selector'        => '.copyright-info',
			'render_callback' => 'ample_footer_copyright',
		) );
	}

// Footer widgets column select type
	$wp_customize->add_section( 'ample_footer_column_select_section', array(
		'priority' => 5,
		'title'    => esc_html__( 'Footer Widgets Column', 'ample' ),
		'panel'    => 'ample_footer_options',
	) );

	$wp_customize->add_setting( 'ample[ample_footer_column_select_setting]', array(
		'default'           => 'four',
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );

	$wp_customize->add_control( 'ample[ample_footer_column_select_setting]', array(
		'type'    => 'select',
		'label'   => esc_html__( 'Choose the number of column for the footer widgetized areas.', 'ample' ),
		'choices' => array(
			'one'   => esc_html__( 'One Column', 'ample' ),
			'two'   => esc_html__( 'Two Column', 'ample' ),
			'three' => esc_html__( 'Three Column', 'ample' ),
			'four'  => esc_html__( 'Four Column', 'ample' ),
		),
		'section' => 'ample_footer_column_select_section',
		'setting' => 'ample[ample_footer_column_select_setting]',
	) );

	/* Additional Options Area */
	$wp_customize->add_panel( 'ample_additional_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 330,
		'title'      => __( 'Additional', 'ample' ),
	) );

// One Page
	$wp_customize->add_section( 'ample_activate_sticky_menu_setting', array(
		'title'    => __( 'One Page Settings', 'ample' ),
		'priority' => 5,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_activate_sticky_menu]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_activate_sticky_menu]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Activate one page style menu', 'ample' ),
		'section' => 'ample_activate_sticky_menu_setting',
	) );

// Pull all the categories into an array
	$options_categories     = array();
	$options_categories_obj = get_categories();
	foreach ( $options_categories_obj as $category ) {
		$options_categories[ $category->cat_ID ] = $category->cat_name;
	}

// Select category to hide from Post Page
	$wp_customize->add_section( 'ample_hide_category_setting', array(
		'title'    => __( 'Category to hide from Blog', 'ample' ),
		'priority' => 20,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_hide_category]', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_escaping',
	) );
	$wp_customize->add_control(
		new AMPLE_Controls_MultiCheck_Control( $wp_customize, 'ample[ample_hide_category]', array(
			'label'   => __( 'Select a Category or Categories to hide its posts from Blog page.', 'ample' ),
			'section' => 'ample_hide_category_setting',
			'setting' => 'ample[ample_hide_category]',
			'choices' => $options_categories,
		) )
	);

// Author bio opion.
	$wp_customize->add_section( 'ample_author_bio_section', array(
		'title'    => esc_html__( 'Author Bio Option', 'ample' ),
		'priority' => 60,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_author_bio_setting]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_author_bio_setting]', array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Check to display author bio', 'ample' ),
		'section' => 'ample_author_bio_section',
		'setting' => 'ample[ample_author_bio_setting]',
	) );

	$wp_customize->add_setting( 'ample[ample_author_bio_social_sites_show]', array(
		'default'           => 0,
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_author_bio_social_sites_show]', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to show the Social Profiles in the Author Bio', 'ample' ),
		'section'  => 'ample_author_bio_section',
		'settings' => 'ample[ample_author_bio_social_sites_show]',
	) );

// Author bio link.
	$wp_customize->add_setting( 'ample[ample_author_bio_link_show]', array(
		'default'           => 0,
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_author_bio_link_show]', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( ' Check to display the link to the author page in the Author Bio section', 'ample' ),
		'section'  => 'ample_author_bio_section',
		'settings' => 'ample[ample_author_bio_link_show]',
	) );

// Display excerpt/content in blog and archives
	$wp_customize->add_section( 'ample_toggle_excerpt_full_post', array(
		'title'    => __( 'Excerpts or Full Posts Option', 'ample' ),
		'priority' => 30,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_toggle_excerpt_full_post_setting]', array(
		'default'           => 'full_post',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_toggle_excerpt_full_post_setting]', array(
		'label'   => __( 'Toggle between displaying excerpts and full posts on your blog and archives.', 'ample' ),
		'type'    => 'radio',
		'section' => 'ample_toggle_excerpt_full_post',
		'choices' => array(
			'full_post' => __( 'Show full post content', 'ample' ),
			'excerpt'   => __( 'Show excerpt', 'ample' ),
		),
	) );

// Read more button for post archive/blog pages.
	$wp_customize->add_setting( 'ample[ample_read_more_button]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_read_more_button]', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to display read more button', 'ample' ),
		'section'  => 'ample_toggle_excerpt_full_post',
		'settings' => 'ample[ample_read_more_button]',
	) );

	$wp_customize->add_setting( 'ample[ample_custom_information_for_readmore_button]', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ample_false_sanitize',
	) );
	$wp_customize->add_control( new AMPLE_Custom_Information( $wp_customize, 'ample[ample_custom_information_for_readmore_button]', array(
		'description' => __( 'Note: When manual excerpt is added read more button is not shown by default.', 'ample' ),
		'settings'    => 'ample[ample_custom_information_for_readmore_button]',
		'section'     => 'ample_toggle_excerpt_full_post',
	) ) );

// Excerpt Options
	$wp_customize->add_section( 'ample_excerpt_words_setting', array(
		'title'    => __( 'Excerpt Length', 'ample' ),
		'priority' => 40,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_excerpt_words]', array(
		'default'           => '40',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_integer_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_excerpt_words]', array(
		'label'   => __( 'Enter the number of Words you wish to show on excerpt. Default value is 40 words.', 'ample' ),
		'section' => 'ample_excerpt_words_setting',
	) );

// Related posts option.
	$wp_customize->add_section( 'ample_related_posts_section', array(
		'title'    => esc_html__( 'Related Posts', 'ample' ),
		'priority' => 60,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_related_posts_setting]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_related_posts_setting]', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to display related posts', 'ample' ),
		'section'  => 'ample_related_posts_section',
		'settings' => 'ample[ample_related_posts_setting]',
	) );

	$wp_customize->add_setting( 'ample[ample_related_posts]', array(
		'default'           => 'categories',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );

	$wp_customize->add_control( 'ample[ample_related_posts]', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Related Posts Must Be Shown As:', 'ample' ),
		'section'  => 'ample_related_posts_section',
		'settings' => 'ample[ample_related_posts]',
		'choices'  => array(
			'categories' => esc_html__( 'Related Posts By Categories', 'ample' ),
			'tags'       => esc_html__( 'Related Posts By Tags', 'ample' ),
		),
	) );

// Select option to display number of posts.
	$wp_customize->add_setting( 'ample[ample_related_posts_number_display]', array(
		'default'           => '3',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );

	$wp_customize->add_control( 'ample[ample_related_posts_number_display]', array(
		'type'     => 'select',
		'section'  => 'ample_related_posts_section',
		'settings' => 'ample[ample_related_posts_number_display]',
		'label'    => esc_html__( 'Number of post to display', 'ample' ),
		'choices'  => array(
			'3' => esc_html__( '3', 'ample' ),
			'6' => esc_html__( '6', 'ample' ),
		),
	) );

// Change Read more text
	$wp_customize->add_section( 'ample_read_more_text_setting', array(
		'title'    => __( 'Excerpt Read More Text', 'ample' ),
		'priority' => 50,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_read_more_text]', array(
		'default'           => 'Read more',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_escaping',
	) );

	$wp_customize->add_control( 'ample[ample_read_more_text]', array(
		'label'   => __( 'Replace the default Read more text with your own words', 'ample' ),
		'section' => 'ample_read_more_text_setting',
	) );

// Allow Comments on Pages
	$wp_customize->add_section( 'ample_allow_comment_on_page_setting', array(
		'title'    => __( 'Allow Comments on Pages', 'ample' ),
		'priority' => 60,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_allow_comment_on_page]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_allow_comment_on_page]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to display Comment on pages', 'ample' ),
		'section' => 'ample_allow_comment_on_page_setting',
	) );

// Menu Top Border
	$wp_customize->add_section( 'ample_hide_menu_top_border_setting', array(
		'title'    => __( 'Hide Menu Top Border', 'ample' ),
		'priority' => 70,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_hide_menu_top_border]', array(

		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_hide_menu_top_border]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to hide the top bar of Primary Menu', 'ample' ),
		'section' => 'ample_hide_menu_top_border_setting',
	) );

// Sticky post and sidebar section
	$wp_customize->add_section( 'ample_sticky_content_sidebar_setting', array(
		'priority' => 90,
		'title'    => esc_html__( 'Sticky Content And Sidebar', 'ample' ),
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_sticky_content_sidebar]', array(
		'default'           => 0,
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_sticky_content_sidebar]', array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Check to activate the sticky options for content and sidebar areas.', 'ample' ),
		'setting' => 'ample[ample_sticky_content_sidebar]',
		'section' => 'ample_sticky_content_sidebar_setting',
	) );

// Content read more tag display from beginning.
	$wp_customize->add_section( 'ample_content_read_more_tag_display_setting', array(
		'priority' => 90,
		'title'    => esc_html__( 'Content Read More Tag', 'ample' ),
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_content_read_more_tag_display]', array(
		'default'           => 0,
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_content_read_more_tag_display]', array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Check to display Content read more tag from beginning', 'ample' ),
		'setting' => 'ample[ample_content_read_more_tag_display]',
		'section' => 'ample_content_read_more_tag_display_setting',
	) );
// End of the Additional Options

	/**************************************************************************************/

// Start of the Typography Option.
	$wp_customize->add_panel( 'ample_typography_options', array(
		'priority'   => 340,
		'title'      => __( 'Typography', 'ample' ),
		'capability' => 'edit_theme_options',
	) );

// Font family options
	$wp_customize->add_section( 'ample_google_fonts_settings', array(
		'priority' => 1,
		'title'    => __( 'Google Font Options', 'ample' ),
		'panel'    => 'ample_typography_options',
	) );

	$ample_fonts = array(
		'ample_site_title_font'   => array(
			'id'      => 'ample[ample_site_title_font]',
			'default' => 'Roboto+Slab:700,400',
			'title'   => __( 'Site title font. Default is "Roboto Slab".', 'ample' ),
		),
		'ample_site_tagline_font' => array(
			'id'      => 'ample[ample_site_tagline_font]',
			'default' => 'Roboto+Slab:700,400',
			'title'   => __( 'Site tagline font. Default is "Roboto Slab".', 'ample' ),
		),
		'ample_primary_menu_font' => array(
			'id'      => 'ample[ample_primary_menu_font]',
			'default' => 'Roboto:400,300,100',
			'title'   => __( 'Primary menu font. Default is "Roboto".', 'ample' ),
		),
		'ample_titles_font'       => array(
			'id'      => 'ample[ample_titles_font]',
			'default' => 'Roboto+Slab:700,400',
			'title'   => __( 'All Titles font. Default is "Roboto Slab".', 'ample' ),
		),
		'ample_content_font'      => array(
			'id'      => 'ample[ample_content_font]',
			'default' => 'Roboto:400,300,100',
			'title'   => __( 'Content font and for others. Default is "Roboto".', 'ample' ),
		),
	);

	foreach ( $ample_fonts as $ample_font ) {

		$wp_customize->add_setting( $ample_font['id'], array(
			'default'           => $ample_font['default'],
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'ample_font_sanitize',
		) );

		$wp_customize->add_control(
			new Ample_Typography_Control(
				$wp_customize,
				$ample_font['id'], array(
					'label'    => $ample_font['title'],
					'settings' => $ample_font['id'],
					'section'  => 'ample_google_fonts_settings',
				)
			)
		);
	}

// Font Size Option
	$ample_fonts_size_options = ample_font_size_func();

	foreach ( $ample_fonts_size_options as $ample_section ) {

		$wp_customize->add_section( $ample_section['section_id'], array(
			'title' => $ample_section['title'],
			'panel' => 'ample_typography_options',
		) );

		$ample_section_id        = $ample_section['section_id'];
		$ample_font_size_setting = $ample_section['ample_font_size_setting'];

		foreach ( $ample_font_size_setting as $ample_font_setting ) {

			$wp_customize->add_setting( 'ample[' . $ample_font_setting['id'] . ']', array(
				'default'           => $ample_font_setting['default'],
				'capability'        => 'edit_theme_options',
				'type'              => 'option',
				'sanitize_callback' => 'ample_radio_sanitize',
				'transport'         => 'postMessage',
			) );

			$wp_customize->add_control( 'ample[' . $ample_font_setting['id'] . ']', array(
				'label'    => $ample_font_setting['label'],
				'type'     => 'select',
				'settings' => 'ample[' . $ample_font_setting['id'] . ']',
				'section'  => $ample_section_id,
				'choices'  => $ample_font_setting['choice'],
			) );
		}
	}
// End of the Typography Options

	/**************************************************************************************/

	/* Start of the Color Options */
	$wp_customize->add_panel( 'ample_color_options', array(
		'priority'   => 350,
		'title'      => __( 'Color', 'ample' ),
		'capability' => 'edit_theme_options',
	) );
// Primary Color Option
	$wp_customize->add_section( 'ample_primary_color_setting', array(
		'title' => 'Primary Color Option',
		'panel' => 'ample_color_options',
	) );
	$wp_customize->add_setting( 'ample[ample_primary_color]', array(
		'default'              => '#80abc8',
		'capability'           => 'edit_theme_options',
		'type'                 => 'option',
		'sanitize_callback'    => 'ample_color_option_hex_sanitize',
		'sanitize_js_callback' => 'ample_color_escaping_option_sanitize',
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'ample[ample_primary_color]', array(
			'label'    => 'This will reflect in links, buttons and many others. Choose a color to match your site.',
			'settings' => 'ample[ample_primary_color]',
			'section'  => 'ample_primary_color_setting',
		) )
	);

	$ample_colors_options = ample_color_func();

	foreach ( $ample_colors_options as $ample_color_section ) {

		$wp_customize->add_section( $ample_color_section['section_id'], array(
			'title' => $ample_color_section['title'],
			'panel' => 'ample_color_options',
		) );

		$ample_color_section_id = $ample_color_section['section_id'];
		$ample_color_settings   = $ample_color_section['ample_color_settings'];

		foreach ( $ample_color_settings as $ample_color_setting ) {

			$wp_customize->add_setting( 'ample[' . $ample_color_setting['id'] . ']', array(
				'default'              => $ample_color_setting['default'],
				'capability'           => 'edit_theme_options',
				'type'                 => 'option',
				'sanitize_callback'    => 'ample_color_option_hex_sanitize',
				'sanitize_js_callback' => 'ample_color_escaping_option_sanitize',
				'transport'            => 'postMessage',
			) );

			$wp_customize->add_control(
				new WP_Customize_Color_Control( $wp_customize, 'ample[' . $ample_color_setting['id'] . ']', array(
					'label'    => $ample_color_setting['label'],
					'settings' => 'ample[' . $ample_color_setting['id'] . ']',
					'section'  => $ample_color_section_id,
				) )
			);
		}
	}
// End of the Color Options

	/**************************************************************************************/

	/* Start of the WooCommerce Options */
	if ( class_exists( 'woocommerce' ) ) {
		// WooCommerce Archive Page layout
		$wp_customize->add_panel( 'ample_woocommerce_options', array(
			'priority'   => 360,
			'title'      => __( 'WooCommerce', 'ample' ),
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_section( 'ample_woocommerce_layout_setting', array(
			'title'    => __( 'Archive Page Layout', 'ample' ),
			'priority' => 10,
			'panel'    => 'ample_woocommerce_options',
		) );

		$wp_customize->add_setting( 'ample[ample_woocommerce_layout]', array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'ample_radio_sanitize',
		) );
		$wp_customize->add_control(
			new AMPLE_Image_Radio_Control( $wp_customize, 'ample[ample_woocommerce_layout]', array(
				'type'    => 'radio',
				'label'   => __( 'Select woocommerce layout. This layout will be reflected in woocommerce archive page only.', 'ample' ),
				'section' => 'ample_woocommerce_layout_setting',
				'choices' => array(
					'right_sidebar'               => get_template_directory_uri() . '/inc/admin/images/right-sidebar.png',
					'left_sidebar'                => get_template_directory_uri() . '/inc/admin/images/left-sidebar.png',
					'no_sidebar_full_width'       => get_template_directory_uri() . '/inc/admin/images/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => get_template_directory_uri() . '/inc/admin/images/no-sidebar-content-centered-layout.png',
					'both_sidebar'                => get_template_directory_uri() . '/inc/admin/images/both-sidebar.png',
				),
			) )
		);
	}

	$wp_customize->add_section( 'ample_important_links', array(
		'priority' => 700,
		'title'    => __( 'About Ample Pro', 'ample' ),
	) );

	/**
	 * This setting has the dummy Sanitization function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'ample[ample_important_links]', array(
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_links_sanitize',
	) );

	$wp_customize->add_control(
		new AMPLE_Important_Links( $wp_customize, 'important_links', array(
			'section'  => 'ample_important_links',
			'settings' => 'ample[ample_important_links]',
		) )
	);
// Theme Important Links Ended

	/**************************************************************************************/

// Checkbox sanitization
	function ample_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}

// URL sanitization
	function ample_sanitize_url( $input ) {
		$input = esc_url_raw( $input );

		return $input;
	}

	function ample_sanitize_js_url( $input ) {
		$input = esc_url( $input );

		return $input;
	}

// Color sanitization
	function ample_sanitize_hex_color( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
			return '#' . $unhashed;
		}

		return $color;
	}

	function ample_sanitize_escaping( $input ) {
		$input = esc_attr( $input );

		return $input;
	}

// Radio/Select sanitization
	function ample_radio_sanitize( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

// Sanitization of links
	function ample_links_sanitize() {
		return false;
	}

// Editor sanitization
	function ample_editor_sanitize( $input ) {
		if ( isset( $input ) ) {
			$input = stripslashes( wp_filter_post_kses( addslashes( $input ) ) );
		}

		return $input;
	}

	function ample_integer_sanitize( $input ) {
		if ( is_numeric( $input ) ) {
			return intval( $input );
		} else {
			return 4;
		}
	}

	function ample_false_sanitize() {
		return false;
	}

// Google Font Sanitization.
	function ample_font_sanitize( $input ) {
		$ample_standard_fonts_array = ample_standard_fonts_array();
		$ample_google_fonts         = ample_google_fonts();
		$valid_keys                 = array_merge( $ample_standard_fonts_array, $ample_google_fonts );

		if ( array_key_exists( $input, $valid_keys ) ) {
			return $input;
		} else {
			return '';
		}
	}


// Color sanitization
	function ample_color_option_hex_sanitize( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
			return '#' . $unhashed;
		}

		return $color;
	}

	function ample_color_escaping_option_sanitize( $input ) {
		$input = esc_attr( $input );

		return $input;
	}
}

add_action( 'customize_register', 'ample_customize_register' );

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

if ( ! function_exists( 'ample_font_size_func' ) ) :
	/**
	 * Function that contain Font Size customze setting
	 */
	function ample_font_size_func() {
		$ample_fonts_size_options = array(
			'ample_header_font_size_setting'  => array(
				'section_id'              => 'ample_header_font_size_setting',
				'title'                   => __( 'Header Font Size Options', 'ample' ),
				'ample_font_size_setting' => array(
					'ample_header_top_bar_font_size'   => array(
						'id'         => 'ample_header_top_bar_font_size',
						'default'    => '15',
						'label'      => __( 'Header Top Bar Font Size. Default is 15px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 22 ),
						'custom_css' => ' .small-info-text p',
					),
					'ample_site_title_font_size'       => array(
						'id'         => 'ample_site_title_font_size',
						'default'    => '34',
						'label'      => __( 'Site title font size. Default is 34px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 25, 45 ),
						'custom_css' => '  #site-title a',
					),
					'ample_tagline_font_size'          => array(
						'id'         => 'ample_tagline_font_size',
						'default'    => '13',
						'label'      => __( 'Site tagline font size. Default is 13px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 5, 20 ),
						'custom_css' => ' #site-description',
					),
					'ample_primary_menu_font_size'     => array(
						'id'         => 'ample_primary_menu_font_size',
						'default'    => '14',
						'label'      => __( 'Primary menu. Default is 14px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 22 ),
						'custom_css' => '  .main-navigation ul.menu li a',
					),
					'ample_primary_sub_menu_font_size' => array(
						'id'         => 'ample_primary_sub_menu_font_size',
						'default'    => '14',
						'label'      => __( 'Primary sub menu. Default is 14px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 22 ),
						'custom_css' => ' .main-navigation ul.menu li ul.sub-menu li a',
					),
				),
			),
			'ample_slider_font_size_setting'  => array(
				'section_id'              => 'ample_slider_font_size_setting',
				'title'                   => __( 'Slider Font Size Options', 'ample' ),
				'ample_font_size_setting' => array(
					'ample_slider_title_font_size'  => array(
						'id'         => 'ample_slider_title_font_size',
						'default'    => '40',
						'label'      => __( 'Slider title. Default is 40px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 30, 50 ),
						'custom_css' => ' .big-slider .entry-title',
					),
					'ample_slider_button_font_size' => array(
						'id'         => 'ample_slider_button_font_size',
						'default'    => '16',
						'label'      => __( 'Slider button. Default is 16px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 24 ),
						'custom_css' => ' .slider-button',
					),
				),
			),
			'ample_title_font_size_setting'   => array(
				'section_id'              => 'ample_title_font_size_setting',
				'title'                   => __( 'Titles Related Font Size Options', 'ample' ),
				'ample_font_size_setting' => array(
					'ample_h1_title_font_size'                    => array(
						'id'         => 'ample_h1_title_font_size',
						'default'    => '30',
						'label'      => __( 'Heading h1 tag. Default is 30px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 22, 38 ),
						'custom_css' => ' h1',
					),
					'ample_h2_title_font_size'                    => array(
						'id'         => 'ample_h2_title_font_size',
						'default'    => '28',
						'label'      => __( 'Heading h2 tag. Default is 28px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 20, 36 ),
						'custom_css' => ' h2',
					),
					'ample_h3_title_font_size'                    => array(
						'id'         => 'ample_h3_title_font_size',
						'default'    => '26',
						'label'      => __( 'Heading h3 tag. Default is 26px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 18, 34 ),
						'custom_css' => ' h3',
					),
					'ample_h4_title_font_size'                    => array(
						'id'         => 'ample_h4_title_font_size',
						'default'    => '24',
						'label'      => __( 'Heading h4 tag. Default is 24px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 16, 32 ),
						'custom_css' => ' h4',
					),
					'ample_h5_title_font_size'                    => array(
						'id'         => 'ample_h5_title_font_size',
						'default'    => '22',
						'label'      => __( 'Heading h5 tag. Default is 22px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 14, 30 ),
						'custom_css' => ' h5',
					),
					'ample_h6_title_font_size'                    => array(
						'id'         => 'ample_h6_title_font_size',
						'default'    => '19',
						'label'      => __( 'Heading h6 tag. Default is 19px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 10, 28 ),
						'custom_css' => ' h6',
					),
					'ample_widget_titles_font_size'               => array(
						'id'         => 'ample_widget_titles_font_size',
						'default'    => '26',
						'label'      => __( 'Widget Titles. Default is 26px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 18, 34 ),
						'custom_css' => ' h3.widget-title, #secondary .widget-title, #tertiary .widget-title',
					),
					'ample_widget_description_font_size'          => array(
						'id'         => 'ample_widget_description_font_size',
						'default'    => '16',
						'label'      => __( 'Widget Description. Default is 16px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 24 ),
						'custom_css' => ' .widget .services-main-description p, .widget .portfolio-main-description p, .widget .featured-posts-main-description p, .widget .testimonials-main-description p, .widget .clients-main-description p',
					),
					'ample_call_to_action_widget_title_font_size' => array(
						'id'         => 'ample_call_to_action_widget_title_font_size',
						'default'    => '26',
						'label'      => __( 'TG: Call to Action widget text. Default is 26px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 18, 34 ),
						'custom_css' => ' .call-to-action-content-wrapper h3',
					),
					'ample_header_title_bar_font_size'            => array(
						'id'         => 'ample_header_title_bar_font_size',
						'default'    => '24',
						'label'      => __( 'Header Title Bar. Default is 24px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 16, 35 ),
						'custom_css' => ' .header-post-title-class',
					),
					'ample_posts_page_title_font_size'            => array(
						'id'         => 'ample_posts_page_title_font_size',
						'default'    => '24',
						'label'      => __( 'Post Title of Posts Page. Default is 24px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 16, 32 ),
						'custom_css' => ' .hentry .entry-title',
					),
					'ample_comment_title_font_size'               => array(
						'id'         => 'ample_comment_title_font_size',
						'default'    => '22',
						'label'      => __( 'Comment Title. Default is 22px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 14, 30 ),
						'custom_css' => ' .comments-title',
					),
				),
			),
			'ample_content_font_size_setting' => array(
				'section_id'              => 'ample_content_font_size_setting',
				'title'                   => __( 'Content Font Size Options', 'ample' ),
				'ample_font_size_setting' => array(
					'ample_content_font_size'   => array(
						'id'         => 'ample_content_font_size',
						'default'    => '15',
						'label'      => __( 'Content font size, also applies to other text like in search fields, post comment button etc. Default is 15px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 24 ),
						'custom_css' => ' body, button, input, select, textarea, p, dl, .ample-button, input[type="reset"], input[type="button"], input[type="submit"], button, .previous a, .next a, .nav-previous a, .nav-next a, #respond h3#reply-title #cancel-comment-reply-link, #respond form input[type="text"], #respond form textarea, #secondary .widget, .error-404 .widget',
					),
					'ample_post_meta_font_size' => array(
						'id'         => 'ample_post_meta_font_size',
						'default'    => '14',
						'label'      => __( 'Post meta font size. Default is 14px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 22 ),
						'custom_css' => ' .entry-meta',
					),
				),
			),
			'ample_footer_font_size_setting'  => array(
				'section_id'              => 'ample_footer_font_size_setting',
				'title'                   => __( 'Footer Font Size Options', 'ample' ),
				'ample_font_size_setting' => array(
					'ample_footer_widget_titles_font_size'  => array(
						'id'         => 'ample_footer_widget_titles_font_size',
						'default'    => '22',
						'label'      => __( 'Footer widget Titles. Default is 22px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 14, 30 ),
						'custom_css' => ' #colophon .widget-title',
					),
					'ample_footer_widget_content_font_size' => array(
						'id'         => 'ample_footer_widget_content_font_size',
						'default'    => '13',
						'label'      => __( 'Footer widget content font size. Default is 13px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 8, 22 ),
						'custom_css' => ' .footer-widgets-area, #colophon .footer-widgets-area a',
					),
					'ample_footer_copyright_text_font_size' => array(
						'id'         => 'ample_footer_copyright_text_font_size',
						'default'    => '13',
						'label'      => __( 'Footer copyright text font size. Default is 13px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 5, 20 ),
						'custom_css' => ' #colophon .copyright, #colophon .copyright a, #colophon .copyright p',
					),
					'ample_small_footer_menu_font_size'     => array(
						'id'         => 'ample_small_footer_menu_font_size',
						'default'    => '13',
						'label'      => __( 'Footer small menu. Default is 13px.', 'ample' ),
						'choice'     => ample_font_size_range_generator( 5, 20 ),
						'custom_css' => ' #colophon .menu-footer-menu-container, #colophon .menu-footer-menu-container a, #colophon .footer-nav a',
					),
				),
			),
		);

		return $ample_fonts_size_options;
	}
endif;

/**************************************************************************************/

if ( ! function_exists( 'ample_color_func' ) ) :
	/**
	 * Function that contain Color customze setting
	 */
	function ample_color_func() {
		$ample_color_options = array(
			'ample_header_color_settings'  => array(
				'section_id'           => 'ample_header_color_settings',
				'title'                => __( 'Header Color Options', 'ample' ),
				'ample_color_settings' => array(
					'ample_header_background_color'       => array(
						'id'               => 'ample_header_background_color',
						'default'          => '#ffffff',
						'label'            => __( 'Header background color. Default is #ffffff.', 'ample' ),
						'color_custom_css' => '.header, .one-page-menu-active .header { background-color: ',
					),
					'ample_site_title_text_color'         => array(
						'id'               => 'ample_site_title_text_color',
						'default'          => '#666666',
						'label'            => __( 'Site Title. Default is #666666.', 'ample' ),
						'color_custom_css' => ' #site-title a { color: ',
					),
					'ample_site_tagline_text_color'       => array(
						'id'               => 'ample_site_tagline_text_color',
						'default'          => '#888888',
						'label'            => __( 'Site Tagline. Default is #888888.', 'ample' ),
						'color_custom_css' => ' #site-description { color: ',
					),
					'ample_primary_menu_background_color' => array(
						'id'               => 'ample_primary_menu_background_color',
						'default'          => '#ffffff',
						'label'            => __( 'Primary menu background color. Default is #ffffff.', 'ample' ),
						'color_custom_css' => ' .main-navigation { background-color: ',
					),
					'ample_primary_menu_selected_color'   => array(
						'id'                   => 'ample_primary_menu_selected_color',
						'default'              => '#80abc8',
						'label'                => __( 'Primary menu selected/hovered item text color. Default is #80abc8.', 'ample' ),
						'color_custom_css'     => ' .main-navigation a:hover, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-item a::after, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-ancestor a::after, .main-navigation ul li.current_page_item a::after, .main-navigation ul li.current_page_item a, .main-navigation ul li.current_page_ancestor a, .main-navigation ul li.current_page_ancestor a::after, .main-navigation ul li:hover > a, .main-navigation li.menu-item-has-children:hover > a::after, .main-navigation li.page_item_has_children:hover > a::after,  .main-navigation ul li ul li a:hover, .main-navigation ul li ul li:hover > a, .main-navigation ul li.current-menu-item ul li a:hover { color: ',
						'color_custom_css_two' => ' .main-navigation ul.menu > li.current-menu-item, .main-navigation ul.menu > li.current-menu-ancestor, .main-navigation .menu > ul > li.current_page_item, .main-navigation .menu > ul > li.current_page_ancestor, .main-navigation ul.menu > li:hover, .main-navigation .menu > ul > li:hover { border-top: 2px solid ',
					),
					'ample_primary_menu_text_color'       => array(
						'id'               => 'ample_primary_menu_text_color',
						'default'          => '#666666',
						'label'            => __( 'Primary menu (unselected/unhovered) text color. Default is #666666.', 'ample' ),
						'color_custom_css' => ' .main-navigation a, .main-navigation ul li ul li a,.main-navigation ul li.current-menu-item ul li a { color: ',
					),
					'ample_primary_menu_background_color' => array(
						'id'               => 'ample_primary_menu_background_color',
						'default'          => '#ffffff',
						'label'            => __( 'Primary menu background color. Default is #ffffff.', 'ample' ),
						'color_custom_css' => ' .main-navigation, .main-navigation ul li ul, .main-small-navigation .menu-primary-container { background-color: ',
					),
					'ample_primary_menu_selected_color'   => array(
						'id'                   => 'ample_primary_menu_selected_color',
						'default'              => '#80abc8',
						'label'                => __( 'Primary menu selected/hovered item text color. Default is #80abc8.', 'ample' ),
						'color_custom_css'     => '#masthead .main-small-navigation .menu-primary-container .menu-item-has-children:hover > a,#masthead .main-small-navigation .menu-primary-container li a:hover,.main-navigation a:hover, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-item a::after, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-ancestor a::after, .main-navigation ul li.current_page_item a::after, .main-navigation ul li.current_page_item a, .main-navigation ul li.current_page_ancestor a, .main-navigation ul li.current_page_ancestor a::after, .main-navigation ul li:hover > a, .main-navigation li.menu-item-has-children:hover > a::after, .main-navigation li.page_item_has_children:hover > a::after,  .main-navigation ul li ul li a:hover, .main-navigation ul li ul li:hover > a, .main-navigation ul li.current-menu-item ul li a:hover { color: ',
						'color_custom_css_two' => ' .main-navigation ul.menu > li.current-menu-item, .main-navigation ul.menu > li.current-menu-ancestor, .main-navigation .menu > ul > li.current_page_item, .main-navigation .menu > ul > li.current_page_ancestor, .main-navigation ul.menu > li:hover, .main-navigation .menu > ul > li:hover { border-top: 2px solid ',
					),
					'ample_top_bar_text_color'            => array(
						'id'               => 'ample_top_bar_text_color',
						'default'          => '#666666',
						'label'            => __( 'Header top bar text color. Default is #666666.', 'ample' ),
						'color_custom_css' => ' .small-info-text p { color: ',
					),
				),
			),
			'ample_slider_color_settings'  => array(
				'section_id'           => 'ample_slider_color_settings',
				'title'                => __( 'Slider Part Color Options', 'ample' ),
				'ample_color_settings' => array(
					'ample_slider_title_color'             => array(
						'id'               => 'ample_slider_title_color',
						'default'          => '#ffffff',
						'label'            => __( 'Slider title text color. Default is #ffffff.', 'ample' ),
						'color_custom_css' => ' .big-slider .entry-title a { color: ',
					),
					'ample_slider_title_hover_color'       => array(
						'id'               => 'ample_slider_title_hover_color',
						'default'          => '#80abc8',
						'label'            => __( 'Slider title hover text color. Default is #80abc8.', 'ample' ),
						'color_custom_css' => ' .big-slider .entry-title a:hover { color: ',
					),
					'ample_slider_button_text_color'       => array(
						'id'               => 'ample_slider_button_text_color',
						'default'          => '#ffffff',
						'label'            => __( 'Slider button text color. Default is #ffffff.', 'ample' ),
						'color_custom_css' => ' .slider-button { color: ',
					),
					'ample_slider_button_background_color' => array(
						'id'               => 'ample_slider_button_background_color',
						'default'          => '',
						'label'            => __( 'Slider button hover background color. Default is none.', 'ample' ),
						'color_custom_css' => ' .slider-button:hover { background-color: ',
					),
				),
			),
			'ample_content_color_settings' => array(
				'section_id'           => 'ample_content_color_settings',
				'title'                => __( 'Content Part Color Options', 'ample' ),
				'ample_color_settings' => array(
					'ample_title_bar_background_color' => array(
						'id'               => 'ample_title_bar_background_color',
						'default'          => '#80abc8',
						'label'            => __( 'Header Title Bar background color. Default is #80abc8.', 'ample' ),
						'color_custom_css' => ' .header-post-title-container { background-color: ',
					),
					'ample_header_title_color'         => array(
						'id'               => 'ample_header_title_color',
						'default'          => '#ffffff',
						'label'            => __( 'Header Title Bar text color. Default is #ffffff.', 'ample' ),
						'color_custom_css' => ' .header-post-title-class, .breadcrumb { color: ',
					),
					'ample_header_title_link_color'    => array(
						'id'               => 'ample_header_title_link_color',
						'default'          => '#b1b6b6',
						'label'            => __( 'Header Title Bar link text color. Default is #b1b6b6.', 'ample' ),
						'color_custom_css' => ' .breadcrumb a { color: ',
					),
					'ample_content_text_color'         => array(
						'id'               => 'ample_content_text_color',
						'default'          => '#888888',
						'label'            => __( 'Content section text color. Default is #888888.', 'ample' ),
						'color_custom_css' => ' body, button, input, select, textarea, p { color: ',
					),
					'ample_post_page_title_color'      => array(
						'id'               => 'ample_post_page_title_color',
						'default'          => '#666666',
						'label'            => __( 'Post title color for Posts Page. Default is #666666.', 'ample' ),
						'color_custom_css' => ' .hentry .entry-title a { color: ',
					),
					'ample_post_meta_color'            => array(
						'id'               => 'ample_post_meta_color',
						'default'          => '#888888',
						'label'            => __( 'Post meta color. Default is #888888.', 'ample' ),
						'color_custom_css' => ' .entry-meta a { color: ',
					),
					'ample_readmore_text_color'        => array(
						'id'               => 'ample_readmore_text_color',
						'default'          => '#80abc8',
						'label'            => __( 'Read more text color. Default is #80abc8.', 'ample' ),
						'color_custom_css' => ' .more-link span { color: ',
					),
					'ample_readmore_background_color'  => array(
						'id'               => 'ample_readmore_background_color',
						'default'          => '#ffffff',
						'label'            => __( 'Read more background color. Default is #ffffff.', 'ample' ),
						'color_custom_css' => ' .more-link span { background-color: ',
					),
					'ample_sidebar_widget_title_color' => array(
						'id'               => 'ample_sidebar_widget_title_color',
						'default'          => '#666666',
						'label'            => __( 'Left and Right sidebar widget title color. Default is #666666.', 'ample' ),
						'color_custom_css' => ' #secondary .widget-title, #tertiary .widget-title { color: ',
					),
				),
			),
			'ample_footer_color_settings'  => array(
				'section_id'           => 'ample_footer_color_settings',
				'title'                => __( 'Footer Part Color Options', 'ample' ),
				'ample_color_settings' => array(
					'ample_footer_background_color'        => array(
						'id'               => 'ample_footer_background_color',
						'default'          => '#1f2021',
						'label'            => __( 'Footer background color. Default is #1f2021.', 'ample' ),
						'color_custom_css' => ' #colophon { background-color: ',
					),
					'ample_footer_widget_background_color' => array(
						'id'               => 'ample_footer_widget_background_color',
						'default'          => '#1f2021',
						'label'            => __( 'Footer widget background color. Default is #1f2021.', 'ample' ),
						'color_custom_css' => ' #colophon .tg-one-fourth { background-color: ',
					),
					'ample_footer_widget_title_color'      => array(
						'id'               => 'ample_footer_widget_title_color',
						'default'          => '#b1b6b6',
						'label'            => __( 'Footer widget title color. Default is #b1b6b6.', 'ample' ),
						'color_custom_css' => ' #colophon .widget-title  { color: ',
					),
					'ample_footer_content_color'           => array(
						'id'               => 'ample_footer_content_color',
						'default'          => '#777777',
						'label'            => __( 'Footer content color. Default is #777777.', 'ample' ),
						'color_custom_css' => ' #colophon, #colophon .footer-widgets-area,#colophon p { color: ',
					),
					'ample_footer_link_color'              => array(
						'id'               => 'ample_footer_link_color',
						'default'          => '#b1b6b6',
						'label'            => __( 'Footer content link text color. Default is #b1b6b6.', 'ample' ),
						'color_custom_css' => ' #colophon a, #colophon .copyright-info a, #colophon .footer-nav ul li a  { color: ',
					),
				),
			),
		);

		return $ample_color_options;
	}
endif;

/**************************************************************************************/

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ample_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ample_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Ample 2.0.9
 */
function ample_customize_preview_js() {
	wp_enqueue_script( 'ample-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), false, true );
}

add_action( 'customize_preview_init', 'ample_customize_preview_js' );

if ( ! function_exists( 'ample_standard_fonts_array' ) ) :

	/**
	 * Standard Fonts array
	 *
	 * @return array of Standarad Fonts
	 */
	function ample_standard_fonts_array() {
		$ample_standard_fonts = array(
			'Georgia,Times,"Times New Roman",serif'                                                                                                 => 'serif',
			'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif' => 'sans-serif',
			'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'                                                   => 'monospace',
		);

		return $ample_standard_fonts;
	}

endif;

if ( ! function_exists( 'ample_google_fonts' ) ) :

	/**
	 * Google Fonts array
	 *
	 * @return array of Google Fonts
	 */
	function ample_google_fonts() {
		$ample_google_font = array(
			'ABeeZee'                   => 'ABeeZee',
			'Abel'                      => 'Abel',
			'Abhaya Libre'              => 'Abhaya Libre',
			'Abril Fatface'             => 'Abril Fatface',
			'Aclonica'                  => 'Aclonica',
			'Acme'                      => 'Acme',
			'Actor'                     => 'Actor',
			'Adamina'                   => 'Adamina',
			'Advent Pro'                => 'Advent Pro',
			'Aguafina Script'           => 'Aguafina Script',
			'Akronim'                   => 'Akronim',
			'Aladin'                    => 'Aladin',
			'Aldrich'                   => 'Aldrich',
			'Alef'                      => 'Alef',
			'Alegreya'                  => 'Alegreya',
			'Alegreya SC'               => 'Alegreya SC',
			'Alegreya Sans'             => 'Alegreya Sans',
			'Alegreya Sans SC'          => 'Alegreya Sans SC',
			'Alex Brush'                => 'Alex Brush',
			'Alfa Slab One'             => 'Alfa Slab One',
			'Alice'                     => 'Alice',
			'Alike'                     => 'Alike',
			'Alike Angular'             => 'Alike Angular',
			'Allan'                     => 'Allan',
			'Allerta'                   => 'Allerta',
			'Allerta Stencil'           => 'Allerta Stencil',
			'Allura'                    => 'Allura',
			'Almendra'                  => 'Almendra',
			'Almendra Display'          => 'Almendra Display',
			'Almendra SC'               => 'Almendra SC',
			'Amarante'                  => 'Amarante',
			'Amaranth'                  => 'Amaranth',
			'Amatic SC'                 => 'Amatic SC',
			'Amatica SC'                => 'Amatica SC',
			'Amethysta'                 => 'Amethysta',
			'Amiko'                     => 'Amiko',
			'Amiri'                     => 'Amiri',
			'Amita'                     => 'Amita',
			'Anaheim'                   => 'Anaheim',
			'Andada'                    => 'Andada',
			'Andika'                    => 'Andika',
			'Angkor'                    => 'Angkor',
			'Annie Use Your Telescope'  => 'Annie Use Your Telescope',
			'Anonymous Pro'             => 'Anonymous Pro',
			'Antic'                     => 'Antic',
			'Antic Didone'              => 'Antic Didone',
			'Antic Slab'                => 'Antic Slab',
			'Anton'                     => 'Anton',
			'Arapey'                    => 'Arapey',
			'Arbutus'                   => 'Arbutus',
			'Arbutus Slab'              => 'Arbutus Slab',
			'Architects Daughter'       => 'Architects Daughter',
			'Archivo Black'             => 'Archivo Black',
			'Archivo Narrow'            => 'Archivo Narrow',
			'Aref Ruqaa'                => 'Aref Ruqaa',
			'Arima Madurai'             => 'Arima Madurai',
			'Arimo'                     => 'Arimo',
			'Arizonia'                  => 'Arizonia',
			'Armata'                    => 'Armata',
			'Arsenal'                   => 'Arsenal',
			'Artifika'                  => 'Artifika',
			'Arvo'                      => 'Arvo',
			'Arya'                      => 'Arya',
			'Asap'                      => 'Asap',
			'Asar'                      => 'Asar',
			'Asset'                     => 'Asset',
			'Assistant'                 => 'Assistant',
			'Astloch'                   => 'Astloch',
			'Asul'                      => 'Asul',
			'Athiti'                    => 'Athiti',
			'Atma'                      => 'Atma',
			'Atomic Age'                => 'Atomic Age',
			'Aubrey'                    => 'Aubrey',
			'Audiowide'                 => 'Audiowide',
			'Autour One'                => 'Autour One',
			'Average'                   => 'Average',
			'Average Sans'              => 'Average Sans',
			'Averia Gruesa Libre'       => 'Averia Gruesa Libre',
			'Averia Libre'              => 'Averia Libre',
			'Averia Sans Libre'         => 'Averia Sans Libre',
			'Averia Serif Libre'        => 'Averia Serif Libre',
			'Bad Script'                => 'Bad Script',
			'Bahiana'                   => 'Bahiana',
			'Baloo'                     => 'Baloo',
			'Baloo Bhai'                => 'Baloo Bhai',
			'Baloo Bhaina'              => 'Baloo Bhaina',
			'Baloo Chettan'             => 'Baloo Chettan',
			'Baloo Da'                  => 'Baloo Da',
			'Baloo Paaji'               => 'Baloo Paaji',
			'Baloo Tamma'               => 'Baloo Tamma',
			'Baloo Thambi'              => 'Baloo Thambi',
			'Balthazar'                 => 'Balthazar',
			'Bangers'                   => 'Bangers',
			'Barrio'                    => 'Barrio',
			'Basic'                     => 'Basic',
			'Battambang'                => 'Battambang',
			'Baumans'                   => 'Baumans',
			'Bayon'                     => 'Bayon',
			'Belgrano'                  => 'Belgrano',
			'Belleza'                   => 'Belleza',
			'BenchNine'                 => 'BenchNine',
			'Bentham'                   => 'Bentham',
			'Berkshire Swash'           => 'Berkshire Swash',
			'Bevan'                     => 'Bevan',
			'Bigelow Rules'             => 'Bigelow Rules',
			'Bigshot One'               => 'Bigshot One',
			'Bilbo'                     => 'Bilbo',
			'Bilbo Swash Caps'          => 'Bilbo Swash Caps',
			'BioRhyme'                  => 'BioRhyme',
			'BioRhyme Expanded'         => 'BioRhyme Expanded',
			'Biryani'                   => 'Biryani',
			'Bitter'                    => 'Bitter',
			'Black Ops One'             => 'Black Ops One',
			'Bokor'                     => 'Bokor',
			'Bonbon'                    => 'Bonbon',
			'Boogaloo'                  => 'Boogaloo',
			'Bowlby One'                => 'Bowlby One',
			'Bowlby One SC'             => 'Bowlby One SC',
			'Brawler'                   => 'Brawler',
			'Bree Serif'                => 'Bree Serif',
			'Bubblegum Sans'            => 'Bubblegum Sans',
			'Bubbler One'               => 'Bubbler One',
			'Buda'                      => 'Buda',
			'Buenard'                   => 'Buenard',
			'Bungee'                    => 'Bungee',
			'Bungee Hairline'           => 'Bungee Hairline',
			'Bungee Inline'             => 'Bungee Inline',
			'Bungee Outline'            => 'Bungee Outline',
			'Bungee Shade'              => 'Bungee Shade',
			'Butcherman'                => 'Butcherman',
			'Butterfly Kids'            => 'Butterfly Kids',
			'Cabin'                     => 'Cabin',
			'Cabin Condensed'           => 'Cabin Condensed',
			'Cabin Sketch'              => 'Cabin Sketch',
			'Caesar Dressing'           => 'Caesar Dressing',
			'Cagliostro'                => 'Cagliostro',
			'Cairo'                     => 'Cairo',
			'Calligraffitti'            => 'Calligraffitti',
			'Cambay'                    => 'Cambay',
			'Cambo'                     => 'Cambo',
			'Candal'                    => 'Candal',
			'Cantarell'                 => 'Cantarell',
			'Cantata One'               => 'Cantata One',
			'Cantora One'               => 'Cantora One',
			'Capriola'                  => 'Capriola',
			'Cardo'                     => 'Cardo',
			'Carme'                     => 'Carme',
			'Carrois Gothic'            => 'Carrois Gothic',
			'Carrois Gothic SC'         => 'Carrois Gothic SC',
			'Carter One'                => 'Carter One',
			'Catamaran'                 => 'Catamaran',
			'Caudex'                    => 'Caudex',
			'Caveat'                    => 'Caveat',
			'Caveat Brush'              => 'Caveat Brush',
			'Cedarville Cursive'        => 'Cedarville Cursive',
			'Ceviche One'               => 'Ceviche One',
			'Changa'                    => 'Changa',
			'Changa One'                => 'Changa One',
			'Chango'                    => 'Chango',
			'Chathura'                  => 'Chathura',
			'Chau Philomene One'        => 'Chau Philomene One',
			'Chela One'                 => 'Chela One',
			'Chelsea Market'            => 'Chelsea Market',
			'Chenla'                    => 'Chenla',
			'Cherry Cream Soda'         => 'Cherry Cream Soda',
			'Cherry Swash'              => 'Cherry Swash',
			'Chewy'                     => 'Chewy',
			'Chicle'                    => 'Chicle',
			'Chivo'                     => 'Chivo',
			'Chonburi'                  => 'Chonburi',
			'Cinzel'                    => 'Cinzel',
			'Cinzel Decorative'         => 'Cinzel Decorative',
			'Clicker Script'            => 'Clicker Script',
			'Coda'                      => 'Coda',
			'Coda Caption'              => 'Coda Caption',
			'Codystar'                  => 'Codystar',
			'Coiny'                     => 'Coiny',
			'Combo'                     => 'Combo',
			'Comfortaa'                 => 'Comfortaa',
			'Coming Soon'               => 'Coming Soon',
			'Concert One'               => 'Concert One',
			'Condiment'                 => 'Condiment',
			'Content'                   => 'Content',
			'Contrail One'              => 'Contrail One',
			'Convergence'               => 'Convergence',
			'Cookie'                    => 'Cookie',
			'Copse'                     => 'Copse',
			'Corben'                    => 'Corben',
			'Cormorant'                 => 'Cormorant',
			'Cormorant Garamond'        => 'Cormorant Garamond',
			'Cormorant Infant'          => 'Cormorant Infant',
			'Cormorant SC'              => 'Cormorant SC',
			'Cormorant Unicase'         => 'Cormorant Unicase',
			'Cormorant Upright'         => 'Cormorant Upright',
			'Courgette'                 => 'Courgette',
			'Cousine'                   => 'Cousine',
			'Coustard'                  => 'Coustard',
			'Covered By Your Grace'     => 'Covered By Your Grace',
			'Crafty Girls'              => 'Crafty Girls',
			'Creepster'                 => 'Creepster',
			'Crete Round'               => 'Crete Round',
			'Crimson Text'              => 'Crimson Text',
			'Croissant One'             => 'Croissant One',
			'Crushed'                   => 'Crushed',
			'Cuprum'                    => 'Cuprum',
			'Cutive'                    => 'Cutive',
			'Cutive Mono'               => 'Cutive Mono',
			'Damion'                    => 'Damion',
			'Dancing Script'            => 'Dancing Script',
			'Dangrek'                   => 'Dangrek',
			'David Libre'               => 'David Libre',
			'Dawning of a New Day'      => 'Dawning of a New Day',
			'Days One'                  => 'Days One',
			'Dekko'                     => 'Dekko',
			'Delius'                    => 'Delius',
			'Delius Swash Caps'         => 'Delius Swash Caps',
			'Delius Unicase'            => 'Delius Unicase',
			'Della Respira'             => 'Della Respira',
			'Denk One'                  => 'Denk One',
			'Devonshire'                => 'Devonshire',
			'Dhurjati'                  => 'Dhurjati',
			'Didact Gothic'             => 'Didact Gothic',
			'Diplomata'                 => 'Diplomata',
			'Diplomata SC'              => 'Diplomata SC',
			'Domine'                    => 'Domine',
			'Donegal One'               => 'Donegal One',
			'Doppio One'                => 'Doppio One',
			'Dorsa'                     => 'Dorsa',
			'Dosis'                     => 'Dosis',
			'Dr Sugiyama'               => 'Dr Sugiyama',
			'Droid Sans'                => 'Droid Sans',
			'Droid Sans Mono'           => 'Droid Sans Mono',
			'Droid Serif'               => 'Droid Serif',
			'Duru Sans'                 => 'Duru Sans',
			'Dynalight'                 => 'Dynalight',
			'EB Garamond'               => 'EB Garamond',
			'Eagle Lake'                => 'Eagle Lake',
			'Eater'                     => 'Eater',
			'Economica'                 => 'Economica',
			'Eczar'                     => 'Eczar',
			'Ek Mukta'                  => 'Ek Mukta',
			'El Messiri'                => 'El Messiri',
			'Electrolize'               => 'Electrolize',
			'Elsie'                     => 'Elsie',
			'Elsie Swash Caps'          => 'Elsie Swash Caps',
			'Emblema One'               => 'Emblema One',
			'Emilys Candy'              => 'Emilys Candy',
			'Engagement'                => 'Engagement',
			'Englebert'                 => 'Englebert',
			'Enriqueta'                 => 'Enriqueta',
			'Erica One'                 => 'Erica One',
			'Esteban'                   => 'Esteban',
			'Euphoria Script'           => 'Euphoria Script',
			'Ewert'                     => 'Ewert',
			'Exo'                       => 'Exo',
			'Exo 2'                     => 'Exo 2',
			'Expletus Sans'             => 'Expletus Sans',
			'Fanwood Text'              => 'Fanwood Text',
			'Farsan'                    => 'Farsan',
			'Fascinate'                 => 'Fascinate',
			'Fascinate Inline'          => 'Fascinate Inline',
			'Faster One'                => 'Faster One',
			'Fasthand'                  => 'Fasthand',
			'Fauna One'                 => 'Fauna One',
			'Federant'                  => 'Federant',
			'Federo'                    => 'Federo',
			'Felipa'                    => 'Felipa',
			'Fenix'                     => 'Fenix',
			'Finger Paint'              => 'Finger Paint',
			'Fira Mono'                 => 'Fira Mono',
			'Fira Sans'                 => 'Fira Sans',
			'Fira Sans Condensed'       => 'Fira Sans Condensed',
			'Fira Sans Extra Condensed' => 'Fira Sans Extra Condensed',
			'Fjalla One'                => 'Fjalla One',
			'Fjord One'                 => 'Fjord One',
			'Flamenco'                  => 'Flamenco',
			'Flavors'                   => 'Flavors',
			'Fondamento'                => 'Fondamento',
			'Fontdiner Swanky'          => 'Fontdiner Swanky',
			'Forum'                     => 'Forum',
			'Francois One'              => 'Francois One',
			'Frank Ruhl Libre'          => 'Frank Ruhl Libre',
			'Freckle Face'              => 'Freckle Face',
			'Fredericka the Great'      => 'Fredericka the Great',
			'Fredoka One'               => 'Fredoka One',
			'Freehand'                  => 'Freehand',
			'Fresca'                    => 'Fresca',
			'Frijole'                   => 'Frijole',
			'Fruktur'                   => 'Fruktur',
			'Fugaz One'                 => 'Fugaz One',
			'GFS Didot'                 => 'GFS Didot',
			'GFS Neohellenic'           => 'GFS Neohellenic',
			'Gabriela'                  => 'Gabriela',
			'Gafata'                    => 'Gafata',
			'Galada'                    => 'Galada',
			'Galdeano'                  => 'Galdeano',
			'Galindo'                   => 'Galindo',
			'Gentium Basic'             => 'Gentium Basic',
			'Gentium Book Basic'        => 'Gentium Book Basic',
			'Geo'                       => 'Geo',
			'Geostar'                   => 'Geostar',
			'Geostar Fill'              => 'Geostar Fill',
			'Germania One'              => 'Germania One',
			'Gidugu'                    => 'Gidugu',
			'Gilda Display'             => 'Gilda Display',
			'Give You Glory'            => 'Give You Glory',
			'Glass Antiqua'             => 'Glass Antiqua',
			'Glegoo'                    => 'Glegoo',
			'Gloria Hallelujah'         => 'Gloria Hallelujah',
			'Goblin One'                => 'Goblin One',
			'Gochi Hand'                => 'Gochi Hand',
			'Gorditas'                  => 'Gorditas',
			'Goudy Bookletter 1911'     => 'Goudy Bookletter 1911',
			'Graduate'                  => 'Graduate',
			'Grand Hotel'               => 'Grand Hotel',
			'Gravitas One'              => 'Gravitas One',
			'Great Vibes'               => 'Great Vibes',
			'Griffy'                    => 'Griffy',
			'Gruppo'                    => 'Gruppo',
			'Gudea'                     => 'Gudea',
			'Gurajada'                  => 'Gurajada',
			'Habibi'                    => 'Habibi',
			'Halant'                    => 'Halant',
			'Hammersmith One'           => 'Hammersmith One',
			'Hanalei'                   => 'Hanalei',
			'Hanalei Fill'              => 'Hanalei Fill',
			'Handlee'                   => 'Handlee',
			'Hanuman'                   => 'Hanuman',
			'Happy Monkey'              => 'Happy Monkey',
			'Harmattan'                 => 'Harmattan',
			'Headland One'              => 'Headland One',
			'Heebo'                     => 'Heebo',
			'Henny Penny'               => 'Henny Penny',
			'Herr Von Muellerhoff'      => 'Herr Von Muellerhoff',
			'Hind'                      => 'Hind',
			'Hind Guntur'               => 'Hind Guntur',
			'Hind Madurai'              => 'Hind Madurai',
			'Hind Siliguri'             => 'Hind Siliguri',
			'Hind Vadodara'             => 'Hind Vadodara',
			'Holtwood One SC'           => 'Holtwood One SC',
			'Homemade Apple'            => 'Homemade Apple',
			'Homenaje'                  => 'Homenaje',
			'IM Fell DW Pica'           => 'IM Fell DW Pica',
			'IM Fell DW Pica SC'        => 'IM Fell DW Pica SC',
			'IM Fell Double Pica'       => 'IM Fell Double Pica',
			'IM Fell Double Pica SC'    => 'IM Fell Double Pica SC',
			'IM Fell English'           => 'IM Fell English',
			'IM Fell English SC'        => 'IM Fell English SC',
			'IM Fell French Canon'      => 'IM Fell French Canon',
			'IM Fell French Canon SC'   => 'IM Fell French Canon SC',
			'IM Fell Great Primer'      => 'IM Fell Great Primer',
			'IM Fell Great Primer SC'   => 'IM Fell Great Primer SC',
			'Iceberg'                   => 'Iceberg',
			'Iceland'                   => 'Iceland',
			'Imprima'                   => 'Imprima',
			'Inconsolata'               => 'Inconsolata',
			'Inder'                     => 'Inder',
			'Indie Flower'              => 'Indie Flower',
			'Inika'                     => 'Inika',
			'Inknut Antiqua'            => 'Inknut Antiqua',
			'Irish Grover'              => 'Irish Grover',
			'Istok Web'                 => 'Istok Web',
			'Italiana'                  => 'Italiana',
			'Italianno'                 => 'Italianno',
			'Itim'                      => 'Itim',
			'Jacques Francois'          => 'Jacques Francois',
			'Jacques Francois Shadow'   => 'Jacques Francois Shadow',
			'Jaldi'                     => 'Jaldi',
			'Jim Nightshade'            => 'Jim Nightshade',
			'Jockey One'                => 'Jockey One',
			'Jolly Lodger'              => 'Jolly Lodger',
			'Jomhuria'                  => 'Jomhuria',
			'Josefin Sans'              => 'Josefin Sans',
			'Josefin Slab'              => 'Josefin Slab',
			'Joti One'                  => 'Joti One',
			'Judson'                    => 'Judson',
			'Julee'                     => 'Julee',
			'Julius Sans One'           => 'Julius Sans One',
			'Junge'                     => 'Junge',
			'Jura'                      => 'Jura',
			'Just Another Hand'         => 'Just Another Hand',
			'Just Me Again Down Here'   => 'Just Me Again Down Here',
			'Kadwa'                     => 'Kadwa',
			'Kalam'                     => 'Kalam',
			'Kameron'                   => 'Kameron',
			'Kanit'                     => 'Kanit',
			'Kantumruy'                 => 'Kantumruy',
			'Karla'                     => 'Karla',
			'Karma'                     => 'Karma',
			'Katibeh'                   => 'Katibeh',
			'Kaushan Script'            => 'Kaushan Script',
			'Kavivanar'                 => 'Kavivanar',
			'Kavoon'                    => 'Kavoon',
			'Kdam Thmor'                => 'Kdam Thmor',
			'Keania One'                => 'Keania One',
			'Kelly Slab'                => 'Kelly Slab',
			'Kenia'                     => 'Kenia',
			'Khand'                     => 'Khand',
			'Khmer'                     => 'Khmer',
			'Khula'                     => 'Khula',
			'Kite One'                  => 'Kite One',
			'Knewave'                   => 'Knewave',
			'Kotta One'                 => 'Kotta One',
			'Koulen'                    => 'Koulen',
			'Kranky'                    => 'Kranky',
			'Kreon'                     => 'Kreon',
			'Kristi'                    => 'Kristi',
			'Krona One'                 => 'Krona One',
			'Kumar One'                 => 'Kumar One',
			'Kumar One Outline'         => 'Kumar One Outline',
			'Kurale'                    => 'Kurale',
			'La Belle Aurore'           => 'La Belle Aurore',
			'Laila'                     => 'Laila',
			'Lakki Reddy'               => 'Lakki Reddy',
			'Lalezar'                   => 'Lalezar',
			'Lancelot'                  => 'Lancelot',
			'Lateef'                    => 'Lateef',
			'Lato'                      => 'Lato',
			'League Script'             => 'League Script',
			'Leckerli One'              => 'Leckerli One',
			'Ledger'                    => 'Ledger',
			'Lekton'                    => 'Lekton',
			'Lemon'                     => 'Lemon',
			'Lemonada'                  => 'Lemonada',
			'Libre Baskerville'         => 'Libre Baskerville',
			'Libre Franklin'            => 'Libre Franklin',
			'Life Savers'               => 'Life Savers',
			'Lilita One'                => 'Lilita One',
			'Lily Script One'           => 'Lily Script One',
			'Limelight'                 => 'Limelight',
			'Linden Hill'               => 'Linden Hill',
			'Lobster'                   => 'Lobster',
			'Lobster Two'               => 'Lobster Two',
			'Londrina Outline'          => 'Londrina Outline',
			'Londrina Shadow'           => 'Londrina Shadow',
			'Londrina Sketch'           => 'Londrina Sketch',
			'Londrina Solid'            => 'Londrina Solid',
			'Lora'                      => 'Lora',
			'Love Ya Like A Sister'     => 'Love Ya Like A Sister',
			'Loved by the King'         => 'Loved by the King',
			'Lovers Quarrel'            => 'Lovers Quarrel',
			'Luckiest Guy'              => 'Luckiest Guy',
			'Lusitana'                  => 'Lusitana',
			'Lustria'                   => 'Lustria',
			'Macondo'                   => 'Macondo',
			'Macondo Swash Caps'        => 'Macondo Swash Caps',
			'Mada'                      => 'Mada',
			'Magra'                     => 'Magra',
			'Maiden Orange'             => 'Maiden Orange',
			'Maitree'                   => 'Maitree',
			'Mako'                      => 'Mako',
			'Mallanna'                  => 'Mallanna',
			'Mandali'                   => 'Mandali',
			'Marcellus'                 => 'Marcellus',
			'Marcellus SC'              => 'Marcellus SC',
			'Marck Script'              => 'Marck Script',
			'Margarine'                 => 'Margarine',
			'Marko One'                 => 'Marko One',
			'Marmelad'                  => 'Marmelad',
			'Martel'                    => 'Martel',
			'Martel Sans'               => 'Martel Sans',
			'Marvel'                    => 'Marvel',
			'Mate'                      => 'Mate',
			'Mate SC'                   => 'Mate SC',
			'Maven Pro'                 => 'Maven Pro',
			'McLaren'                   => 'McLaren',
			'Meddon'                    => 'Meddon',
			'MedievalSharp'             => 'MedievalSharp',
			'Medula One'                => 'Medula One',
			'Meera Inimai'              => 'Meera Inimai',
			'Megrim'                    => 'Megrim',
			'Meie Script'               => 'Meie Script',
			'Merienda'                  => 'Merienda',
			'Merienda One'              => 'Merienda One',
			'Merriweather'              => 'Merriweather',
			'Merriweather Sans'         => 'Merriweather Sans',
			'Metal'                     => 'Metal',
			'Metal Mania'               => 'Metal Mania',
			'Metamorphous'              => 'Metamorphous',
			'Metrophobic'               => 'Metrophobic',
			'Michroma'                  => 'Michroma',
			'Milonga'                   => 'Milonga',
			'Miltonian'                 => 'Miltonian',
			'Miltonian Tattoo'          => 'Miltonian Tattoo',
			'Miniver'                   => 'Miniver',
			'Miriam Libre'              => 'Miriam Libre',
			'Mirza'                     => 'Mirza',
			'Miss Fajardose'            => 'Miss Fajardose',
			'Mitr'                      => 'Mitr',
			'Modak'                     => 'Modak',
			'Modern Antiqua'            => 'Modern Antiqua',
			'Mogra'                     => 'Mogra',
			'Molengo'                   => 'Molengo',
			'Molle'                     => 'Molle',
			'Monda'                     => 'Monda',
			'Monofett'                  => 'Monofett',
			'Monoton'                   => 'Monoton',
			'Monsieur La Doulaise'      => 'Monsieur La Doulaise',
			'Montaga'                   => 'Montaga',
			'Montez'                    => 'Montez',
			'Montserrat'                => 'Montserrat',
			'Montserrat Alternates'     => 'Montserrat Alternates',
			'Montserrat Subrayada'      => 'Montserrat Subrayada',
			'Moul'                      => 'Moul',
			'Moulpali'                  => 'Moulpali',
			'Mountains of Christmas'    => 'Mountains of Christmas',
			'Mouse Memoirs'             => 'Mouse Memoirs',
			'Mr Bedfort'                => 'Mr Bedfort',
			'Mr Dafoe'                  => 'Mr Dafoe',
			'Mr De Haviland'            => 'Mr De Haviland',
			'Mrs Saint Delafield'       => 'Mrs Saint Delafield',
			'Mrs Sheppards'             => 'Mrs Sheppards',
			'Mukta Vaani'               => 'Mukta Vaani',
			'Muli'                      => 'Muli',
			'Mystery Quest'             => 'Mystery Quest',
			'NTR'                       => 'NTR',
			'Neucha'                    => 'Neucha',
			'Neuton'                    => 'Neuton',
			'New Rocker'                => 'New Rocker',
			'News Cycle'                => 'News Cycle',
			'Niconne'                   => 'Niconne',
			'Nixie One'                 => 'Nixie One',
			'Nobile'                    => 'Nobile',
			'Nokora'                    => 'Nokora',
			'Norican'                   => 'Norican',
			'Nosifer'                   => 'Nosifer',
			'Nothing You Could Do'      => 'Nothing You Could Do',
			'Noticia Text'              => 'Noticia Text',
			'Noto Sans'                 => 'Noto Sans',
			'Noto Serif'                => 'Noto Serif',
			'Nova Cut'                  => 'Nova Cut',
			'Nova Flat'                 => 'Nova Flat',
			'Nova Mono'                 => 'Nova Mono',
			'Nova Oval'                 => 'Nova Oval',
			'Nova Round'                => 'Nova Round',
			'Nova Script'               => 'Nova Script',
			'Nova Slim'                 => 'Nova Slim',
			'Nova Square'               => 'Nova Square',
			'Numans'                    => 'Numans',
			'Nunito'                    => 'Nunito',
			'Nunito Sans'               => 'Nunito Sans',
			'Odor Mean Chey'            => 'Odor Mean Chey',
			'Offside'                   => 'Offside',
			'Old Standard TT'           => 'Old Standard TT',
			'Oldenburg'                 => 'Oldenburg',
			'Oleo Script'               => 'Oleo Script',
			'Oleo Script Swash Caps'    => 'Oleo Script Swash Caps',
			'Open Sans'                 => 'Open Sans',
			'Open Sans Condensed'       => 'Open Sans Condensed',
			'Oranienbaum'               => 'Oranienbaum',
			'Orbitron'                  => 'Orbitron',
			'Oregano'                   => 'Oregano',
			'Orienta'                   => 'Orienta',
			'Original Surfer'           => 'Original Surfer',
			'Oswald'                    => 'Oswald',
			'Over the Rainbow'          => 'Over the Rainbow',
			'Overlock'                  => 'Overlock',
			'Overlock SC'               => 'Overlock SC',
			'Overpass'                  => 'Overpass',
			'Overpass Mono'             => 'Overpass Mono',
			'Ovo'                       => 'Ovo',
			'Oxygen'                    => 'Oxygen',
			'Oxygen Mono'               => 'Oxygen Mono',
			'PT Mono'                   => 'PT Mono',
			'PT Sans'                   => 'PT Sans',
			'PT Sans Caption'           => 'PT Sans Caption',
			'PT Sans Narrow'            => 'PT Sans Narrow',
			'PT Serif'                  => 'PT Serif',
			'PT Serif Caption'          => 'PT Serif Caption',
			'Pacifico'                  => 'Pacifico',
			'Padauk'                    => 'Padauk',
			'Palanquin'                 => 'Palanquin',
			'Palanquin Dark'            => 'Palanquin Dark',
			'Pangolin'                  => 'Pangolin',
			'Paprika'                   => 'Paprika',
			'Parisienne'                => 'Parisienne',
			'Passero One'               => 'Passero One',
			'Passion One'               => 'Passion One',
			'Pathway Gothic One'        => 'Pathway Gothic One',
			'Patrick Hand'              => 'Patrick Hand',
			'Patrick Hand SC'           => 'Patrick Hand SC',
			'Pattaya'                   => 'Pattaya',
			'Patua One'                 => 'Patua One',
			'Pavanam'                   => 'Pavanam',
			'Paytone One'               => 'Paytone One',
			'Peddana'                   => 'Peddana',
			'Peralta'                   => 'Peralta',
			'Permanent Marker'          => 'Permanent Marker',
			'Petit Formal Script'       => 'Petit Formal Script',
			'Petrona'                   => 'Petrona',
			'Philosopher'               => 'Philosopher',
			'Piedra'                    => 'Piedra',
			'Pinyon Script'             => 'Pinyon Script',
			'Pirata One'                => 'Pirata One',
			'Plaster'                   => 'Plaster',
			'Play'                      => 'Play',
			'Playball'                  => 'Playball',
			'Playfair Display'          => 'Playfair Display',
			'Playfair Display SC'       => 'Playfair Display SC',
			'Podkova'                   => 'Podkova',
			'Poiret One'                => 'Poiret One',
			'Poller One'                => 'Poller One',
			'Poly'                      => 'Poly',
			'Pompiere'                  => 'Pompiere',
			'Pontano Sans'              => 'Pontano Sans',
			'Poppins'                   => 'Poppins',
			'Port Lligat Sans'          => 'Port Lligat Sans',
			'Port Lligat Slab'          => 'Port Lligat Slab',
			'Pragati Narrow'            => 'Pragati Narrow',
			'Prata'                     => 'Prata',
			'Preahvihear'               => 'Preahvihear',
			'Press Start 2P'            => 'Press Start 2P',
			'Pridi'                     => 'Pridi',
			'Princess Sofia'            => 'Princess Sofia',
			'Prociono'                  => 'Prociono',
			'Prompt'                    => 'Prompt',
			'Prosto One'                => 'Prosto One',
			'Proza Libre'               => 'Proza Libre',
			'Puritan'                   => 'Puritan',
			'Purple Purse'              => 'Purple Purse',
			'Quando'                    => 'Quando',
			'Quantico'                  => 'Quantico',
			'Quattrocento'              => 'Quattrocento',
			'Quattrocento Sans'         => 'Quattrocento Sans',
			'Questrial'                 => 'Questrial',
			'Quicksand'                 => 'Quicksand',
			'Quintessential'            => 'Quintessential',
			'Qwigley'                   => 'Qwigley',
			'Racing Sans One'           => 'Racing Sans One',
			'Radley'                    => 'Radley',
			'Rajdhani'                  => 'Rajdhani',
			'Rakkas'                    => 'Rakkas',
			'Raleway'                   => 'Raleway',
			'Raleway Dots'              => 'Raleway Dots',
			'Ramabhadra'                => 'Ramabhadra',
			'Ramaraja'                  => 'Ramaraja',
			'Rambla'                    => 'Rambla',
			'Rammetto One'              => 'Rammetto One',
			'Ranchers'                  => 'Ranchers',
			'Rancho'                    => 'Rancho',
			'Ranga'                     => 'Ranga',
			'Rasa'                      => 'Rasa',
			'Rationale'                 => 'Rationale',
			'Ravi Prakash'              => 'Ravi Prakash',
			'Redressed'                 => 'Redressed',
			'Reem Kufi'                 => 'Reem Kufi',
			'Reenie Beanie'             => 'Reenie Beanie',
			'Revalia'                   => 'Revalia',
			'Rhodium Libre'             => 'Rhodium Libre',
			'Ribeye'                    => 'Ribeye',
			'Ribeye Marrow'             => 'Ribeye Marrow',
			'Righteous'                 => 'Righteous',
			'Risque'                    => 'Risque',
			'Roboto:400,300,100'        => 'Roboto',
			'Roboto Condensed'          => 'Roboto Condensed',
			'Roboto Mono'               => 'Roboto Mono',
			'Roboto+Slab:700,400'       => 'Roboto Slab',
			'Rochester'                 => 'Rochester',
			'Rock Salt'                 => 'Rock Salt',
			'Rokkitt'                   => 'Rokkitt',
			'Romanesco'                 => 'Romanesco',
			'Ropa Sans'                 => 'Ropa Sans',
			'Rosario'                   => 'Rosario',
			'Rosarivo'                  => 'Rosarivo',
			'Rouge Script'              => 'Rouge Script',
			'Rozha One'                 => 'Rozha One',
			'Rubik'                     => 'Rubik',
			'Rubik Mono One'            => 'Rubik Mono One',
			'Ruda'                      => 'Ruda',
			'Rufina'                    => 'Rufina',
			'Ruge Boogie'               => 'Ruge Boogie',
			'Ruluko'                    => 'Ruluko',
			'Rum Raisin'                => 'Rum Raisin',
			'Ruslan Display'            => 'Ruslan Display',
			'Russo One'                 => 'Russo One',
			'Ruthie'                    => 'Ruthie',
			'Rye'                       => 'Rye',
			'Sacramento'                => 'Sacramento',
			'Sahitya'                   => 'Sahitya',
			'Sail'                      => 'Sail',
			'Salsa'                     => 'Salsa',
			'Sanchez'                   => 'Sanchez',
			'Sancreek'                  => 'Sancreek',
			'Sansita'                   => 'Sansita',
			'Sarala'                    => 'Sarala',
			'Sarina'                    => 'Sarina',
			'Sarpanch'                  => 'Sarpanch',
			'Satisfy'                   => 'Satisfy',
			'Scada'                     => 'Scada',
			'Scheherazade'              => 'Scheherazade',
			'Schoolbell'                => 'Schoolbell',
			'Scope One'                 => 'Scope One',
			'Seaweed Script'            => 'Seaweed Script',
			'Secular One'               => 'Secular One',
			'Sevillana'                 => 'Sevillana',
			'Seymour One'               => 'Seymour One',
			'Shadows Into Light'        => 'Shadows Into Light',
			'Shadows Into Light Two'    => 'Shadows Into Light Two',
			'Shanti'                    => 'Shanti',
			'Share'                     => 'Share',
			'Share Tech'                => 'Share Tech',
			'Share Tech Mono'           => 'Share Tech Mono',
			'Shojumaru'                 => 'Shojumaru',
			'Short Stack'               => 'Short Stack',
			'Shrikhand'                 => 'Shrikhand',
			'Siemreap'                  => 'Siemreap',
			'Sigmar One'                => 'Sigmar One',
			'Signika'                   => 'Signika',
			'Signika Negative'          => 'Signika Negative',
			'Simonetta'                 => 'Simonetta',
			'Sintony'                   => 'Sintony',
			'Sirin Stencil'             => 'Sirin Stencil',
			'Six Caps'                  => 'Six Caps',
			'Skranji'                   => 'Skranji',
			'Slabo 13px'                => 'Slabo 13px',
			'Slabo 27px'                => 'Slabo 27px',
			'Slackey'                   => 'Slackey',
			'Smokum'                    => 'Smokum',
			'Smythe'                    => 'Smythe',
			'Sniglet'                   => 'Sniglet',
			'Snippet'                   => 'Snippet',
			'Snowburst One'             => 'Snowburst One',
			'Sofadi One'                => 'Sofadi One',
			'Sofia'                     => 'Sofia',
			'Sonsie One'                => 'Sonsie One',
			'Sorts Mill Goudy'          => 'Sorts Mill Goudy',
			'Source Code Pro'           => 'Source Code Pro',
			'Source Sans Pro'           => 'Source Sans Pro',
			'Source Serif Pro'          => 'Source Serif Pro',
			'Space Mono'                => 'Space Mono',
			'Special Elite'             => 'Special Elite',
			'Spicy Rice'                => 'Spicy Rice',
			'Spinnaker'                 => 'Spinnaker',
			'Spirax'                    => 'Spirax',
			'Squada One'                => 'Squada One',
			'Sree Krushnadevaraya'      => 'Sree Krushnadevaraya',
			'Sriracha'                  => 'Sriracha',
			'Stalemate'                 => 'Stalemate',
			'Stalinist One'             => 'Stalinist One',
			'Stardos Stencil'           => 'Stardos Stencil',
			'Stint Ultra Condensed'     => 'Stint Ultra Condensed',
			'Stint Ultra Expanded'      => 'Stint Ultra Expanded',
			'Stoke'                     => 'Stoke',
			'Strait'                    => 'Strait',
			'Sue Ellen Francisco'       => 'Sue Ellen Francisco',
			'Suez One'                  => 'Suez One',
			'Sumana'                    => 'Sumana',
			'Sunshiney'                 => 'Sunshiney',
			'Supermercado One'          => 'Supermercado One',
			'Sura'                      => 'Sura',
			'Suranna'                   => 'Suranna',
			'Suravaram'                 => 'Suravaram',
			'Suwannaphum'               => 'Suwannaphum',
			'Swanky and Moo Moo'        => 'Swanky and Moo Moo',
			'Syncopate'                 => 'Syncopate',
			'Tangerine'                 => 'Tangerine',
			'Taprom'                    => 'Taprom',
			'Tauri'                     => 'Tauri',
			'Taviraj'                   => 'Taviraj',
			'Teko'                      => 'Teko',
			'Telex'                     => 'Telex',
			'Tenali Ramakrishna'        => 'Tenali Ramakrishna',
			'Tenor Sans'                => 'Tenor Sans',
			'Text Me One'               => 'Text Me One',
			'The Girl Next Door'        => 'The Girl Next Door',
			'Tienne'                    => 'Tienne',
			'Tillana'                   => 'Tillana',
			'Timmana'                   => 'Timmana',
			'Tinos'                     => 'Tinos',
			'Titan One'                 => 'Titan One',
			'Titillium Web'             => 'Titillium Web',
			'Trade Winds'               => 'Trade Winds',
			'Trirong'                   => 'Trirong',
			'Trocchi'                   => 'Trocchi',
			'Trochut'                   => 'Trochut',
			'Trykker'                   => 'Trykker',
			'Tulpen One'                => 'Tulpen One',
			'Ubuntu'                    => 'Ubuntu',
			'Ubuntu Condensed'          => 'Ubuntu Condensed',
			'Ubuntu Mono'               => 'Ubuntu Mono',
			'Ultra'                     => 'Ultra',
			'Uncial Antiqua'            => 'Uncial Antiqua',
			'Underdog'                  => 'Underdog',
			'Unica One'                 => 'Unica One',
			'UnifrakturCook'            => 'UnifrakturCook',
			'UnifrakturMaguntia'        => 'UnifrakturMaguntia',
			'Unkempt'                   => 'Unkempt',
			'Unlock'                    => 'Unlock',
			'Unna'                      => 'Unna',
			'VT323'                     => 'VT323',
			'Vampiro One'               => 'Vampiro One',
			'Varela'                    => 'Varela',
			'Varela Round'              => 'Varela Round',
			'Vast Shadow'               => 'Vast Shadow',
			'Vesper Libre'              => 'Vesper Libre',
			'Vibur'                     => 'Vibur',
			'Vidaloka'                  => 'Vidaloka',
			'Viga'                      => 'Viga',
			'Voces'                     => 'Voces',
			'Volkhov'                   => 'Volkhov',
			'Vollkorn'                  => 'Vollkorn',
			'Voltaire'                  => 'Voltaire',
			'Waiting for the Sunrise'   => 'Waiting for the Sunrise',
			'Wallpoet'                  => 'Wallpoet',
			'Walter Turncoat'           => 'Walter Turncoat',
			'Warnes'                    => 'Warnes',
			'Wellfleet'                 => 'Wellfleet',
			'Wendy One'                 => 'Wendy One',
			'Wire One'                  => 'Wire One',
			'Work Sans'                 => 'Work Sans',
			'Yanone Kaffeesatz'         => 'Yanone Kaffeesatz',
			'Yantramanav'               => 'Yantramanav',
			'Yatra One'                 => 'Yatra One',
			'Yellowtail'                => 'Yellowtail',
			'Yeseva One'                => 'Yeseva One',
			'Yesteryear'                => 'Yesteryear',
			'Yrsa'                      => 'Yrsa',
			'Zeyada'                    => 'Zeyada',
		);

		return $ample_google_font;
	}

endif;
