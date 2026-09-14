<?php
/**
 * Theme Single Post Section for our theme.
 *
 * @package    ThemeGrill
 * @subpackage Ample Pro
 * @since      Ample 1.0
 */

get_header();

do_action( 'ample_before_body_content' ); ?>

<div class="single-page clearfix">
	<div class="inner-wrap">
		<div id="primary">
			<div id="content">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php get_template_part( 'navigation', 'single' ); ?>

					<?php if ( ( ample_option( 'ample_author_bio_setting', 0 ) == 1 ) && ( get_the_author_meta( 'description' ) ) ) { ?>
						<div class="author-box clearfix">
							<div class="author-img"><?php echo get_avatar( get_the_author_meta( 'user_email' ), '100' ); ?></div>
							<div class="author-description-wrapper">
								<h4 class="author-name"><?php the_author_meta( 'display_name' ); ?></h4>

								<p class="author-description"><?php the_author_meta( 'description' ); ?></p>
								<?php if ( ample_option( 'ample_author_bio_social_sites_show', 0 ) == 1 ) {
									ample_author_social_link();
								}
								?>
								<?php if ( ample_option( 'ample_author_bio_link_show', 0 ) == 1 ) { ?>
									<p class="author-url"><?php printf( __( '%1$s has %2$s posts and counting.', 'ample' ), get_the_author_meta( 'display_name' ), absint( count_user_posts( get_the_author_meta( 'ID' ) ) ) ); ?>
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php printf( __( 'See all posts by %1$s', 'ample' ), get_the_author_meta( 'display_name' ) ); ?></a>
									</p>
								<?php } ?>
							</div>
						</div>
					<?php } ?>

					<?php if ( ample_option( 'ample_related_posts_setting', 0 ) == 1 ) {
						get_template_part( 'inc/related-posts' );
					} ?>

					<?php
					do_action( 'ample_before_comments_template' );
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) {
						comments_template();
					}
					do_action( 'ample_after_comments_template' );
					?>
				<?php endwhile; ?>
			</div>
			<?php ample_both_sidebar_select(); ?>
		</div>

		<?php ample_sidebar_select(); ?>
	</div><!-- .inner-wrap -->
</div><!-- .single-page -->

<?php do_action( 'ample_after_body_content' );
get_footer(); ?>
