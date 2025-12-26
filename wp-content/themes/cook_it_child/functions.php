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

    // Enqueue К СЕБЕ card styles
    // Используем время модификации файла как версию для автообновления кеша
    $css_file = get_stylesheet_directory() . '/style-k-sebe-cards.css';
    $css_version = file_exists($css_file) ? filemtime($css_file) : '1.0.2';

    wp_enqueue_style(
        'k-sebe-cards',
        get_stylesheet_directory_uri() . '/style-k-sebe-cards.css',
        array( 'cook-it-style-child' ),
        $css_version
    );
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
 * Change ingredients taxonomy rewrite slug from /ingredients/ to /tags/
 * URL structure: http://site.com/tags/сахар-песок/
 *
 * NOTE: Using 'tags' to provide a cleaner URL structure
 *
 * IMPORTANT: After activating this code, go to WordPress Admin → Settings → Permalinks
 * and click "Save Changes" to flush rewrite rules manually.
 */

// Step 1: Unregister the original taxonomy
add_action( 'init', 'cook_it_child_unregister_ingredients', 1 );
function cook_it_child_unregister_ingredients() {
    unregister_taxonomy( 'ingredients' );
}

// Step 2: Re-register with custom rewrite slug
add_action( 'init', 'cook_it_child_register_ingredients', 2 );
function cook_it_child_register_ingredients() {
    $labels = array(
        'name'                       => _x( 'Ingredients', 'Taxonomy General Name', THEME_TEXTDOMAIN ),
        'singular_name'              => _x( 'Ingredients', 'Taxonomy Singular Name', THEME_TEXTDOMAIN ),
        'menu_name'                  => __( 'Ingredients', THEME_TEXTDOMAIN ),
        'all_items'                  => __( 'All Ingredients', THEME_TEXTDOMAIN ),
        'parent_item'                => __( 'Ingredient Category', THEME_TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Ingredient Category:', THEME_TEXTDOMAIN ),
        'new_item_name'              => __( 'New Ingredient Name', THEME_TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Ingredient', THEME_TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Ingredient', THEME_TEXTDOMAIN ),
        'update_item'                => __( 'Update Ingredient', THEME_TEXTDOMAIN ),
        'view_item'                  => __( 'View Ingredient', THEME_TEXTDOMAIN ),
        'separate_items_with_commas' => __( 'Separate ingredients with commas', THEME_TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove ingredients', THEME_TEXTDOMAIN ),
        'choose_from_most_used'      => __( 'Choose from the most used', THEME_TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Ingredients', THEME_TEXTDOMAIN ),
        'search_items'               => __( 'Search Ingredient', THEME_TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', THEME_TEXTDOMAIN ),
        'no_terms'                   => __( 'No Ingredients', THEME_TEXTDOMAIN ),
        'items_list'                 => __( 'Ingredients list', THEME_TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Ingredients list navigation', THEME_TEXTDOMAIN ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,  // Оставляем иерархию в админке
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'meta_box_cb'                => false,
        'rewrite'                    => array(
            'slug'         => 'tags',
            'with_front'   => false,
            'hierarchical' => false,  // Отключаем родительские термины в URL
        ),
    );

    register_taxonomy( 'ingredients', array( 'post' ), $args );
}

/**
 * Flush rewrite rules on theme activation
 */
add_action( 'after_switch_theme', 'cook_it_child_flush_rewrite_rules' );
function cook_it_child_flush_rewrite_rules() {
    flush_rewrite_rules();
}

/**
 * Admin notice to remind user to flush permalinks
 */
add_action( 'admin_notices', 'cook_it_child_permalink_flush_notice' );
function cook_it_child_permalink_flush_notice() {
    // Show notice if transient is not set
    // Using v3 key to force showing notice again after slug change to /tags/
    if ( ! get_transient( 'cook_it_child_permalink_flushed_v3' ) ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Cook It Child Theme:</strong> Taxonomy URL structure has been changed to /tags/. Please go to <a href="<?php echo admin_url( 'options-permalink.php' ); ?>">Settings → Permalinks</a> and click "Save Changes" to update rewrite rules.</p>
        </div>
        <?php
    }
}

/**
 * Set transient when user visits permalink settings page
 */
add_action( 'load-options-permalink.php', 'cook_it_child_set_permalink_transient' );
function cook_it_child_set_permalink_transient() {
    set_transient( 'cook_it_child_permalink_flushed_v3', 1, MONTH_IN_SECONDS );
}

/**
 * Replace all internal /ingredients/ links with /tags/ links
 * This ensures all existing content uses the new URL structure
 */

// Replace in post content
add_filter( 'the_content', 'cook_it_child_replace_ingredients_links' );
// Replace in excerpts
add_filter( 'the_excerpt', 'cook_it_child_replace_ingredients_links' );
// Replace in text widgets
add_filter( 'widget_text', 'cook_it_child_replace_ingredients_links' );

function cook_it_child_replace_ingredients_links( $content ) {
    // Replace /ingredients/ with /tags/ in all links
    $content = str_replace( '/ingredients/', '/tags/', $content );

    // Also handle full URLs with domain
    $content = str_replace(
        'http://regret49.beget.tech/ingredients/',
        'http://regret49.beget.tech/tags/',
        $content
    );

    return $content;
}

// Replace in term links (category/tag/taxonomy archive links)
add_filter( 'term_link', 'cook_it_child_replace_term_link', 10, 3 );
function cook_it_child_replace_term_link( $url, $term, $taxonomy ) {
    // Only replace for ingredients taxonomy
    if ( $taxonomy === 'ingredients' ) {
        $url = str_replace( '/ingredients/', '/tags/', $url );
    }
    return $url;
}

// Replace in menus
add_filter( 'wp_nav_menu', 'cook_it_child_replace_menu_links' );
function cook_it_child_replace_menu_links( $menu ) {
    $menu = str_replace( '/ingredients/', '/tags/', $menu );
    $menu = str_replace(
        'http://regret49.beget.tech/ingredients/',
        'http://regret49.beget.tech/tags/',
        $menu
    );
    return $menu;
}