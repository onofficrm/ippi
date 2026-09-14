<?php
/**
 * amalie Customizer functionality
 *
 * @package Amalie
 * @since Amalie 1.0
 */

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Amalie 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function amalie_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'amalie_theme_options', array(
		'title'    => esc_html__( 'Front Page Featured Page', 'amalie' ),
		'priority' => 131,
	) );

	/* Front Page: Featured Page One */
	$wp_customize->add_setting( 'amalie_featured_page_one_front_page_first_block', array(
		'default'           => '',
		'sanitize_callback' => 'amalie_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control( 'amalie_featured_page_one_front_page_first_block', array(
		'label'             => esc_html__( 'Featured Page', 'amalie' ),
		'section'           => 'amalie_theme_options',
		'priority'          => 8,
		'type'              => 'dropdown-pages',
	) );


	// Add an additional description to the header image section.
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'Applies to the sidebar on wide screens.', 'amalie' );

	/**
	* Adds the individual sections for footer
	*/
	$wp_customize->add_section(
	'amalie_section_one',
		array(
			'title' => esc_html__( 'Copyright Settings', 'amalie' ),
			'priority' => 300,
		)
	);
	$wp_customize->add_setting(
	'copyright_textbox',
	array(
		'default' => esc_html__( 'Amalie by Anariel Design. All rights reserved.', 'amalie' ),
		'sanitize_callback' => 'amalie_sanitize_text',
	)
	);
	$wp_customize->add_control(
		'copyright_textbox',
		array(
			'label' => esc_html__( 'Copyright text', 'amalie' ),
			'section' => 'amalie_section_one',
			'type' => 'text',
		)
	);
	$wp_customize->add_setting(
		'hide_copyright',
		array(
		'sanitize_callback' => 'amalie_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'hide_copyright',
		array(
			'type' => 'checkbox',
			'label' => esc_html__( 'Hide copyright text', 'amalie' ),
			'section' => 'amalie_section_one',
		)
	);

	/**
	 * Adds the individual sections for custom colors
	 */
	$wp_customize->add_setting('amalie_link_color', array(
		'default'           => '#98b84c',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'amalie_link_color', array(
		'label'    => esc_html__('Change color of the green background elements like buttons etc.', 'amalie'),
		'section'  => 'colors',
		'priority' => 25,
		'settings' => 'amalie_link_color',
	)));

/* Post Settings */
$wp_customize->add_section( 'amalie_theme_options_post', array(
	'title'    => esc_html__( 'Blog Options', 'amalie' ),
	'priority' => 136,
) );

$wp_customize->add_setting( 'amalie_blog_entry_date', array(
	'default'           => false,
	'sanitize_callback' => 'amalie_sanitize_checkbox',
) );
$wp_customize->add_control('amalie_blog_entry_date', array(
	'label'      => esc_html__( 'Hide Post Date', 'amalie' ),
	'section'    => 'amalie_theme_options_post',
	'settings'   => 'amalie_blog_entry_date',
	'type'		 => 'checkbox',
	'priority'	 => 3
) );

$wp_customize->add_setting( 'amalie_blog_entry_meta', array(
	'default'           => false,
	'sanitize_callback' => 'amalie_sanitize_checkbox',
) );
$wp_customize->add_control('amalie_blog_entry_meta', array(
	'label'      => esc_html__( 'Hide Post Meta', 'amalie' ),
	'section'    => 'amalie_theme_options_post',
	'settings'   => 'amalie_blog_entry_meta',
	'type'		 => 'checkbox',
	'priority'	 => 2
) );


/***** Register Custom Controls *****/

	class Amalie_Upgrade extends WP_Customize_Control {
		public function render_content() {  ?>
			<p class="amalie-upgrade-thumb">
				<img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" />
			</p>
			<p class="textfield amalie-upgrade-text">
				<a href="<?php echo esc_url('http://www.anarieldesign.com/documentation/amalie/'); ?>" target="_blank" class="button button-secondary">
					<?php esc_html_e('Visit Documentation', 'amalie'); ?>
				</a>
			</p>
			<p class="textfield amalie-upgrade-title">
				<a href="<?php echo esc_url('http://www.anarieldesign.com/support/'); ?>" class="button button-secondary" target="_blank">
					<?php esc_html_e('Support Page', 'amalie'); ?>
				</a>
			</p>
			<p class="amalie-upgrade-button">
				<a href="http://www.anarieldesign.com/themes/" target="_blank" class="button button-secondary">
					<?php esc_html_e('More Themes by Anariel Design', 'amalie'); ?>
				</a>
			</p><?php
		}
	}

	/***** Add Sections *****/

	$wp_customize->add_section('amalie_upgrade', array(
		'title' => esc_html__('Theme Info', 'amalie'),
		'priority' => 600
	) );

	/***** Add Settings *****/

	$wp_customize->add_setting('amalie_options[premium_version_upgrade]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'esc_attr'
	) );

	/***** Add Controls *****/

	$wp_customize->add_control(new Amalie_Upgrade($wp_customize, 'premium_version_upgrade', array(
		'section' => 'amalie_upgrade',
		'settings' => 'amalie_options[premium_version_upgrade]',
		'priority' => 1
	) ) );
	

return $wp_customize;
}
add_action( 'customize_register', 'amalie_customize_register', 11 );

/**
 * Sanitization
 */
//Checkboxes
function amalie_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

//Integers
function amalie_sanitize_int( $input ) {
	if( is_numeric( $input ) ) {
		return intval( $input );
	}
}

//Text
function amalie_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

//No sanitize - empty function for options that do not require sanitization -> to bypass the Theme Check plugin
function amalie_no_sanitize( $input ) {
}

/**
 * Sanitize the dropdown pages.
 *
 * @param interger $input.
 * @return interger.
 */
function amalie_sanitize_dropdown_pages( $input ) {
	if ( is_numeric( $input ) ) {
		return intval( $input );
	}
}

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Amalie 1.0
 */
function amalie_customize_preview_js() {
	wp_enqueue_script( 'amalie-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20141216', true );
}
add_action( 'customize_preview_init', 'amalie_customize_preview_js' );
/***** Enqueue Customizer CSS *****/

function amalie_admin_customizer_css() {
	wp_enqueue_style('amalie-admin-customizer', get_template_directory_uri() . '/admin/customizer.css', array());
}
add_action('customize_controls_print_styles', 'amalie_admin_customizer_css');
/**
 * Colors Changer
 */
function amalie_customizer_css() {
	?>
	<style type="text/css">
	.button { background: <?php echo get_theme_mod( 'amalie_link_color' ); ?>; }
	input[type="button"], input[type="reset"], input[type="submit"], .widget_calendar tbody a, .sticky-post, .comment-list .reply a { background-color: <?php echo get_theme_mod( 'amalie_link_color' ); ?>!important; }
	.social-navigation a:before, .entry-content .more-link:after, .entry-summary .more-link:after { border-color: <?php echo get_theme_mod( 'amalie_link_color' ); ?>!important; }
	.social-navigation a:before, .entry-content .more-link:after, .entry-summary .more-link:after, .woocommerce ul.products li.product .price, .woocommerce span.amount { color: <?php echo get_theme_mod( 'amalie_link_color' ); ?>!important; }
	</style>
	<?php
}
add_action( 'wp_head', 'amalie_customizer_css' );