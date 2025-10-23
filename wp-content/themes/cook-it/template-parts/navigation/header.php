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

$is_show_header_menu = $wpshop_core->is_show_element( 'header_menu' );

/**
 * Check menu exist, if no - add separator
 */
if ( has_nav_menu( 'header_menu' ) && $is_show_header_menu ) { ?>

    <?php do_action( THEME_SLUG . '_before_main_navigation' ); ?>

    <nav id="site-navigation" class="site-navigation <?php $wpshop_core->the_option( 'header_menu_width' ) ?>" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <div class="site-navigation-inner <?php $wpshop_core->the_option( 'header_menu_inner_width' ) ?>">
            <?php wp_nav_menu( array( 'theme_location' => 'header_menu', 'menu_id' => 'header_menu', 'menu_class' => 'b-menu' ) ) ?>
        </div>
    </nav><!-- #site-navigation -->

    <?php do_action( THEME_SLUG . '_after_main_navigation' ); ?>

<?php } else { ?>

    <nav id="site-navigation" class="site-navigation <?php $wpshop_core->the_option( 'header_menu_width' ) ?>" style="display: none;">
        <div class="site-navigation-inner <?php $wpshop_core->the_option( 'header_menu_inner_width' ) ?>">
            <ul id="header_menu"></ul>
        </div>
    </nav>
    <div class="container header-separator"></div>

<?php } ?>