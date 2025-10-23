<?php

use Wpshop\Core\AdminNotices;
use Wpshop\Core\Core;
use Wpshop\Core\ThemeUpdater;
use Wpshop\Core\ThemeOptions;
use Wpshop\Core\ThemeSettings;
use Wpshop\Core\Helper;
use Wpshop\Core\Advertising;
use Wpshop\Core\Sitemap;
use Wpshop\Core\Template;
use Wpshop\Core\ContactForm;
use Wpshop\Core\Shortcodes;
use Wpshop\Core\Breadcrumbs;
use Wpshop\Core\Social;
use Wpshop\Core\TableOfContents;
use Wpshop\Core\Customizer\Customizer;
use Wpshop\Core\Fonts;
use Wpshop\Core\StarRating;
use Wpshop\Core\MetaBoxTaxonomy;
use Wpshop\Core\Partner;
use Wpshop\Core\ViewsCounter;

require get_template_directory() . '/vendor/autoload.php';


/**
 * Theme options
 */
$wpshop_theme_options = new ThemeOptions();
$wpshop_theme_options->text_domain   = THEME_TEXTDOMAIN;
$wpshop_theme_options->theme_slug    = THEME_SLUG;
$wpshop_theme_options->settings_name = THEME_SLUG . '_settings';
$wpshop_theme_options->option_name   = THEME_SLUG . '_options';
$wpshop_theme_options->theme_name    = THEME_NAME;
$wpshop_theme_options->theme_title   = THEME_TITLE;
$wpshop_theme_options->updater_url   = THEME_UPDATE_URL;

$wpshop_theme_options->license           = THEME_SLUG . '_license';
$wpshop_theme_options->license_verify    = THEME_SLUG . '_license_verify';
$wpshop_theme_options->license_error     = THEME_SLUG . '_license_error';

$wpshop_theme_options->settings_page_title = __( 'Theme Settings', THEME_TEXTDOMAIN );
$wpshop_theme_options->settings_menu_title = __( 'Theme Settings', THEME_TEXTDOMAIN );


/**
 * Init
 */
$wpshop_helper            = new Helper( $wpshop_theme_options );
$wpshop_core              = new Core( $wpshop_theme_options );
$wpshop_theme_settings    = new ThemeSettings( $wpshop_theme_options );
$wpshop_theme_updater     = new ThemeUpdater( $wpshop_theme_options );
$wpshop_customizer        = new Customizer( $wpshop_theme_options );
$wpshop_template          = new Template( $wpshop_theme_options );
$wpshop_breadcrumbs       = new Breadcrumbs( $wpshop_theme_options );
$wpshop_sitemap           = new Sitemap( $wpshop_theme_options );
$wpshop_advertising       = new Advertising( $wpshop_theme_options );
$wpshop_shortcodes        = new Shortcodes( $wpshop_theme_options );
$wpshop_social            = new Social( $wpshop_theme_options );
$wpshop_table_of_contents = new TableOfContents( $wpshop_theme_options );
$wpshop_rating            = new StarRating( $wpshop_theme_options );
$wpshop_contact_form      = new ContactForm( $wpshop_theme_options );
$wpshop_fonts             = new Fonts( $wpshop_theme_options );
$wpshop_partner           = new Partner( $wpshop_theme_options );
$wpshop_admin_notices     = new AdminNotices( $wpshop_theme_options );
$wpshop_views_counter     = new ViewsCounter( $wpshop_core, $wpshop_theme_options, $wpshop_admin_notices );

if ( class_exists( 'WP_CLI' ) ) {
    $GLOBALS['wpshop_helper']            = $wpshop_helper;
    $GLOBALS['wpshop_core']              = $wpshop_core;
    $GLOBALS['wpshop_theme_settings']    = $wpshop_theme_settings;
    $GLOBALS['wpshop_theme_updater']     = $wpshop_theme_updater;
    $GLOBALS['wpshop_customizer']        = $wpshop_customizer;
    $GLOBALS['wpshop_template']          = $wpshop_template;
    $GLOBALS['wpshop_breadcrumbs']       = $wpshop_breadcrumbs;
    $GLOBALS['wpshop_sitemap']           = $wpshop_sitemap;
    $GLOBALS['wpshop_advertising']       = $wpshop_advertising;
    $GLOBALS['wpshop_shortcodes']        = $wpshop_shortcodes;
    $GLOBALS['wpshop_social']            = $wpshop_social;
    $GLOBALS['wpshop_table_of_contents'] = $wpshop_table_of_contents;
    $GLOBALS['wpshop_rating']            = $wpshop_rating;
    $GLOBALS['wpshop_contact_form']      = $wpshop_contact_form;
    $GLOBALS['wpshop_fonts']             = $wpshop_fonts;
    $GLOBALS['wpshop_partner']           = $wpshop_partner;
    $GLOBALS['wpshop_admin_notices']     = $wpshop_admin_notices;
    $GLOBALS['wpshop_views_counter']     = $wpshop_views_counter;
}


