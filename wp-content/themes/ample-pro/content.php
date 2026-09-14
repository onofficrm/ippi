<?php
/**
 * This template is used to display content of page.
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'ample_before_post_content' ); ?>

	<?php
	if ( is_single() ) { ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php } else { ?>
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	<?php } ?>

	<?php ample_meta_select(); ?>

	<?php
	if ( has_post_thumbnail() ) {
		$image           = '';
		$title_attribute = the_title_attribute( 'echo=0' );
		$thumb_id        = get_post_thumbnail_id( get_the_ID() );
		$img_altr        = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
		$img_alt         = ! empty( $img_altr ) ? $img_altr : $title_attribute;
		$image           .= '<figure class="post-featured-image">';
		$image           .= '<a href="' . get_permalink() . '" title="' . $title_attribute . '">';
		$image           .= get_the_post_thumbnail( $post->ID, 'ample-featured-blog-large', array(
				'title' => $title_attribute,
				'alt'   => $img_alt,
			) ) . '</a>';
		$image           .= '</figure>';

		echo $image;
	}
	?>

	<div class="entry-summary">
		<?php
		global $more;
		$more = 0;
		if ( ample_option( 'ample_toggle_excerpt_full_post_setting', 'full_post' ) == 'excerpt' ) {
			the_excerpt();
			if ( ( ample_option( 'ample_read_more_button', 0 ) == 1 ) && has_excerpt() ) {
				echo '<a class="more-link" href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"><span>' . ample_option( 'ample_read_more_text', __( 'Read more', 'ample' ) ) . '</span></a>';
			}
		} else {
			the_content( '<span>' . ample_option( 'ample_read_more_text', __( 'Read more', 'ample' ) ) . '</span>' );
		}
		?>
	</div>

	<?php do_action( 'ample_after_post_content' ); ?>
</article>
