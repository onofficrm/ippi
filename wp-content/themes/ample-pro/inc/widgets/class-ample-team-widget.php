<?php

/**
 * Class ample_team_widget.
 */
class ample_team_widget extends WP_Widget {
	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_team_block',
			'description'                 => esc_html__( 'Display some pages as Team. Best for Business sidebar.', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = esc_html__( 'TG: Team', 'ample' ), $widget_ops, $control_ops );

		// Hooks.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		$options = $this->get_settings();

		// Enqueue script if widget is active (appears in a sidebar) or if in Customizer preview.
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			$widget_options = $options[ $this->number ];
			// Enqueue script if slider is active.
			if ( ! empty( $widget_options ) && $widget_options['enable_slider'] != '' ) {
				$carouselnum = '';
				if ( $widget_options['select_column'] == 'teams-column-layout-2' ) {
					$carouselnum = 2;
				} elseif ( $widget_options['select_column'] == 'teams-column-layout-3' ) {
					$carouselnum = 3;
				} else {
					$carouselnum = 4;
				}
				wp_enqueue_style( 'ample-bxslider' );
				wp_enqueue_script( 'ample-bxslider' );
				wp_localize_script(
					'ample-bxslider',
					'team_carousel_obj',
					array(
						'carouselnum' => $carouselnum,
					)
				);
			}
		}
	}

	function form( $instance ) {
		$defaults                     = array();
		$defaults['title']            = '';
		$defaults['team_menu_id']     = '';
		$defaults['background_color'] = '#80abc8';
		$defaults['background_image'] = '';
		$defaults['attachment']       = 'scroll';
		$defaults['text']             = '';
		$defaults['enable_slider']    = '';
		$defaults['image_link']       = '';
		$defaults['title_link']       = '';
		$defaults['select_column']    = 'teams-column-layout-3';
		$defaults['open_in_new_tab']  = '';

		for ( $i = 0; $i < 8; $i++ ) {
			$defaults[ 'page_' . $i ]        = '';
			$defaults[ 'designation_' . $i ] = '';
			$defaults[ 'fbook_' . $i ]       = '';
			$defaults[ 'twitter_' . $i ]     = '';
			$defaults[ 'gplus_' . $i ]       = '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = $instance['title'];
		$team_menu_id     = $instance['team_menu_id'];
		$background_color = $instance['background_color'];
		$background_image = $instance['background_image'];
		$attachment       = $instance['attachment'];
		$text             = $instance['text'];
		$enable_slider    = $instance['enable_slider'] ? 'checked="checked"' : '';
		$image_link       = $instance['image_link'] ? 'checked="checked"' : '';
		$title_link       = $instance['title_link'] ? 'checked="checked"' : '';
		$open_in_new_tab  = $instance['open_in_new_tab'] ? 'checked="checked"' : '';
		$select_column    = $instance['select_column'];
		?>
		<p><?php esc_html_e( 'Note: Enter the Team Section ID and use same for Menu item. Only used for One Page Sidebar.', 'ample' ); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'team_menu_id' ); ?>"><?php esc_html_e( 'Team Section ID:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'team_menu_id' ); ?>" name="<?php echo $this->get_field_name( 'team_menu_id' ); ?>" type="text" value="<?php echo esc_attr( $team_menu_id ); ?>" />
		</p>

		<p>
			<strong><?php esc_html_e( 'DESIGN SETTINGS :', 'ample' ); ?></strong><br />
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'ample' ); ?></label><br />
			<input class="my-color-picker" type="text" data-default-color="#80abc8" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo esc_attr( $background_color ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'ample' ); ?> </label>
			<br />
		<div class="media-uploader" id="<?php echo $this->get_field_id( 'background_image' ); ?>">
			<div class="custom_media_preview">
				<?php if ( $background_image != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance['background_image'] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="<?php echo esc_url( $instance['background_image'] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'background_image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'ample' ); ?></button>
		</div>
		</p>

		<p>
			<?php esc_html_e( 'Background attachment:', 'ample' ); ?> <br />
			<input type="radio" <?php checked( $attachment, 'scroll' ) ?> id="<?php echo $this->get_field_id( 'attachment' ); ?>" name="<?php echo $this->get_field_name( 'attachment' ); ?>" value="scroll" /><?php esc_html_e( 'Scroll', 'ample' ); ?>
			<input type="radio" <?php checked( $attachment, 'fixed' ) ?> id="<?php echo $this->get_field_id( 'attachment' ); ?>" name="<?php echo $this->get_field_name( 'attachment' ); ?>" value="fixed" style="margin-left: 20px;" /><?php esc_html_e( 'Fixed', 'ample' ); ?>
		</p>

		<strong><?php esc_html_e( 'OTHER SETTINGS :', 'ample' ); ?></strong><br />

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php esc_html_e( 'Description', 'ample' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $text ); ?></textarea>

		<?php
		for ( $i = 0; $i < 8; $i++ ) : ?>
			<p>
				<label for="<?php echo $this->get_field_id( 'page_' . $i ); ?>"><?php esc_html_e( 'Page:', 'ample' ); ?></label>
				<?php
				$arg = array(
					'class'            => 'widefat',
					'show_option_none' => ' ',
					'name'             => $this->get_field_name( 'page_' . $i ),
					'id'               => $this->get_field_id( 'page_' . $i ),
					'selected'         => absint( $instance[ 'page_' . $i ] ),
				);
				wp_dropdown_pages( $arg ); ?>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'designation_' . $i ); ?>"><?php esc_html_e( 'Designation:', 'ample' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'designation_' . $i ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'designation_' . $i ); ?>" type="text" value="<?php if ( isset ( $instance[ 'designation_' . $i ] ) ) {
					echo esc_attr( $instance[ 'designation_' . $i ] );
				} ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'fbook_' . $i ); ?>"><?php esc_html_e( 'Facebook:', 'ample' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'fbook_' . $i ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'fbook_' . $i ); ?>" type="text" value="<?php if ( isset ( $instance[ 'fbook_' . $i ] ) ) {
					echo esc_url( $instance[ 'fbook_' . $i ] );
				} ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'twitter_' . $i ); ?>"><?php esc_html_e( 'Twitter:', 'ample' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'twitter_' . $i ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'twitter_' . $i ); ?>" type="text" value="<?php if ( isset ( $instance[ 'twitter_' . $i ] ) ) {
					echo esc_url( $instance[ 'twitter_' . $i ] );
				} ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'gplus_' . $i ); ?>"><?php esc_html_e( 'Google Plus:', 'ample' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'gplus_' . $i ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'gplus_' . $i ); ?>" type="text" value="<?php if ( isset ( $instance[ 'gplus_' . $i ] ) ) {
					echo esc_url( $instance[ 'gplus_' . $i ] );
				} ?>" />
			</p>

			<hr />

		<?php endfor; ?>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $enable_slider; ?> id="<?php echo $this->get_field_id( 'enable_slider' ); ?>" name="<?php echo $this->get_field_name( 'enable_slider' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'enable_slider' ); ?>"><?php esc_html_e( 'Show team members in slider', 'ample' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $image_link; ?> id="<?php echo $this->get_field_id( 'image_link' ); ?>" name="<?php echo $this->get_field_name( 'image_link' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'image_link' ); ?>"><?php esc_html_e( 'Link featured image to their respective page', 'ample' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $title_link; ?> id="<?php echo $this->get_field_id( 'title_link' ); ?>" name="<?php echo $this->get_field_name( 'title_link' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'title_link' ); ?>"><?php esc_html_e( 'Link title to their respective page', 'ample' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $open_in_new_tab; ?> id="<?php echo $this->get_field_id( 'open_in_new_tab' ); ?>" name="<?php echo $this->get_field_name( 'open_in_new_tab' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'open_in_new_tab' ); ?>"><?php esc_html_e( 'Check to open in new tab.', 'ample' ); ?></label>
		</p>

		<?php esc_html_e( 'Select the teams column', 'ample' ); ?>

		<p>
			<select id="<?php echo $this->get_field_id( 'select_column' ); ?>" name="<?php echo $this->get_field_name( 'select_column' ); ?>">
				<option value="teams-column-layout-2" <?php if ( $select_column == 'teams-column-layout-2' ) {
					echo 'selected="selected"';
				} ?> ><?php esc_html_e( 'Two Column', 'ample' ); ?></option>
				<option value="teams-column-layout-3" <?php if ( $select_column == 'teams-column-layout-3' ) {
					echo 'selected="selected"';
				} ?> ><?php esc_html_e( 'Three Column', 'ample' ); ?></option>
				<option value="teams-column-layout-4" <?php if ( $select_column == 'teams-column-layout-4' ) {
					echo 'selected="selected"';
				} ?> ><?php esc_html_e( 'Four Column', 'ample' ); ?></option>
			</select>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                     = $old_instance;
		$instance['team_menu_id']     = sanitize_text_field( $new_instance['team_menu_id'] );
		$instance['background_color'] = esc_attr( $new_instance['background_color'] );
		$instance['background_image'] = esc_url_raw( $new_instance['background_image'] );
		$instance['attachment']       = sanitize_key( $new_instance['attachment'] );
		$instance['title']            = sanitize_text_field( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
		}

		for ( $i = 0; $i < 8; $i++ ) {
			$instance[ 'page_' . $i ]        = absint( $new_instance[ 'page_' . $i ] );
			$instance[ 'designation_' . $i ] = sanitize_text_field( $new_instance[ 'designation_' . $i ] );
			$instance[ 'fbook_' . $i ]       = esc_url_raw( $new_instance[ 'fbook_' . $i ] );
			$instance[ 'twitter_' . $i ]     = esc_url_raw( $new_instance[ 'twitter_' . $i ] );
			$instance[ 'gplus_' . $i ]       = esc_url_raw( $new_instance[ 'gplus_' . $i ] );
		}
		$instance['image_link']      = isset( $new_instance['image_link'] ) ? 1 : 0;
		$instance['title_link']      = isset( $new_instance['title_link'] ) ? 1 : 0;
		$instance['enable_slider']   = isset( $new_instance['enable_slider'] ) ? 1 : 0;
		$instance['select_column']   = sanitize_key( $new_instance['select_column'] );
		$instance['open_in_new_tab'] = isset( $new_instance['open_in_new_tab'] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$team_menu_id     = isset( $instance['team_menu_id'] ) ? $instance['team_menu_id'] : '';
		$background_color = isset( $instance['background_color'] ) ? $instance['background_color'] : '';
		$background_image = isset( $instance['background_image'] ) ? $instance['background_image'] : '';
		$attachment       = isset( $instance['attachment'] ) ? $instance['attachment'] : '';
		$title            = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$text             = isset( $instance['text'] ) ? $instance['text'] : '';
		// For WPML plugin compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Ample Pro', 'TG: Team widget description text' . $this->id, $text );
		}
		$image_link      = ! empty( $instance['image_link'] ) ? 'true' : 'false';
		$title_link      = ! empty( $instance['title_link'] ) ? 'true' : 'false';
		$enable_slider   = ! empty( $instance['enable_slider'] ) ? 'true' : 'false';
		$open_in_new_tab = ! empty( $instance['open_in_new_tab'] ) ? 'true' : 'false';
		$select_column   = isset( $instance['select_column'] ) ? $instance['select_column'] : 'teams-column-layout-3';

		$page        = array();
		$designation = array();
		$fbook       = array();
		$twitter     = array();
		$gplus       = array();
		for ( $i = 0; $i < 8; $i++ ) {
			$page[]        = isset( $instance[ 'page_' . $i ] ) ? $instance[ 'page_' . $i ] : '';
			$designation[] = isset( $instance[ 'designation_' . $i ] ) ? $instance[ 'designation_' . $i ] : '';
			$fbook[]       = isset( $instance[ 'fbook_' . $i ] ) ? $instance[ 'fbook_' . $i ] : '';
			$twitter[]     = isset( $instance[ 'twitter_' . $i ] ) ? $instance[ 'twitter_' . $i ] : '';
			$gplus[]       = isset( $instance[ 'gplus_' . $i ] ) ? $instance[ 'gplus_' . $i ] : '';

			// For WPML plugin compatibility
			if ( function_exists( 'icl_register_string' ) ) {
				if ( ! empty ( $designation ) ) {
					icl_register_string( 'Ample Pro', 'TG: Team member designation' . $this->id . $i, $designation[ $i ] );
				}
			}
		}

		if ( ! empty( $page ) ) {
			$get_featured_pages = new WP_Query( array(
				'posts_per_page' => count( $page ),
				'post_type'      => array( 'page' ),
				'post__in'       => $page,
				'orderby'        => 'post__in',
			) );

			//Add class if slider actiove.
			$team_wrapper_class = array( $select_column );
			if ( $enable_slider == 'true' ) {
				$team_wrapper_class[] = 'team-slider';
			}

			$image_style = '';
			if ( ! empty( $background_image ) ) {
				$image_style .= 'background-image:url(' . esc_url( $background_image ) . ');background-attachment:' . esc_attr( $attachment ) . ';background-repeat:no-repeat;background-size:cover;';
			} else {
				$image_style .= 'background-color:' . esc_attr( $background_color ) . ';';
			}

			$section_id = '';
			if ( ! empty( $team_menu_id ) ) {
				$section_id = 'id="' . esc_attr( $team_menu_id ) . '"';
			}

			echo $before_widget; ?>

			<div <?php echo $section_id; ?> class="all-teams" style="<?php echo $image_style; ?>">

				<div class="inner-wrap clearfix">
					<?php
					if ( ! empty( $title ) ) {
						echo $before_title . esc_html( $title ) . $after_title;
					} ?>
					<div class="team-main-description">
						<p><?php
							// For WPML plugin compatibility
							if ( function_exists( 'icl_t' ) ) {
								$text = icl_t( 'Ample Pro', 'TG: Team widget description text' . $this->id, $text );
							}
							echo wp_kses_post( $text ); ?></p>
					</div>

					<div class="team-member-wrapper clearfix <?php echo esc_attr( implode( ' ', $team_wrapper_class ) ) ?>">
						<?php
						$count = 0;
						while ( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
							$post_count = $count + 1;
							$team_class = '';
							$col_num    = '';
							if ( $select_column == 'teams-column-layout-2' ) :
								if ( $post_count % 2 == 0 && $enable_slider == 'false' ) {
									$team_class = 'tg-one-half tg-one-half-last';
								} else {
									$team_class = 'tg-one-half';
								}
								$col_num = 2;
							elseif ( $select_column == 'teams-column-layout-3' ) :
								if ( $post_count % 3 == 0 && $enable_slider == 'false' ) {
									$team_class = "tg-one-third tg-one-third-last";
								} else {
									$team_class = "tg-one-third";
								}
								$col_num = 3;
							elseif ( $select_column == 'teams-column-layout-4' ) :
								if ( $post_count % 4 == 0 && $enable_slider == 'false' ) {
									$team_class = 'tg-one-fourth tg-one-fourth-last';
								} else {
									$team_class = 'tg-one-fourth';
								}
								$col_num = 4;
							endif;
							?>
							<div class="<?php echo esc_attr( $team_class ); ?> team-block-wrapper">
								<?php
								$new_tab = '';
								if ( $open_in_new_tab == "true" ) {
									$new_tab = 'target="_blank"';
								}
								?>
								<?php
								if ( has_post_thumbnail() ) {
									$title_attribute     = get_the_title( $post->ID );
									$thumb_id            = get_post_thumbnail_id( get_the_ID() );
									$img_altr            = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
									$img_alt             = ! empty( $img_altr ) ? $img_altr : $title_attribute;
									$post_thumbnail_attr = array(
										'alt'   => esc_attr( $img_alt ),
										'title' => esc_attr( $title_attribute ),
									);
									if ( $image_link == 'true' ) {
										echo '<div class="team-image"><a title="' . esc_attr( get_the_title() ) . '" href="' . esc_url( get_permalink() ) . '"' . esc_attr( $new_tab ) . '>' . get_the_post_thumbnail( $post->ID, 'ample-portfolio-image', $post_thumbnail_attr ) . '</a></div>';
									} else {
										echo '<div class="team-image">' . get_the_post_thumbnail( $post->ID, 'ample-portfolio-image' ) . '</div>';
									}
								}
								?>
								<h3 class="team-title">
									<?php if ( $title_link == 'true' ) : ?>
										<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" <?php echo esc_attr( $new_tab ); ?>><?php the_title(); ?></a>
									<?php else : ?>
										<?php the_title(); ?>
									<?php endif; ?>
								</h3>
								<?php if ( ! empty( $designation ) ) :
									// For WPML plugin compatibility
									if ( function_exists( 'icl_t' ) ) {
										$designation[ $count ] = icl_t( 'Ample Pro', 'TG: Team member designation' . $this->id . $count, $designation[ $count ] );
									} ?>
									<span class="team-designation"><?php echo esc_html( $designation[ $count ] ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $fbook ) || ! empty( $twitter ) || ! empty( $gplus ) ) : ?>
									<div class="team-social-icon">
										<ul>
											<?php if ( ! empty( $fbook[ $count ] ) ) : ?>
												<li>
													<a href="<?php echo esc_url( $fbook[ $count ] ); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
												</li>
											<?php endif; ?>

											<?php if ( ! empty( $twitter[ $count ] ) ) : ?>
												<li>
													<a href="<?php echo esc_url( $twitter[ $count ] ); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
												</li>
											<?php endif; ?>
											<?php if ( ! empty( $gplus[ $count ] ) ) : ?>
												<li>
													<a href="<?php echo esc_url( $gplus[ $count ] ); ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
												</li>
											<?php endif; ?>
										</ul>
									</div><!-- .team-social-icon -->
								<?php endif; ?>

								<div class="team-description">
									<?php the_excerpt(); ?>
								</div>

							</div>
							<?php
							// dynamic add clearfix div.
							if ( $post_count % $col_num == 0 && $enable_slider != 'true' ) {
								echo '<div class="clearfix"></div>';
							}
							$count++; endwhile;
						// Reset Post Data
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div><!-- .all-team end -->
			<?php
			echo $after_widget;
		}
	}
}
