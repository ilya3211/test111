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

<?php do_action( THEME_SLUG . '_before_header' ) ?>

<header id="masthead" class="site-header <?php $wpshop_core->the_option( 'header_width' ) ?>" itemscope itemtype="http://schema.org/WPHeader">
    <div class="site-header-inner <?php $wpshop_core->the_option( 'header_inner_width' ) ?>">

        <?php get_template_part( 'template-parts/header/site', 'branding' ) ?>

        <?php $header_html_block_1 = $wpshop_core->get_option( 'header_html_block_1' );
        if ( ! empty( $header_html_block_1 ) ) { ?>
            <div class="header-html-1">
                <?php echo do_shortcode( $header_html_block_1 ); ?>
            </div>
        <?php } ?>


        <?php if ( $wpshop_core->get_option( 'header_social' ) ) {
            get_template_part( 'template-parts/social', 'links' );
        } ?>

        <?php //echo get_search_form(); ?>

        <?php
        if ( has_nav_menu( 'top_menu' ) ) {
            wp_nav_menu( array( 'theme_location' => 'top_menu', 'menu_id' => 'top-menu', 'menu_class' => 'menu-top' ) );
        }
        ?>

        <?php $header_html_block_2 = $wpshop_core->get_option( 'header_html_block_2' );
        if ( ! empty( $header_html_block_2 ) ) { ?>
            <div class="header-html-2">
                <?php echo do_shortcode( $header_html_block_2 ); ?>
            </div>
        <?php } ?>

        <div class="humburger js-humburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <?php if ( $wpshop_core->get_option( 'header_search' ) ) { ?>
            <div class="header-search"><?php get_search_form(); ?></div>
        <?php } ?>
    </div><!--.site-header-inner-->
</header><!--.site-header-->

<?php do_action( THEME_SLUG . '_after_header' ) ?>