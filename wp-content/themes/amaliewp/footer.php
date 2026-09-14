<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package Amalie
 * @since Amalie 1.0
 */
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
				}
			?>
			<?php if( get_theme_mod( 'hide_copyright' ) == '') { ?>
				<?php esc_attr_e('&copy;', 'amalie'); ?>
				<a href="<?php echo home_url('/') ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"> <?php echo esc_textarea ( get_theme_mod( 'copyright_textbox', 'Amalie Theme by Anariel Design.' ) ); ?> </a>
			<?php } // end if ?>
		</div>
		<!-- .site-info -->
	</footer><!-- .site-footer -->

	</div><!-- .site-content -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>