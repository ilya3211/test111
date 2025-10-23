<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 *   Используйте хук {THEME_SLUG}_options_defaults
 *   Use hook {THEME_SLUG}_options_defaults
 *
 * *****************************************************************************
 *
 * @package cook-it
 */

$default_options = apply_filters( THEME_SLUG . '_options_defaults', array(

    // layout  >  header
    'header_width'                        => 'fixed',
    'header_inner_width'                  => 'full',
    'header_padding_top'                  => 0,
    'header_padding_bottom'               => 0,

    // layout  >  header menu
    'header_menu_width'                   => 'fixed',
    'header_menu_inner_width'             => 'full',

    // layout  >  footer menu
    'footer_menu_width'                   => 'fixed',
    'footer_menu_inner_width'             => 'full',

    // layout  >  footer
    'footer_width'                        => 'fixed',
    'footer_inner_width'                  => 'full',


    // blocks  >  header
    'logotype_image'                      => '',
    'logotype_max_width'                  => 1000,
    'logotype_max_height'                 => 100,
    'header_hide_title'                   => false,
    'header_social'                       => true,
    'header_html_block_1'                 => '',
    'header_html_block_2'                 => '',
    'header_search'                       => false,

    // blocks  >  footer
    'footer_widgets'                      => 0,
    'footer_copyright'                    => '© %year% ' . get_bloginfo( 'name' ),
    'footer_counters'                     => '',

    // blocks  >  home
    'structure_home_posts'                => 'post-big',
    'structure_home_sidebar'              => 'right',
    'structure_home_h1'                   => '',
    'structure_home_text'                 => '',
    'structure_home_position'             => 'bottom',

    // blocks  >  single
    'structure_single_sidebar'            => 'right',
    'structure_single_hide'               => 'social_top,author_box',
    'structure_single_related'            => 6,

    // blocks  >  page
    'structure_page_sidebar'              => 'right',
    'structure_page_hide'                 => 'social_top,rating',
    'structure_page_related'              => 6,

    // blocks  >  archive
    'structure_archive_posts'             => 'post-big',
    'structure_archive_sidebar'           => 'right',
    'structure_archive_description_show'  => true,
    'structure_archive_subcategories'     => true,
    'structure_archive_description'       => 'top',

    // blocks  >  comments
    'comments_text_before_submit'         => '',
    'comments_date'                       => true,
    'comments_time'                       => true,
    'comments_smiles'                     => true,

    // blocks  >  sidebar
    'sidebar_mob_display'                 => false,


    // modules  >  slider
    'slider_width'                        => 'fixed',
    'slider_autoplay'                     => 2500,
    'slider_type'                         => 'one',
    'slider_count'                        => 0,
    'slider_order_post'                   => 'new',
    'slider_post_in'                      => '',
    'slider_category_in'                  => '',
    'slider_show_category'                => true,
    'slider_show_title'                   => true,
    'slider_show_excerpt'                 => true,
    'slider_show_on_paged'                => false,
    'slider_mob_disable'                  => false,

    // modules  >  toc
    'toc_display'                         => false,
    'toc_display_pages'                   => false,
    'toc_open'                            => true,
    'toc_noindex'                         => false,
    'toc_place'                           => false,
    'toc_title'                           => __( 'Contents', THEME_TEXTDOMAIN ),

    // modules  >  lightbox
    'lightbox_display'                    => true,

    // modules  >  breadcrumbs
    'breadcrumbs_display'                 => true,
    'breadcrumbs_home_text'               => __( 'Home', THEME_TEXTDOMAIN ),
    'breadcrumbs_archive'                 => true,
    'breadcrumbs_single_link'             => false,

    // modules  >  social profiles
    'social_facebook'                     => '',
    'social_vkontakte'                    => '',
    'social_twitter'                      => '',
    'social_odnoklassniki'                => '',
    'social_telegram'                     => '',
    'social_youtube'                      => '',
    'social_instagram'                    => '',
    'social_linkedin'                     => '',
    'social_whatsapp'                     => '',
    'social_viber'                        => '',
    'social_pinterest'                    => '',
    'social_yandexzen'                    => '',
    'social_github'                       => '',
    'social_discord'                      => '',
    'social_rutube'                       => '',
    'social_yappy'                        => '',
    'social_pikabu'                       => '',
    'social_yandex'                       => '',
    'structure_social_js'                 => true,

    // modules > share buttons
    'share_buttons'                       => 'vkontakte,facebook,telegram,odnoklassniki,twitter,sms,viber,whatsapp',
    'share_buttons_counters'              => false,

    // modules  >  author block
    'author_link'                         => false,
    'author_link_target'                  => false,
    'author_social_enable'                => false,
    'author_social_title'                 => __( 'Author profiles', THEME_TEXTDOMAIN ),
    'author_social_title_show'            => true,
    'author_social_js'                    => true,

    // modules  >  contact form
    'contact_form_text_before_submit'     => '',

    // modules  >  sitemap
    'sitemap_category_exclude'            => '',
    'sitemap_posts_exclude'               => '',
    'sitemap_pages_show'                  => true,
    'sitemap_pages_exclude'               => '',

    // modules  >  related posts
    'related_posts_title'                 => __( 'Related articles', THEME_TEXTDOMAIN ),
    'related_post_taxonomy_order'         => 'categories',
    'related_posts_exclude'               => '',
    'related_posts_category_exclude'      => '',
    'related_posts_after_comments'        => false,

    // modules  >  scroll to top
    'structure_arrow'                     => true,
    'structure_arrow_mob'                 => false,
    'structure_arrow_bg'                  => '#ffffff',
    'structure_arrow_color'               => '#ff4e00',
    'structure_arrow_width'               => '60',
    'structure_arrow_height'              => '50',
    'structure_arrow_icon'                => '\2b9d',


    // modules > views counter
    'wpshop_views_counter_enable'         => true,
    'wpshop_views_counter_to_count'       => '0',
    'wpshop_views_counter_exclude_bots'   => '1',


    // post card  >  standard
    'post_card_standard_order'            => 'thumbnail,title,category,meta,excerpt',
    'post_card_standard_order_meta'       => 'cooking_time,serves,date,comments_number,views',
    'post_card_standard_excerpt_length'   => 150,
    'post_card_standard_round_thumbnail'  => false,

    // post card  >  horizontal
    'post_card_horizontal_order'           => 'thumbnail,title,category,meta,excerpt',
    'post_card_horizontal_order_meta'      => 'cooking_time,serves,comments_number,views',
    'post_card_horizontal_excerpt_length'  => 100,
    'post_card_horizontal_round_thumbnail' => false,

    // post card  >  small
    'post_card_small_order'               => 'thumbnail,title,category,meta,excerpt',
    'post_card_small_order_meta'          => 'cooking_time,serves,comments_number,views',
    'post_card_small_excerpt_length'      => 30,
    'post_card_small_round_thumbnail'     => false,

    // post card  >  square
    'post_card_square_order'              => 'thumbnail,title,excerpt,meta,category',
    'post_card_square_order_meta'         => 'cooking_time,serves',
    'post_card_square_excerpt_length'     => 30,
    'post_card_square_round_thumbnail'    => false,

    // post card  >  related
    'post_card_related_order'             => 'thumbnail,title,excerpt,meta',
    'post_card_related_order_meta'        => 'cooking_time,serves,comments_number,views',
    'post_card_related_excerpt_length'    => 50,
    'post_card_related_round_thumbnail'   => false,


    // codes
    'code_head'                           => '',
    'code_body'                           => '',
    'code_after_content'                  => '',


    // typography  >  general
    'typography_body'                     => json_encode( array(
        'font-family'                     => 'roboto',
        'font-size'                       => '16',
        'line-height'                     => '1.5',
        'font-style'                      => '',
        'unit'                            => 'px'
    ) ),

    // typography  >  header
    'typography_site_title'               => json_encode( array(
        'font-family'                     => 'roboto',
        'font-size'                       => '29',
        'line-height'                     => '1.1',
        'font-style'                      => '',
        'unit'                            => 'px'
    ) ),

    'typography_site_description'         => json_encode( array(
        'font-family'                     => 'roboto',
        'font-size'                       => '16',
        'line-height'                     => '1.5',
        'font-style'                      => '',
        'unit'                            => 'px'
    ) ),

    // typography  >  menu
    'typography_menu_links'               => json_encode( array(
        'font-family'                     => 'roboto',
        'font-size'                       => '15',
        'line-height'                     => '1.5',
        'font-style'                      => '',
        'unit'                            => 'px'
    ) ),

    // typography  >  headers
    'typography_header_h1'                => json_encode( [
        'font-family'                     => 'montserrat',
        'font-size'                       => '2.5',
        'font-style'                      => '',
        'line-height'                     => '1.1',
        'unit'                            => 'em'
    ] ),

    'typography_header_h2'                => json_encode( [
        'font-family'                     => 'montserrat',
        'font-size'                       => '2',
        'font-style'                      => '',
        'line-height'                     => '1.2',
        'unit'                            => 'em'
    ] ),

    'typography_header_h3'                => json_encode( [
        'font-family'                     => 'montserrat',
        'font-size'                       => '1.75',
        'font-style'                      => '',
        'line-height'                     => '1.3',
        'unit'                            => 'em'
    ] ),

    'typography_header_h4'                => json_encode( [
        'font-family'                     => 'montserrat',
        'font-size'                       => '1.5',
        'font-style'                      => '',
        'line-height'                     => '1.4',
        'unit'                            => 'em'
    ] ),

    'typography_header_h5'                => json_encode( [
        'font-family'                     => 'montserrat',
        'font-size'                       => '1.25',
        'font-style'                      => '',
        'line-height'                     => '1.5',
        'unit'                            => 'em'
    ] ),

    'typography_header_h6'                => json_encode( [
        'font-family'                     => 'montserrat',
        'font-size'                       => '1',
        'font-style'                      => '',
        'line-height'                     => '1.6',
        'unit'                            => 'em'
    ] ),


    // colors
    'color_main'                          => '#ff4e00',
    'color_text'                          => '#222222',
    'color_link'                          => '#ff4e00',
    'color_link_hover'                    => '#222222',
    'color_header_bg'                     => '#ffffff',
    'color_header'                        => '#222222',
    'color_logo'                          => '#ff4e00',
    'color_site_description'              => '#111111',
    'color_menu_bg'                       => '#ffffff',
    'color_menu'                          => '#222222',
    'color_content_bg'                    => '#ffffff',
    'color_footer_bg'                     => '#eeeeee',
    'color_footer'                        => '#222222',


    // background
    'body_bg_link'                        => '',
    'body_bg_link_js'                     => true,
    'header_bg'                           => '',
    'header_bg_repeat'                    => 'no-repeat',
    'header_bg_position'                  => 'center center',
    'header_bg_mob'                       => false,


    // home constructor
    'display_constructor_static_page'     => false,


    // tweak
    'content_full_width'                  => false,
    'social_share_title'                  => __( 'Share to friends', THEME_TEXTDOMAIN ),
    'social_share_title_show'             => true,
    'rating_title'                        => __( 'Rating', THEME_TEXTDOMAIN ),
    'rating_text_show'                    => true,
    'advertising_page_display'            => false,
    'microdata_publisher_telephone'       => '',
    'microdata_publisher_address'         => '',
    'ingredients_link'                    => true,


    // partner program
    'wpshop_partner_enable'               => false,
    'wpshop_partner_prefix'               => __( 'Powered by theme', THEME_TEXTDOMAIN ),
    'wpshop_partner_postfix'              => '',

) );


/**
 * Set default options
 */
global $wpshop_core;
$wpshop_core->set_default_options( $default_options );
