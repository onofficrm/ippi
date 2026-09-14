<?php

/**
 * Class ample_call_to_action_widget.
 */
class ample_call_to_action_widget extends WP_Widget {
	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_call_to_action_block',
			'description'                 => esc_html__( 'Use this widget to show the call to action section.', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = esc_html__( 'TG: Call To Action Widget', 'ample' ), $widget_ops, $control_ops );
	}

	function form( $instance ) {
		$ample_defaults['background_color'] = '#80abc8';
		$ample_defaults['background_image'] = '';
		$ample_defaults['bg_attachment']    = 'scroll';
		$ample_defaults['text_main']        = '';
		$ample_defaults['text_description'] = '';
		$ample_defaults['button_text']      = '';
		$ample_defaults['button_url']       = '';
		$ample_defaults['new_tab']          = '';

		$instance = wp_parse_args( (array) $instance, $ample_defaults );

		$background_color = esc_attr( $instance['background_color'] );
		$background_image = esc_url_raw( $instance['background_image'] );
		$bg_attachment    = $instance['bg_attachment'];
		$text_main        = esc_textarea( $instance['text_main'] );
		$text_description = esc_textarea( $instance['text_description'] );
		$button_text      = esc_attr( $instance['button_text'] );
		$button_url       = esc_url( $instance['button_url'] );
		$new_tab          = $instance['new_tab'] ? 'checked' : '';
		?>
		<p>
			<strong><?php _e( 'DESIGN SETTINGS :', 'ample' ); ?></strong>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>"><?php _e( 'Background Color:', 'ample' ); ?></label><br />
			<input class="my-color-picker" type="text" data-default-color="#80abc8" id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>" value="<?php echo $background_color; ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>"> <?php _e( 'Background Image:', 'ample' ); ?> </label>
			<br />
		<div class="media-uploader" id="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>">
			<div class="custom_media_preview">
				<?php if ( $background_image != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance['background_image'] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_image' ) ); ?>" value="<?php echo esc_url( $instance['background_image'] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;">
				<?php esc_html_e( 'Select an Image', 'ample' ); ?>
			</button>
		</div>
		</p>

		<p>
			<?php esc_html_e( 'Background attachment:', 'ample' ); ?><br />
			<label>
				<input type="radio" <?php checked( $bg_attachment, 'scroll' ) ?> id="<?php echo esc_attr( $this->get_field_id( 'bg_attachment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_attachment' ) ); ?>" value="scroll" /><?php esc_html_e( 'Scroll', 'ample' ); ?>
			</label>
			<label>
				<input type="radio" <?php checked( $bg_attachment, 'fixed' ) ?> id="<?php echo esc_attr( $this->get_field_id( 'bg_attachment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_attachment' ) ); ?>" value="fixed" style="margin-left: 20px;" /><?php esc_html_e( 'Fixed', 'ample' ); ?>
			</label>
		</p>

		<p>
			<strong><?php esc_html_e( 'OTHER SETTINGS :', 'ample' ); ?></strong>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_main' ) ); ?>"><?php esc_html_e( 'Call to Action Main Text', 'ample' ); ?></label>
			<textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text_main' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_main' ) ); ?>"><?php echo $text_main; ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_description' ) ); ?>"><?php esc_html_e( 'Call to Action Description Text', 'ample' ); ?></label>
			<textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text_description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_description' ) ); ?>"><?php echo $text_description; ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button Text:', 'ample' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e( 'Button Redirect Link:', 'ample' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo $button_url; ?>" />
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" <?php echo esc_attr( $new_tab ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e( 'Check to open button link in new tab.', 'ample' ); ?></label>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['background_color'] = $new_instance['background_color'];
		$instance['background_image'] = esc_url_raw( $new_instance['background_image'] );
		$instance['bg_attachment']    = $new_instance['bg_attachment'];

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text_main']        = $new_instance['text_main'];
			$instance['text_description'] = $new_instance['text_description'];
		} else {
			$instance['text_main']        = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text_main'] ) ) );
			$instance['text_description'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text_description'] ) ) );
			// wp_filter_post_kses() expects slashed
		}

		$instance['button_text'] = strip_tags( $new_instance['button_text'] );
		$instance['button_url']  = esc_url_raw( $new_instance['button_url'] );
		$instance['new_tab']     = isset( $new_instance['new_tab'] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$background_color = isset( $instance['background_color'] ) ? $instance['background_color'] : '';
		$background_image = isset( $instance['background_image'] ) ? $instance['background_image'] : '';
		$bg_attachment    = isset( $instance['bg_attachment'] ) ? $instance['bg_attachment'] : '';
		$text_main        = empty( $instance['text_main'] ) ? '' : $instance['text_main'];
		$text_description = empty( $instance['text_description'] ) ? '' : $instance['text_description'];
		$button_text      = isset( $instance['button_text'] ) ? $instance['button_text'] : '';
		$button_url       = isset( $instance['button_url'] ) ? $instance['button_url'] : '#';
		$new_tab          = ! empty( $instance['new_tab'] ) ? 'target="_blank"' : '';

		// For WPML plugin compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Ample Pro', 'TG: Call to action widget text' . $this->id, $text_main );
			icl_register_string( 'Ample Pro', 'TG: Call to action widget description' . $this->id, $text_description );
			icl_register_string( 'Ample Pro', 'TG: Call to action widget button text' . $this->id, $button_text );
			icl_register_string( 'Ample Pro', 'TG: Call to action widget button url' . $this->id, $button_url );
		}
		if ( function_exists( 'icl_t' ) ) {
			$text_main        = icl_t( 'Ample Pro', 'TG: Call to action widget text' . $this->id, $text_main );
			$text_description = icl_t( 'Ample Pro', 'TG: Call to action widget description' . $this->id, $text_description );
			$button_text      = icl_t( 'Ample Pro', 'TG: Call to action widget button text' . $this->id, $button_text );
			$button_url       = icl_t( 'Ample Pro', 'TG: Call to action widget button url' . $this->id, $button_url );
		}

		echo $before_widget;
		$bg_image_style = '';
		if ( ! empty( $background_image ) ) {
			$bg_image_style .= 'background-image:url(' . $background_image . ');background-attachment:' . $bg_attachment . ';background-repeat:no-repeat;background-size:cover;';
			$bg_height      = 'call-to-action-content-wrapper';
		} else {
			$bg_image_style .= 'background-color:' . $background_color . ';';
			$bg_height      = 'call-to-action-content-wrapper no-bg-image';
		} ?>
		<div class="<?php echo esc_attr( $bg_height ); ?> clearfix" style="<?php echo $bg_image_style; ?>">
			<div class="inner-wrap <?php echo ( ! empty( $text_description ) ) ? 'cta-description' : ''; ?>">
				<?php if ( ! empty( $text_main ) ) { ?>
					<h3>
						<?php
						echo wp_kses_post( $text_main );

						if ( ! empty( $text_description ) ) {
							echo '<span>' . wp_kses_post( $text_description ) . '</span>';
						}
						?>
					</h3>
					<?php
					if ( ! empty( $button_text ) ) { ?>
						<a class="call-to-action-button" href="<?php echo $button_url; ?>" title="<?php echo esc_attr( $button_text ); ?>" <?php echo esc_attr( $new_tab ); ?>>
							<?php echo esc_html( $button_text ); ?>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
		</div>

		<?php echo $after_widget;
	}
}
