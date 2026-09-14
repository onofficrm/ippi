<?php
/**
 * The template for displaying search forms.
 *
 * @package ThemeGrill
 * @subpackage Ample Pro
 * @since Ample 1.0
 */
?>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form searchform clearfix" method="get">
   <div class="search-wrap">
      <input type="text" value="<?php echo get_search_query(); ?>"  placeholder="<?php esc_attr_e( 'Search', 'ample' ); ?>" class="s field" name="s">
      <button class="search-icon" type="submit"></button>
   </div>
</form><!-- .searchform -->