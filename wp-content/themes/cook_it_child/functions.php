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
 * Enqueue header menu JavaScript
 */
add_action( 'wp_enqueue_scripts', 'enqueue_header_menu_script', 100);
function enqueue_header_menu_script() {
    wp_enqueue_script( 'header-menu', get_stylesheet_directory_uri() . '/js/header-menu.js', array(), '1.0.0', true );
}

/**
 * НИЖЕ ВЫ МОЖЕТЕ ДОБАВИТЬ ЛЮБОЙ СВОЙ КОД
 */

/**
 * Замена номера телефона 34343 на 555-0001
 * Работает через перехват всего HTML вывода
 */
add_action('template_redirect', 'cook_it_child_replace_phone_number');
function cook_it_child_replace_phone_number() {
    // Запускаем буферизацию вывода
    ob_start('cook_it_child_replace_phone_callback');
}

/**
 * Callback функция для замены номера в HTML
 */
function cook_it_child_replace_phone_callback($html) {
    // Заменяем номер телефона во всем HTML
    $html = str_replace('34343', '555-0001', $html);
    return $html;
}

/**
 * Add Hero Section to homepage
 */
add_action( 'cook_it_before_site_content', 'cook_it_child_add_hero_section' );
function cook_it_child_add_hero_section() {
    // Only show on front page
    if ( is_front_page() || is_home() ) {
        get_template_part( 'template-parts/hero/hero-section' );
    }
}