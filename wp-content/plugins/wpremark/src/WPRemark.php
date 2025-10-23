<?php

namespace Wpshop\WPRemark;

use Wpshop\WPRemark\Settings\PluginOptions;

class WPRemark {

	const POST_TYPE = 'wpremark';

	/**
	 * @var Plugin
	 */
	protected $plugin;

	protected $options;

	protected $default_attributes;

	/**
	 * WPRemark constructor.
	 *
	 * @param Plugin              $plugin
	 * @param PluginOptions       $options
	 */
	public function __construct(
		Plugin $plugin,
		PluginOptions $options
	) {
		$this->plugin             = $plugin;
		$this->options            = $options;

        $this->default_attributes = [
            'preset_name' => '',

            'icon_show'         => true,
            'icon_image'        => 'warning-triangle-regular',
            'icon_image_custom' => '',
            'icon_color'        => '#f58128',
            'icon_width'        => 32,
            'icon_height'       => 32,
            'icon_indent'       => 16,
            'icon_position'     => 'left center',

            'background_show'           => true,
            'background_color'          => '#fff4d4',
            'background_image'          => '',
            'background_image_repeat'   => 'no-repeat',
            'background_image_position' => 'center center',
            'background_image_size'     => 'auto',

            'border_top'    => false,
            'border_right'  => false,
            'border_bottom' => false,
            'border_left'   => false,
            'border_width'  => 2,
            'border_style'  => 'solid',
            'border_color'  => '#f58128',

            'shadow_show'       => false,
            'shadow_x'          => 0,
            'shadow_y'          => 5,
            'shadow_blur'       => 10,
            'shadow_stretching' => -5,
            'shadow_color'      => '#333333',
            'shadow_opacity'    => 0.3,

            'title_show'        => false,
            'title_text'        => '',
            'title_align'       => 'no',
            'title_color'       => '#333333',
            'title_bold'        => false,
            'title_italic'      => false,
            'title_underline'   => false,
            'title_uppercase'   => false,
            'title_font_size'   => 18,
            'title_line_height' => 1.5,

            'text_align'       => 'no',
            'text_color'       => '',
            'text_link_color'  => '',
            'text_bold'        => false,
            'text_italic'      => false,
            'text_underline'   => false,
            'text_uppercase'   => false,
            'text_font_size'   => '',
            'text_line_height' => '',

            'padding_top'    => 20,
            'padding_right'  => 20,
            'padding_bottom' => 20,
            'padding_left'   => 20,
            'margin_top'     => 20,
            'margin_right'   => 0,
            'margin_bottom'  => 20,
            'margin_left'    => 0,

            'border_radius' => 0,
            'tag'           => 'div',
            'css'           => 'head',
            'custom_class'  => '',
            'block_id'      => '',
        ];
    }

	/**
	 * @return void
	 */
	public function init() {
		do_action( __METHOD__, $this );
	}

	public function get_default_attributes() {
	    return $this->default_attributes;
    }

    /**
     * Generate block_id
     *
     * @param $length
     *
     * @return string
     */
    public function make_block_id( $length = 4 ) {
        $result            = '';
        $characters        = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $characters_length = strlen( $characters );
        for ( $i = 0; $i < $length; $i ++ ) {
            $result .= $characters[ rand( 0, $characters_length - 1 ) ];
        }

        return $result;
    }

}
