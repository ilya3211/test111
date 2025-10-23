<?php

namespace Wpshop\WPRemark;

class Shortcodes {

    const SHORTCODE = 'wpremark';
    const SHORTCODE_ICON = 'wpremark_icon';

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
            add_shortcode( self::SHORTCODE, [ $this, '_wpremark_shortcode' ] );
            add_shortcode( self::SHORTCODE_ICON, [ $this, '_wpremark_shortcode_icon' ] );
        }

        do_action( __METHOD__, $this );
    }




    /**
     * array  $atts
     * string $content
     *
     * @return string
     */
    public function _wpremark_shortcode_icon( $atts, $content = '' ) {

        $atts = shortcode_atts(
            [
                'icon' => '',
                'width' => '',
                'height' => '',
                'color' => '',
            ],
            $atts,
            self::SHORTCODE_ICON
        );

        // если фид, то ничего не выводим
        if ( is_feed() ) {
            return '';
        }

        $icons = new Icons();
        return $icons->get_icon( $atts['icon'], $atts );
    }


    /**
     * array  $atts
     * string $content
     *
     * @return string
     */
    public function _wpremark_shortcode( $atts, $content = '' ) {

        $atts = shortcode_atts(
            PluginContainer::get( WPRemark::class )->get_default_attributes(),
            $atts,
            'wpremark'
        );

        // если фид, то выводим просто контент
        if ( is_feed() ) {
            return $content;
        }

        global $post;

        // шорткод в контенте?
        $in_content = true;


        // ищем в контенте
        if ( ( $post = get_queried_object() ) && $post instanceof \WP_Post ) {
            if ( false !== strpos( $post->post_content, '[wpremark' ) ) {

                if ( ! preg_match( '/\[wpremark([^\]]+?)block_id="' . $atts['block_id'] . '"/s', $post->post_content ) ) {
                    $in_content = false;
                }

            } else {
                $in_content = false;
            }
        } else {
            $in_content = false;
        }



        $styles = [];
        $output      = '';
        $icon_output = '';



        // положить стили рядом
        $output_styles_near = ( $atts['css'] == 'near' || empty( $atts['block_id'] ) || ! $in_content );
        $output_styles_near = apply_filters( 'wpremark_shortcode_styles_near', $output_styles_near, $atts['block_id'] );


        // если нет block_id — генерируем
        if ( empty( $atts['block_id'] ) ) $atts['block_id'] = PluginContainer::get( WPRemark::class )->make_block_id();


        // если стили нужно рядом положить
        if ( $output_styles_near ) {
            $styles = PluginContainer::get( Styles::class )->generate_styles( $atts, 'classic' );
            $compile_styles = PluginContainer::get( Styles::class )->compile_styles( $styles );
            $output .= '<style id="wpremark-styles-' . $atts['block_id'] . '">' . $compile_styles . '</style>';
        }


        // классы у блока
        $block_classes = [ 'wpremark', 'wpremark--' . $atts['block_id'] ];
        if ( ! empty( $atts['custom_class'] ) ) $block_classes[] = $atts['custom_class'];
        $block_classes = apply_filters( 'wpremark_block_classes', $block_classes );


        // начинаем выводить сам блок
        $output .= '<' . $atts['tag'] . ' class="' . implode( ' ', $block_classes ) . '">';


        // выводим иконку
        if ( $atts['icon_show'] && ( ! empty( $atts['icon_image'] ) || ! empty( $atts['icon_image_custom'] ) ) ) {
            $icon_output .= '<div class="wpremark-icon">';

            if ( empty( $atts['icon_image_custom'] ) ) {
                $class_icons = new Icons();
                $icon_output .= $class_icons->get_icon( $atts['icon_image'], [ 'width' => $atts['icon_width'], 'height' => $atts['icon_height'] ] );
            } else {
                $icon_output .= '<img src="' . $atts['icon_image_custom'] . '" width="' . $atts['icon_width'] . '" height="' . $atts['icon_height'] . '" alt="">';
            }

            $icon_output .= '</div>';

            $output .= $icon_output;
        }

        // если есть заголовок и текст
        if ( ( $atts['title_show'] && ! empty( $atts['title_text'] ) ) || ! empty( $content ) ) {

            $output .= '<div class="wpremark-body">';

            if ( $atts['title_show'] && ! empty( $atts['title_text'] ) ) {
                $output .= '<div class="wpremark-title">' . $atts['title_text'] . '</div>';
            }

            if ( ! empty( $content ) ) {

                if ( apply_filters( 'wpremark_content_autop', true ) ) {
                    $content = wpautop( $content );
                }
                if ( apply_filters( 'wpremark_content_do_shortcode', true ) ) {
                    $content = do_shortcode( $content );
                }

                $output .= '<div class="wpremark-content">' . $content . '</div>';
            }

            $output .= '</div>';
        }

        $output .= '</' . $atts['tag'] . '>';

        return $output;
    }


    /**
     * Поиск всех ат
     *
     * @param $content
     *
     * @return array|false
     */
    public function find_shortcodes_atts( $content ) {
        $pattern = get_shortcode_regex( [ 'wpremark' ] );
        preg_match_all( '/' . $pattern . '/s', $content, $matches );

        if ( ! empty( $matches[3] ) ) {
            $atts = [];
            foreach ( $matches[3] as $shortcode_atts ) {
                $atts[] = shortcode_parse_atts( $shortcode_atts );
            }

            return $atts;
        }

        return false;
    }

}
