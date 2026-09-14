<?php
/**
 * Extend WP_Customize_Control for to add the small information text.
 *
 * Class AMPLE_Custom_Information
 *
 * @since 2.1.8
 */

// Extend Customizer Options to add the small information text.
class AMPLE_Custom_Information extends WP_Customize_Control {

	public $type = 'ample-custom-information';

	public function render_content() {
		?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<p><?php echo wp_kses_post( $this->description ); ?></p>

		<?php
	}

}
