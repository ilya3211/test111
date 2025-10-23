<?php

namespace Wpshop\WPRemark;

class Styles {

    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * Shortcodes constructor.
     *
     * @param Plugin $plugin
     */
    public function __construct( Plugin $plugin ) {
        $this->plugin = $plugin;
    }

    /**
     * @return void
     */
    public function init() {
        if ( $this->plugin->verify() ) {
            add_action( 'wp_head', [ $this, '_output_styles' ] );
        }

        do_action( __METHOD__, $this );
    }

    /**
     * @return void
     */
    public function _output_styles() {

        $styles = [];

        // default styles
        $default_styles = $this->get_default_styles();

        // если это пост — ищем шорткод или гутенберг блок
        if ( ( $post = get_queried_object() ) && $post instanceof \WP_Post ) {

            // нашли гутенберг блоки
            if ( function_exists( 'has_block' ) && has_block( 'wpshop/wpremark', $post->post_content ) ) {
                $parse_content = parse_blocks( $post->post_content );
                $styles = $this->parse_gutenberg_blocks( $parse_content );
            }

            // нашли шорткоды
            if ( false !== strpos( $post->post_content, '[wpremark' ) ) {
                $pattern = get_shortcode_regex( [ 'wpremark' ] );
                preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches );

                if ( ! empty( $matches[3] ) ) {
                    foreach ( $matches[3] as $shortcode_atts ) {
                        $atts = shortcode_parse_atts( $shortcode_atts );

                        if ( ! isset( $atts['css'] ) || $atts['css'] != 'near' ) $styles = array_merge( $styles, $this->generate_styles( $atts, 'classic' ) );
                    }
                }
            }
        }

        // нашли гутенберг блоки в виджетах
        $widget_blocks = get_option( 'widget_block' );
        if ( ! empty( $widget_blocks ) && is_array( $widget_blocks ) ) {
            foreach ( $widget_blocks as $widget_block ) {
                if ( ! empty( $widget_block['content'] ) && function_exists( 'has_block' ) && has_block( 'wpshop/wpremark', $widget_block['content'] ) ) {
                    $parse_block_content = parse_blocks( $widget_block['content'] );
                    $styles              = array_merge( $styles, $this->parse_gutenberg_blocks( $parse_block_content ) );
                }
            }
        }

        $styles = apply_filters( 'wpremark_styles', $styles );
        $compile_styles = '';

        // если есть стили — компилируем
        if ( ! empty( $styles ) ) {
            $compile_styles = $this->compile_styles( $styles );
        }

