<?php

/**
 * Class ample_our_clients_widget.
 */
class ample_our_clients_widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_our_clients',
			'description'                 => esc_html__( 'Widget to show clients/partners images', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = esc_html__( 'TG: Our Clients', 'ample' ), $widget_ops, $control_ops );
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'client_menu_id'     => '',
			'client_title'       => '',
			'client_description' => '',
			'client_num'         => '5',
			'image-1'            => '',
			'image-2'            => '',
			'image-3'            => '',
			'image-4'            => '',
			'image-5'            => '',
			'link-1'             => '',
			'link-2'             => '',
			'link-3'             => '',
			'link-4'             => '',
			'link-5'             => '',
			'hover-text1'        => '',
			'hover-text2'        => '',
			'hover-text3'        => '',
			'hover-text4'        => '',
			'hover-text5'        => '',
			'enable_slider'      => '0',
		) );

		for ( $i = 1; $i <= $instance['client_num']; $i ++ ) {
			$image                   = 'image-' . $i;
			$link                    = 'link-' . $i;
			$hover_text              = 'hover-text' . $i;
			$instance[ $image ]      = esc_url_raw( $instance[ $image ] );
			$instance[ $link ]       = esc_url( $instance[ $link ] );
			$instance[ $hover_text ] = strip_tags( $instance[ $hover_text ] );
		}
		$enable_slider = $instance['enable_slider'] ? 'checked="checked"' : '';
		?>
		<p><?php _e( 'Note: Enter the Client Section ID and use same for Menu item. Only used for One Page Sidebar.', 'ample' ); ?></p>
		<p>
		<p>
			<label for="<?php echo $this->get_field_id( 'client_menu_id' ); ?>"><?php _e( 'Client Section ID:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'client_menu_id' ); ?>" name="<?php echo $this->get_field_name( 'client_menu_id' ); ?>" type="text" value="<?php echo $instance['client_menu_id']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'client_title' ); ?>"><?php _e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'client_title' ); ?>" name="<?php echo $this->get_field_name( 'client_title' ); ?>" type="text" value="<?php echo $instance['client_title']; ?>" />
		</p>

		<?php next( $instance ); ?>
		<?php _e( 'Description:', 'ample' ); ?>
		<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id( 'client_description' ); ?>" name="<?php echo $this->get_field_name( 'client_description' ); ?>"><?php echo $instance['client_description']; ?></textarea>

		<p><?php _e( 'Note: Enter the Client number (default will show fields for 5 clients) and save it than enter the data in respective field.', 'ample' ); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'client_num' ); ?>"><?php _e( 'Client number:', 'ample' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'client_num' ); ?>" name="<?php echo $this->get_field_name( 'client_num' ); ?>" type="text" value="<?php echo $instance['client_num']; ?>" />
		</p>

		<?php for ( $i = 1; $i <= $instance['client_num']; $i ++ ) {
			$image      = 'image-' . $i;
			$link       = 'link-' . $i;
			$hover_text = 'hover-text' . $i;
			?>
			<p>
				<label for="<?php echo $this->get_field_id( $image ); ?>"><?php esc_html_e( 'Image ', 'ample' );
					echo $i; ?></label><br />
			<div class="media-uploader" id="<?php echo $this->get_field_id( $image ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ $image ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php if ( isset ( $instance[ $image ] ) ) {
							echo esc_url( $instance[ $image ] );
						} ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( $image ); ?>" name="<?php echo $this->get_field_name( $image ); ?>" value="<?php if ( isset ( $instance[ $image ] ) ) {
					echo esc_url( $instance[ $image ] );
				} ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( '$image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'ample' ); ?></button>
			</div>
			</p>

			<p><?php _e( 'Redirect Link ', 'ample' );
				echo $i; ?>
				<input style="width: 100%;" name="<?php echo $this->get_field_name( $link ); ?>" type="text" value="<?php if ( isset ( $instance[ $link ] ) ) {
					echo esc_url( $instance[ $link ] );
				} ?>" /></p>
			<p>
				<label for="<?php echo $this->get_field_id( $hover_text ); ?>"><?php _e( 'Hover Title Text ', 'ample' );
					echo $i; ?></label>
				<input style="width: 100%;" id="<?php echo $this->get_field_id( $hover_text ); ?>" name="<?php echo $this->get_field_name( $hover_text ); ?>" type="text" value="<?php echo $instance[ $hover_text ]; ?>" />
			</p>
			<hr />
		<?php } ?>
		<p>
			<input class="checkbox" <?php echo $enable_slider; ?> id="<?php echo $this->get_field_id( 'enable_slider' ); ?>" name="<?php echo $this->get_field_name( 'enable_slider' ); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id( 'enable_slider' ); ?>"><?php esc_html_e( 'Check to enable the slider.', 'ample' ); ?></label>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		$instance['client_menu_id'] = strip_tags( $new_instance['client_menu_id'] );
		$instance['client_title']   = strip_tags( $new_instance['client_title'] );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['client_description'] = $new_instance['client_description'];
		} else {
			$instance['client_description'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['client_description'] ) ) );
		} // wp_filter_post_kses() expects slashed

		$instance['client_num'] = absint( $new_instance['client_num'] );

		for ( $i = 1; $i <= $instance['client_num']; $i ++ ) {
			$image                   = 'image-' . $i;
			$link                    = 'link-' . $i;
			$hover_text              = 'hover-text' . $i;
			$instance[ $image ]      = esc_url_raw( $new_instance[ $image ] );
			$instance[ $link ]       = esc_url( $new_instance[ $link ] );
			$instance[ $hover_text ] = strip_tags( $new_instance[ $hover_text ] );
		}

		$instance['enable_slider'] = isset( $new_instance['enable_slider'] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$title         = apply_filters( 'widget_title', isset( $instance['client_title'] ) ? $instance['client_title'] : '' );
		$description   = isset( $instance['client_description'] ) ? $instance['client_description'] : '';
		$client_num    = isset( $instance['client_num'] ) ? $instance['client_num'] : '5';
		$enable_slider = ! empty( $instance['enable_slider'] ) ? 'true' : 'false';

		$image_array      = array();
		$link_array       = array();
		$hover_text_array = array();

		for ( $i = 1; $i <= $client_num; $i ++ ) {
			$j          = $i - 1;
			$image      = 'image-' . $i;
			$link       = 'link-' . $i;
			$hover_text = 'hover-text' . $i;
			$image      = isset( $instance[ $image ] ) ? $instance[ $image ] : '';
			$link       = isset( $instance[ $link ] ) ? $instance[ $link ] : '';
			$hover_text = isset( $instance[ $hover_text ] ) ? $instance[ $hover_text ] : '';
			array_push( $image_array, $image );
			array_push( $link_array, $link );
			array_push( $hover_text_array, $hover_text );
			// For WPML plugin compatibility
			if ( function_exists( 'icl_register_string' ) ) {
				if ( ! empty( $image ) ) {
					icl_register_string( 'Ample Pro', 'TG: Our Clients image' . $this->id . $j, $image_array[ $j ] );

					if ( ! empty( $link ) ) {
						icl_register_string( 'Ample Pro', 'TG: Our Clients link' . $this->id . $j, $link_array[ $j ] );
					}
					if ( ! empty( $hover_text ) ) {
						icl_register_string( 'Ample Pro', 'TG: Our Clients hover' . $this->id . $j, $hover_text_array[ $j ] );
					}
				}
			}
		}

		echo $before_widget;

		$section_id = '';
		if ( ! empty( $instance['client_menu_id'] ) ) {
			$section_id = 'id="' . $instance['client_menu_id'] . '"';
		}

		$slider_class = '';
		if ( $enable_slider == 'true' ) {
			$slider_class = 'slider-clients';
			wp_enqueue_script( 'ample-bxslider' );
			wp_enqueue_style( 'ample-bxslider' );
		}
		?>

		<div <?php echo $section_id ?> class="client-list">
			<div class="clients-all-content clearfix">

				<div class="clients-header">
					<?php if ( ! empty( $title ) ) { ?>
						<?php echo $before_title . esc_html( $title ) . $after_title; ?>
					<?php } ?>
					<?php if ( ! empty( $description ) ) { ?>
						<div class="clients-main-description">
							<p><?php echo wp_kses_post( $description ); ?></p>
						</div>
					<?php } ?>
				</div>

				<?php
				if ( ! empty( $image_array ) ) {
					$output = '';
					$output .= '<ul class="client-slider ' . esc_attr( $slider_class ) . '">';
					for ( $i = 1; $i <= $client_num; $i ++ ) {
						$j                  = $i - 1;
						$attachment_post_id = attachment_url_to_postid( $image_array[ $j ] );
						$image_attributes   = wp_get_attachment_image_src( $attachment_post_id, 'full' );
						if ( ! empty( $image_array[ $j ] ) ) {
							$output .= '<li>';
							// For WPML plugin compatibility
							if ( function_exists( 'icl_t' ) ) {
								$image_array[ $j ] = icl_t( 'Ample Pro', 'TG: Our Clients image' . $this->id . $j, $image_array[ $j ] );
							}
							if ( ! empty( $hover_text_array[ $j ] ) ) {
								if ( function_exists( 'icl_t' ) ) {
									$hover_text_array[ $j ] = icl_t( 'Ample Pro', 'TG: Our Clients hover' . $this->id . $j, $hover_text_array[ $j ] );
								}
							}

							if ( ! empty( $link_array[ $j ] ) ) {
								if ( function_exists( 'icl_t' ) ) {
									$link_array[ $j ] = icl_t( 'Ample Pro', 'TG: Our Clients link' . $this->id . $j, $link_array[ $j ] );
								}

								$output .= '<a href="' . $link_array[ $j ] . '" title="' . $hover_text_array[ $j ] . '" target="_blank"><img src="' . $image_array[ $j ] . '" width="' . esc_attr( $image_attributes[1] ) . '" height="' . esc_attr( $image_attributes[2] ) . '" alt="' . $hover_text_array[ $j ] . '"></a>';
							} else {
								$output .= '<img src="' . $image_array[ $j ] . '" width="' . esc_attr( $image_attributes[1] ) . '" height="' . esc_attr( $image_attributes[2] ) . '" alt="' . $hover_text_array[ $j ] . '">';
							}
							$output .= '</li>';
						}
					}
					$output .= '</ul>';
					echo $output;
				}
				?>
			</div>
		</div>
		<?php
		echo $after_widget;
	}
}
