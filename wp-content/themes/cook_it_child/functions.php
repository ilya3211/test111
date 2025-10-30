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

/**
 * Change ingredients taxonomy rewrite slug from /ingredients/ to /tags/
 * URL structure: http://site.com/tags/сахар-песок/
 *
 * NOTE: Using 'tags' to provide a cleaner URL structure
 *
 * IMPORTANT: After activating this code, go to WordPress Admin → Settings → Permalinks
 * and click "Save Changes" to flush rewrite rules manually.
 */

// Unregister the original ingredients taxonomy
add_action('init', 'cook_it_child_unregister_ingredients', 20);
function cook_it_child_unregister_ingredients() {
    unregister_taxonomy_for_object_type('ingredients', 'post');
}

// Re-register ingredients taxonomy with new slug
add_action('init', 'cook_it_child_register_ingredients', 30);
function cook_it_child_register_ingredients() {
    $labels = array(
        'name'              => 'Ингредиенты',
        'singular_name'     => 'Ингредиент',
        'search_items'      => 'Найти ингредиенты',
        'all_items'         => 'Все ингредиенты',
        'view_item'         => 'Просмотр ингредиента',
        'parent_item'       => 'Родительский ингредиент',
        'parent_item_colon' => 'Родительский ингредиент:',
        'edit_item'         => 'Редактировать ингредиент',
        'update_item'       => 'Обновить ингредиент',
        'add_new_item'      => 'Добавить новый ингредиент',
        'new_item_name'     => 'Название нового ингредиента',
        'not_found'         => 'Ингредиенты не найдены',
        'menu_name'         => 'Ингредиенты',
    );

    $args = array(
        'labels'                     => $labels,
        'public'                     => true,
        'publicly_queryable'         => true,
        'show_ui'                    => true,
        'show_in_menu'               => true,
        'show_in_nav_menus'          => true,
        'show_in_rest'               => true,
        'show_tagcloud'              => true,
        'meta_box_cb'                => false,
        'rewrite'                    => array(
            'slug'         => 'tags',
            'with_front'   => false,
            'hierarchical' => false,
        ),
    );

    register_taxonomy('ingredients', array('post'), $args);
}

// Flush rewrite rules once
add_action('admin_init', 'cook_it_child_flush_rewrite_rules');
function cook_it_child_flush_rewrite_rules() {
    if (get_option('cook_it_child_flush_rewrite_rules_flag') !== 'done') {
        flush_rewrite_rules();
        update_option('cook_it_child_flush_rewrite_rules_flag', 'done');
    }
}

/**
 * Show admin notice to manually flush permalinks
 */
add_action('admin_notices', 'cook_it_child_permalink_flush_notice');
function cook_it_child_permalink_flush_notice() {
    // Show notice if transient is not set
    // Using v3 key for /tags/ slug change
    if (!get_transient('cook_it_child_permalink_flushed_v3')) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Cook It Child Theme:</strong> Taxonomy URL structure has been changed to /tags/. Please go to <a href="<?php echo admin_url('options-permalink.php'); ?>">Settings → Permalinks</a> and click "Save Changes" to update rewrite rules.</p>
        </div>
        <?php
    }
}

/**
 * Set transient when user visits permalinks page
 */
add_action('load-options-permalink.php', 'cook_it_child_set_permalink_transient');
function cook_it_child_set_permalink_transient() {
    set_transient('cook_it_child_permalink_flushed_v3', 1, MONTH_IN_SECONDS);
}

/**
 * Replace all internal /ingredients/ links with /tags/ links
 * This ensures all existing content uses the new URL structure
 */

// Apply to content, excerpts, and widgets
add_filter('the_content', 'cook_it_child_replace_ingredients_links');
add_filter('the_excerpt', 'cook_it_child_replace_ingredients_links');
add_filter('widget_text', 'cook_it_child_replace_ingredients_links');

function cook_it_child_replace_ingredients_links($content) {
    // Replace /ingredients/ with /tags/ in all links
    $content = str_replace('/ingredients/', '/tags/', $content);

    // Also handle full URLs with domain
    $content = str_replace(
        'http://regret49.beget.tech/ingredients/',
        'http://regret49.beget.tech/tags/',
        $content
    );

    return $content;
}

// Replace in taxonomy term links
add_filter('term_link', 'cook_it_child_replace_term_link', 10, 3);
function cook_it_child_replace_term_link($url, $term, $taxonomy) {
    // Only replace for ingredients taxonomy
    if ($taxonomy === 'ingredients') {
        $url = str_replace('/ingredients/', '/tags/', $url);
    }
    return $url;
}

// Replace in menus
add_filter('wp_nav_menu', 'cook_it_child_replace_menu_links');
function cook_it_child_replace_menu_links($menu) {
    $menu = str_replace('/ingredients/', '/tags/', $menu);
    $menu = str_replace(
        'http://regret49.beget.tech/ingredients/',
        'http://regret49.beget.tech/tags/',
        $menu
    );
    return $menu;
}