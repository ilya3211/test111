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

/**
 * Замена номера телефона в хедере
 * Заменяет 34343 на 555-0001
 */
add_filter('cook_it_get_option', 'replace_phone_number_in_header', 10, 2);
function replace_phone_number_in_header($value, $option_name) {
    // Проверяем HTML блоки в хедере
    if (in_array($option_name, array('header_html_block_1', 'header_html_block_2'))) {
        $value = str_replace('34343', '555-0001', $value);
    }
    return $value;
}

/**
 * Дополнительная замена через фильтр контента
 * На случай если номер выводится где-то еще
 */
add_filter('the_content', 'replace_phone_number_in_content', 999);
function replace_phone_number_in_content($content) {
    return str_replace('34343', '555-0001', $content);
}

/**
 * Замена в виджетах
 */
add_filter('widget_text', 'replace_phone_number_in_widgets', 999);
function replace_phone_number_in_widgets($text) {
    return str_replace('34343', '555-0001', $text);
}