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

if ( ! function_exists( 'wpshop_theme_setup' ) ) :
    function wpshop_theme_setup() {

        // Add default posts and comments RSS feed links to head.
        if ( apply_filters( THEME_SLUG . '_allow_rss_links', false ) ) {
            add_theme_support( 'automatic-feed-links' );
        }


        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );


        // Switch default core markup to output valid HTML5.
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );


        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );
        $thumb_big_sizes  = apply_filters( THEME_SLUG . '_thumb_big', array( 680, 270, true ) );
        $thumb_wide_sizes = apply_filters( THEME_SLUG . '_thumb_wide', array( 330, 200, true ) );
        $thumb_small_sizes = apply_filters( THEME_SLUG . '_thumb_small', array( 100, 100, true ) );
        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'thumb-big', $thumb_big_sizes[0], $thumb_big_sizes[1], $thumb_big_sizes[2]);
            add_image_size( 'thumb-wide', $thumb_wide_sizes[0], $thumb_wide_sizes[1], $thumb_wide_sizes[2] );
            add_image_size( 'thumb-small', $thumb_small_sizes[0], $thumb_small_sizes[1], $thumb_small_sizes[2] );
        }


        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( THEME_SLUG . '_custom_background_args', array(
            'default-color' => 'fdfbf2',
            'default-image' => '',
        ) ) );


        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'top_menu'    => esc_html__( 'Top menu', THEME_TEXTDOMAIN ),
            'header_menu' => esc_html__( 'Header menu', THEME_TEXTDOMAIN ),
            'footer_menu' => esc_html__( 'Footer menu', THEME_TEXTDOMAIN ),
        ) );

    }
endif;
add_action( 'after_setup_theme', 'wpshop_theme_setup' );



/**
 * Register widget area.
 */
function wpshop_widgets_init() {

    global $wpshop_core;

    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', THEME_TEXTDOMAIN ),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="widget-header">',
        'after_title'   => '</div>',
    ) );


    $footer_widgets = $wpshop_core->get_option( 'footer_widgets' );
    if ( $footer_widgets > 5 ) $footer_widgets = 5;
    if ( $footer_widgets > 0 ) {
        for ( $n = 1; $n <= $footer_widgets; $n++ ) {

            register_sidebar( array(
                'name'          => esc_html__( 'Footer', THEME_TEXTDOMAIN ) . ' ' . $n,
                'id'            => 'footer-widget-'. $n,
                'description'   => esc_html__( 'Add widgets here.', THEME_TEXTDOMAIN ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<div class="widget-header">',
                'after_title'   => '</div>',
            ) );

        }
    }
}
add_action( 'widgets_init', 'wpshop_widgets_init' );



/**
 * Excerpt
 */
if ( ! function_exists( 'new_excerpt_length' ) ) :
    function new_excerpt_length( $length ) {
        return 28;
    }
    add_filter( 'excerpt_length', 'new_excerpt_length' );
endif;

if ( ! function_exists( 'change_excerpt_more' ) ) :
    function change_excerpt_more( $more ) {
        return '...';
    }
    add_filter( 'excerpt_more', 'change_excerpt_more' );
endif;



/**
 * Text after steps
 *
 * @param $content
 *
 * @return string
 */
function recipe_after_text( $content ) {

    $yturbo_options = get_option('yturbo_options');
    if ( is_single() ) {
        $content .= _recipe_after_text();

        // Добавление микроразметки Рецептов в Турбо страницы с плагином
        // https://ru.wordpress.org/plugins/rss-for-yandex-turbo/
        if ( ! empty( $yturbo_options['ytrssname'] ) && is_feed($yturbo_options['ytrssname']) ) {
            $content = '<div itemscope itemtype="http://schema.org/Recipe">' . $content . '</div>';
        }

    }

    return $content;
}



/**
 * @param string $content
 *
 * @return string
 */
function _recipe_after_text( $content = '' ) {
    global $post;
    global $wpshop_core;
    global $wpshop_advertising;

    if ( is_recipe( $post ) ) {
        $is_show_ingredients = $wpshop_core->is_show_element( 'ingredients' );
        $is_show_steps       = $wpshop_core->is_show_element( 'steps' );

        if ( $is_show_ingredients ) {
            $content .= do_shortcode( '[ingredients]' );
        }
        if ( $is_show_steps ) {
            $content .= do_shortcode( '[steps]' );
        }

        $recipe_after_text = get_post_meta( $post->ID, 'recipe_after_text', true );

        if ( ! empty ( $recipe_after_text ) ) {
            $content .= '<hr>';
            $content .= wpautop( htmlspecialchars_decode( $recipe_after_text ) );
            $content .= $wpshop_advertising->show_ad( 'after_text' );
        }

    }

    return $content;
}

add_filter( 'the_content', 'recipe_after_text', 0 );



/**
 * Enable microdata rating in recipes
 */
add_filter( 'wpshop_rating_markup', function() {
    if ( is_recipe() ) return 'schema';
    else return 'no';
} );



/**
 * Body background link
 */
global $wpshop_core;

