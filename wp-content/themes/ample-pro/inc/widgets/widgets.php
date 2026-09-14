<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0
 */

/**
 * Register widget area.
 *
 */
add_action( 'widgets_init', 'ample_widgets_init' );
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function ample_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'ample' ),
		'id'            => 'ample_right_sidebar',
		'description'   => __( 'Shows widgets at right side.', 'ample' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'ample' ),
		'id'            => 'ample_left_sidebar',
		'description'   => __( 'Shows widgets at left side.', 'ample' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Sidebar', 'ample' ),
		'id'            => 'ample_business_sidebar',
		'description'   => __( 'Shows widgets on Business Page Template.', 'ample' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="inner-wrap clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Sidebar Two', 'ample' ),
		'id'            => 'ample_business_sidebar_two',
		'description'   => __( 'Shows widgets on Business Template Two.', 'ample' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="inner-wrap clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Sidebar Three', 'ample' ),
		'id'            => 'ample_business_sidebar_three',
		'description'   => __( 'Shows widgets on Business Template Three.', 'ample' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="inner-wrap clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Sidebar Four', 'ample' ),
		'id'            => 'ample_business_sidebar_four',
		'description'   => __( 'Shows widgets on Business Template Four.', 'ample' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="inner-wrap clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Sidebar Five', 'ample' ),
		'id'            => 'ample_business_sidebar_five',
		'description'   => __( 'Shows widgets on Business Template Five.', 'ample' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="inner-wrap clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'One Page Sidebar', 'ample' ),
		'id'            => 'ample_onepage_sidebar',
		'description'   => __( 'Shows widgets on One Page Template.', 'ample' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="inner-wrap clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Registering woocommerce sidebar
	if ( class_exists( 'woocommerce' ) ) {
		register_sidebar( array(
			'name'          => __( 'Shop Sidebar', 'ample' ),
			'id'            => 'ample_woocommerce_sidebar',
			'description'   => __( 'Widget area for WooCommerce Pages.', 'ample' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		) );
	}
	register_sidebar( array(
		'name'          => __( 'Error 404 Page Sidebar', 'ample' ),
		'id'            => 'ample_error_404_page_sidebar',
		'description'   => __( 'Shows widgets on Error 404 page.', 'ample' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Contact Page Sidebar', 'ample' ),
		'id'            => 'ample_contact_page_sidebar',
		'description'   => __( 'Shows widgets on Right/Left side of Contact page.', 'ample' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar1', 'ample' ),
		'id'            => 'ample_footer_sidebar1',
		'description'   => __( 'Shows widgets on footer.', 'ample' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	$sidebar_num = '';
	$sidebar_num = ample_option( 'ample_footer_column_select_setting', 'four' );
	if ( $sidebar_num == 'four' || $sidebar_num == 'three' || $sidebar_num == 'two' ) {
		register_sidebar( array(
			'name'          => __( 'Footer Sidebar2', 'ample' ),
			'id'            => 'ample_footer_sidebar2',
			'description'   => __( 'Shows widgets on footer.', 'ample' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		) );
	}

	if ( $sidebar_num == 'four' || $sidebar_num == 'three' ) {
		register_sidebar( array(
			'name'          => __( 'Footer Sidebar3', 'ample' ),
			'id'            => 'ample_footer_sidebar3',
			'description'   => __( 'Shows widgets on footer.', 'ample' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		) );
	}

	if ( $sidebar_num == 'four' ) {
		register_sidebar( array(
			'name'          => __( 'Footer Sidebar4', 'ample' ),
			'id'            => 'ample_footer_sidebar4',
			'description'   => __( 'Shows widgets on footer.', 'ample' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		) );
	}

	register_widget( "ample_service_widget" );
	register_widget( "ample_portfolio_widget" );
	register_widget( "ample_call_to_action_widget" );
	register_widget( "ample_featured_posts_widget" );
	register_widget( "ample_testimonial_widget" );
	register_widget( "ample_our_clients_widget" );
	register_widget( "ample_pricing_table_widget" );
	register_widget( "ample_contact_widget" );
	register_widget( "ample_team_widget" );
	register_widget( "ample_fun_facts_widget" );
}

/**************************************************************************************/
/**
 * Include Ample widgets class.
 */
// Class: TG: Call To Action Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-call-to-action-widget.php';

// Class: TG: Contact Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-contact-widget.php';

// Class: TG: Featured Posts Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-featured-posts-widget.php';

// Class: TG: Fun Facts Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-fun-facts-widget.php';

// Class: TG: Our Clients Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-our-clients-widget.php';

// Class: TG: Portfolio Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-portfolio-widget.php';

// Class: TG: Pricing Table Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-pricing-table-widget.php';

// Class: TG: Service Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-service-widget.php';

// Class: TG: Team Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-team-widget.php';

// Class: TG: Testimonial Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-testimonial-widget.php';
