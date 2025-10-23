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
global $wpshop_advertising;

$is_show_header = $wpshop_core->is_show_element( 'header' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <?php $wpshop_core->the_option( 'code_head' ) ?>
</head>

<body <?php body_class(); ?>>
<?php $wpshop_core->check_license() ?>

<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
} ?>

<?php do_action( THEME_SLUG . '_after_body' ) ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', THEME_TEXTDOMAIN ); ?></a>

    <?php
    if ( $is_show_header ) {
        get_template_part( 'template-parts/header/header' );
    }
    ?>

    <?php get_template_part( 'template-parts/navigation/header' ) ?>

    <?php do_action( THEME_SLUG . '_before_site_content' ) ?>

    <?php
    if ( apply_filters( THEME_SLUG . '_slider_output', is_front_page() || is_home() ) ) {
        if ( ! empty( $wpshop_core->get_option( 'slider_count' ) ) && ( ! is_paged() || ( $wpshop_core->get_option( 'slider_show_on_paged' ) && is_paged() ) ) ) {
            if ( ! wp_is_mobile() || ( wp_is_mobile() && ! $wpshop_core->get_option( 'slider_mob_disable' ) ) ) {
                if ( $wpshop_core->get_option( 'slider_width' ) == 'fixed') echo '<div class="container">';
                get_template_part( 'template-parts/slider', 'posts' );
                if ( $wpshop_core->get_option( 'slider_width' ) == 'fixed') echo '</div>';
            }
        }
    }
    ?>

	<div id="content" class="site-content <?php site_content_classes() ?>">

        <?php echo $wpshop_advertising->show_ad( 'before_site_content' ); ?>

        <div class="site-content-inner">
