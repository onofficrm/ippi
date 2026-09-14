<?php
/**
 * Extend WP_Customize_Control to include ample typography options.
 *
 * Class Ample_Typography_Control
 *
 * @since 2.1.8
 */

// Extending `WP_Customize_Control` to include ample typography options.
class Ample_Typography_Control extends WP_Customize_Control {

	// Assign the type of control to be rendered.
	public $type = 'ample-typography-options';

	/**
	 * Function to display typography select options in customize options.
	 */
	public function render_content() {
		$this_value = $this->value();
		?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<select class="ample-typography-select" <?php $this->link(); ?>>

			<?php
			// Get Standard font options
			if ( $std_fonts = ample_standard_fonts_array() ) { ?>
				<optgroup label="<?php esc_html_e( 'Standard Fonts', 'ample' ); ?>">
					<?php
					// Loop through font options and add to select
					foreach ( $std_fonts as $font => $value ) { ?>
						<option value="<?php echo esc_html( $font ); ?>" <?php selected( $font, $this_value ); ?>><?php echo esc_html( $value ); ?></option>
					<?php } ?>
				</optgroup>
			<?php }
			?>

			<?php
			// Google font options
			if ( $google_fonts = ample_google_fonts() ) { ?>
				<optgroup label="<?php esc_html_e( 'Google Fonts', 'ample' ); ?>">
					<?php
					// Loop through font options and add to select
					foreach ( $google_fonts as $font => $value ) { ?>
						<option value="<?php echo esc_html( $font ); ?>" <?php selected( $font, $this_value ); ?>><?php echo esc_html( $value ); ?></option>
					<?php } ?>
				</optgroup>
			<?php } ?>

		</select>

		<?php
	}
}
