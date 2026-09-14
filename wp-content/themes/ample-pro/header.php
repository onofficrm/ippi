<?php
/**
 * The header for our theme.
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	/**
	 * This hook is important for wordpress plugins and other many things
	 */
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<?php
$background_image_url_link = ample_option( 'ample_background_image_link' );
if ( $background_image_url_link ) {
	echo '<a href="' . esc_url( $background_image_url_link ) . '" class="background-image-clickable" target="_blank"></a>';
}
?>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'ample' ); ?></a>
	<?php
	if ( ample_option( 'ample_show_header_logo_text', 'text_only' ) == 'none' ) {
		$header_extra_class = 'logo-disable';
	} else {
		$header_extra_class = '';
	}
	?>
	<header id="masthead" class="site-header <?php echo $header_extra_class; ?>" role="banner">
		<div class="header">
			<?php if ( ample_option( 'ample_activate_top_header_bar', 0 ) == 1 ) { ?>
				<div id="header-meta" class="clearfix">
					<div class="inner-wrap">
						<?php
						if ( ample_option( 'ample_activate_social_links', 0 ) == 1 ) {
							ample_social_links();
						}
						ample_header_info_text();
						?>
					</div>
				</div>
			<?php } ?>
			<?php if ( ample_option( 'ample_header_image_position', 'above' ) == 'above' ) {
				ample_render_header_image();
			} ?>

			<div class="main-head-wrap inner-wrap clearfix">
				<div id="header-left-section">
					<?php if ( ( ample_option( 'ample_show_header_logo_text', 'text_only' ) == 'both' || ample_option( 'ample_show_header_logo_text', 'text_only' ) == 'logo_only' ) ) { ?>

						<div id="header-logo-image">
							<?php
							if ( function_exists( 'the_custom_logo' ) && has_custom_logo( $blog_id = 0 ) ) {
								ample_the_custom_logo();
							} ?>
						</div><!-- #header-logo-image -->
					<?php }
					$screen_reader = '';
					if ( ( ample_option( 'ample_show_header_logo_text', 'text_only' ) == 'logo_only' || ample_option( 'ample_show_header_logo_text', 'text_only' ) == 'none' ) ) {
						$screen_reader = 'screen-reader-text';
					}
					?>
					<div id="header-text" class="<?php echo $screen_reader; ?>">
						<?php
						if ( is_front_page() || is_home() ) : ?>
							<h1 id="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h1>
						<?php else : ?>
							<h3 id="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h3>
						<?php endif;
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p id="site-description"><?php echo $description; ?></p>
						<?php endif;
						?>
					</div><!-- #header-text -->
				</div><!-- #header-left-section -->

				<div id="header-right-section">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<p class="menu-toggle"></p>
						<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_class'     => 'menu menu-primary-container',
								)
							);
						} else {
							wp_page_menu();
						}
						?>
					</nav>
					<?php if ( ample_option( 'ample_header_display_search_icon', 1 ) == 1 ) : ?>
						<i class="fa fa-search search-top"></i>
						<div class="search-form-top">
							<?php get_search_form(); ?>
						</div>
					<?php endif; ?>

					<?php if ( class_exists( 'woocommerce' ) && ( ample_option( 'ample_cart_icon_setting', 0 ) == 1 ) ) : ?>
						<div class="cart-wrapper">
							<div class="ample-cart-views">
								<?php $cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url(); ?>

								<a href="<?php echo esc_url( $cart_url ); ?>" class="wcmenucart-contents">
									<i class="fa fa-shopping-cart"></i>
									<span class="cart-value"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
								</a> <!-- quick wishlist end -->
								<div class="my-cart-wrap">
									<div class="my-cart"><?php esc_html_e( 'Total', 'ample' ); ?></div>
									<div class="cart-total"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></div>
								</div>
							</div>
							<?php the_widget( 'WC_Widget_Cart', '' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div><!-- .main-head-wrap -->
			<?php if ( ample_option( 'ample_header_image_position', 'above' ) == 'below' ) {
				ample_render_header_image();
			} ?>
		</div><!-- .header -->
	</header><!-- end of header -->

	<div class="main-wrapper" id="main">

		<?php if ( ample_option( 'ample_activate_slider', '0' ) == '1' ) {
			if ( ( ample_option( 'ample_slider_status', 'front_page' ) == 'all_page' ) || ( is_front_page() && ample_option( 'ample_slider_status', 'front_page' ) == 'front_page' ) ) {
				ample_pass_slider_parameters();
				ample_featured_image_slider();
			}
		}
		if ( '' != ample_header_title() && ! ( is_front_page() ) ) {
			?>
			<div class="header-post-title-container clearfix">
				<div class="inner-wrap">
					<div class="post-title-wrapper">
						<?php if ( is_home() ) : ?>
							<h2 class="header-post-title-class entry-title"><?php echo ample_header_title(); ?></h2>
						<?php else : ?>
							<h1 class="header-post-title-class entry-title"><?php echo ample_header_title(); ?></h1>
						<?php endif; ?>
					</div>
					<?php if ( function_exists( 'ample_breadcrumb' ) ) {
						ample_breadcrumb();
					} ?>
				</div>
			</div>
		<?php } ?>
