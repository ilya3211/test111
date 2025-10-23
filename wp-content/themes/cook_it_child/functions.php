<?php
/**
 * Child theme of Cook It
 * https://wpshop.ru/themes/cook-it
 *
 * @package Cook it
 */

/**
 * Enqueue child styles
 *
 * НЕ УДАЛЯЙТЕ ДАННЫЙ КОД
 */
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', 100);
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'cook-it-style-child', get_stylesheet_uri(), array( 'cook-it-style' )  );
}

/**
 * НИЖЕ ВЫ МОЖЕТЕ ДОБАВИТЬ ЛЮБОЙ СВОЙ КОД
 */