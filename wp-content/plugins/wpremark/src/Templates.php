<?php

namespace Wpshop\WPRemark;

use WP_Error;

class Templates {

    const OPT_NAME = 'wpremark_templates';

    /**
     * @var array[]
     */
    public $templates = [
        'default-warning'     => [
            'preset_name'      => 'default-warning',
            'icon_image'       => 'warning-circle-regular',
            'icon_color'       => '#f58128',
            'background_color' => '#fff4d4',
            'border_color'     => '#f58128',
            'border_radius'    => 5,
            '_order'           => 10,
        ],
        'default-question'    => [
            'preset_name'      => 'default-question',
            'icon_image'       => 'question-circle-regular',
            'icon_color'       => '#3da2e0',
            'background_color' => '#e3f1f4',
            'border_color'     => '#3da2e0',
            'border_radius'    => 5,
            '_order'           => 20,
        ],
        'default-danger'      => [
            'preset_name'      => 'default-danger',
            'icon_image'       => 'times-circle-regular',
            'icon_color'       => '#ff9475',
            'background_color' => '#ffe3db',
            'border_color'     => '#ff9475',
            'border_radius'    => 5,
            '_order'           => 30,
        ],
        'default-check'       => [
            'preset_name'      => 'default-check',
            'icon_image'       => 'check-circle-regular',
            'icon_color'       => '#34bc58',
            'background_color' => '#def9e5',
            'border_color'     => '#34bc58',
            'border_radius'    => 5,
            '_order'           => 40,
        ],
        'default-info'        => [
            'preset_name'      => 'default-info',
            'icon_image'       => 'info-circle-regular',
            'icon_color'       => '#3da2e0',
            'background_color' => '#e3f1f4',
            'border_color'     => '#3da2e0',
            'border_radius'    => 5,
            '_order'           => 50,
        ],
        'default-thumbs-up'   => [
            'preset_name'      => 'default-thumbs-up',
            'icon_image'       => 'thumbs-up-regular',
            'icon_color'       => '#34bc58',
            'background_color' => '#def9e5',
            'border_color'     => '#34bc58',
            'border_radius'    => 5,
            '_order'           => 60,
        ],
        'default-thumbs-down' => [
            'preset_name'      => 'default-thumbs-down',
            'icon_image'       => 'thumbs-down-regular',
            'icon_color'       => '#ff9475',
            'background_color' => '#ffe3db',
            'border_color'     => '#ff9475',
            'border_radius'    => 5,
            '_order'           => 70,
        ],
        'default-quote'       => [
            'preset_name'      => 'default-quote',
            'icon_image'       => 'quote-right-regular',
            'icon_color'       => '#9ca9c7',
            'background_color' => '#eff4f5',
            'border_color'     => '#9ca9c7',
            'border_radius'    => 5,
            '_order'           => 80,
        ],
    ];

    /**
     * @var WPRemark
     */
    protected $wpremark;

    /**
     * @param WPRemark $wpremark
     */
    public function __construct( WPRemark $wpremark ) {
        $this->wpremark = $wpremark;
    }

    /**
     * @return void
     */
    public function init() {
        $action = 'wpremark_import_preset';
        add_action( "wp_ajax_{$action}", [ $this, '_import_preset' ] );
        $action = 'wpremark_remove_preset';
        add_action( "wp_ajax_{$action}", [ $this, '_remove_preset' ] );

        $this->import_default_presets();

        do_action( __METHOD__, $this );
    }

    /**
     * @return void
     */
    protected function import_default_presets() {
        if ( false === get_option( self::OPT_NAME ) ) {
            update_option( self::OPT_NAME, $this->templates );
        }
    }

