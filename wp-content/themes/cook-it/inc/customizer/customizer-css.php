<?php

use \Wpshop\Core\Customizer\CustomizerCSS;

function wpshop_customizer_css() {
    global $wpshop_core;
    global $default_options;

    $class_customizer_css = new CustomizerCSS( array( 'defaults' => $default_options, 'theme_slug' => THEME_SLUG ) );

    //  layout  ->  header
    $class_customizer_css->add(
        '.site-header',
        array( 'padding-top:%dpx', 'header_padding_top' ),
        '(min-width: 768px)'
    );

    $class_customizer_css->add(
        '.site-header',
        array( 'padding-bottom:%dpx', 'header_padding_bottom' ),
        '(min-width: 768px)'
    );


    // blocks  >  header
    $class_customizer_css->add(
        '.site-logotype',
        array( 'max-width:%dpx', 'logotype_max_width' )
    );

    $class_customizer_css->add(
        '.site-logotype img',
        array( 'max-height:%dpx', 'logotype_max_height' )
    );


    // modules  ->  scroll to top
    $class_customizer_css->add(
        '.scrolltop',
        array( 'background-color:%s', 'structure_arrow_bg' )
    );

    $class_customizer_css->add(
        '.scrolltop:before',
        array( 'color:%s', 'structure_arrow_color' )
    );

    $class_customizer_css->add(
        '.scrolltop',
        array( 'width:%dpx', 'structure_arrow_width' )
    );

    $class_customizer_css->add(
        '.scrolltop',
        array( 'height:%dpx', 'structure_arrow_height' )
    );

    $class_customizer_css->add(
        '.scrolltop:before',
        array( 'content:"%s"', 'structure_arrow_icon' )
    );


    // post cards  >  standard
    if ( $wpshop_core->get_option( 'post_card_standard_round_thumbnail' ) ) {
        $class_customizer_css->add(
            '.content-card--big .content-card__image img',
            [ 'border-radius: 6px', '' ]
        );
    }


    // post cards  >  horizontal
    if ( $wpshop_core->get_option( 'post_card_horizontal_round_thumbnail' ) ) {
        $class_customizer_css->add(
            '.content-card--line .content-card__image',
            [ 'border-radius: 6px', '' ]
        );
    }


    // post cards  >  small
    if ( $wpshop_core->get_option( 'post_card_small_round_thumbnail' ) ) {
        $class_customizer_css->add(
            '.content-card--small .content-card__image',
            [ 'border-radius: 6px', '' ]
        );
    }


    // post cards  >  square
    if ( $wpshop_core->get_option( 'post_card_square_round_thumbnail' ) ) {
        $class_customizer_css->add(
            '.content-card--square .content-card__image',
            [ 'border-radius: 6px', '' ]
        );
    }


    // post cards  >  related
    if ( $wpshop_core->get_option( 'post_card_related_round_thumbnail' ) ) {
        $class_customizer_css->add(
            '.b-related .content-card__image',
            [ 'border-radius: 6px', '' ]
        );
    }


    // typography  >  general
    $class_customizer_css->add(
        'body',
        array( 'typography', 'typography_body' )
    );

    // typography  >  header
    $class_customizer_css->add(
        '.site-title, .site-title a',
        array( 'typography', 'typography_site_title' )
    );

    $class_customizer_css->add(
        '.site-description',
        array( 'typography', 'typography_site_description' )
    );

    // typography  >  menu
    $class_customizer_css->add(
        '.site-navigation ul li a, .site-navigation ul li span, .footer-navigation ul li a, .footer-navigation ul li span',
        array( 'typography', 'typography_menu_links' )
    );

    // typography > headers
    $class_customizer_css->add(
        '.h1, h1:not(.site-title)',
        array( 'typography', 'typography_header_h1' )
    );

    $class_customizer_css->add(
        '.h2, h2, .related-posts__header',
        array( 'typography', 'typography_header_h2' )
    );

    $class_customizer_css->add(
        '.h3, h3',
        array( 'typography', 'typography_header_h3' )
    );

    $class_customizer_css->add(
        '.h4, h4',
        array( 'typography', 'typography_header_h4' )
    );

    $class_customizer_css->add(
        '.h5, h5',
        array( 'typography', 'typography_header_h5' )
    );

    $class_customizer_css->add(
        '.h6, h6',
        array( 'typography', 'typography_header_h6' )
    );


    // colors
    $class_customizer_css->add(
        '.page-separator, .pagination .current, .pagination a.page-numbers:hover, .btn, .comment-respond .form-submit input, .mob-hamburger span, .page-links__item, .comment-respond .form-submit .submit',
        array( 'background-color:%s', 'color_main' )
    );
    $class_customizer_css->add(
        '.card-slider__category, .card-slider-container .swiper-pagination-bullet-active,.entry-category a, .widget-header:after, .widget-article--normal .widget-article__image .widget-article__category a, .ingredients-serves:hover, .entry-content ul:not([class])>li:before, .home-text ul:not([class])>li:before, .page-content ul:not([class])>li:before, .taxonomy-description ul:not([class])>li:before, .site-navigation ul li a:before, .site-navigation ul li .removed-link:before, .footer-navigation ul li a:before, .footer-navigation ul li .removed-link:before',
        array( 'background-color:%s', 'color_main' )
    );

    $class_customizer_css->add(
        '.spoiler-box, .mob-hamburger, .inp:focus, .search-form__text:focus, .entry-content blockquote,
        .input:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=datetime]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, input[type=password]:focus, input[type=range]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, select:focus, textarea:focus',
        array( 'border-color:%s !important', 'color_main' )
    );

    $class_customizer_css->add(
        '.entry-content blockquote:before, .spoiler-box__title:after, .site-navigation ul li.menu-item-has-children>a:after, .site-navigation ul li.menu-item-has-children>.removed-link:after, .footer-navigation ul li.menu-item-has-children>a:after, .footer-navigation ul li.menu-item-has-children>.removed-link:after',
        array( 'color:%s', 'color_main' )
    );

    $class_customizer_css->add(
        '.meta-author:before, .meta-comments:before, .meta-cooking-time:before, .meta-date:before, .meta-play:before, .meta-print:before, .meta-serves:before, .meta-views:before, .widget_categories ul li a:before, .widget_nav_menu ul li a:before, .nutritional__header, .star-rating-item.hover,
        .star-rating--score-1:not(.hover) .star-rating-item:nth-child(1),
        .star-rating--score-2:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-2:not(.hover) .star-rating-item:nth-child(2),
        .star-rating--score-3:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-3:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-3:not(.hover) .star-rating-item:nth-child(3),
        .star-rating--score-4:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(3), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(4),
        .star-rating--score-5:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(3), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(4), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(5)',
        array( 'color:%s', 'color_main' )
    );

    $class_customizer_css->add(
        'body',
        array( 'color:%s', 'color_text' )
    );

    $class_customizer_css->add(
        'a, .spanlink, .comment-reply-link, .pseudo-link, .cook-pseudo-link, .widget_calendar a, .widget_recent_comments a, .child-categories ul li a',
        array( 'color:%s', 'color_link' )
    );

    $class_customizer_css->add(
        '.child-categories ul li a',
        array( 'border-color:%s', 'color_link' )
    );

    $class_customizer_css->add(
        'a:hover, a:focus, a:active, .spanlink:hover, .comment-reply-link:hover, .pseudo-link:hover, .content-card__title a:hover, .child-categories ul li a:hover, .widget a:hover, .site-footer a:hover',
        array( 'color:%s', 'color_link_hover' )
    );

    $class_customizer_css->add(
        '.entry-tag:hover',
        array( 'box-shadow:0 1px 0 %s', 'color_link_hover' )
    );

    $class_customizer_css->add(
        '.child-categories ul li a:hover',
        array( 'border-color:%s', 'color_link_hover' )
    );

    $class_customizer_css->add(
        '.site-header',
        array( 'background-color:%s', 'color_header_bg' )
    );

    $class_customizer_css->add(
        '.site-header, .site-header a, .site-header .pseudo-link',
        array( 'color:%s', 'color_header' )
    );

    $class_customizer_css->add(
        '.site-title, .site-title a',
        array( 'color:%s', 'color_logo' )
    );

    $class_customizer_css->add(
        '.site-description',
        array( 'color:%s', 'color_site_description' )
    );

    $class_customizer_css->add(
        '.site-navigation, .footer-navigation, .site-navigation ul li .sub-menu, .footer-navigation ul li .sub-menu',
        array( 'background-color:%s', 'color_menu_bg' )
    );

    $class_customizer_css->add(
        '.site-navigation ul li a, .site-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link',
        array( 'color:%s', 'color_menu' )
    );

    $class_customizer_css->add(
        '.site-content',
        array( 'background-color:%s', 'color_content_bg' )
    );

    $class_customizer_css->add(
        '.site-footer',
        array( 'background-color:%s', 'color_footer_bg' )
    );

    $class_customizer_css->add(
        '.site-footer, .site-footer a, .site-footer .pseudo-link',
        array( 'color:%s', 'color_footer' )
    );


    // background
    if ( $wpshop_core->get_option( 'header_bg_mob' ) == 'yes' ) {
        $class_customizer_css->add(
            '.site-header',
            array( 'background-image: url("%s")', 'header_bg' )
        );

        $class_customizer_css->add(
            '.site-header',
            array( 'background-repeat:%s', 'header_bg_repeat' )
        );

        $class_customizer_css->add(
            '.site-header',
            array( 'background-position:%s', 'header_bg_position' )
        );
    } else {
        $class_customizer_css->add(
            '.site-header',
            array( 'background-image: url("%s")', 'header_bg' ),
            '(min-width: 768px)'
        );

        $class_customizer_css->add(
            '.site-header',
            array( 'background-repeat:%s', 'header_bg_repeat' ),
            '(min-width: 768px)'
        );

        $class_customizer_css->add(
            '.site-header',
            array( 'background-position:%s', 'header_bg_position' ),
            '(min-width: 768px)'
        );
    }


    // pattern
    /*$class_customizer_css->add(
        'body',
        array( 'background-image:url(' . get_bloginfo('template_url') . '/assets/images/backgrounds/%s)', 'bg_pattern' )
    );*/


    /**
     * Sidebar on mobile
     */
    global $wpshop_core;

    $sidebar_mob = $wpshop_core->get_option( 'sidebar_mob_display' );
    if ( $sidebar_mob ) {
        $class_customizer_css->add(
            '.widget-area',
            array( 'display: block; margin: 0 auto' ),
            '(max-width: 991px)'
        );
    }


    $output = $class_customizer_css->output();
    if ( ! empty( $output ) ) {
        echo PHP_EOL . '    <style>' . $output . '</style>'.PHP_EOL;
    }
}
add_action( 'wp_head', 'wpshop_customizer_css', 10 );