$wpshop_body_bg_link    = $wpshop_core->get_option( 'body_bg_link' );
$wpshop_body_bg_link_js = $wpshop_core->get_option( 'body_bg_link_js' );

if ( ! empty( $wpshop_body_bg_link ) ) {
    add_action( 'cook_it_after_body', function() {
        global $wpshop_body_bg_link;
        global $wpshop_body_bg_link_js;

        echo '<div style="position:fixed; overflow:hidden; top:0px; left:0px; width:100%; height:100%;">';

        if ( $wpshop_body_bg_link_js ) {
            echo '<span class="js-link" data-href="' . base64_encode( $wpshop_body_bg_link ) . '" data-target="_blank" style="display:block; height:100%; width:100%;"></span>';
        } else {
            echo '<a href="' . $wpshop_body_bg_link . '" target="_blank" style="display:block; height:100%; width:100%;"></a>';
        }

        echo '</div>';

    } );
}



function site_content_classes() {
    $classes = apply_filters( THEME_SLUG . '_site_content_classes', 'container' );
    echo $classes;
}



/**
 * Breadcrumbs home text
 */
$breadcrumbs_home_text = $wpshop_core->get_option( 'breadcrumbs_home_text' );
if ( ! empty( $breadcrumbs_home_text ) && $breadcrumbs_home_text != 'Home' ) {
    add_filter( 'wpshop_breadcrumbs_home_text', 'wpshop_breadcrumbs_home_text_change' );
}
function wpshop_breadcrumbs_home_text_change() {
    global $wpshop_core;
    $breadcrumbs_home_text = $wpshop_core->get_option( 'breadcrumbs_home_text' );
    return $breadcrumbs_home_text;
}



/**
 * Breadcrumbs single link
 */
$breadcrumbs_single_link = $wpshop_core->get_option( 'breadcrumbs_single_link' );
if ( $breadcrumbs_single_link ) {
    add_filter( 'wpshop_breadcrumb_single_link', '__return_true' );
}



/**
 * TOC
 */
$toc_noindex = $wpshop_core->get_option( 'toc_noindex' );
if ( $toc_noindex ) {
    add_filter( 'wpshop_toc_noindex', '__return_true' );
}

$toc_open = $wpshop_core->get_option( 'toc_open' );
if ( ! $toc_open ) {
    add_filter( 'wpshop_toc_open', '__return_false' );
}

$toc_display = $wpshop_core->get_option( 'toc_display' );
$toc_display_pages = $wpshop_core->get_option( 'toc_display_pages' );

if ( $toc_display ) {
    add_filter( 'wpshop_toc_in_single', '__return_true' );
} else {
    add_filter( 'wpshop_toc_in_single', '__return_false' );
}

if ( $toc_display_pages ) {
    add_filter( 'wpshop_toc_in_page', '__return_true' );
} else {
    add_filter( 'wpshop_toc_in_page', '__return_false' );
}

$toc_place = $wpshop_core->get_option( 'toc_place' );
if ( $toc_place ) {
    add_filter( 'wpshop_toc_place', '__return_false' );
}

$toc_title = $wpshop_core->get_option( 'toc_title' );
if ( ! empty( $toc_title ) && $toc_title != 'Contents' ) {
    add_filter( 'wpshop_toc_header', 'wpshop_wpshop_toc_header_change' );
}

function wpshop_wpshop_toc_header_change() {
    global $wpshop_core;
    $toc_title = $wpshop_core->get_option( 'toc_title' );
    return $toc_title;
}



if ( $toc_display || $toc_display_pages ) {
    global $wpshop_table_of_contents;
    $wpshop_table_of_contents->init();
}



/**
 * Show comment time
 */
$comments_time = $wpshop_core->get_option( 'comments_time' );
if ( ! $comments_time ) {
    add_filter( 'cook_it_comments_show_time', '__return_false' );
}



/**
 * Author social title
 */
$author_social_title = $wpshop_core->get_option( 'author_social_title' );
if ( ! empty( $author_social_title ) && $author_social_title != 'Author profiles' ) {
    add_filter( 'cook_it_author_social_title', 'author_social_title_change' );
}
function author_social_title_change() {
    global $wpshop_core;
    $author_social_title = $wpshop_core->get_option( 'author_social_title' );
    return $author_social_title;
}



/**
 * Show title author social
 */
$author_social_title_show = $wpshop_core->get_option( 'author_social_title_show' );
if ( ! $author_social_title_show ) {
    add_filter( 'cook_it_author_social_title_show', '__return_false' );
}



/**
 * Exclude category in sitemap
 */
add_filter( 'wpshop_sitemap_category_exclude', function() {
    global $wpshop_core;
    $sitemap_category_exclude = $wpshop_core->get_option( 'sitemap_category_exclude' );

    if ( ! empty( $sitemap_category_exclude ) ) {
        $sitemap_category_exclude_id = explode( ',', $sitemap_category_exclude );

        if ( is_array( $sitemap_category_exclude_id ) ) {
            $sitemap_category_exclude = array_map( 'trim', $sitemap_category_exclude_id );
        } else {
            $sitemap_category_exclude = array( $sitemap_category_exclude );
        }
    }

    return $sitemap_category_exclude;
} );



