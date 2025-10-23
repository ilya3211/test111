<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 * @package cook-it
 */


/**
 * Theme config
 */
require get_template_directory() . '/inc/config.php';


/**
 * Enqueue styles and scripts
 */
require get_template_directory() . '/inc/enqueue.php';


/**
 * Core
 */
require get_template_directory() . '/inc/core.php';


/**
 * Default options
 */
require get_template_directory() . '/inc/default-options.php';


/**
 * after_setup_theme hooks: widgets, menus, theme_support
 */
require get_template_directory() . '/inc/setup.php';


/**
 * Upgrade
 */
require get_template_directory() . '/inc/upgrade.php';


/**
 * Post card
 */
require get_template_directory() . '/inc/post-card.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';


/**
 * TinyMCE
 */
if ( is_admin() ) {
    require get_template_directory() . '/inc/tinymce.php';
}


/**
 * Comments
 */
require get_template_directory() . '/inc/comments.php';


/**
 * Smiles
 */
require get_template_directory() . '/inc/smiles.php';


/**
 * Metaboxes
 */
require get_template_directory() . '/inc/meta-boxes.php';


/**
 * Thumbnails
 */
require get_template_directory() . '/inc/thumbnails.php';


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Recipes
 */
require get_template_directory() . '/inc/recipes/recipes.php';


/**
 * Ingredients
 */
require get_template_directory() . '/inc/recipes/ingredients.php';


/**
 * Shortcodes
 */
require get_template_directory() . '/inc/recipes/shortcodes.php';


/**
 * Recipe Form
 */
require get_template_directory() . '/inc/recipes/recipe-form.php';


/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets/widgets.php';


/**
 * WPShop Partner ID
 */
require get_template_directory() . '/inc/partner-id.php';


require get_template_directory() . '/inc/rss-for-yandex-turbo-support.php';
