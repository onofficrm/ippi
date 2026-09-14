<?php
/**
 * Template Name: One Page Template
 *
 * Displays the Onepage Template of the theme.
 *
 * @package ThemeGrill
 * @subpackage Ample Pro
 * @since Ample 1.0
 */

get_header();

   do_action( 'ample_before_body_content' ); ?>

   <?php
      if( is_active_sidebar( 'ample_onepage_sidebar' ) ) {
         // Calling the Onepage Sidebar if it exists.
         if ( !dynamic_sidebar( 'ample_onepage_sidebar' ) ):
         endif;
      }
   ?>
   <?php do_action( 'ample_after_body_content' );
get_footer(); ?>