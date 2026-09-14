<?php

/**
 * Class ample_service_widget.
 */
class ample_service_widget extends WP_Widget {
	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_service_block',
			'description'                 => esc_html__( 'Show your some pages as services.', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = esc_html__( 'TG: Service Widget', 'ample' ), $widget_ops, $control_ops );
	}

	function form( $instance ) {
		for ( $i = 1; $i <= 16; $i ++ ) {
			$var              = 'page_id' . $i;
			$defaults[ $var ] = '';
		}
		$defaults['service_menu_id'] = '';
		$defaults['title']           = '';
		$defaults['text']            = '';
		$defaults['image']           = '';
		$defaults['featured_image']  = '0';
		$defaults['select_column']   = 'services-column-layout-3';
		$defaults['new_tab']         = '0';
		$defaults['read_more']       = '0';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$service_menu_id = esc_attr( $instance['service_menu_id'] );
		$title           = esc_attr( $instance['title'] );
		$text            = esc_textarea( $instance['text'] );
		$image           = esc_url_raw( $instance['image'] );
		$featured_image  = $instance['featured_image'] ? 'checked="checked"' : '';
		$select_column   = $instance['select_column'];
		$new_tab         = $instance['new_tab'] ? 'checked="checked"' : '';
		$read_more       = $instance['read_more'] ? 'checked="checked"' : '';
		?>
		<p><?php _e( 'Note: Enter the Service Section ID and use same for Menu item. Only used for One Page Sidebar.', 'ample' ); ?></p>
		<p>
		<p>
			<label for="<?php echo $this->get_field_id( 'service_menu_id' ); ?>"><?php _e( 'Service Section ID:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'service_menu_id' ); ?>" name="<?php echo $this->get_field_name( 'service_menu_id' ); ?>" type="text" value="<?php echo $service_menu_id; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php _e( 'Description', 'ample' ); ?>
		<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"> <?php esc_html_e( 'Image:', 'ample' ); ?> </label>
			<br />
		<div class="media-uploader" id="<?php echo $this->get_field_id( 'image' ); ?>">
			<div class="custom_media_preview">
				<?php if ( $image != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance['image'] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo esc_url( $instance['image'] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'ample' ); ?></button>
		</div>
		</p>

		<p>
			<?php
			$url  = 'http://fontawesome.io/icons/';
			$link = sprintf( __( '<a href="%s" target="_blank">Refer here</a> For Icon Class', 'ample' ), esc_url( $url ) );
			echo $link;
			?>
		</p>

		<p><?php esc_html_e( 'Select the page to display Title and Excerpt.', 'ample' ) ?></p>
		<?php
		for ( $i = 1; $i <= 16; $i ++ ) {
			if ( $i % 2 != 0 ) { ?>
				<p>
					<label for="<?php echo $this->get_field_id( key( $defaults ) ); ?>"><?php esc_html_e( 'Page', 'ample' ); ?>
						:</label>
					<?php wp_dropdown_pages( array(
						'show_option_none' => ' ',
						'name'             => $this->get_field_name( key( $defaults ) ),
						'selected'         => $instance[ key( $defaults ) ],
					) ); ?>
				</p>
			<?php } elseif ( $i % 2 == 0 ) { ?>
				<p>
					<label for="<?php echo $this->get_field_id( key( $defaults ) ); ?>"><?php esc_html_e( 'Icon Class:', 'ample' ); ?></label>
					<input id="<?php echo $this->get_field_id( key( $defaults ) ); ?>" name="<?php echo $this->get_field_name( key( $defaults ) ); ?>" placeholder="fa-refresh" type="text" value="<?php echo $instance[ key( $defaults ) ]; ?>" />
				</p>
			<?php }
			next( $defaults );// forwards the key of $defaults array
		} ?>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $featured_image; ?> id="<?php echo $this->get_field_id( 'featured_image' ); ?>" name="<?php echo $this->get_field_name( 'featured_image' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'featured_image' ); ?>"><?php _e( 'Check to display Featured images instead of Icons.', 'ample' ); ?></label>
		</p>
		<?php esc_html_e( 'Select the services column', 'ample' ); ?>
		<p>
			<select id="<?php echo $this->get_field_id( 'select_column' ); ?>" name="<?php echo $this->get_field_name( 'select_column' ); ?>">
				<option value="services-column-layout-2" <?php if ( $select_column == 'services-column-layout-2' ) {
					echo 'selected="selected"';
				} ?> ><?php esc_html_e( 'Two Column', 'ample' ); ?></option>
				<option value="services-column-layout-3" <?php if ( $select_column == 'services-column-layout-3' ) {
					echo 'selected="selected"';
				} ?> ><?php esc_html_e( 'Three Column', 'ample' ); ?></option>
				<option value="services-column-layout-4" <?php if ( $select_column == 'services-column-layout-4' ) {
					echo 'selected="selected"';
				} ?> ><?php esc_html_e( 'Four Column', 'ample' ); ?></option>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $new_tab; ?> id="<?php echo $this->get_field_id( 'new_tab' ); ?>" name="<?php echo $this->get_field_name( 'new_tab' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'new_tab' ); ?>"><?php _e( 'Check to make Icon/Image and Title unclickable.', 'ample' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $read_more; ?> id="<?php echo $this->get_field_id( 'read_more' ); ?>" name="<?php echo $this->get_field_name( 'read_more' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'read_more' ); ?>"><?php _e( 'Check to display read more button', 'ample' ); ?></label>
			<?php esc_html_e( 'Note: When manual excerpt is added read more button is not shown by default.', 'ample' ); ?>
		</p>
	<?php }

	function update( $new_instance, $old_instance ) {
		$instance                    = $old_instance;
		$instance['service_menu_id'] = strip_tags( $new_instance['service_menu_id'] );
		$instance['title']           = strip_tags( $new_instance['title'] );
		for ( $i = 1; $i <= 16; $i ++ ) {
			$var = 'page_id' . $i;
			if ( $i % 2 != 0 ) {
				$instance[ $var ] = absint( $new_instance[ $var ] );
			} elseif ( $i % 2 == 0 ) {
				$instance[ $var ] = strip_tags( $new_instance[ $var ] );
			}
		}
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
		} // wp_filter_post_kses() expects slashed
		$instance['image']          = esc_url_raw( $new_instance['image'] );
		$instance['featured_image'] = isset( $new_instance['featured_image'] ) ? 1 : 0;
		$instance['select_column']  = $new_instance['select_column'];
		$instance['new_tab']        = isset( $new_instance['new_tab'] ) ? 1 : 0;
		$instance['read_more']      = isset( $new_instance['read_more'] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$service_menu_id = isset( $instance['service_menu_id'] ) ? $instance['service_menu_id'] : '';
		$title           = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$text            = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$image           = isset( $instance['image'] ) ? $instance['image'] : '';
		$featured_image  = ! empty( $instance['featured_image'] ) ? 'true' : 'false';
		$select_column   = isset( $instance['select_column'] ) ? $instance['select_column'] : 'services-column-layout-3';
		$new_tab         = ! empty( $instance['new_tab'] ) ? 'true' : 'false';
		$read_more       = ! empty( $instance['read_more'] ) ? 'true' : 'false';


		// For WPML plugin compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Ample Pro', 'TG: Service widget text' . $this->id, $text );
			icl_register_string( 'Ample Pro', 'TG: Service widget image' . $this->id, $image );
		}
		if ( function_exists( 'icl_t' ) ) {
			$text  = icl_t( 'Ample Pro', 'TG: Service widget text' . $this->id, $text );
			$image = icl_t( 'Ample Pro', 'TG: Service widget image' . $this->id, $image );
		}

		$page_array = array();
		$icon       = array();
		for ( $i = 1; $i <= 16; $i ++ ) {
			$var = 'page_id' . $i;
			if ( $i % 2 != 0 ) {
				$page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';
				if ( ! empty( $page_id ) ) {
					array_push( $page_array, $page_id );
				}// Push the page id in the array
			} elseif ( $i % 2 == 0 && ! ( empty( $page_id ) ) ) {
				$strn = $instance[ $var ];
				array_push( $icon, $strn );
			}
		}
		$get_featured_pages = new WP_Query( array(
			'posts_per_page' => - 1,
			'post_type'      => array( 'page' ),
			'post__in'       => $page_array,
			'orderby'        => 'post__in',
		) );
		echo $before_widget;

		$section_id = '';
		if ( ! empty( $service_menu_id ) ) {
			$section_id = 'id="' . $service_menu_id . '"';
		}
		?>

		<div <?php echo $section_id; ?> class="service-block">
			<div class="service-all-content">

				<?php if ( ! empty( $title ) ) { ?>
					<div class="services-header">
						<?php echo $before_title . esc_html( $title ) . $after_title; ?>
						<div class="services-main-description">
							<p>
								<?php echo wp_kses_post( $text ); ?>
							</p>
							<?php if ( ! empty( $image ) ) { ?>
								<?php $attachment_post_id = attachment_url_to_postid( $image );
								$img_altr                 = get_post_meta( $attachment_post_id, '_wp_attachment_image_alt', true );
								$img_alt                  = ! empty( $img_altr ) ? $img_altr : $title; ?>
								<img title="<?php echo esc_attr( $title ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" src="<?php echo $image; ?>">
							<?php } ?>
						</div>
					</div>
				<?php }
				if ( ! empty( $page_array ) ) : ?>
					<div class="services-content clearfix">
						<?php
						$i     = 1;
						$count = 0;
						while ( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();

							$service_wrap_class = '';
							if ( $select_column == 'services-column-layout-2' ) {
								if ( $i % 2 == 0 ) {
									$service_wrap_class = 'single-service tg-one-half tg-one-half-last clearfix';
								} else {
									$service_wrap_class = 'single-service tg-one-half clearfix';
								}
							} elseif ( $select_column == 'services-column-layout-4' ) {
								if ( $i % 4 == 0 ) {
									$service_wrap_class = 'single-service tg-one-fourth tg-one-fourth-last';
								} elseif ( ( $i + 1 ) % 4 == 0 ) {
									$service_wrap_class = 'single-service tg-one-fourth tg-after-two-blocks-clearfix';
								} else {
									$service_wrap_class = 'single-service tg-one-fourth';
								}
								if ( $i % 2 == 1 ) {
									$service_wrap_class .= ' ' . 'tg-column-odd';
								} else {
									$service_wrap_class .= ' ' . 'tg-column-even';
								}
							} elseif ( $select_column == 'services-column-layout-3' ) {
								if ( $i % 3 == 0 ) {
									$service_wrap_class = 'single-service tg-one-third tg-one-third-last';
								} else {
									$service_wrap_class = 'single-service tg-one-third';
								}
							}

							?>
							<div class="<?php echo $service_wrap_class; ?>">
								<?php
								if ( ! empty( $icon[ $count ] ) && $featured_image != 'true' ) { ?>
									<div class="icons">
										<?php if ( $new_tab == 'false' ) { ?>
										<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
											<?php } ?>
											<i class="fa fa-aw <?php echo esc_html( $icon[ $count ] ) ?> fa-3x"></i>
											<?php if ( $new_tab == 'false' ) { ?>
										</a>
									<?php } ?>
									</div>
								<?php } elseif ( $featured_image == 'true' && has_post_thumbnail() ) {
									$image           = '';
									$title_attribute = the_title_attribute( 'echo=0' );
									$image           .= '<figure class="post-featured-image">';
									if ( $new_tab == 'false' ) {
										$image .= '<a href="' . get_permalink() . '" title="' . $title_attribute . '">';
									}
									$image .= get_the_post_thumbnail( $post->ID, 'ample-service-image', array(
										'title' => $title_attribute,
										'alt'   => $title_attribute,
									) );
									if ( $new_tab == 'false' ) {
										$image .= '</a>';
									}
									$image .= '</figure>';

									echo $image;
								}
								?>
								<h5>
									<?php if ( $new_tab == 'false' ) { ?>
									<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
										<?php }
										echo esc_html( get_the_title() );
										if ( $new_tab == 'false' ) { ?>
									</a>
								<?php } ?>
								</h5>
								<?php the_excerpt(); ?>
								<?php if ( ( $read_more == 'true' ) && has_excerpt() ) {
									echo '<a class="more-link" href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"><span>' . ample_option( 'ample_read_more_text', __( 'Read more', 'ample' ) ) . '</span></a>';
								} ?>
							</div>
							<?php
							$count ++;
							$i ++;
						endwhile; ?>
					</div>
				<?php endif;
				// Reset Post Data
				wp_reset_query();
				?>
			</div>
		</div>
		<?php echo $after_widget;
	}
}
