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

global $wpshop_customizer;
global $wpshop_core;
global $wpshop_social;

add_action( 'customize_register', function( $wp_customize ) use ( $wpshop_core, $wpshop_customizer, $wpshop_social ) {

    /*$patterns = [
        'wood.jpg'       => [
            'label'      => esc_html__( 'Wood', THEME_TEXTDOMAIN ),
            'mini'       => 'wood-mini.jpg',
        ],
        'wood-2.jpg'     => [
            'label'      => esc_html__( 'Wood 2', THEME_TEXTDOMAIN ),
            'mini'       => 'wood-2-mini.jpg',
        ],
        'blue-waves.png' => [
            'label'      => esc_html__( 'Blue waves', THEME_TEXTDOMAIN ),
            'mini'       => 'blue-waves-mini.png',
        ],
        'plaid.jpg'      => [
            'label'      => esc_html__( 'Plaid', THEME_TEXTDOMAIN ),
            'mini'       => 'plaid-mini.jpg',
        ],
        'wallpaper.png'  => [
            'label'      => esc_html__( 'Wallpaper', THEME_TEXTDOMAIN ),
            'mini'       => 'wallpaper-mini.png',
        ],
        'honey.png'      => [
            'label'      => esc_html__( 'Honey', THEME_TEXTDOMAIN ),
            'mini'       => 'honey-mini.png',
        ],
        'wall.png'       => [
            'label'      => esc_html__( 'Wall', THEME_TEXTDOMAIN ),
            'mini'       => 'wall-mini.png',
        ],
        'sea.png'        => [
            'label'      => esc_html__( 'Sea', THEME_TEXTDOMAIN ),
            'mini'       => 'sea-mini.png',
        ],
        'dots.png'       => [
            'label'      => esc_html__( 'Dots', THEME_TEXTDOMAIN ),
            'mini'       => 'dots-mini.png',
        ],
    ];*/

    $post_cards = [
        'post-big'    => __( 'Big card', THEME_TEXTDOMAIN ),
        'post-line'   => __( 'Horizontal card', THEME_TEXTDOMAIN ),
        'post-small'  => __( 'Small card', THEME_TEXTDOMAIN ),
        'post-square' => __( 'Square card', THEME_TEXTDOMAIN ),
    ];

    $sidebar_position = [
        'right' => __( 'Right', THEME_TEXTDOMAIN ),
        'left'  => __( 'Left', THEME_TEXTDOMAIN ),
        'none'  => __( 'Do not show', THEME_TEXTDOMAIN ),
    ];

    $post_card_order = [
        'thumbnail' => __( 'Thumbnail', THEME_TEXTDOMAIN ),
        'title'     => __( 'Title', THEME_TEXTDOMAIN ),
        'category'  => __( 'Category', THEME_TEXTDOMAIN ),
        'meta'      => __( 'Meta', THEME_TEXTDOMAIN ),
        'excerpt'   => __( 'Excerpt', THEME_TEXTDOMAIN ),
    ];

    $post_card_order_meta = [
        'cooking_time'    => __( 'Сooking time', THEME_TEXTDOMAIN ),
        'serves'          => __( 'Serves', THEME_TEXTDOMAIN ),
        'date'            => __( 'Date', THEME_TEXTDOMAIN ),
        'comments_number' => __( 'Comments count', THEME_TEXTDOMAIN ),
        'views'           => __( 'Views count', THEME_TEXTDOMAIN ),
        'author'          => __( 'Author', THEME_TEXTDOMAIN ),
    ];

    /*$pattern_choices = array(
        'no' => array(
            'label' => esc_html__( 'No', THEME_TEXTDOMAIN ),
            'url'   => '%s/assets/images/backgrounds/no.png'
        ),
    );
    foreach ( $patterns as $key => $pattern ) {
        $pattern_choices[ $key ] = array(
            'label'     => $pattern['label'],
            'url'       => '%s/assets/images/backgrounds/' . $pattern['mini'],
        );
    }*/

    $customizer_controls = [

        'layout' => [
            'title'    => __( 'Layout', THEME_TEXTDOMAIN ),
            'priority' => 10,

            'sections' => [

                'header' => [
                    'title'       => __( 'Header', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the width and height of the header', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#structure-header" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'header_width' => [
                            'label'   => __( 'Header width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                        'header_inner_width' => [
                            'label'   => __( 'Header inner width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                        'header_padding_top' => [
                            'label'       => __( 'Header padding top', THEME_TEXTDOMAIN ),
                            'type'        => 'range',
                            'sanitize'    => 'integer',
                            'description' => __( 'You can set padding top and bottom, ex. for background image', THEME_TEXTDOMAIN ),
                            'input_attrs' => [ 'min' => 0, 'max' => 200, 'step' => 1 ],
                        ],

                        'header_padding_bottom' => [
                            'label'       => __( 'Header padding bottom', THEME_TEXTDOMAIN ),
                            'type'        => 'range',
                            'sanitize'    => 'integer',
                            'input_attrs' => [ 'min' => 0, 'max' => 200, 'step' => 1 ],
                        ],

                    ],
                ],

                'header_menu' => [
                    'title'       => __( 'Header menu', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the width and fixation of the menu under the header', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#structure-menu-header" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'header_menu_width' => [
                            'label'   => __( 'Header menu width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                        'header_menu_inner_width' => [
                            'label'   => __( 'Header menu inner width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                    ],
                ],

                'footer_menu' => [
                    'title'       => __( 'Footer menu', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the width and display on the mobile menu in the footer', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#structure-menu-footer" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'footer_menu_width' => [
                            'label'   => __( 'Footer menu width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                        'footer_menu_inner_width' => [
                            'label'   => __( 'Footer menu inner width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                    ],
                ],

                'footer' => [
                    'title'       => __( 'Footer', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the width of the footer', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#structure-footer" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'footer_width' => [
                            'label'   => __( 'Footer width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                        'footer_inner_width' => [
                            'label'   => __( 'Footer inner width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                    ],
                ],

            ],
        ],


        'structure' => [
            'title'    => __( 'Blocks', THEME_TEXTDOMAIN ),
            'priority' => 12,

            'sections' => [

                'header' => [
                    'title'       => __( 'Header', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the header', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-header" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'logotype_image' => [
                            'name'  => 'logotype_image',
                            'label' => __( 'Logotype', THEME_TEXTDOMAIN ),
                            'type'  => 'image',
                        ],

                        'logotype_max_width' => [
                            'label'       => __( 'Logotype max width, px', THEME_TEXTDOMAIN ),
                            'type'        => 'number',
                            'input_attrs' => [ 'min' => 20, 'max' => 1000, 'step' => 1 ],
                        ],

                        'logotype_max_height' => [
                            'label'       => __( 'Logotype max height, px', THEME_TEXTDOMAIN ),
                            'type'        => 'number',
                            'input_attrs' => [ 'min' => 20, 'max' => 500, 'step' => 1 ],
                        ],

                        'header_hide_title' => [
                            'label'       => __( 'Hide site title and description', THEME_TEXTDOMAIN ),
                            'type'        => 'checkbox',
                            'description' => __( 'If you hide the title and description, it is desirable to set for the main page h1, for example, in the section "Blocks" -> "Home"', THEME_TEXTDOMAIN ),
                        ],

                        'header_social' => [
                            'label'       => __( 'Show social links', THEME_TEXTDOMAIN ),
                            'type'        => 'checkbox',
                            'description' => __( 'Links to social networks can be set in Modules -> Social Profiles', THEME_TEXTDOMAIN ),
                        ],

                        'header_html_block_1' => [
                            'label'       => __( 'HTML code #1', THEME_TEXTDOMAIN ),
                            'type'        => 'textarea',
                            'description' => __( 'Code will be displayed after logotype', THEME_TEXTDOMAIN ),
                        ],

                        'header_html_block_2' => [
                            'label'       => __( 'HTML code #2', THEME_TEXTDOMAIN ),
                            'type'        => 'textarea',
                            'description' => __( 'Code will be displayed after top menu', THEME_TEXTDOMAIN ),
                        ],

                        'header_search' => [
                            'label' => __( 'Show search', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],
                    ],
                ],

                'footer' => [
                    'title'       => __( 'Footer', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the footer', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-footer" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'footer_widgets'  => [
                            'label'       => __( 'Number of widget areas', THEME_TEXTDOMAIN ),
                            'description' => __( '0 - for disable, maximum 5', THEME_TEXTDOMAIN ),
                            'type'        => 'number',
                            'input_attrs' => [ 'min' => 0, 'max' => 5, 'step' => 1 ],
                        ],

                        'footer_copyright' => [
                            'label'        => __( 'Copyright', THEME_TEXTDOMAIN ),
                            'description'  => __( 'Use %year% to add the current year', THEME_TEXTDOMAIN ),
                            'type'         => 'textarea',
                        ],

                        'footer_counters' => [
                            'label'       => __( 'Counters', THEME_TEXTDOMAIN ),
                            'type'        => 'textarea',
                        ],

                    ],
                ],

                'home' => [
                    'title'       => __( 'Home', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the home page', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-main" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'structure_home_posts' => [
                            'label'   => __( 'Post cards on home', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => $post_cards,
                        ],

                        'structure_home_sidebar' => [
                            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => $sidebar_position,
                        ],

                        'structure_home_h1' => [
                            'label'       => __( 'Header H1', THEME_TEXTDOMAIN ),
                            'description' => __( 'If the field is not specified, the logo (site name) becomes the h1 header', THEME_TEXTDOMAIN ),
                        ],

                        'structure_home_text' => [
                            'label'       => __( 'Text', THEME_TEXTDOMAIN ),
                            'type'        => 'textarea',
                            'description' => __( 'The text under the heading H1 is displayed only on the main', THEME_TEXTDOMAIN ),
                        ],

                        'structure_home_position' => [
                            'label'   => __( 'H1 and text position', THEME_TEXTDOMAIN ),
                            'type'    => 'radio',
                            'choices' => [
                                'top'    => __( 'Top', THEME_TEXTDOMAIN ),
                                'bottom' => __( 'Bottom', THEME_TEXTDOMAIN ),
                            ],
                        ]

                    ],
                ],

                'single' => [
                    'title'       => __( 'Single', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the post', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-post" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'structure_single_sidebar' => [
                            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => $sidebar_position,
                        ],

                        'structure_single_hide' => [
                            'label'    => __( 'Hide elements', THEME_TEXTDOMAIN ),
                            'type'    => 'multicheck',
                            'choices' => [
                                'thumbnail'      => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                'category'       => __( 'Category', THEME_TEXTDOMAIN ),
                                'author'         => __( 'Author', THEME_TEXTDOMAIN ),
                                'date'           => __( 'Date', THEME_TEXTDOMAIN ),
                                'comments_count' => __( 'Comments count', THEME_TEXTDOMAIN ),
                                'views'          => __( 'Views count', THEME_TEXTDOMAIN ),
                                'social_top'     => __( 'Top social buttons', THEME_TEXTDOMAIN ),
                                'excerpt'        => __( 'Excerpt', THEME_TEXTDOMAIN ),
                                'cooking_time'   => __( 'Cooking time', THEME_TEXTDOMAIN ),
                                'author_box'     => __( 'Author block', THEME_TEXTDOMAIN ),
                                'social_bottom'  => __( 'Bottom social buttons', THEME_TEXTDOMAIN ),
                                'rating'         => __( 'Rating', THEME_TEXTDOMAIN ),
                                'tags'           => __( 'Tags', THEME_TEXTDOMAIN ),
                                'comments'       => __( 'Comments', THEME_TEXTDOMAIN ),
                            ],
                        ],

                        'structure_single_related' => [
                            'label'       => __( 'Count of related articles', THEME_TEXTDOMAIN ),
                            'type'        => 'number',
                            'input_attrs' => [ 'min' => 0, 'max' => 50, 'step' => 1 ],
                            'description' => __( '0 - for disable, maximum 50', THEME_TEXTDOMAIN ),
                        ],

                    ],
                ],

                'page' => [
                    'title'       => __( 'Page', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the page', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-page" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'structure_page_sidebar' => [
                            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => $sidebar_position,
                        ],

                        'structure_page_hide' => [
                            'label'   => __( 'Hide elements', THEME_TEXTDOMAIN ),
                            'type'    => 'multicheck',
                            'choices' => [
                                'thumbnail'     => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                'social_top'    => __( 'Top social buttons', THEME_TEXTDOMAIN ),
                                'social_bottom' => __( 'Bottom social buttons', THEME_TEXTDOMAIN ),
                                'rating'        => __( 'Rating', THEME_TEXTDOMAIN ),
                                'comments'      => __( 'Comments', THEME_TEXTDOMAIN ),
                            ],
                        ],

                        'structure_page_related' => [
                            'label'       => __( 'Count of related articles', THEME_TEXTDOMAIN ),
                            'type'        => 'number',
                            'input_attrs' => [ 'min' => 0, 'max' => 50, 'step' => 1 ],
                            'description' => __( '0 - for disable, maximum 50', THEME_TEXTDOMAIN ),
                        ],

                    ],
                ],

                'archive' => [
                    'title'       => __( 'Archive', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the archive', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-archive" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'structure_archive_posts' => [
                            'label'   => __( 'Post cards in archive', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => $post_cards,
                        ],

                        'structure_archive_sidebar' => [
                            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => $sidebar_position,
                        ],

                        'structure_archive_description_show' => [
                            'label' => __( 'Show description', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'structure_archive_subcategories' => [
                            'label' => __( 'Show subcategories', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'structure_archive_description' => [
                            'label'   => __( 'Position of archive description', THEME_TEXTDOMAIN ),
                            'type'    => 'radio',
                            'choices' => [
                                'top'    => __( 'Top', THEME_TEXTDOMAIN ),
                                'bottom' => __( 'Bottom', THEME_TEXTDOMAIN ),
                            ],
                        ],

                    ],
                ],

                'comments' => [
                    'title'       => __( 'Comments', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the comments', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-comments" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'comments_text_before_submit' => [
                            'label'       => __( 'Text before Send button', THEME_TEXTDOMAIN ),
                            'type'        => 'textarea',
                            'description' => 'Вы можете добавить любой HTML код, пример с ссылками (# нужно заменить на адрес ссылки):<br><br>Нажимая на кнопку "Отправить комментарий", я даю согласие на &lt;a href="#"&gt;обработку персональных данных&lt;/a&gt; и принимаю &lt;a href="#" target="_blank"&gt;политику конфиденциальности&lt;/a&gt;.',
                        ],

                        'comments_date' => [
                            'label' => __( 'Show comment date', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'comments_time' => [
                            'label' => __( 'Show comment time', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'comments_smiles' => [
                            'label' => __( 'Show smiles', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'sidebar' => [
                    'title'       => __( 'Sidebar', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the appearance of the sidebar', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#blocks-sidebar" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'sidebar_mob_display' => [
                            'label' => __( 'Enable sidebar on mobile', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

            ],
        ],


        'modules' => [
            'title'    => __( 'Modules', THEME_TEXTDOMAIN ),
            'priority' => 12,

            'sections' => [

                'slider' => [
                    'title'       => __( 'Slider', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the slider', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#slider" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'slider_width' => [
                            'label'   => __( 'Slider width', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN )
                            ],
                        ],

                        'slider_autoplay' => [
                            'label'       => __( 'Autoplay', THEME_TEXTDOMAIN ),
                            'type'        => 'number',
                            'input_attrs' => [ 'min' => 0, 'max' => 100000, 'step' => 500 ],
                            'description' => __( 'Autoplay slides in ms, 0 - for disable', THEME_TEXTDOMAIN ),
                        ],

                        'slider_type' => [
                            'label'   => __( 'Slider type', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'one'        => __( 'One slide', THEME_TEXTDOMAIN ),
                                'three'      => __( 'Three slides', THEME_TEXTDOMAIN ),
                                'thumbnails' => __( 'With thumbnails', THEME_TEXTDOMAIN ),
                            ],
                        ],

                        'slider_count' => [
                            'label'       => __( 'Count of slider posts', THEME_TEXTDOMAIN ),
                            'type'        => 'number',
                            'input_attrs' => [ 'min' => 0, 'max' => 50, 'step' => 1 ],
                            'description' => __( 'The latest posts with thumbnails will be displayed. 0 - for disable, maximum 15', THEME_TEXTDOMAIN ),
                        ],

                        'slider_order_post' => [
                            'label'   => __( 'Order posts', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                'rand'     => __( 'Rand', THEME_TEXTDOMAIN ),
                                'views'    => __( 'By views', THEME_TEXTDOMAIN ),
                                'comments' => __( 'By comments', THEME_TEXTDOMAIN ),
                                'new'      => __( 'New top', THEME_TEXTDOMAIN ),
                            ],
                        ],

                        'slider_post_in' => [
                            'label'       => __( 'ID posts for the slider', THEME_TEXTDOMAIN ),
                            'description' => __( 'You can specify the ID of posts separated by commas to display certain posts in the slider. Missing will be filled with the latest posts.', THEME_TEXTDOMAIN ),
                        ],

                        'slider_category_in' => [
                            'label'       => __( 'ID category posts for the slider', THEME_TEXTDOMAIN ),
                            'description' => __( 'You can specify the ID of category for posts separated by commas to display certain posts in the slider. Missing will be filled with posts in accordance with the sorting.', THEME_TEXTDOMAIN ),
                        ],

                        'slider_show_on_paged' => [
                            'label' => __( 'Show on pagination pages', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'slider_show_category' => [
                            'label' => __( 'Show category', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'slider_show_title' => [
                            'label' => __( 'Show title', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'slider_show_excerpt' => [
                            'label' => __( 'Show excerpt', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'slider_mob_disable' => [
                            'label' => __( 'Disable slider on mobile', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'toc' => [
                    'title'       => __( 'Contents', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the toc', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#toc-content" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'toc_display' => [
                            'label' => __( 'Enable on posts', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'toc_display_pages' => [
                            'label' => __( 'Enable on pages', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'toc_open' => [
                            'label' => __( 'Default open', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'toc_noindex' => [
                            'label' => __( 'Wrap the content in noindex', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'toc_place' => [
                            'label' => __( 'Display the content at the beginning of the post', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'toc_title' => [
                            'label' => __( 'Content title', THEME_TEXTDOMAIN ),
                        ],

                    ],
                ],

                'lightbox' => [
                    'title'       => __( 'Lightbox', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can turn on the enlargement of the picture when you click on it', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#lightbox" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'lightbox_display' => [
                            'label' => __( 'Enable lightbox', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'breadcrumbs' => [
                    'title'       => __( 'Breadcrumbs', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the breadcrumbs', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#breadcrumbs" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'breadcrumbs_display' => [
                            'label' => __( 'Enable breadcrumbs', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'breadcrumbs_home_text' => [
                            'label' => __( 'Home text', THEME_TEXTDOMAIN ),
                        ],

                        'breadcrumbs_archive' => [
                            'label' => __( 'Show breadcrumbs in archives', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'breadcrumbs_single_link' => [
                            'label' => __( 'Display page title', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'social_profiles' => [
                    'title'       => __( 'Social profiles', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the social profiles', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#social-profiles" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'social_facebook' => [
                            'label' => __( 'Facebook', THEME_TEXTDOMAIN ),
                        ],

                        'social_vkontakte' => [
                            'label' => __( 'Vk', THEME_TEXTDOMAIN ),
                        ],

                        'social_twitter' => [
                            'label' => __( 'Twitter', THEME_TEXTDOMAIN ),
                        ],

                        'social_odnoklassniki' => [
                            'label' => __( 'Odnoklassniki', THEME_TEXTDOMAIN ),
                        ],

                        'social_telegram' => [
                            'label' => __( 'Telegram', THEME_TEXTDOMAIN ),
                        ],

                        'social_youtube' => [
                            'label' => __( 'Youtube', THEME_TEXTDOMAIN ),
                        ],

                        'social_instagram' => [
                            'label' => __( 'Instagram', THEME_TEXTDOMAIN ),
                        ],

                        'social_tiktok' => [
                            'label' => __( 'Tik Tok', THEME_TEXTDOMAIN ),
                        ],

                        'social_linkedin' => [
                            'label' => __( 'Linkedin', THEME_TEXTDOMAIN ),
                        ],

                        'social_whatsapp' => [
                            'label' => __( 'WhatsApp', THEME_TEXTDOMAIN ),
                        ],

                        'social_viber' => [
                            'label' => __( 'Viber', THEME_TEXTDOMAIN ),
                        ],

                        'social_pinterest' => [
                            'label' => __( 'Pinterest', THEME_TEXTDOMAIN ),
                        ],

                        'social_yandexzen' => [
                            'label' => __( 'Yandex Zen', THEME_TEXTDOMAIN ),
                        ],

                        'social_github' => [
                            'label' => __( 'GitHub', THEME_TEXTDOMAIN ),
                        ],

                        'social_discord' => [
                            'label' => __( 'Discord', THEME_TEXTDOMAIN ),
                        ],

                        'social_rutube' => [
                            'label' => __( 'RuTube', THEME_TEXTDOMAIN ),
                        ],

                        'social_yappy' => [
                            'label' => __( 'Yappy', THEME_TEXTDOMAIN ),
                        ],

                        'social_pikabu' => [
                            'label' => __( 'Pikabu', THEME_TEXTDOMAIN ),
                        ],

                        'social_yandex' => [
                            'label' => __( 'Yandex', THEME_TEXTDOMAIN ),
                        ],

                        'structure_social_js' => [
                            'label' => __( 'Hide links by JS', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'share_buttons' => [
                    'title'       => __( 'Share buttons', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the share buttons', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#share-buttons" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'share_buttons_counters' => [
                            'label' => __( 'Enable counters', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'share_buttons' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Share buttons', THEME_TEXTDOMAIN ),
                            'choices' => $wpshop_social->get_share_services(),
                        ],

                    ],
                ],

                'author_block' => [
                    'title'       => __( 'Author block', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the author block', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#author-block" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'author_link' => [
                            'label' => __( 'Display a link to the author’s page', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'author_link_target' => [
                            'label' => __( 'Open link in new window', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'author_social_enable' => [
                            'label'       => __( 'Display author social profiles', THEME_TEXTDOMAIN ),
                            'type'        => 'checkbox',
                            'description' => __( 'Links to social profiles author can be set in Users', THEME_TEXTDOMAIN ),

                        ],

                        'author_social_title' => [
                            'label' => __( 'Social profiles title', THEME_TEXTDOMAIN ),
                        ],

                        'author_social_title_show' => [
                            'label' => __( 'Show title social profiles', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'author_social_js' => [
                            'label' => __( 'Hide links social profiles by JS', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'contact_form' => [
                    'title'       => __( 'Contact Form', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the contact form', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#contact-form" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'contact_form_text_before_submit' => [
                            'label'       => __( 'Text before Send button', THEME_TEXTDOMAIN ),
                            'type'        => 'textarea',
                            'description' => 'Вы можете добавить любой HTML код, пример с ссылками (# нужно заменить на адрес ссылки):<br><br>Нажимая на кнопку "Отправить", я даю согласие на &lt;a href="#"&gt;обработку персональных данных&lt;/a&gt; и принимаю &lt;a href="#" target="_blank"&gt;политику конфиденциальности&lt;/a&gt;.',
                        ],

                    ],
                ],

                'sitemap' => [
                    'title'       => __( 'Sitemap', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the sitemap', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#sitemap" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'sitemap_category_exclude' => [
                            'label'       => __( 'ID of categories to exclude', THEME_TEXTDOMAIN ),
                            'description' => __( 'Enter the ID of the categories separated by commas to exclude them from the sitemap', THEME_TEXTDOMAIN ),
                        ],

                        'sitemap_posts_exclude' => [
                            'label' => __( 'ID of posts to exclude', THEME_TEXTDOMAIN ),
                            'description' => __( 'Enter the ID of the posts separated by commas to exclude them from the sitemap', THEME_TEXTDOMAIN ),
                        ],

                        'sitemap_pages_show' => [
                            'label' => __( 'Show pages in sitemap', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'sitemap_pages_exclude' => [
                            'label' => __( 'ID of pages to exclude', THEME_TEXTDOMAIN ),
                            'description' => __( 'Enter the ID of the pages separated by commas to exclude them from the sitemap', THEME_TEXTDOMAIN ),
                        ],

                    ],
                ],

                'related_posts' => [
                    'title'       => __( 'Related posts', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the related posts', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#related-posts" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'related_posts_title' => [
                            'label' => __( 'Related posts title', THEME_TEXTDOMAIN ),
                        ],

                        'related_post_taxonomy_order' => [
                            'label'       => __( 'Order related posts', THEME_TEXTDOMAIN ),
                            'type'        => 'select',
                            'choices'     => [
                                'categories' => __( 'By categories', THEME_TEXTDOMAIN ),
                                'tags'       => __( 'By tags', THEME_TEXTDOMAIN ),
                            ],
                            'description' => __( 'In related posts, posts from the same category\tag are displayed first, and then, if there is not enough related articles to the specified number, they are displayed randomly', THEME_TEXTDOMAIN ),
                        ],

                        'related_posts_exclude' => [
                            'label'       => __( 'ID of posts to exclude', THEME_TEXTDOMAIN ),
                            'description' => __( 'You can specify the ID of the posts separated by commas to exclude them from the related posts', THEME_TEXTDOMAIN ),
                        ],

                        'related_posts_category_exclude' => [
                            'label'       => __( 'ID of categories to exclude', THEME_TEXTDOMAIN ),
                            'description' => __( 'You can specify the ID of categories separated by commas to exclude them from the related posts', THEME_TEXTDOMAIN ),
                        ],

                        'related_posts_after_comments' => [
                            'label'       => __( 'Display related posts after comments', THEME_TEXTDOMAIN ),
                            'type'        => 'checkbox',
                            'description' => __( 'By default, related posts are displayed before comments', THEME_TEXTDOMAIN ),
                        ],

                    ],
                ],

                'arrow' => [
                    'title'       => __( 'Scroll to top button', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the top button', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#top-button" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'structure_arrow' => [
                            'label' => __( 'Enable scroll to top button', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'structure_arrow_mob' => [
                            'label' => __( 'Enable on mobile', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'structure_arrow_bg' => [
                            'label' => __( 'Background color', THEME_TEXTDOMAIN ),
                            'type'  => 'color',
                        ],

                        'structure_arrow_color' => [
                            'label' => __( 'Arrow color', THEME_TEXTDOMAIN ),
                            'type'  => 'color',
                        ],

                        'structure_arrow_width' => [
                            'label'       => __( 'Button width', THEME_TEXTDOMAIN ),
                            'type'        => 'range',
                            'sanitize'    => 'integer',
                            'input_attrs' => [ 'min' => 30, 'max' => 80, 'step' => 1 ],
                        ],

                        'structure_arrow_height' => [
                            'label'       => __( 'Button height', THEME_TEXTDOMAIN ),
                            'type'        => 'range',
                            'sanitize'    => 'integer',
                            'input_attrs' => [ 'min' => 30, 'max' => 80, 'step' => 1 ],
                        ],

                        'structure_arrow_icon' => [
                            'label'   => __( 'Button icon', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                '\2b9d' => '⮝',
                                '\2b85' => '⮅',
                                '\2b61' => '⭡',
                                '\2b06' => '⬆',
                                '\25b3' => '△',
                            ],
                        ],

                    ],
                ],

                'views_counter' => [
                    'title'       => __( 'Views counter', THEME_TEXTDOMAIN ),
                    'description' => __( 'In this section, you can customize the views counter', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/modules/#views-counter" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'wpshop_views_counter_enable' => [
                            'label' => __( 'Enable view counter', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                        'wpshop_views_counter_to_count' => [
                            'label'   => __( 'Count views', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                '0' => __( 'Everyone', THEME_TEXTDOMAIN ),
                                '1' => __( 'Only guests', THEME_TEXTDOMAIN ),
                                '2' => __( 'Only registered users', THEME_TEXTDOMAIN ),
                            ],
                        ],

                        'wpshop_views_counter_exclude_bots' => [
                            'label'   => __( 'Exclude bot views', THEME_TEXTDOMAIN ),
                            'type'    => 'select',
                            'choices' => [
                                '0' => __( 'No', THEME_TEXTDOMAIN ),
                                '1' => __( 'Yes', THEME_TEXTDOMAIN ),
                            ],
                        ],

                    ],
                ],

            ],
        ],


        'post_cards' => [
            'title'    => __( 'Post cards', THEME_TEXTDOMAIN ),
            'priority' => 12,

            'sections' => [

                'post_card_standard' => [
                    'title' => __( 'Big', THEME_TEXTDOMAIN ),

                    'controls' => [

                        'post_card_standard_order' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order,
                        ],

                        'post_card_standard_order_meta' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order_meta,
                        ],

                        'post_card_standard_excerpt_length' => [
                            'label' => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                            'type'  => 'number',
                        ],

                        'post_card_standard_round_thumbnail' => [
                            'label' => __( 'Round off a thumbnail', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'post_card_horizontal' => [
                    'title' => __( 'Horizontal', THEME_TEXTDOMAIN ),

                    'controls' => [

                        'post_card_horizontal_order' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order,
                        ],

                        'post_card_horizontal_order_meta' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order_meta,
                        ],

                        'post_card_horizontal_excerpt_length' => [
                            'label' => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                            'type'  => 'number',
                        ],

                        'post_card_horizontal_round_thumbnail' => [
                            'label' => __( 'Round off a thumbnail', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'post_card_small' => [
                    'title' => __( 'Small', THEME_TEXTDOMAIN ),

                    'controls' => [

                        'post_card_small_order' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order,
                        ],

                        'post_card_small_order_meta' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order_meta,
                        ],

                        'post_card_small_excerpt_length' => [
                            'label' => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                            'type'  => 'number',
                        ],

                        'post_card_small_round_thumbnail' => [
                            'label' => __( 'Round off a thumbnail', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'post_card_square' => [
                    'title' => __( 'Square', THEME_TEXTDOMAIN ),

                    'controls' => [

                        'post_card_square_order' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order,
                        ],

                        'post_card_square_order_meta' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                            'choices' => $post_card_order_meta,
                        ],

                        'post_card_square_excerpt_length' => [
                            'label' => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                            'type'  => 'number',
                        ],

                        'post_card_square_round_thumbnail' => [
                            'label' => __( 'Round off a thumbnail', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

                'post_card_related' => [
                    'title' => __( 'Related posts', THEME_TEXTDOMAIN ),

                    'controls' => [

                        'post_card_related_order' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                            'choices' => [
                                'thumbnail' => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                'title'     => __( 'Title', THEME_TEXTDOMAIN ),
                                'meta'      => __( 'Meta', THEME_TEXTDOMAIN ),
                                'excerpt'   => __( 'Excerpt', THEME_TEXTDOMAIN ),
                            ],
                        ],

                        'post_card_related_order_meta' => [
                            'type'    => 'sortable-checkboxes',
                            'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                            'choices' => [
                                'cooking_time'    => __( 'Сooking time', THEME_TEXTDOMAIN ),
                                'serves'          => __( 'Serves', THEME_TEXTDOMAIN ),
                                'comments_number' => __( 'Comments count', THEME_TEXTDOMAIN ),
                                'views'           => __( 'Views count', THEME_TEXTDOMAIN ),
                            ]
                        ],

                        'post_card_related_excerpt_length' => [
                            'label'  => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                            'type'   => 'number',
                        ],

                        'post_card_related_round_thumbnail' => [
                            'label' => __( 'Round off a thumbnail', THEME_TEXTDOMAIN ),
                            'type'  => 'checkbox',
                        ],

                    ],
                ],

            ],
        ],


        'codes' => [
            'title'    => __( 'Codes', THEME_TEXTDOMAIN ),
            'priority' => 13,

            'controls' => [

                'code_head' => [
                    'label'       => __( 'In &lt;head&gt; section', THEME_TEXTDOMAIN ),
                    'description' => __( 'Before &lt;/head&gt; tag', THEME_TEXTDOMAIN ),
                    'type'        => 'textarea',
                ],

                'code_body' => [
                    'label' => __( 'Before &lt;/body&gt;', THEME_TEXTDOMAIN ),
                    'type'  => 'textarea',
                ],

                'code_after_content' => [
                    'label' => __( 'After content', THEME_TEXTDOMAIN ),
                    'type'  => 'textarea',
                ]

            ],
        ],


        'typography' => [
            'title'    => __( 'Typography', THEME_TEXTDOMAIN ),
            'priority' => 15,

            'sections' => [

                'typography_general' => [
                    'title' => __( 'General', THEME_TEXTDOMAIN ),

                    'controls' => [

                        'typography_body' => [
                            'label'   => __( 'Main text', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height' ],
                        ],

                    ]
                ],

                'typography_header' => [
                    'title' => __( 'Header', THEME_TEXTDOMAIN ),

                    'controls' => [

                        'typography_site_title' => [
                            'label'   => __( 'Site title', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height' ],
                        ],

                        'typography_site_description' => [
                            'label'   => __( 'Site description', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height' ],
                        ],

                    ],
                ],

                'typography_menu' => [
                    'title' => __( 'Menu', THEME_TEXTDOMAIN ),

                    'controls' => [
                        'typography_menu_links' => [
                            'label'   => __( 'Links in the menu', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height'],
                        ],
                    ],
                ],

                'typography_headers' => [
                    'title'       => __( 'Headers', THEME_TEXTDOMAIN ),
                    'description' => __( 'Font sizes of headings are in relative em units', THEME_TEXTDOMAIN ) . ' <a href="https://wpschool.ru/edinitsy-izmereniya-css/" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',

                    'controls' => [

                        'typography_header_h1' => [
                            'label'   => __( 'Header H1', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-size', 'font-style', 'line-height' ],
                        ],

                        'typography_header_h2' => [
                            'label'   => __( 'Header H2', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-size', 'font-style', 'line-height' ],
                        ],

                        'typography_header_h3' => [
                            'label'   => __( 'Header H3', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-size', 'font-style', 'line-height' ],
                        ],

                        'typography_header_h4' => [
                            'label'   => __( 'Header H4', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-size', 'font-style', 'line-height' ],
                        ],

                        'typography_header_h5' => [
                            'label'   => __( 'Header H5', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-size', 'font-style', 'line-height' ],
                        ],

                        'typography_header_h6' => [
                            'label'   => __( 'Header H6', THEME_TEXTDOMAIN ),
                            'type'    => 'typography',
                            'choices' => [ 'font-family', 'font-size', 'font-style', 'line-height' ],
                        ]

                    ]
                ],

            ]
        ],


        'colors' => [
            'title'    => __( 'Colors', THEME_TEXTDOMAIN ),
            'priority' => 14,

            'controls' => [

                'color_main' => [
                    'label' => __( 'Base site color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_text' => [
                    'label' => __( 'Site text color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_link' => [
                    'label' => __( 'Link color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_link_hover' => [
                    'label' => __( 'Link hover color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_header_bg' => [
                    'label' => __( 'Header background color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_header' => [
                    'label' => __( 'Header text and link color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_logo' => [
                    'label' => __( 'Site title color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_site_description' => [
                    'label' => __( 'Site description color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_menu_bg' => [
                    'label' => __( 'Menu background color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_menu' => [
                    'label' => __( 'Menu link color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_content_bg' => [
                    'label' => __( 'Content background color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_footer_bg' => [
                    'label' => __( 'Footer background color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

                'color_footer' => [
                    'label' => __( 'Footer text and link color', THEME_TEXTDOMAIN ),
                    'type'  => 'color',
                ],

            ],
        ],


        'background_image' => [
            'title'    => __( 'Background', THEME_TEXTDOMAIN ),
            'priority' => 14,

            'controls' => [

                'body_bg_link' => [
                    'label' => __( 'Site background link', THEME_TEXTDOMAIN ),
                ],

                'body_bg_link_js' => [
                    'label' => __( 'Hide link background by JS', THEME_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                ],

                'header_bg' => [
                    'label'       => __( 'Header background', THEME_TEXTDOMAIN ),
                    'type'        => 'image',
                    'description' => __( 'By default, the background of the header is displayed only on the desktop', THEME_TEXTDOMAIN ),
                ],

                'header_bg_repeat' => [
                    'label'   => __( 'Header background repeat', THEME_TEXTDOMAIN ),
                    'type'    => 'select',
                    'choices' => [
                        'no-repeat' => __( 'No repeat', THEME_TEXTDOMAIN ),
                        'repeat'    => __( 'Repeat horizontal and vertical', THEME_TEXTDOMAIN ),
                        'repeat-x'  => __( 'Repeat horizontal', THEME_TEXTDOMAIN ),
                        'repeat-y'  => __( 'Repeat vertical', THEME_TEXTDOMAIN ),
                    ],
                ],

                'header_bg_position' => [
                    'label'   => __( 'Header background position', THEME_TEXTDOMAIN ),
                    'type'    => 'select',
                    'choices' => [
                        'left top'      => __( 'Top left', THEME_TEXTDOMAIN ),
                        'center top'    => __( 'Top center', THEME_TEXTDOMAIN ),
                        'right top'     => __( 'Top right', THEME_TEXTDOMAIN ),
                        'left center'   => __( 'Middle left', THEME_TEXTDOMAIN ),
                        'center center' => __( 'Middle center', THEME_TEXTDOMAIN ),
                        'right center'  => __( 'Middle right', THEME_TEXTDOMAIN ),
                        'left bottom'   => __( 'Bottom left', THEME_TEXTDOMAIN ),
                        'center bottom' => __( 'Bottom center', THEME_TEXTDOMAIN ),
                        'right bottom'  => __( 'Bottom right', THEME_TEXTDOMAIN ),
                    ],
                ],

                'header_bg_mob' => [
                    'label' => __( 'Display header background on mobile', THEME_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                ],

            ],
        ],


        'home_constructor' => [
            'title'       => __( 'Home constructor', THEME_TEXTDOMAIN ),
            'description' => __( 'In this section, you can customize the main constructor blocks', THEME_TEXTDOMAIN ) . ' <a href="https://support.wpshop.ru/docs/themes/cook-it/settings/#home-constructor" target="_blank" rel="noopener" class="cook-it-ico-help" title="' . __( 'Help', THEME_TEXTDOMAIN ) . '">?</a>',
            'priority'    => 16,

            'controls' => [

                'home_constructor' => [
                    'label'   => __( 'Home constructor', THEME_TEXTDOMAIN ),
                    'type'    => 'page-constructor',
                    'choices' => [
                        'title_tags' => [
                            'div',
                            'h2',
                        ],
                        'posts_order' => [
                            'new',
                            'views',
                            'comments',
                            'rand',
                        ],
                        'post_card_types' => [
                            'big',
                            'line',
                            'small',
                            'square',
                        ],
                        'post_card_elements' => [
                            'thumbnail'       => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                            'date'            => __( 'Date', THEME_TEXTDOMAIN ),
                            'excerpt'         => __( 'Excerpt', THEME_TEXTDOMAIN ),
                            'category'        => __( 'Category', THEME_TEXTDOMAIN ),
                            'author'          => __( 'Author', THEME_TEXTDOMAIN ),
                            'views'           => __( 'Views count', THEME_TEXTDOMAIN ),
                            'comments_number' => __( 'Comments count', THEME_TEXTDOMAIN ),
                        ],
                        'presets' => [
                            'gradient-1',
                            'gradient-2',
                            'gradient-3',
                            'bgc-1',
                            'bgc-2',
                            'bgc-3',
                            'bgc-4',
                            'bgc-5',
                            'bgc-6',
                            'bgc-7',
                            'bgc-8',
                            'bgc-9',
                            'bgc-10',
                            'bgc-11',
                            'bgc-12',
                            'bgc-13',
                            'bgc-14',
                            'bgc-15',
                            'bgc-16',
                            'bgc-17',
                            'bg-dark-1',
                            'bg-dark-2',
                            'bg-dark-3',
                            'bg-dark-4',
                            'bg-dark-5',
                            'bg-dark-6',
                            'bg-dark-7',
                            'bg-dark-8',
                            'bg-dark-9',
                            'bgi-1',
                            'bgi-2',
                        ]
                    ]
                    //'choices' => [ 'font-family', 'font-size', 'font-style', 'line-height', 'color' ],
                ],

                'display_constructor_static_page' => [
                    'label'       => __( 'Display constructor blocks on the main static page', THEME_TEXTDOMAIN ),
                    'type'        => 'checkbox',
                    'description' => __( 'By default, the main constructor blocks are displayed on the blog page with the latest posts', THEME_TEXTDOMAIN ),
                ],
            ],
        ],


        'tweak' => [
            'title'    => __( 'Tweak options', THEME_TEXTDOMAIN ),
            'priority' => 200,

            'controls' => [

                'content_full_width' => [
                    'label' => __( 'Content on full width', THEME_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                ],

                'social_share_title' => [
                    'label' => __( 'Social buttons title', THEME_TEXTDOMAIN ),
                ],

                'social_share_title_show' => [
                    'label' => __( 'Show title social buttons', THEME_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                ],

                'rating_title' => [
                    'label' => __( 'Rating title', THEME_TEXTDOMAIN ),
                ],

                'rating_text_show' => [
                    'label' => __( 'Show rating statistics', THEME_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                ],

                'advertising_page_display' => [
                    'label' => __( 'Enable avertising on pages', THEME_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                ],

                'microdata_publisher_telephone' => [
                    'label'       => __( 'The value of the telephone field for publisher microdata', THEME_TEXTDOMAIN ),
                    'description' => __( 'If the field is not specified, the site name will be displayed as the telephone value', THEME_TEXTDOMAIN ),
                ],

                'microdata_publisher_address' => [
                    'label'       => __( 'The value of the address field for publisher microdata', THEME_TEXTDOMAIN ),
                    'description' => __( 'If the field is not specified, the site address will be displayed as the address value', THEME_TEXTDOMAIN ),
                ],

	            'ingredients_link' => [
		            'label' => __( 'Show ingredients link', THEME_TEXTDOMAIN ),
		            'type'  => 'checkbox',
	            ]

            ]
        ],

        'partner' => [
            'title'       => __( 'Affiliate program', THEME_TEXTDOMAIN ),
            'description' => 'Мы добавили возможность зарабатывать Вам на нашей <a href="https://wpshop.ru/partner" target="_blank" rel="noopener">партнерской программе</a>. Вы можете встроить партнерскую ссылку в подвал сайта и зарабатывать 25% с продаж. Ваш партнерский ID уже встроен в тему.<br><br>Ссылка замаскирована через JS, она не индексируется и не передает вес страницы и обернута в noindex.<br><br>О продаже по партнерской ссылке мы сообщим Вам на e-mail, Вы ничего не пропустите.',
            'priority'    => 999,

            'controls' => [

                'wpshop_partner_enable' => [
                    'label' => __( 'Start earning money', THEME_TEXTDOMAIN ),
                    'type'  => 'checkbox',
                ],

                'wpshop_partner_prefix' => [
                    'label' => __( 'Text before link', THEME_TEXTDOMAIN ),
                ],

                'wpshop_partner_postfix' => [
                    'label' => __( 'Text after link', THEME_TEXTDOMAIN ),
                ],

            ],
        ],
    ];

    // apply filter
    $customizer_controls = apply_filters( 'wpshop_customizer_controls', $customizer_controls );

    // set defaults
    $wpshop_customizer->set_defaults( $wpshop_core->get_default_options() );

    // add controls
    $wpshop_customizer->add_controls( $customizer_controls );

    // init
    $wpshop_customizer->init( $wp_customize );

} );



/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wpshop_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'wpshop_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'wpshop_customize_partial_blogdescription',
        ) );
    }
}
//add_action( 'customize_register', 'wpshop_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function wpshop_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function wpshop_customize_partial_blogdescription() {
    bloginfo( 'description' );
}


function wpshop_customizer_body_classes( $classes ) {

    global $wpshop_core;

    /********************************************************************
     * Sidebar
     */

    $sidebar_class = 'sidebar-right';

    // Сайдбар на главной
    if ( is_front_page() || is_home() ) {
        $sidebar_class = 'sidebar-' . $wpshop_core->get_option( 'structure_home_sidebar' );
    }

    // Сайдбар в архивах
    if ( is_archive() ) {
        $sidebar_class = 'sidebar-' . $wpshop_core->get_option( 'structure_archive_sidebar' );
    }

    // Сайдбар записи
    if ( is_single() ) {
        $sidebar_class = 'sidebar-' . $wpshop_core->get_option( 'structure_single_sidebar' );
    }

    // Сайдбар страниц
    if ( is_page() ) {
        $sidebar_class = 'sidebar-' . $wpshop_core->get_option( 'structure_page_sidebar' );
    }

    // настройки для отдельной статьи
    if ( is_single() || is_page() ) {
        global $wpshop_core;

        if ( ! $wpshop_core->is_show_element( 'sidebar' ) ) {
            $sidebar_class = 'sidebar-none';
        }
    }

    $classes[] = $sidebar_class;

    return $classes;

}
add_filter( 'body_class', 'wpshop_customizer_body_classes' );


/**
 * Customizer CSS
 */
require get_template_directory() . '/inc/customizer/customizer-css.php';