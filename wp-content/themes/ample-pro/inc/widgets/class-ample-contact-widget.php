<?php

/**
 * Class ample_contact_widget.
 */
class ample_contact_widget extends WP_Widget {
	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_contact_block',
			'description'                 => esc_html__( 'Show your Contact page.', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = esc_html__( 'TG: Contact Widget', 'ample' ), $widget_ops, $control_ops );
	}

	function form( $instance ) {
		$defaults['contact_menu_id'] = '';
		$defaults['title']           = '';
		$defaults['text']            = '';
		$defaults['page_id']         = '';
		$defaults['shortcode']       = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$contact_menu_id = esc_attr( $instance['contact_menu_id'] );
		$title           = esc_attr( $instance['title'] );
		$text            = esc_textarea( $instance['text'] );
		$page_id         = absint( $instance['page_id'] );
		$shortcode       = esc_attr( $instance['shortcode'] );
		?>
		<p><?php esc_html_e( 'Note: Enter the Contact Section ID and use same for Menu item. Only used for One Page Menu.', 'ample' ); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'contact_menu_id' ); ?>"><?php esc_html_e( 'Contact Section ID:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'contact_menu_id' ); ?>" name="<?php echo $this->get_field_name( 'contact_menu_id' ); ?>" type="text" value="<?php echo $contact_menu_id; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:', 'ample' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p><?php esc_html_e( 'Select a Contact page.', 'ample' ) ?></p>
		<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'Page', 'ample' ); ?>:</label>
		<?php wp_dropdown_pages( array(
			'show_option_none' => ' ',
			'name'             => $this->get_field_name( 'page_id' ),
			'selected'         => $instance['page_id'],
		) ); ?>

		<p><?php esc_html_e( 'Use Contact Form Plugin and enter the shortcode here:', 'ample' ) ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'shortcode' ); ?>"><?php esc_html_e( 'Shortcode', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'shortcode' ); ?>" name="<?php echo $this->get_field_name( 'shortcode' ); ?>" type="text" value="<?php echo $shortcode; ?>" />
		</p>
	<?php }

	function update( $new_instance, $old_instance ) {
		$instance                    = $old_instance;
		$instance['contact_menu_id'] = sanitize_text_field( $new_instance['contact_menu_id'] );
		$instance['title']           = sanitize_text_field( $new_instance['title'] );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
		} // wp_filter_post_kses() expects slashed

		$instance['page_id']   = absint( $new_instance['page_id'] );
		$instance['shortcode'] = sanitize_text_field( $new_instance['shortcode'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$contact_menu_id = isset( $instance['contact_menu_id'] ) ? $instance['contact_menu_id'] : '';
		$title           = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$text            = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$page_id         = isset( $instance['page_id'] ) ? $instance['page_id'] : '';
		$shortcode       = isset( $instance['shortcode'] ) ? $instance['shortcode'] : '';

		$section_id = '';
		if ( ! empty( $contact_menu_id ) ) {
			$section_id = 'id="' . $contact_menu_id . '"';
		}

		echo $before_widget; ?>
		<div <?php echo $section_id; ?> >

			<div class="contact-all-content">

				<div class="contact-header">
					<?php if ( ! empty( $title ) ) {
						echo $before_title . esc_html( $title ) . $after_title;
					}

					if ( ! empty( $text ) ) { ?>
						<div class="contact-main-description">
							<p><?php echo wp_kses_post( $text ); ?></p>
						</div>
					<?php } ?>
				</div>

				<div class="contact-form-wrapper contact-content clearfix">
					<?php if ( $page_id ) :
						$the_query = new WP_Query( array(
							'posts_per_page' => 1,
							'post_type'      => 'page',
							'post__in'       => array( $page_id ),
						) );
						while ( $the_query->have_posts() ):$the_query->the_post(); ?>

							<div class="tg-one-half clearfix">

								<h2 class="contact-title"> <?php the_title(); ?> </h2>

								<div class="contact-content"> <?php the_content(); ?> </div>
							</div>
						<?php endwhile;
					endif;
					// Reset Post Data
					wp_reset_query();
					if ( ! empty ( $shortcode ) ) { ?>
						<div class="tg-one-half tg-one-half-last clearfix">
							<?php echo do_shortcode( wp_kses_post( $shortcode ) ); ?>
						</div>
					<?php } ?>
				</div><!-- .contact-content-wrapper -->
			</div>
		</div>
		<?php echo $after_widget;
	}
}
