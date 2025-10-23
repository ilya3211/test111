<?php
/**
 * ****************************************************************************
 *
 *   DON'T EDIT THIS FILE
 *   After update you will lose all changes. Use child theme
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *
 *   https://support.wpshop.ru/docs/general/child-themes/
 *
 * *****************************************************************************
 *
 * @package cook-it
 */

global $wpshop_core;
?>

<?php if ( has_nav_menu( 'footer_menu' ) ) {  ?>
    <div class="footer-navigation <?php $wpshop_core->the_option( 'footer_menu_width' ) ?>" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <div class="footer-navigation-inner <?php $wpshop_core->the_option( 'footer_menu_inner_width' ) ?>">
            <?php wp_nav_menu( array( 'theme_location' => 'footer_menu', 'menu_class' => 'b-menu-footer' ) ); ?>
        </div>
    </div><!--footer-navigation-->
<?php } ?>