    /**
     * @return void
     */
    public function _import_preset() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wpremark-presets' ) ) {
            wp_send_json_error( new WP_Error( 'error', __( 'Forbidden', Plugin::TEXT_DOMAIN ) ) );
        }

        if ( empty( $_POST['name'] ) ) {
            wp_send_json_error( new WP_Error( 'error', __( 'Unable to import unnamed preset', Plugin::TEXT_DOMAIN ) ) );
        }

        $presets = $this->load_templates_transient();

        if ( is_wp_error( $presets ) ) {
            wp_send_json_error( $presets );
        }

        if ( ! array_key_exists( $_POST['name'], $presets ) ) {
            wp_send_json_error( new WP_Error( 'error', __( 'Unable to import preset', Plugin::TEXT_DOMAIN ) ) );
        }

        $stored_presets = (array) get_option( self::OPT_NAME, [] );

        $stored_presets[ $_POST['name'] ] = $presets[ $_POST['name'] ];
        uasort( $stored_presets, function ( $a, $b ) {
            return $a['_order'] - $b['_order'];
        } );

        update_option( self::OPT_NAME, $stored_presets );

        wp_send_json_success();
    }

    /**
     * @return void
     */
    public function _remove_preset() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wpremark-presets' ) ) {
            wp_send_json_error( new WP_Error( 'error', __( 'Forbidden', Plugin::TEXT_DOMAIN ) ) );
        }

        if ( empty( $_POST['name'] ) ) {
            wp_send_json_error( new WP_Error( 'error', __( 'Unable to import unnamed preset', Plugin::TEXT_DOMAIN ) ) );
        }

        $stored_presets = (array) get_option( self::OPT_NAME, [] );
        unset( $stored_presets[ $_POST['name'] ] );

        update_option( self::OPT_NAME, $stored_presets );

        wp_send_json_success();
    }

    /**
     * @param bool $with_default append default params
     * @param bool $filter       filter service attributes
     *
     * @return array[]
     */
    public function get_templates( $with_default = true, $filter = false ) {
        $templates = get_option( self::OPT_NAME, [] );
        if ( $with_default ) {
            $templates = array_map( function ( $item ) {
                return wp_parse_args( $item, $this->wpremark->get_default_attributes() );
            }, $templates );
        }

        if ( $filter ) {
            $templates = array_map( [ $this, 'filter_service_attributes' ], $templates );
        }

        return $templates;
    }

    /**
     * @param bool $filter filter service attributes
     *
     * @return array|WP_Error
     */
    public function load_templates_transient( $filter = false ) {
        $key = 'wpremark_remote_templates';
        if ( false === ( $templates = get_transient( $key ) ) ) {
            $templates = $this->load_templates();
            if ( ! is_wp_error( $templates ) ) {
                set_transient( $key, $templates, MINUTE_IN_SECONDS );
            }
        }

        if ( ! is_wp_error( $templates ) ) {
            uasort( $templates, function ( $a, $b ) {
                return $a['_order'] - $b['_order'];
            } );

            if ( $filter ) {
                $templates = array_map( [ $this, 'filter_service_attributes' ], $templates );
            }
        }

        return $templates;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function exists( $name ) {
        return array_key_exists( $name, $this->get_templates() );
    }

    /**
     * @return array|WP_Error
     */
    protected function load_templates() {
        $response = wp_remote_get( 'https://wpremark.ru/presets.php', [
            'timeout'   => 15,
            'sslverify' => false,
        ] );
        if ( is_wp_error( $response ) ) {
            return $response;
        }
        if ( 200 !== ( $response_code = wp_remote_retrieve_response_code( $response ) ) ) {
            return new WP_Error( 'api_error', sprintf( __( 'Invalid API response code (%d).', Plugin::TEXT_DOMAIN ), $response_code ) );
        }

        $body    = wp_remote_retrieve_body( $response );
        $presets = json_decode( $body, true );
        if ( json_last_error() != JSON_ERROR_NONE ) {
            return new WP_Error( 'json_last_error', __( 'Unable to parse json', Plugin::TEXT_DOMAIN ) );
        }

        return $presets;
    }

    /**
     * @param array $preset
     *
     * @return array
     */
    public function filter_service_attributes( $preset ) {
        $result = [];
        foreach ( $preset as $key => $value ) {
            if ( '_' !== substr( $key, 0, 1 ) ) {
                $result[ $key ] = $value;
            }
        }

        return $result;
    }
}
