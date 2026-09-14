<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 * @package ThemeGrill
 * @subpackage Ample Pro
 * @since Ample 1.0
 */
?>

<?php
/**
 * The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if( !is_active_sidebar( 'ample_footer_sidebar1' ) &&
   !is_active_sidebar( 'ample_footer_sidebar2' ) &&
   !is_active_sidebar( 'ample_footer_sidebar3' ) &&
   !is_active_sidebar( 'ample_footer_sidebar4' ) ) {
   return;
}

// Assign the dynamic classes for the footer column select option
if ( ample_option( 'ample_footer_column_select_setting' , 'four') == 'one' ) {
   $footer_column_one_class   = 'tg-column-full';
   $footer_column_two_class   = '';
   $footer_column_three_class = '';
   $footer_column_four_class  = '';
} else if ( ample_option( 'ample_footer_column_select_setting', 'four' ) == 'two' ){
   $footer_column_one_class   = 'tg-one-half';
   $footer_column_two_class   = 'tg-one-half tg-one-half-last';
   $footer_column_three_class = '';
   $footer_column_four_class  = '';
} else if ( ample_option( 'ample_footer_column_select_setting', 'four' ) == 'three' ){
   $footer_column_one_class   = 'tg-one-third';
   $footer_column_two_class   = 'tg-one-third';
   $footer_column_three_class = 'tg-one-third tg-one-third-last';
   $footer_column_four_class  = '';
} else if ( ample_option( 'ample_footer_column_select_setting', 'four' ) == 'four' ){
   $footer_column_one_class   = 'footer-box tg-one-fourth tg-column-odd';
   $footer_column_two_class   = 'footer-box tg-one-fourth tg-column-even';
   $footer_column_three_class = 'footer-box tg-one-fourth tg-after-two-blocks-clearfix tg-column-odd';
   $footer_column_four_class  = 'footer-box tg-one-fourth tg-one-fourth-last tg-column-even';
}
?>
<div class="footer-widgets-wrapper">
   <div class="footer-widgets-area clearfix">
      <div class="<?php echo esc_attr( $footer_column_one_class ); ?>">
         <?php
         // Calling the footer sidebar if it exists.
         if ( !dynamic_sidebar( 'ample_footer_sidebar1' ) ):
         endif;
         ?>
      </div>

      <?php if ( $footer_column_two_class != '' ) : ?>
         <div class="<?php echo esc_attr( $footer_column_two_class ); ?>">
            <?php
            // Calling the footer sidebar if it exists.
            if ( !dynamic_sidebar( 'ample_footer_sidebar2' ) ):
            endif;
            ?>
         </div>
      <?php endif; ?>

      <?php if ( $footer_column_three_class != '' ) : ?>
         <div class="<?php echo esc_attr( $footer_column_three_class ); ?>">
            <?php
            // Calling the footer sidebar if it exists.
            if ( !dynamic_sidebar( 'ample_footer_sidebar3' ) ):
            endif;
            ?>
         </div>
      <?php endif; ?>

      <?php if ( $footer_column_four_class != '' ) : ?>
         <div class="<?php echo esc_attr( $footer_column_four_class ); ?>">
            <?php
            // Calling the footer sidebar if it exists.
            if ( !dynamic_sidebar( 'ample_footer_sidebar4' ) ):
            endif;
            ?>
         </div>
      <?php endif; ?>
   </div>
</div>
