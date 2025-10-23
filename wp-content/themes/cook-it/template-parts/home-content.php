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

$structure_home_h1   = $wpshop_core->get_option( 'structure_home_h1' );
$structure_home_text = $wpshop_core->get_option( 'structure_home_text' );

if ( ! empty( $structure_home_h1 ) || ! empty( $structure_home_text ) || is_customize_preview() ) {

    echo '<div class="home-content">';

    if ( ! empty( $structure_home_h1 ) || is_customize_preview() ) {
        echo '<h1 class="home-header">' . $structure_home_h1 . '</h1>';
    }
    if ( ( ! empty( $structure_home_text ) || is_customize_preview() ) && ! is_paged() ) {
        echo '<div class="home-text">' . do_shortcode( wpautop( $structure_home_text ) ) . '</div>';
    }

    echo '</div>';

}