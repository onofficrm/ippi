<?php
/**
 * Template Name: Template for Page Builder
 *
 */

get_header(); ?>

	<div class="builder-content">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page-blank' ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
<?php get_footer(); ?>