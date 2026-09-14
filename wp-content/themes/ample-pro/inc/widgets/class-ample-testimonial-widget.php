<?php

/**
 * Class ample_testimonial_widget.
 */
class ample_testimonial_widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_testimonial_block',
			'description'                 => esc_html__( 'Display Testimonial', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = esc_html__( 'TG: Testimonial', 'ample' ), $widget_ops, $control_ops );
	}

	function form( $instance ) {
		$default_value['testimonial_menu_id'] = '';
		$default_value['title']               = '';
		$default_value['description']         = '';
		$default_value['testimonial_num']     = '2';
		$default_value['column_num']          = 'testimonial-column-layout-2';

		for ( $i = 1; $i <= $default_value['testimonial_num']; $i ++ ) {
			$default_value[ 'text' . $i ]        = '';
			$default_value[ 'person_name' . $i ] = '';
			$default_value[ 'byline' . $i ]      = '';
			$default_value[ 'image' . $i ]       = '';
		}

		$instance = wp_parse_args( (array) $instance, $default_value ); ?>
		<p><?php _e( 'Note: Enter the Testimonial Section ID and use same for Menu item. Only used for One Page Sidebar.', 'ample' ); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( key( $instance ) ); ?>"><?php _e( 'Testimonial Section ID:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( key( $instance ) ); ?>" name="<?php echo $this->get_field_name( key( $instance ) ); ?>" type="text" value="<?php echo $instance[ key( $instance ) ]; ?>" />
		</p>

		<?php next( $instance ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( key( $instance ) ); ?>"><?php _e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( key( $instance ) ); ?>" name="<?php echo $this->get_field_name( key( $instance ) ); ?>" type="text" value="<?php echo $instance[ key( $instance ) ]; ?>" />
		</p>

		<?php next( $instance ); ?>
		<?php _e( 'Description:', 'ample' ); ?>
		<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id( key( $instance ) ); ?>" name="<?php echo $this->get_field_name( key( $instance ) ); ?>"><?php echo $instance[ key( $instance ) ]; ?></textarea>

		<?php next( $instance ); ?>
		<p><?php _e( 'Note: Enter the number of testimonial and save it than enter the data in respective field.', 'ample' ); ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( key( $instance ) ); ?>"><?php _e( 'No. of Testimonial:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( key( $instance ) ); ?>" name="<?php echo $this->get_field_name( key( $instance ) ); ?>" type="text" value="<?php echo $instance[ key( $instance ) ]; ?>" />
		</p>

		<?php next( $instance ); ?>
		<?php esc_html_e( 'Select Column:', 'ample' ); ?>
		<select id="<?php echo $this->get_field_id( key( $instance ) ); ?>" name="<?php echo $this->get_field_name( key( $instance ) ); ?>">
			<option value="testimonial-column-layout-2" <?php if ( $instance[ key( $instance ) ] == 'testimonial-column-layout-2' ) {
				echo 'selected="selected"';
			} ?> ><?php esc_html_e( 'Two Column', 'ample' ); ?></option>
			<option value="testimonial-column-layout-3" <?php if ( $instance[ key( $instance ) ] == 'testimonial-column-layout-3' ) {
				echo 'selected="selected"';
			} ?> ><?php esc_html_e( 'Three Column', 'ample' ); ?></option>
			<option value="testimonial-column-layout-4" <?php if ( $instance[ key( $instance ) ] == 'testimonial-column-layout-4' ) {
				echo 'selected="selected"';
			} ?> ><?php esc_html_e( 'Four Column', 'ample' ); ?></option>
		</select>

		<?php for ( $i = 1; $i <= $instance['testimonial_num']; $i ++ ) {

			$text        = 'text' . $i;
			$person_name = 'person_name' . $i;
			$byline      = 'byline' . $i;
			$image       = 'image' . $i;
			?>
			<p><strong><?php _e( 'Testimonial ', 'ample' );
					echo $i; ?></strong><br /></p>

			<?php _e( 'Text:', 'ample' ); ?>
			<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id( $text ); ?>" name="<?php echo $this->get_field_name( $text ); ?>"><?php echo $instance[ $text ]; ?></textarea>

			<p>
				<label for="<?php echo $this->get_field_id( $person_name ); ?>"><?php _e( 'Name:', 'ample' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $person_name ); ?>" name="<?php echo $this->get_field_name( $person_name ); ?>" type="text" value="<?php echo esc_attr( $instance[ $person_name ] ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( $byline ); ?>"><?php _e( 'Byline:', 'ample' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $byline ); ?>" name="<?php echo $this->get_field_name( $byline ); ?>" type="text" value="<?php echo esc_attr( $instance[ $byline ] ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( $image ); ?>"> <?php esc_html_e( 'Image:', 'ample' ); ?> </label>
				<br />
			<div class="media-uploader" id="<?php echo $this->get_field_id( $image ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ $image ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ $image ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( $image ); ?>" name="<?php echo $this->get_field_name( $image ); ?>" value="<?php echo esc_url( $instance[ $image ] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( $image ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'ample' ); ?></button>
			</div>
			</p>
		<?php } ?>
	<?php }

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['testimonial_menu_id'] = strip_tags( $new_instance['testimonial_menu_id'] );
		$instance['title']               = strip_tags( $new_instance['title'] );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['description'] = $new_instance['description'];
		} else {
			$instance['description'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['description'] ) ) );
		} // wp_filter_post_kses() expects slashed

		$instance['testimonial_num'] = absint( $new_instance['testimonial_num'] );
		$instance['column_num']      = sanitize_key( $new_instance['column_num'] );

		for ( $i = 1; $i <= $instance['testimonial_num']; $i ++ ) {
			if ( current_user_can( 'unfiltered_html' ) ) {
				$instance[ 'text' . $i ] = $new_instance[ 'text' . $i ];
			} else {
				$instance[ 'text' . $i ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' . $i ] ) ) );
			} // wp_filter_post_kses() expects slashed

			$instance[ 'person_name' . $i ] = strip_tags( $new_instance[ 'person_name' . $i ] );
			$instance[ 'byline' . $i ]      = strip_tags( $new_instance[ 'byline' . $i ] );
			$instance[ 'image' . $i ]       = esc_url_raw( $new_instance[ 'image' . $i ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$title           = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$description     = isset( $instance['description'] ) ? $instance['description'] : '';
		$testimonial_num = empty( $instance['testimonial_num'] ) ? 2 : $instance['testimonial_num'];
		$column_num      = isset( $instance['column_num'] ) ? $instance['column_num'] : 'testimonial-column-layout-2';

		echo $before_widget;

		$section_id = '';
		if ( ! empty( $instance['testimonial_menu_id'] ) ) {
			$section_id = 'id="' . $instance['testimonial_menu_id'] . '"';
		}
		?>

		<div <?php echo $section_id ?> class="testimonial-slider testimonial-wrap">
			<div class="testimonials-all-content clearfix">

				<div class="testimonials-header">
					<?php if ( ! empty( $title ) ) { ?>
						<?php echo $before_title . esc_html( $title ) . $after_title; ?>
					<?php } ?>
					<?php if ( ! empty( $description ) ) { ?>
						<div class="testimonials-main-description">
							<p><?php echo wp_kses_post( $description ); ?></p>
						</div>
					<?php } ?>
				</div>

				<?php
				if ( $testimonial_num >= 1 ) : ?>

					<?php
					for ( $i = 1; $i <= $testimonial_num; $i ++ ) {
						$text        = 'text' . $i;
						$person_name = 'person_name' . $i;
						$byline      = 'byline' . $i;
						$image       = 'image' . $i;
						$class       = '';
						if ( $column_num == 'testimonial-column-layout-2' ) {
							if ( $i % 2 == 0 ) {
								$class = 'single-testimonial tg-one-half tg-one-half-last clearfix';
							} else {
								$class = 'single-testimonial tg-one-half clearfix';
							}
						} elseif ( $column_num == 'testimonial-column-layout-3' ) {
							if ( $i % 3 == 0 ) {
								$class = "single-testimonial tg-one-third tg-one-third-last";
							} else {
								$class = "single-testimonial tg-one-third";
							}
						} elseif ( $column_num == 'testimonial-column-layout-4' ) {
							if ( $i % 4 == 0 ) {
								$class = 'single-testimonial tg-one-fourth tg-one-fourth-last';
							} else {
								$class = 'single-testimonial tg-one-fourth';
							}
						}
						if ( ! empty( $instance[ $text ] ) ) {
							// For WPML plugin compatibility
							if ( function_exists( 'icl_register_string' ) ) {
								icl_register_string( 'Ample Pro', 'TG: Testimonial widget text' . $this->id . $i, $instance[ $text ] );
								if ( ! empty( $instance[ $person_name ] ) ) {
									icl_register_string( 'Ample Pro', 'TG: Testimonial widget person name' . $this->id . $i, $instance[ $person_name ] );
								}
								if ( ! empty( $instance[ $byline ] ) ) {
									icl_register_string( 'Ample Pro', 'TG: Testimonial widget byline' . $this->id . $i, $instance[ $byline ] );
								}
								if ( ! empty( $instance[ $image ] ) ) {
									icl_register_string( 'Ample Pro', 'TG: Testimonial widget image' . $this->id . $i, $instance[ $image ] );
								}
							}
							if ( function_exists( 'icl_t' ) ) {
								$instance[ $text ] = icl_t( 'Ample Pro', 'TG: Testimonial widget text' . $this->id . $i, $instance[ $text ] );
								if ( ! empty( $instance[ $person_name ] ) ) {
									$instance[ $person_name ] = icl_t( 'Ample Pro', 'TG: Testimonial widget person name' . $this->id . $i, $instance[ $person_name ] );
								}
								if ( ! empty( $instance[ $byline ] ) ) {
									$instance[ $byline ] = icl_t( 'Ample Pro', 'TG: Testimonial widget byline' . $this->id . $i, $instance[ $byline ] );
								}
								if ( ! empty( $instance[ $image ] ) ) {
									$instance[ $image ] = icl_t( 'Ample Pro', 'TG: Testimonial widget image' . $this->id . $i, $instance[ $image ] );
								}
							} ?>
							<div class="<?php echo $class; ?>">
								<div class="testimonial-image">
									<?php if ( ! empty( $instance[ $image ] ) ) { ?>
										<img src="<?php echo $instance[ $image ]; ?>" alt="<?php echo $instance[ $person_name ]; ?>">
										<?php
									} else { ?>
										<span><i class="fa fa-aw fa-user"></i></span>
									<?php } ?>
								</div>
								<div class="testimonial-content">
									<p>
										<?php echo wp_kses_post( $instance[ $text ] ); ?>
									</p>
									<div class="profile-detail">
										<span><strong><?php echo esc_html( $instance[ $person_name ] ); ?></strong></span>
										<span><?php echo esc_html( $instance[ $byline ] ); ?></span>
									</div>
								</div>
							</div>
						<?php }
					}
				endif;
				?>
			</div>
		</div>
		<?php

		echo $after_widget;
	}
}