        echo '<style id="wpremark-styles">' . $default_styles . $compile_styles . '</style>';
    }


    /**
     * Рекурсивно ищем блоки, чтобы проверить во вложенных
     *
     * @param $blocks
     *
     * @return array
     */
    public function parse_gutenberg_blocks( $blocks ) {
        $styles = [];

        foreach ( $blocks as $gutenberg_block ) {

            if ( ! empty( $gutenberg_block['innerBlocks'] ) ) {
                $styles = array_merge( $styles, $this->parse_gutenberg_blocks( $gutenberg_block['innerBlocks'] ));
            }

            if ( $gutenberg_block['blockName'] == 'wpshop/wpremark' ) {
                $styles = array_merge( $styles, $this->generate_styles( $gutenberg_block['attrs'] ) );
            }
        }

        return $styles;
    }


    public function compile_styles( $styles = [] ) {

        $output = '';

        foreach ( $styles as $selector => $style ) {
            if ( ! empty( $style ) ) {
                $output .= $selector . '{';
                $output .= implode( ';', $style );
                $output .= '}';
            }
        }

        return $output;
    }


    public function generate_styles( $atts, $editor = 'gutenberg' ) {

        // templates generator
//        echo '<pre>';
//        $key = uniqid('preset_');
//        echo "'$key' => [" . PHP_EOL;
//        if ( ! isset( $atts['preset_name'] ) ) {
//            echo "'preset_name' => 'PRESET_NAME'," . PHP_EOL;
//        }
//        foreach ( $atts as $k => $v ) {
//            if ( $k == 'block_id' ) continue;
//            if ( $k == 'preset_name' ) $v = 'PRESET_NAME';
//            if ( in_array( $k, [ 'border_top', 'border_right', 'border_bottom', 'border_left', 'border_width', 'shadow_show', 'shadow_x', 'shadow_y', 'shadow_blur', 'shadow_stretching', 'shadow_opacity', 'icon_width', 'icon_height', 'icon_indent', 'icon_show', 'background_show', 'title_show', 'title_bold', 'title_italic', 'title_underline', 'title_uppercase', 'title_font_size', 'title_line_height', 'text_bold', 'text_italic', 'text_underline', 'text_uppercase', 'padding_top', 'padding_right', 'padding_bottom', 'padding_left', 'margin_top', 'margin_right', 'margin_bottom', 'margin_left', 'text_font_size', 'text_line_height', 'border_radius' ] ) ) {
//                $value = $v;
//            } else {
//                $value = "'" . $v . "'";
//            }
//            echo "'" . $k . "' => " . $value . "," . PHP_EOL;
//        }
//        echo "'_order' => 0," . PHP_EOL;
//        echo "'_group' => ''," . PHP_EOL;
//        echo "],";
//        echo '</pre>';

        // собираем атрибуты и ставим дефолтные
        $atts = wp_parse_args( $atts, PluginContainer::get( WPRemark::class )->get_default_attributes() );

        // если block_id пустой — генерим
//        if ( empty( $atts['block_id'] ) ) {
//            $atts['block_id'] = PluginContainer::get( WPRemark::class )->make_block_id();
//        }

        // для гутенберга заменяем атрибуты
        if ( $editor == 'gutenberg' ) {

            if ( isset( $atts['customIconColor'] ) ) {
                $atts['icon_color'] = $atts['customIconColor'];
                unset( $atts['customIconColor'] );
            }

            if ( isset( $atts['customBackgroundColor'] ) ) {
                $atts['background_color'] = $atts['customBackgroundColor'];
                unset( $atts['customBackgroundColor'] );
            }

            if ( isset( $atts['customBorderColor'] ) ) {
                $atts['border_color'] = $atts['customBorderColor'];
                unset( $atts['customBorderColor'] );
            }

            if ( isset( $atts['customShadowColor'] ) ) {
                $atts['shadow_color'] = $atts['customShadowColor'];
                unset( $atts['customShadowColor'] );
            }

            if ( isset( $atts['customTitleColor'] ) ) {
                $atts['title_color'] = $atts['customTitleColor'];
                unset( $atts['customTitleColor'] );
            }

            if ( isset( $atts['customTextColor'] ) ) {
                $atts['text_color'] = $atts['customTextColor'];
                unset( $atts['customTextColor'] );
            }

            if ( isset( $atts['customTextLinkColor'] ) ) {
                $atts['text_link_color'] = $atts['customTextLinkColor'];
                unset( $atts['customTextLinkColor'] );
            }

        }

        // фильтр на атрибуты
        $atts = apply_filters( 'wpremark_generate_styles_atts', $atts, $editor );

//        echo '<pre>';
//        print_r( $editor );
//        print_r( $atts );
//
//        foreach ( $atts as $k => $v ) {
//
//        }
//
//        echo '</pre>';

        $styles = [];


        // префикс у стилей
        $prefix = '';
        if ( $atts['tag'] == 'blockquote' ) $prefix = 'body ';
        $prefix = apply_filters( 'wpremark_generate_styles_prefix', $prefix );

        $styles_block = $this->create_styles_block( $prefix . '.wpremark--' . $atts['block_id'], $atts, $editor );
        $styles_icon  = $this->create_styles_icon( $prefix . '.wpremark--' . $atts['block_id'] . ' .wpremark-icon', $atts, $editor );
        $styles_title  = $this->create_styles_title( $prefix . '.wpremark--' . $atts['block_id'] . ' .wpremark-title', $atts, $editor );
        $styles_text  = $this->create_styles_text( $prefix . '.wpremark--' . $atts['block_id'] . ' .wpremark-content', $atts, $editor );
        $styles_links  = $this->create_styles_link( $prefix . '.wpremark--' . $atts['block_id'] . ' .wpremark-content a', $atts, $editor );

        $styles = array_merge( $styles, $styles_block, $styles_icon, $styles_title, $styles_text, $styles_links );

        return $styles;
    }


    /**
     * Стили для блока
     *
     * @param $selector
     * @param $atts
     * @param $editor
     *
     * @return array[]
     */
    public function create_styles_block( $selector, $atts, $editor ) {
        $styles = [];

        // BACKGROUND
        if ( $atts['background_show'] ) {
            if ( ! empty( $atts['background_color'] ) ) {
                $styles[] = 'background-color:' . $atts['background_color'];
            }

            if ( ! empty( $atts['background_image'] ) ) {
                $styles[] = 'background-image:url(' . $atts['background_image'] . ')';

                if ( ! empty( $atts['background_image_repeat'] ) ) {
                    $styles[] = 'background-repeat:' . $atts['background_image_repeat'];
                }
                if ( ! empty( $atts['background_image_position'] ) ) {
                    $styles[] = 'background-position:' . $atts['background_image_position'];
                }
                if ( ! empty( $atts['background_image_size'] ) ) {
                    $styles[] = 'background-size:' . $atts['background_image_size'];
                }
            }
        }

        // BORDER
        if ( ( $atts['border_top'] || $atts['border_right'] || $atts['border_bottom'] || $atts['border_left'] ) ) {
            $border_width = ( ! empty( $atts['border_width'] ) ) ? $atts['border_width'] . 'px' : '';
            $border_style = ( ! empty( $atts['border_style'] ) ) ? $atts['border_style'] : '';
            $border_color = ( ! empty( $atts['border_color'] ) ) ? $atts['border_color'] : '';

            if ( $atts['border_top'] && $atts['border_right'] && $atts['border_bottom'] && $atts['border_left'] ) {
                $styles[] = 'border:' . $border_width . ' ' . $border_style . ' ' . $border_color;
            } else {

                if ( $atts['border_top'] ) {
                    $styles[] = 'border-top:' . $border_width . ' ' . $border_style . ' ' . $border_color;
                }
                if ( $atts['border_right'] ) {
                    $styles[] = 'border-right:' . $border_width . ' ' . $border_style . ' ' . $border_color;
                }
                if ( $atts['border_bottom'] ) {
                    $styles[] = 'border-bottom:' . $border_width . ' ' . $border_style . ' ' . $border_color;
                }
                if ( $atts['border_left'] ) {
                    $styles[] = 'border-left:' . $border_width . ' ' . $border_style . ' ' . $border_color;
                }

            }
        }

        // SHADOW
        if ( $atts['shadow_show'] ) {
            $shadow_x          = ( ! empty( $atts['shadow_x'] ) ) ? $atts['shadow_x'] : 0;
            $shadow_y          = ( ! empty( $atts['shadow_y'] ) ) ? $atts['shadow_y'] : 0;
            $shadow_blur       = ( ! empty( $atts['shadow_blur'] ) ) ? $atts['shadow_blur'] : 0;
            $shadow_stretching = ( ! empty( $atts['shadow_stretching'] ) ) ? $atts['shadow_stretching'] : 0;
            $shadow_color      = ( ! empty( $atts['shadow_color'] ) ) ? $atts['shadow_color'] : '#000000';
            list( $r, $g, $b ) = sscanf( $shadow_color, "#%02x%02x%02x" );
            $shadow_opacity    = ( ! empty( $atts['shadow_opacity'] ) ) ? $atts['shadow_opacity'] : 0;
            $styles[] = 'box-shadow:' . $shadow_x . 'px ' . $shadow_y . 'px ' . $shadow_blur . 'px ' . $shadow_stretching . 'px rgba(' . $r . ',' . $g . ',' . $b . ',' . $shadow_opacity . ')';
        }

        // PADDING
        if ( $atts['padding_top'] == $atts['padding_right'] && $atts['padding_right'] == $atts['padding_bottom'] && $atts['padding_bottom'] == $atts['padding_left'] ) {
            $styles[] = 'padding:' . $atts['padding_top'] . 'px';
        } else if ( $atts['padding_top'] == $atts['padding_bottom'] && $atts['padding_left'] == $atts['padding_right'] ) {
            $styles[] = 'padding:' . $atts['padding_top'] . 'px ' . $atts['padding_left'] . 'px';
        } else {
            if ( isset( $atts['padding_top'] ) ) {
                $styles[] = 'padding-top:' . $atts['padding_top'] . 'px';
            }
            if ( isset( $atts['padding_right'] ) ) {
                $styles[] = 'padding-right:' . $atts['padding_right'] . 'px';
            }
            if ( isset( $atts['padding_bottom'] ) ) {
                $styles[] = 'padding-bottom:' . $atts['padding_bottom'] . 'px';
            }
            if ( isset( $atts['padding_left'] ) ) {
                $styles[] = 'padding-left:' . $atts['padding_left'] . 'px';
            }
        }

        // MARGIN
        if ( $atts['margin_top'] == $atts['margin_right'] && $atts['margin_right'] == $atts['margin_bottom'] && $atts['margin_bottom'] == $atts['margin_left'] ) {
            $styles[] = 'margin:' . $atts['margin_top'] . 'px';
        } else if ( $atts['margin_top'] == $atts['margin_bottom'] && $atts['margin_left'] == $atts['margin_right'] ) {
            $styles[] = 'margin:' . $atts['margin_top'] . 'px ' . $atts['margin_left'] . 'px';
        } else {
            if ( isset( $atts['margin_top'] ) ) {
                $styles[] = 'margin-top:' . $atts['margin_top'] . 'px';
            }
            if ( isset( $atts['margin_right'] ) ) {
                $styles[] = 'margin-right:' . $atts['margin_right'] . 'px';
            }
            if ( isset( $atts['margin_bottom'] ) ) {
                $styles[] = 'margin-bottom:' . $atts['margin_bottom'] . 'px';
            }
            if ( isset( $atts['margin_left'] ) ) {
                $styles[] = 'margin-left:' . $atts['margin_left'] . 'px';
            }
        }

        // BORDER RADIUS
        if ( isset( $atts['border_radius'] ) ) {
            $styles[] = 'border-radius:' . $atts['border_radius'] . 'px';
        }

        // ICON POSITION
        if ( $atts['icon_show'] && ! empty( $atts['icon_position'] ) ) {
            if ( in_array( $atts['icon_position'], [ 'top left', 'top center', 'top right', 'bottom left', 'bottom center', 'bottom right' ] ) ) {
                $styles[] = 'flex-direction:column';
            }
        }

        return [ $selector => $styles ];
    }


    /**
     * Стили для иконки
     *
     * @param $selector
     * @param $atts
     * @param $editor
     *
     * @return array[]
     */
    public function create_styles_icon( $selector, $atts, $editor ) {
        $styles = [];

        // ICON
        if ( $atts['icon_show'] ) {

            // COLOR
            if ( $atts['icon_color'] ) {
                $styles[] = 'color:' . $atts['icon_color'];
            }

            // WIDTH
            if ( ! empty( $atts['icon_width'] ) ) {
                $styles[] = 'width:' . $atts['icon_width'] . 'px';
                $styles[] = 'flex:0 0 auto';
                $styles[] = 'max-width:100%';
            }

            // HEIGHT
            if ( ! empty( $atts['icon_height'] ) ) {
                $styles[] = 'max-height:' . $atts['icon_height'] . 'px'; // @todo max-height ?
            }

            // INDENT
            if ( ! empty( $atts['icon_indent'] ) ) {
                if ( in_array( $atts['icon_position'], [ 'left top', 'left center', 'left bottom' ] ) ) {
                    $styles[] = 'margin-right:' . $atts['icon_indent'] . 'px';
                }
                if ( in_array( $atts['icon_position'], [ 'top right', 'top center', 'top left' ] ) ) {
                    $styles[] = 'margin-bottom:' . $atts['icon_indent'] . 'px';
                }
                if ( in_array( $atts['icon_position'], [ 'right top', 'right center', 'right bottom' ] ) ) {
                    $styles[] = 'margin-left:' . $atts['icon_indent'] . 'px';
                }
                if ( in_array( $atts['icon_position'], [ 'bottom left', 'bottom center', 'bottom right' ] ) ) {
                    $styles[] = 'margin-top:' . $atts['icon_indent'] . 'px';
                }
            }

            // POSITION
            if ( ! empty( $atts['icon_position'] ) ) {
                if ( in_array( $atts['icon_position'], [ 'right top', 'right center', 'right bottom' ] ) ) {
                    $styles[] = 'order:10';
                }
                if ( in_array( $atts['icon_position'], [ 'bottom left', 'bottom center', 'bottom right' ] ) ) {
                    $styles[] = 'order:10';
                }
                if ( in_array( $atts['icon_position'], [ 'left center', 'right center', 'top center', 'bottom center' ] ) ) {
                    $styles[] = 'align-self:center';
                }
                if ( in_array( $atts['icon_position'], [ 'left top', 'right top' ] ) ) {
                    $styles[] = 'align-self:flex-start';
                }
                if ( in_array( $atts['icon_position'], [ 'left bottom', 'right bottom', 'top right', 'bottom right' ] ) ) {
                    $styles[] = 'align-self:flex-end';
                }
            }

        }

        return [ $selector => $styles ];
    }


    /**
     * Стили для заголовка
     *
     * @param $selector
     * @param $atts
     * @param $editor
     *
     * @return array[]
     */
    public function create_styles_title( $selector, $atts, $editor ) {
        $styles = [];

        if ( $atts['title_show'] && ! empty( $atts['title_text'] ) ) {

            if ( ! empty( $atts['title_align'] ) && $atts['title_align'] != 'no' ) {
                $styles[] = 'text-align:' . $atts['title_align'];
            }

            if ( ! empty( $atts['title_color'] ) ) {
                $styles[] = 'color:' . $atts['title_color'];
            }

            if ( $atts['title_bold'] ) {
                $styles[] = 'font-weight:bold';
            }
            if ( $atts['title_italic'] ) {
                $styles[] = 'font-style:italic';
            }
            if ( $atts['title_underline'] ) {
                $styles[] = 'text-decoration:underline';
            }
            if ( $atts['title_uppercase'] ) {
                $styles[] = 'text-transform:uppercase';
            }
            if ( ! empty( $atts['title_font_size'] ) ) {
                $styles[] = 'font-size:' . $atts['title_font_size'] . 'px';
            }
            if ( ! empty( $atts['title_line_height'] ) ) {
                $styles[] = 'line-height:' . $atts['title_line_height'];
            }
        }

        return [ $selector => $styles ];
    }

    /**
     * Стили для текста
     *
     * @param $selector
     * @param $atts
     * @param $editor
     *
     * @return array[]
     */
    public function create_styles_text( $selector, $atts, $editor ) {
        $styles = [];

        if ( ! empty( $atts['text_align'] ) && $atts['text_align'] != 'no' ) {
            $styles[] = 'text-align:' . $atts['text_align'];
        }
        if ( ! empty( $atts['text_color'] ) ) {
            $styles[] = 'color:' . $atts['text_color'];
        }
        if ( $atts['text_bold'] ) {
            $styles[] = 'font-weight:bold';
        }
        if ( $atts['text_italic'] ) {
            $styles[] = 'font-style:italic';
        }
        if ( $atts['text_underline'] ) {
            $styles[] = 'text-decoration:underline';
        }
        if ( $atts['text_uppercase'] ) {
            $styles[] = 'text-transform:uppercase';
        }
        if ( ! empty( $atts['text_font_size'] ) ) {
            $styles[] = 'font-size:' . $atts['text_font_size'] . 'px';
        }
        if ( ! empty( $atts['text_line_height'] ) ) {
            $styles[] = 'line-height:' . $atts['text_line_height'];
        }

        return [ $selector => $styles ];
    }

    /**
     * Стили для ссылки
     *
     * @param $selector
     * @param $atts
     * @param $editor
     *
     * @return array[]
     */
    public function create_styles_link( $selector, $atts, $editor ) {
        $styles = [];

        if ( ! empty( $atts['text_link_color'] ) ) {
            $styles[] = 'color:' . $atts['text_link_color'];
        }

        return [ $selector => $styles ];
    }


    public function get_default_styles() {
        $default_styles  = '.wpremark{position:relative;display:flex;border:none}';
        $default_styles .= '.wpremark p{margin:.75em 0}';
        $default_styles .= '.wpremark p:first-child{margin-top:0}';
        $default_styles .= '.wpremark p:last-child{margin-bottom:0}';
        $default_styles .= '.wpremark .wpremark-body{width:100%;max-width:100%;align-self:center}';
        $default_styles .= '.wpremark .wpremark-icon svg,.wpremark .wpremark-icon img{display:block;max-width:100%;max-height:100%}';

        return apply_filters( 'wpremark_default_styles', $default_styles );
    }

}