/**
 * Core v120722280
 */
$wpshop_core->minimum_php_version( '5.3' );

$wpshop_admin_notices->init();


/**
 * Template
 */
$wpshop_template->init( array(
    'remove_hentry',
    'remove_current_links_from_menu',
    'remove_h_tag_from_navigation',
    'remove_label_archive_title',
    'microformat_image',
    'remove_style_tag',
    'remove_script_tag',
) );
$wpshop_template->body_class_customizer();


/**
 * MetaBoxTaxonomy
 */
$wpshop_metabox_taxonomy = new MetaBoxTaxonomy();


/**
 * Shortcodes
 */
$wpshop_shortcodes->init_shortcode( 'spoiler' );
$wpshop_shortcodes->init_shortcode( 'mask_link' );
$wpshop_shortcodes->init_shortcode( 'social_profiles' );


add_action( 'after_setup_theme', 'wpshop_core_setup' );
function wpshop_core_setup() {

    global $wpshop_advertising;
    global $wpshop_contact_form;

    /**
     * Advertising
     */
    $advertising_positions = apply_filters( THEME_SLUG . '_advertising_positions', array(
        'before_site_content' =>  array(
            'title'           => __( 'After the header and top menu (for the entire width of the site)', THEME_TEXTDOMAIN ),
            'type'            => 'regular',
        ),
        'before_content'    =>  array(
            'type'          => 'before_content',
        ),
        'middle_content'    =>  array(
            'type'          => 'middle_content',
        ),
        'after_content'     =>  array(
            'type'          => 'after_content',
        ),
        'after_p_1'     =>  array(
            'type'      => 'after_p',
        ),
        'after_p_2'     =>  array(
            'type'      => 'after_p',
        ),
        'after_p_3'     =>  array(
            'type'      => 'after_p',
        ),
        'after_p_4'     =>  array(
            'type'      => 'after_p',
        ),
        'after_p_5'     =>  array(
            'type'      => 'after_p',
        ),
        'before_ingredients' =>  array(
            'title'          => __( 'Before ingredients', THEME_TEXTDOMAIN ),
            'type'           => 'single',
        ),
        'after_ingredients' =>  array(
            'title'         => __( 'After ingredients', THEME_TEXTDOMAIN ),
            'type'          => 'single',
        ),
        'after_steps'       =>  array(
            'title'         => __( 'After cooking steps', THEME_TEXTDOMAIN ),
            'type'          => 'single',
        ),
        'after_text'        =>  array(
            'title'         => __( 'After additional information', THEME_TEXTDOMAIN ),
            'type'          => 'single',
        ),
        'before_related'    =>  array(
            'title'         => __( 'Before related posts', THEME_TEXTDOMAIN ),
            'type'          => 'single',
        ),
        'after_related'     =>  array(
            'title'         => __( 'After related posts', THEME_TEXTDOMAIN ),
            'type'          => 'single',
        ),
        'after_site_content' => array(
            'title'          => __( 'Before the bottom menu and footer (for the entire width of the site)', THEME_TEXTDOMAIN ),
            'type'           => 'regular',
        ),
    ) );
    $wpshop_advertising->set_positions( $advertising_positions );
    $wpshop_advertising->init();


    /**
     * Contact form
     */
    $fields = array(
        array(
            'name'          => 'contact-name',
            'placeholder'   => __( 'Your name', THEME_TEXTDOMAIN ),
            'required'      => 'required',
        ),
        array(
            'name'          => 'contact-email',
            'type'          => 'email',
            'placeholder'   => __( 'Your e-mail', THEME_TEXTDOMAIN ),
            'required'      => 'required',
        ),
        array(
            'name'          => 'contact-subject',
            'placeholder'   => __( 'Your subject', THEME_TEXTDOMAIN ),
        ),
        array(
            'tag'           => 'textarea',
            'name'          => 'contact-message',
            'placeholder'   => __( 'Message', THEME_TEXTDOMAIN ),
            'required'      => 'required',
        ),
    );
    $fields = apply_filters( THEME_SLUG . '_contact_form_fields' , $fields );
    $wpshop_contact_form->create_fields( $fields );

}


add_filter( 'wpshop_text_before_submit', 'contact_form_text_before_submit' );

function contact_form_text_before_submit() {
    global $wpshop_core;
    $contact_form_text_before_submit = $wpshop_core->get_option( 'contact_form_text_before_submit' );

    if ( ! empty( $contact_form_text_before_submit ) ) {
        return '<div class="contact-form-notes-after">'. $contact_form_text_before_submit .'</div>';
    }
}


/**
 * Rating
 */
if ( defined('DOING_AJAX') ) {
    $wpshop_rating->ajax_actions();
}


/**
 * Fonts
 */
$wpshop_fonts->preloading_fonts( get_template_directory_uri() . '/assets/fonts/icomoon.ttf' );