/**
 * Exclude posts in sitemap
 */
add_filter( 'wpshop_sitemap_posts_exclude', function() {
    global $wpshop_core;
    $sitemap_posts_exclude = $wpshop_core->get_option( 'sitemap_posts_exclude' );

    if ( ! empty( $sitemap_posts_exclude ) ) {
        $sitemap_posts_exclude_id = explode( ',', $sitemap_posts_exclude );

        if ( is_array( $sitemap_posts_exclude_id ) ) {
            $sitemap_posts_exclude = array_map( 'trim', $sitemap_posts_exclude_id );
        } else {
            $sitemap_posts_exclude = array( $sitemap_posts_exclude );
        }
    }

    return $sitemap_posts_exclude;
} );



/**
 * Show pages in sitemap
 */
$sitemap_pages_show = $wpshop_core->get_option( 'sitemap_pages_show' );
if ( ! $sitemap_pages_show ) {
    add_filter( 'wpshop_sitemap_show_pages', '__return_false' );
}



/**
 * Exclude pages in sitemap
 */
add_filter( 'wpshop_sitemap_pages_exclude', function() {
    global $wpshop_core;
    $sitemap_pages_exclude = $wpshop_core->get_option( 'sitemap_pages_exclude' );

    if ( ! empty( $sitemap_pages_exclude ) ) {
        $sitemap_pages_exclude_id = explode( ',', $sitemap_pages_exclude );

        if ( is_array( $sitemap_pages_exclude_id ) ) {
            $sitemap_pages_exclude = array_map( 'trim', $sitemap_pages_exclude_id );
        } else {
            $sitemap_pages_exclude = array( $sitemap_pages_exclude );
        }
    }

    return $sitemap_pages_exclude;
} );



/**
 * Views counter
 */
global $wpshop_views_counter;
$wpshop_views_counter->init();



/**
 * Content on full width
 */
$content_full_width = $wpshop_core->get_option( 'content_full_width' );
if ( $content_full_width ) {
    add_filter( 'cook_it_site_content_classes', '__return_false' );
}



/**
 * Social buttons title
 */
$social_share_title = $wpshop_core->get_option( 'social_share_title' );
if ( ! empty( $social_share_title ) && $social_share_title != 'Share to friends' ) {
    add_filter( 'cook_it_social_share_title', 'social_share_title_change' );
}
function social_share_title_change() {
    global $wpshop_core;
    $social_share_title = $wpshop_core->get_option( 'social_share_title' );
    return $social_share_title;
}



/**
 * Show title social buttons
 */
$social_share_title_show = $wpshop_core->get_option( 'social_share_title_show' );
if ( ! $social_share_title_show ) {
    add_filter( 'cook_it_social_share_title_show', '__return_false' );
}



/**
 * Rating title
 */
$rating_title = $wpshop_core->get_option( 'rating_title' );
if ( ! empty( $rating_title ) && $rating_title != 'Rating' ) {
    add_filter( 'cook_it_rating_title', 'rating_title_change' );
}
function rating_title_change() {
    global $wpshop_core;
    $rating_title = $wpshop_core->get_option( 'rating_title' );
    return $rating_title;
}



/**
 * Rating text
 */
$rating_text_show = $wpshop_core->get_option( 'rating_text_show' );
if ( ! $rating_text_show ) {
    add_filter( 'cook_it_rating_text_show', '__return_false' );
}



/**
 * Related posts title
 */
$related_posts_title = $wpshop_core->get_option( 'related_posts_title' );
if ( ! empty( $related_posts_title ) && $related_posts_title != 'Related articles' ) {
    add_filter( 'cook_it_related_title', 'related_posts_title_change' );
}
function related_posts_title_change() {
    global $wpshop_core;
    $related_posts_title = $wpshop_core->get_option( 'related_posts_title' );
    return $related_posts_title;
}



/**
 * Enable advertising on pages
 */
$advertising_page_display = $wpshop_core->get_option( 'advertising_page_display' );
if ( $advertising_page_display ) {
    add_filter( 'wpshop_advertising_single', '__return_false' );
}



/**
 * Microdata publisher telephone
 */
$microdata_publisher_telephone = $wpshop_core->get_option( 'microdata_publisher_telephone' );
if ( ! empty( $microdata_publisher_telephone ) ) {
    add_filter( 'wpshop_microdata_publisher_telephone', 'microdata_publisher_telephone_change' );
}
function microdata_publisher_telephone_change() {
    global $wpshop_core;
    $microdata_publisher_telephone = $wpshop_core->get_option( 'microdata_publisher_telephone' );
    return $microdata_publisher_telephone;
}



/**
 * Microdata publisher address
 */
$microdata_publisher_address = $wpshop_core->get_option( 'microdata_publisher_address' );
if ( ! empty( $microdata_publisher_address ) ) {
    add_filter( 'wpshop_microdata_publisher_address', 'microdata_publisher_address_change' );
}
function microdata_publisher_address_change() {
    global $wpshop_core;
    $microdata_publisher_address = $wpshop_core->get_option( 'microdata_publisher_address' );
    return $microdata_publisher_address;
}