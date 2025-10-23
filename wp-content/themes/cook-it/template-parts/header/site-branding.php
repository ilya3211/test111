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

$logotype_image = $wpshop_core->get_option( 'logotype_image' );

if ( ! empty( $logotype_image ) ) {
    $logotype_attachment_id = attachment_url_to_postid( $logotype_image );
    if ( ! empty( $logotype_attachment_id ) ) {
        $logotype_metadata = wp_get_attachment_metadata( $logotype_attachment_id );

        if ( ! empty( $logotype_metadata['width'] ) ) {
            $logotype_attributes[] = 'width="' . $logotype_metadata['width'] . '"';
        }
        if ( ! empty( $logotype_metadata['height'] ) ) {
            $logotype_attributes[] = 'height="' . $logotype_metadata['height'] . '"';
        }
    }
}

$logotype_attributes[] = 'alt="' . esc_attr( apply_filters( THEME_SLUG . '_logotype_alt', get_bloginfo( 'name' ) ) ) . '"';
$logotype_html = '<img src="' . $logotype_image . '" ' . implode( ' ', $logotype_attributes ) . '>';

?>

<div class="site-branding">

    <?php
    if ( ! empty( $logotype_image ) ) {
        if ( is_front_page() ) {
            if ( is_home() && is_paged()  ) {
                echo '<div class="site-logotype"><a href="'. esc_url( home_url( '/' ) ) .'">' . $logotype_html . '</a></div>';
            } else {
                echo '<div class="site-logotype">' . $logotype_html . '</div>';
            }
        } else {
            echo '<div class="site-logotype"><a href="'. esc_url( home_url( '/' ) ) .'">' . $logotype_html . '</a></div>';
        }
    }

    if ( ! $wpshop_core->get_option( 'header_hide_title' ) ) {

        $structure_home_h1 = $wpshop_core->get_option( 'structure_home_h1' );
        if ( ! $structure_home_h1 ) $structure_home_h1 = '';

        $site_title_text = get_bloginfo( 'name' );
        $site_title_tag  = apply_filters( THEME_SLUG . '_site_title_tag', 'div' );

        $description = get_bloginfo( 'description', 'display' );

        if ( is_front_page() && is_home() ) {

            if ( empty( $structure_home_h1 ) ) {
                $site_title_tag = 'h1';
            }

            if ( is_paged() ) {
                $site_title_text = '<a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>';
            }

        } else {
            if ( ! is_front_page() ) {
                $site_title_text = '<a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>';
            }
        }

        echo '<div class="site-branding__body">';

        if ( ! $wpshop_core->get_option( 'header_hide_title' ) ) {
            echo '<' . $site_title_tag . ' class="site-title">' . $site_title_text . '</' . $site_title_tag . '>';
        }
        if ( ( $description || is_customize_preview() ) && ! $wpshop_core->get_option( 'header_hide_description' ) ) {
            echo '<p class="site-description">' . $description . '</p>';
        }

        echo '</div>';

    }
    ?>

</div>