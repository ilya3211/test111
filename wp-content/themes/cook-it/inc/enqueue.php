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


load_theme_textdomain( THEME_TEXTDOMAIN, get_template_directory() . '/languages' );


/**
 * Enqueue scripts and styles.
 */
function wpshop_enqueue() {

    global $wpshop_core;
    global $wpshop_fonts;

    $style_version = apply_filters( THEME_SLUG . '_style_version', THEME_VERSION );


    // get list of font families options
    $fonts_options = array(
        'typography_body', 'typography_site_title', 'typography_site_description', 'typography_menu_links',
    );

    // get list of font families
    $fonts_list = array();
    foreach ( $fonts_options as $fonts_option ) {
        $option = $wpshop_core->get_option( $fonts_option );
        $option_decode = json_decode( $option, true );
        if ( ! empty( $option_decode['font-family'] ) ) {
            $fonts_list[] = $option_decode['font-family'];
        } else {
            // back compat, when option is font family
            $fonts_list[] = $option;
        }
    }
    $google_fonts = $wpshop_fonts->get_enqueue_link( $fonts_list );

    // enqueue link
    if ( ! empty( $google_fonts ) ) {
        wp_enqueue_style( 'google-fonts', $google_fonts, false );
    }

    // styles and scripts
    wp_enqueue_style( THEME_NAME . '-style',   get_template_directory_uri() . '/assets/css/style.min.css', array(), $style_version );
    wp_enqueue_script( THEME_NAME . '-scripts', get_template_directory_uri() . '/assets/js/scripts.min.js', array('jquery'), $style_version, true );
    wp_localize_script( THEME_NAME . '-scripts', 'settings_array', array(
            'rating_text_average' => __( 'average', THEME_TEXTDOMAIN ),
            'rating_text_from'    => __( 'from', THEME_TEXTDOMAIN ),
            'lightbox_display'    => $wpshop_core->get_option( 'lightbox_display' ),
        )
    );

    // swiper
    if ( apply_filters( THEME_SLUG . '_slider_output', is_front_page() || is_home() ) && ! empty( $wpshop_core->get_option( 'slider_count' ) ) ) {
        if ( ! wp_is_mobile() || ( wp_is_mobile() && ! $wpshop_core->get_option( 'slider_mob_disable' ) ) ) {
            wp_enqueue_script( THEME_NAME . '-swiper', get_template_directory_uri() . '/assets/js/plugins/swiper.min.js', array('jquery'), $style_version, true );
        }
    }

    // photoswipe
    if ( is_recipe() ) {
        wp_enqueue_script( THEME_NAME . '-photoswipe', get_template_directory_uri() . '/assets/js/plugins/photoswipe.min.js', array('jquery'), $style_version, true );
        wp_enqueue_script( THEME_NAME . '-photoswipe-default', get_template_directory_uri() . '/assets/js/plugins/photoswipe-ui-default.min.js', array('jquery'), $style_version, true );
    }

    // ajax
    wp_localize_script( THEME_NAME . '-scripts' , 'wps_ajax', array(
        'url'   => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'wpshop-nonce' )
    ) );

    // comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'wpshop_enqueue' );



/**
 * Enqueue admin scripts and styles.
 */
function wpshop_enqueue_admin() {
    wp_enqueue_style( THEME_NAME . '-admin-style', get_template_directory_uri() . '/assets/css/admin.min.css', array(), null );
    wp_enqueue_script( THEME_NAME . '-admin-scripts', get_template_directory_uri() . '/assets/js/admin.min.js', array('jquery'), null, true );
}
add_action( 'admin_enqueue_scripts', 'wpshop_enqueue_admin' );



/**
 * Editor styles
 */
function wpshop_add_editor_style() {
    add_editor_style( 'assets/css/editor-styles.min.css' );
}
add_action( 'current_screen', 'wpshop_add_editor_style' );



/**
 * Gutenberg scripts and styles
 */
function wpshop_enqueue_gutenberg() {
    wp_enqueue_script(
        THEME_SLUG . '-gutenberg',
        get_template_directory_uri() . '/assets/js/gutenberg.min.js',
        array( 'wp-blocks', 'wp-dom' ),
        THEME_VERSION,
        true
    );

    wp_enqueue_style(
        THEME_SLUG . '-gutenberg',
        get_template_directory_uri() . '/assets/css/gutenberg.min.css',
        array(),
        THEME_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'wpshop_enqueue_gutenberg' );