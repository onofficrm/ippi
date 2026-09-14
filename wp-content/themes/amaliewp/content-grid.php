<?php
/**
 * The default template for displaying grid content
 *
 * Used for grid page template.
 *
 * @package Amalie
 * @since Amalie 1.0
 */
?>

<div class="column clearfix">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'child-page' ); ?>>
		<?php if ( '' != get_the_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>">
				<?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				the_post_thumbnail( 'amalie-grid-image' );
				}
				?>
			</a>
		<?php endif; ?>

		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
		<footer class="entry-footer">
			<?php edit_post_link( esc_html__( 'Edit', 'amalie' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-footer -->

	</article>
	<!-- #post-## -->
</div>