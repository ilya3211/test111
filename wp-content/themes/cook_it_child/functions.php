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

/**
 * Change ingredients taxonomy rewrite slug from /ingredients/ to /search/
 * URL structure: http://site.com/search/сахар-песок/
 */
add_action( 'init', 'cook_it_child_change_ingredients_slug', 999 );
function cook_it_child_change_ingredients_slug() {
    // Get the existing taxonomy object
    $taxonomy = 'ingredients';

    // Check if taxonomy exists
    if ( !taxonomy_exists( $taxonomy ) ) {
        return;
    }

    // Get existing taxonomy object
    global $wp_taxonomies;

    if ( isset( $wp_taxonomies[$taxonomy] ) ) {
        // Change the rewrite slug
        $wp_taxonomies[$taxonomy]->rewrite = array(
            'slug'         => 'search',
            'with_front'   => false,
            'hierarchical' => true,
        );
    }
}

/**
 * Flush rewrite rules on theme activation (one time)
 * This ensures the new /search/ URLs work correctly
 */
add_action( 'after_switch_theme', 'cook_it_child_flush_rewrite_rules' );
function cook_it_child_flush_rewrite_rules() {
    // Trigger init actions to register taxonomies
    do_action( 'init' );

    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Replace all internal /ingredients/ links with /search/ links
 * This ensures all existing content uses the new URL structure
 */

// Replace in post content
add_filter( 'the_content', 'cook_it_child_replace_ingredients_links' );
// Replace in excerpts
add_filter( 'the_excerpt', 'cook_it_child_replace_ingredients_links' );
// Replace in text widgets
add_filter( 'widget_text', 'cook_it_child_replace_ingredients_links' );

function cook_it_child_replace_ingredients_links( $content ) {
    // Replace /ingredients/ with /search/ in all links
    $content = str_replace( '/ingredients/', '/search/', $content );

    // Also handle full URLs with domain
    $content = str_replace(
        'http://regret49.beget.tech/ingredients/',
        'http://regret49.beget.tech/search/',
        $content
    );

    return $content;
}

// Replace in term links (category/tag/taxonomy archive links)
add_filter( 'term_link', 'cook_it_child_replace_term_link', 10, 3 );
function cook_it_child_replace_term_link( $url, $term, $taxonomy ) {
    // Only replace for ingredients taxonomy
    if ( $taxonomy === 'ingredients' ) {
        $url = str_replace( '/ingredients/', '/search/', $url );
    }
    return $url;
}

// Replace in menus
add_filter( 'wp_nav_menu', 'cook_it_child_replace_menu_links' );
function cook_it_child_replace_menu_links( $menu ) {
    $menu = str_replace( '/ingredients/', '/search/', $menu );
    $menu = str_replace(
        'http://regret49.beget.tech/ingredients/',
        'http://regret49.beget.tech/search/',
        $menu
    );
    return $menu;
}