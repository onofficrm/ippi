<?php
/**
 * Extend WP_Customize_Control for to include Theme important links.
 *
 * Class AMPLE_Important_Links
 *
 * @since 2.1.8
 */

// Theme important links started
class AMPLE_Important_Links extends WP_Customize_Control {

	public $type = "ample-important-links";

	public function render_content() {
		//Add Theme instruction, Support Forum, Demo Link, Rating Link
		$important_links = array(
			'support'       => array(
				'link' => esc_url( 'https://themegrill.com/support-forum/' ),
				'text' => __( 'Free Support', 'ample' ),
			),
			'documentation' => array(
				'link' => esc_url( 'https://themegrill.com/theme-instruction/ample-pro/' ),
				'text' => __( 'Documentation', 'ample' ),
			),
			'demo'          => array(
				'link' => esc_url( 'https://demo.themegrill.com/ample-pro/' ),
				'text' => __( 'View Demo', 'ample' ),
			),
		);
		foreach ( $important_links as $important_link ) {
			echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr( $important_link['text'] ) . ' </a></p>';
		}
	}

}
