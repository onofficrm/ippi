<?php
/**
 * Jetpack Compatibility File
 *
 * @link       https://jetpack.com/
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample Pro 2.0.9
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function ample_jetpack_setup() {
	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'post-details' => array(
			'stylesheet' => 'ample-style',
			'date'       => '.entry-date',
			'categories' => '.category',
			'tags'       => '.tags',
			'author'     => '.author',
			'comment'    => '.comments',
		),
	) );
}

add_action( 'after_setup_theme', 'ample_jetpack_setup' );
