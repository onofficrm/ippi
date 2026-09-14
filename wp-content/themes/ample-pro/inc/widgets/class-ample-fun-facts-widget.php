<?php

/**
 * Class ample_fun_facts_widget.
 */
class ample_fun_facts_widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_fun_facts',
			'description'                 => esc_html__( 'Widget to show Fun Facts', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = esc_html__( 'TG: Fun Facts', 'ample' ), $widget_ops, $control_ops );
	}

	function form( $instance ) {
		$defaults                 = array();
		$defaults['team_menu_id'] = '';
		$defaults['facts_title']  = '';
		$defaults['facts_desc']   = '';
		for ( $i = 0; $i < 4; $i++ ) {
			$defaults[ 'fact_num_' . $i ]    = '';
			$defaults[ 'fact_detail_' . $i ] = '';
			$defaults[ 'fact_icon_' . $i ]   = '';
		}
		$instance     = wp_parse_args( (array) $instance, $defaults );
		$team_menu_id = $instance['team_menu_id'];
		$facts_title  = $instance['facts_title'];
		$facts_desc   = $instance['facts_desc'];
		?>

		<p><?php esc_html_e( 'Note: Enter the Fun Facts Section ID and use same for Menu item. Only used for One Page Sidebar.', 'ample' ); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'team_menu_id' ); ?>"><?php esc_html_e( 'Fun Facts Section ID:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'team_menu_id' ); ?>" name="<?php echo $this->get_field_name( 'team_menu_id' ); ?>" type="text" value="<?php echo esc_attr( $team_menu_id ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'facts_title' ); ?>"><?php esc_html_e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'facts_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'facts_title' ); ?>" type="text" value="<?php echo esc_attr( $facts_title ); ?>" />
		</p>
		<?php esc_html_e( 'Description:', 'ample' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'facts_desc' ); ?>" name="<?php echo $this->get_field_name( 'facts_desc' ); ?>"><?php echo esc_textarea( $facts_desc ); ?></textarea>

		<?php for ( $i = 0; $i < 4; $i++ ) : ?>
			<p>
				<label for="<?php echo $this->get_field_id( 'fact_num_' . $i ); ?>"><?php esc_html_e( 'Fact number: ', 'ample' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'fact_num_' . $i ); ?>" name="<?php echo $this->get_field_name( 'fact_num_' . $i ); ?>" type="number" step="1" min="1" value="<?php echo absint( $instance[ 'fact_num_' . $i ] ); ?>" size="10" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'fact_detail_' . $i ); ?>"><?php esc_html_e( 'Fact Detail:', 'ample' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'fact_detail_' . $i ); ?>" name="<?php echo $this->get_field_name( 'fact_detail_' . $i ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'fact_detail_' . $i ] ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'fact_icon_' . $i ); ?>"><?php esc_html_e( 'Icon Class:', 'ample' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'fact_icon_' . $i ); ?>" name="<?php echo $this->get_field_name( 'fact_icon_' . $i ); ?>" placeholder="fa-trophy" type="text" value="<?php echo esc_attr( $instance[ 'fact_icon_' . $i ] ); ?>" />
			</p>
			<hr />
		<?php endfor; ?>

		<p>
			<?php
			$url  = 'http://fontawesome.io/icons/';
			$link = sprintf( __( '<a href="%s" target="_blank">Refer here</a> For Icon Class', 'ample' ), esc_url( $url ) );
			echo $link;
			?>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['team_menu_id'] = sanitize_text_field( $new_instance['team_menu_id'] );
		$instance['facts_title']  = sanitize_text_field( $new_instance['facts_title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['facts_desc'] = $new_instance['facts_desc'];
		} else {
			$instance['facts_desc'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['facts_desc'] ) ) );
		}

		for ( $i = 0; $i < 4; $i++ ) {
			$instance[ 'fact_num_' . $i ]    = absint( $new_instance[ 'fact_num_' . $i ] );
			$instance[ 'fact_detail_' . $i ] = sanitize_text_field( $new_instance[ 'fact_detail_' . $i ] );
			$instance[ 'fact_icon_' . $i ]   = sanitize_text_field( $new_instance[ 'fact_icon_' . $i ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$facts_title  = apply_filters( 'widget_title', isset( $instance['facts_title'] ) ? $instance['facts_title'] : '' );
		$facts_desc   = isset( $instance['facts_desc'] ) ? $instance['facts_desc'] : '';
		$team_menu_id = isset( $instance['team_menu_id'] ) ? $instance['team_menu_id'] : '';
		// For WPML plugin compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Ample Pro', 'TG: Fun Facts widget description text' . $this->id, $facts_desc );
		}
		$fact_nums    = array();
		$fact_deatils = array();
		$fact_icons   = array();
		for ( $i = 0; $i < 4; $i++ ) {
			$fact_nums[]    = isset( $instance[ 'fact_num_' . $i ] ) ? $instance[ 'fact_num_' . $i ] : '';
			$fact_deatils[] = isset( $instance[ 'fact_detail_' . $i ] ) ? $instance[ 'fact_detail_' . $i ] : '';
			$fact_icons[]   = isset( $instance[ 'fact_icon_' . $i ] ) ? $instance[ 'fact_icon_' . $i ] : '';
			// For WPML plugin compatibility
			if ( function_exists( 'icl_register_string' ) && ! empty( $packages ) ) {
				icl_register_string( 'Ample Pro', 'TG: Fun Facts' . $this->id . $i, $fact_deatils[ $i ] );
			}
		}
		$section_id = '';
		if ( ! empty( $team_menu_id ) ) {
			$section_id = 'id="' . esc_attr( $team_menu_id ) . '"';
		}

		echo $before_widget; ?>

		<div <?php echo $section_id; ?> class="section-wrapper">
			<div class="tg-container fact clearfix">
				<?php if ( ! empty( $facts_title ) ) {
					echo $before_title . esc_html( $facts_title ) . $after_title;
				}
				if ( ! empty( $facts_desc ) ) { ?>
					<div class="fun-facts-main-description">
						<p><?php
							// For WPML plugin compatibility
							if ( function_exists( 'icl_t' ) ) {
								$facts_desc = icl_t( 'Ample Pro', 'TG: Fun Facts' . $this->id, $facts_desc );
							}
							echo wp_kses_post( $facts_desc ); ?></p>
					</div>
				<?php } ?>

				<div class="counter-wrapper">
					<?php
					for ( $i = 0; $i < 4; $i++ ) :
						if ( isset( $fact_nums ) || isset( $fact_deatils ) || isset( $fact_icons ) ) : ?>
							<div class="counter-block-wrapper clearfix">
								<?php
								// For WPML plugin compatibility
								if ( function_exists( 'icl_t' ) ) {
									$fact_deatils[ $i ] = icl_t( 'Ample Pro', 'TG: Fun Facts' . $this->id . $i, $fact_deatils[ $i ] );
								}
								echo '<span class="counter-icon"> <i class="fa ' . esc_attr( $fact_icons[ $i ] ) . '"></i> </span>';
								echo '<div class="counter-content">';
								echo '<span class="counter">' . esc_html( $fact_nums[ $i ] ) . '</span>';
								echo '<span class="counter-text">' . esc_html( $fact_deatils[ $i ] ) . '</span>';
								echo '</div>';
								?>
							</div>
						<?php endif;
					endfor;
					?>
				</div>
			</div>
		</div>
		<?php
		echo $after_widget;
	}
}
