<?php

/***** Theme Info Page *****/

if (!function_exists('amalie_theme_info_page')) {
	function amalie_theme_info_page() {
		add_theme_page(esc_html__('Welcome to Amalie', 'amalie'), esc_html__('Theme Info', 'amalie'), 'edit_theme_options', 'blog', 'amalie_display_theme_page');
	}
}
add_action('admin_menu', 'amalie_theme_info_page');

if (!function_exists('amalie_display_theme_page')) {
	function amalie_display_theme_page() {
		$theme_data = wp_get_theme(); ?>
		<div class="theme-info-wrap">
			<h1>
				<?php printf(esc_html__('Welcome to %1s %2s', 'amalie'), $theme_data->Name, $theme_data->Version); ?>
			</h1>

			<p>
				<a href="<?php echo esc_url('http://www.anarieldesign.com/themes/personal-blog-wordpress-theme/'); ?>" target="_blank" class="button button-primary">
					<?php esc_html_e('Find more about Amalie', 'amalie'); ?>
				</a>
			</p>
		<div class="ad-row clearfix">
			<div class="ad-col-1-2">
				<div class="section">
					<div class="theme-description">
						<?php echo esc_html($theme_data['Description']); ?>
					</div>
				</div>
			</div>
			<div class="ad-col-1-2">
				<img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="<?php esc_html_e('Theme Screenshot', 'amalie'); ?>" />
			</div></div>
			<hr>
			<div id="getting-started" class="bg">
				<h3>
					<?php printf(esc_html__('Getting Started with %s', 'amalie'), $theme_data->Name); ?>
				</h3>
				<div class="ad-row clearfix">
						<div class="section documentation">
							<h4>
								<?php esc_html_e('Theme Documentation', 'amalie'); ?>
							</h4>
							<p class="about">
								<?php printf(esc_html__('Please check the documentation to get better overview of how the theme is structured.', 'amalie'), $theme_data->Name); ?>
							</p>
							<p>
								<a href="<?php echo esc_url('http://www.anarieldesign.com/documentation/amalie/'); ?>" target="_blank" class="button button-primary">
									<?php esc_html_e('Visit Documentation', 'amalie'); ?>
								</a>
							</p>
						</div>
						<div class="section options">
							<h4>
								<?php esc_html_e('Theme Options', 'amalie'); ?>
							</h4>
							<p class="about">
								<?php printf(esc_html__('Click "Customize" to open the Customizer. Amalie has implemented Customizer and added some useful options to help you style color elements, upload image logo and a lot more.', 'amalie'), $theme_data->Name); ?>
							</p>
							<p>
								<a href="<?php echo admin_url('customize.php'); ?>" class="button button-secondary">
									<?php esc_html_e('Customize', 'amalie'); ?>
								</a>
							</p>
						</div>
						<div class="section options">
							<h4>
								<?php esc_html_e('Theme Update Logs', 'amalie'); ?>
							</h4>
							<p class="about">
								<?php printf(esc_html__('View the full change log for our themes.', 'amalie'), $theme_data->Name); ?>
							</p>
							<p>
								<a href="<?php echo esc_url('https://www.anarieldesign.com/theme-update-logs/'); ?>" class="button button-secondary" target="_blank">
									<?php esc_html_e('Theme Update Logs', 'amalie'); ?>
								</a>

							</p>
						</div>
						<div class="section video">
							<h4>
								<?php esc_html_e('Support Page', 'amalie'); ?>
							</h4>
							<p class="about">
								<?php printf(esc_html__('There is a solution to every problem!', 'amalie'), $theme_data->Name); ?>
							</p>
							<p>
								<a href="<?php echo esc_url('http://www.anarieldesign.com/support/'); ?>" class="button button-primary" target="_blank">
									<?php esc_html_e('Support Page', 'amalie'); ?>
								</a>
							</p>
						</div>

						<div class="section recommend clear">
							<h4>
								<?php esc_html_e('Recommended Plugins', 'amalie'); ?>
							</h4>
							<p class="center"><?php esc_html_e('Plugins listed are not mandatory for theme to work! Install only the ones you need for your website!', 'amalie'); ?></p>
							<!-- Give -->

							<!-- WooCommerce -->
							<p><strong><?php esc_html_e( 'WooCommerce', 'amalie' ); ?></strong></p>
							<p><?php esc_html_e( 'An e-commerce toolkit that helps you sell anything. Beautifully.', 'amalie' ); ?></p>

							<?php if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) { ?>

							<p><span class="amalie-w-activated button"><?php esc_html_e( 'Already activated', 'amalie' ); ?></span></p>

							<?php
							}
							else { ?>

							<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install WooCommerce', 'amalie' ); ?></a></p>

							<?php
							}

							?>
							<!-- Contact Form 7 -->
							<p><strong><?php esc_html_e( 'Contact Form 7', 'amalie' ); ?></strong></p>
							<p><?php esc_html_e( 'Just another contact form plugin. Simple but flexible.', 'amalie' ); ?></p>

							<?php if ( is_plugin_active( 'contact-form-7/contact-form-7.php' ) ) { ?>

							<p><span class="amalie-activated button"><?php esc_html_e( 'Already activated', 'amalie' ); ?></span></p>

							<?php
							}
							else { ?>

							<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=contact-form-7' ), 'install-plugin_contact-form-7' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install Contact Form 7', 'amalie' ); ?></a></p>

							<?php
							}

							?>

							<!-- Email Subscribers & Newsletter -->
							<p><strong><?php esc_html_e( 'Email Subscribers & Newsletters', 'amalie' ); ?></strong></p>
							<p><?php esc_html_e( 'Add subscription forms on website, send HTML newsletters & automatically notify subscribers about new blog posts once it is published.', 'amalie' ); ?></p>

							<?php if ( is_plugin_active( 'email-subscribers/email-subscribers.php' ) ) { ?>

							<p><span class="amalie-activated button"><?php esc_html_e( 'Already activated', 'amalie' ); ?></span></p>

							<?php
							}
							else { ?>

							<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=email-subscribers' ), 'install-plugin_email-subscribers' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Email Subscribers & Newsletters', 'amalie' ); ?></a></p>

							<?php
							}

							?>
							<!-- Elementor -->
							<p><strong><?php esc_html_e( 'Elementor', 'amalie' ); ?></strong></p>
							<p><?php esc_html_e( 'The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.', 'amalie' ); ?></p>

							<?php if ( is_plugin_active( 'elementor/elementor.php' ) ) { ?>

							<p><span class="amalie-activated button"><?php esc_html_e( 'Already activated', 'amalie' ); ?></span></p>

							<?php
							}
							else { ?>

							<p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Elementor', 'amalie' ); ?></a></p>

							<?php
							}

							?>

							<!-- Premium Soliloquy Slider -->
							<p><strong><?php esc_html_e( 'Premium Soliloquy Slider', 'amalie' ); ?></strong></p>

							<?php if ( is_plugin_active( 'soliloquy/soliloquy.php' ) ) { ?>

							<p><span class="amalie-activated button"><?php esc_html_e( 'Already activated', 'amalie' ); ?></span></p>

							<?php
							}
							else { ?>

							<p class="bg2"><?php esc_html_e( 'Plugin & license key can be found inside the plugins folder within the main folder you downloaded', 'amalie' ); ?></p>

							<?php
							}
							?>
							<!-- Custom Google Fonts Plugin -->
							<p><strong><?php esc_html_e( 'Custom Google Fonts Plugin', 'amalie' ); ?></strong></p>

							<?php if ( is_plugin_active( 'AnarielDesign-GoogleFonts/ad_gfp.php' ) ) { ?>

							<p><span class="amalie-activated button"><?php esc_html_e( 'Already activated', 'amalie' ); ?></span></p>

							<?php
							}
							else { ?>

							<p class="bg2"><?php esc_html_e( 'Plugin can be found inside the plugins folder within the main folder you downloaded', 'amalie' ); ?></p>

							<?php
							}
							?>
							</div>

						<div class="clear"></div>
						<div class="section bg1">
							<h3>
								<?php esc_html_e('More Themes by Anariel Design', 'amalie'); ?>
							</h3>
							<p class="about">
								<?php printf(esc_html__('Build Your Dream WordPress Site with Premium Niche Themes for Bloggers & Charities',  'amalie'), $theme_data->Name); ?>
							</p>
							<a target="_blank" href="<?php echo esc_url('http://www.anarieldesign.com/themes/'); ?>"><img src="http://www.anarieldesign.com/themedemos/marketimages/anarieldesign-themes.jpg" alt="<?php esc_html_e('Theme Screenshot', 'amalie'); ?>" /></a>
							<p>
								<a target="_blank" href="<?php echo esc_url('http://www.anarieldesign.com/themes/'); ?>" class="button button-primary advertising">
									<?php esc_html_e('More Themes', 'amalie'); ?>
								</a>
							</p>
						</div>
					</div>
			</div>
			<hr>
			<div id="theme-author">
				<p>
					<?php printf(esc_html__('%1s is proudly brought to you by %2s. %3s: %4s.', 'amalie'), $theme_data->Name, '<a target="_blank" href="http://www.anarieldesign.com/" title="Anariel Design">Anariel Design</a>', $theme_data->Name, '<a target="_blank" href="http://www.anarieldesign.com/themes/personal-blog-wordpress-theme/" title="Amalie Theme Demo">' . esc_html__('Theme Demo', 'amalie') . '</a>'); ?>
				</p>
			</div>
		</div><?php
	}
}

?>