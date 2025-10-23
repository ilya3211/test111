<?php

namespace Wpshop\WPRemark;

use Puc_v4_Factory;
use Wpshop\WPRemark\Settings\PluginOptions;

class Plugin {

    const TEXT_DOMAIN = 'wpremark';

    /**
     * @var null|bool
     */
    protected $_verify;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    protected $plugin_file;

    /**
     * @var string
     */
    protected $verify_url;

    /**
     * @var string
     */
    protected $update_url;

    /**
     * @var string
     */
    protected $update_slug;

    /**
     * @var string
     */
    protected $update_check_period;

    /**
     * @var string
     */
    protected $update_option_name;

    /**
     * @var PluginOptions
     */
    protected $options;

    /**
     * Plugin constructor.
     *
     * @param array         $config
     * @param PluginOptions $options
     */
    public function __construct( array $config, PluginOptions $options ) {
        $this->configure( $config );
        $this->options = $options;
    }

    /**
     * @param array $cnf
     *
     * @return void
     */
    protected function configure( array $cnf ) {
        $update_cnf = $cnf['update'];

        $this->verify_url          = $cnf['verify_url'];
        $this->update_url          = $update_cnf['url'];
        $this->update_slug         = $update_cnf['slug'];
        $this->update_check_period = $update_cnf['check_period'];
        $this->update_option_name  = $update_cnf['opt_name'];
    }

    /**
     * @param string $plugin_file
     *
     * @return bool
     */
    public function init( $plugin_file ) {
        $this->plugin_file = $plugin_file;

        $this->load_languages();
        $this->init_metadata();
        add_action( 'admin_notices', function () {
            $this->license_notice();
        } );
        $this->enqueue_resources( $this->version );
        $this->setup_editor_plugins( $this->version );
        $this->init_updates();

        do_action( __METHOD__, $this );

        add_filter( 'mce_css', [ $this, 'mce_css_styles' ] );

        add_action( 'init', [ $this, 'handle_activation' ] );

        return true;
    }

    /**
     * @return void
     */
    protected function load_languages() {
        load_plugin_textdomain( static::TEXT_DOMAIN, false, dirname( plugin_basename( $this->plugin_file ) ) . '/languages/' );
    }

    /**
     * @param string $version
     *
     * @return void
     */
    protected function enqueue_resources( $version ) {
        if ( $this->verify() ) {
            add_action( 'wp_enqueue_scripts', function () use ( $version ) {
                do_action( 'wpremark_enqueue_scripts', $version );

//                wp_localize_script( 'wpremark-scripts', 'wpremark_ajax', [
//                    'url'   => admin_url( 'admin-ajax.php' ),
//                    'nonce' => wp_create_nonce( 'wpshop-nonce' ),
//                ] );
            } );
        }

        add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) use ( $version ) {
            wp_enqueue_style( 'wpremark-style', plugins_url( 'assets/admin/css/style.min.css', $this->plugin_file ), [], $version );
            wp_enqueue_style( 'wp-color-picker' );

            wp_enqueue_script( 'wpremark-admin-scripts', plugins_url( 'assets/admin/js/tinymce.plugin-blockquote.min.js', $this->plugin_file ), [
                'shortcode',
                'jquery',
                'wp-color-picker',
            ], $version, true );

            wp_enqueue_script( 'wpremark-admin-script-templates', plugins_url( 'assets/admin/js/templates.min.js', $this->plugin_file ), [], $version, true );

            do_action( 'wpremark_admin_enqueue_scripts', $version );

            $icon_styles = new Icons();

            wp_localize_script( 'wpremark-admin-scripts', 'wpremark_globals', [
                'url'                => admin_url( 'admin-ajax.php' ),
                'nonce'              => wp_create_nonce( 'wpshop-nonce' ),
                'editor_icon'        => 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" style="fill:#000"><path d="M504 395.45L304.18 58.22a56 56 0 00-96.36 0L8 395.45A56 56 0 0056.16 480h399.68A56 56 0 00504 395.45zM462.79 428a7.73 7.73 0 01-7 4H56.16a8 8 0 01-6.88-12.08L249.12 82.69a8 8 0 0113.76 0l199.84 337.23a7.72 7.72 0 01.07 8.08zM284 380c0 16-10.95 28-27.84 28S228 396 228 380c0-16.31 11.58-28 28.16-28s27.53 11.69 27.84 28zm-44.95-60l-6.9-128.2h47.7l-6.6 128.2z"/></svg>' ),
                'is_settings_page'   => $hook_suffix === 'wpremark_page_wpremark-settings',
                'enabled'            => $this->verify(),
                'i18n'               => [
                    //'require_name'     => _x( 'Please, enter at least name', static::TEXT_DOMAIN ),
                    'edit'             => __( 'edit', static::TEXT_DOMAIN ),
                    'remove'           => __( 'remove', static::TEXT_DOMAIN ),
                    'save'             => __( 'Save', static::TEXT_DOMAIN ),
                    'ok'               => __( 'OK', static::TEXT_DOMAIN ),
                    'cancel'           => __( 'Cancel', static::TEXT_DOMAIN ),
                    'title'            => __( 'Title', static::TEXT_DOMAIN ),
                    'text'             => __( 'Text', static::TEXT_DOMAIN ),
                    'link'             => __( 'Link', static::TEXT_DOMAIN ),
                    'add_blockquote'   => __( 'Add attention block', static::TEXT_DOMAIN ),
                    'popup_title'      => __( 'Attention block', static::TEXT_DOMAIN ),
                    'blockquote_style' => __( 'Style', static::TEXT_DOMAIN ),
                    'blockquote_text'  => __( 'Text', static::TEXT_DOMAIN ),
                    'select_preset'    => __( 'Please, select preset', static::TEXT_DOMAIN ),
                    'selecting_preset' => __( 'Cannot delete active preset', static::TEXT_DOMAIN ),
                    'preset_name'      => __( 'Enter name preset', static::TEXT_DOMAIN ),
                    'want_update'      => __( 'Are you sure you want update preset', static::TEXT_DOMAIN ),
                    'want_remove'      => __( 'Are you sure you want removes preset', static::TEXT_DOMAIN ),
                ],
                'icon_images'        => $icon_styles->get_icons(),
                'default_attributes' => PluginContainer::get( WPRemark::class )->get_default_attributes(),
            ] );

            wp_enqueue_media();
        } );
    }

    /**
     * @param string $version
     *
     * @return void
     */
    protected function setup_editor_plugins( $version ) {
        if ( $this->verify() ) {
            add_action( 'init', function () use ( $version ) {
                if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
                    return;
                }

                // tinymce
                add_filter( 'mce_external_plugins', function ( $plugin_array ) use ( $version ) {
                    $plugin_array['wpremark_plugin'] = plugins_url( 'assets/admin/js/tinymce.plugin.min.js?v=' . $version, $this->plugin_file );

                    return $plugin_array;
                } );

                add_filter( 'mce_buttons', function ( $buttons ) {
                    array_push(
                        $buttons,
                        'wpremark_plugin_button'
                    );

                    return $buttons;
                } );

                // gutenberg
                add_action( 'enqueue_block_editor_assets', function () use ( $version ) {
                    wp_enqueue_style( 'wpremark-gutenberg-style', plugins_url() . '/wpremark/assets/admin/css/gutenberg.min.css', [ 'wp-edit-blocks' ], $version );
                    wp_enqueue_script( 'wpremark-gutenberg-scripts', plugins_url() . '/wpremark/assets/admin/js/gutenberg.min.js', [
                        'wp-blocks',
                        'wp-element',
                        'wp-editor',
                    ], $version, true );
                    $class_templates = PluginContainer::get( Templates::class );
                    $icon_styles     = new Icons();

                    $presets      = PluginContainer::get( Preset::class )->get_all_preses();
                    $preset_names = [];

                    foreach ( $presets as $preset ) {
                        $preset_names[] = $preset['name'];
                    }

                    wp_localize_script( 'wpremark-gutenberg-scripts', 'wpremark_gutenberg', [
                            'top'                        => __( 'Top', static::TEXT_DOMAIN ),
                            'right'                      => __( 'Right', static::TEXT_DOMAIN ),
                            'bottom'                     => __( 'Bottom', static::TEXT_DOMAIN ),
                            'left'                       => __( 'Left', static::TEXT_DOMAIN ),
                            'center'                     => __( 'Center', static::TEXT_DOMAIN ),
                            'size'                       => __( 'Size', static::TEXT_DOMAIN ),
                            'auto'                       => __( 'Auto', static::TEXT_DOMAIN ),
                            'cover'                      => __( 'Cover', static::TEXT_DOMAIN ),
                            'contain'                    => __( 'Contain', static::TEXT_DOMAIN ),
                            'placeholder'                => __( 'Enter text...', static::TEXT_DOMAIN ),
                            'presets'                    => __( 'Presets', static::TEXT_DOMAIN ),
                            'icon'                       => __( 'Icon', static::TEXT_DOMAIN ),
                            'show_icon'                  => __( 'Show icon', static::TEXT_DOMAIN ),
                            'search_icon'                => __( 'Search icon', static::TEXT_DOMAIN ),
                            'own_image'                  => __( 'Own image', static::TEXT_DOMAIN ),
                            'width'                      => __( 'Width, px', static::TEXT_DOMAIN ),
                            'height'                     => __( 'Height, px', static::TEXT_DOMAIN ),
                            'indent'                     => __( 'Indent, px', static::TEXT_DOMAIN ),
                            'position'                   => __( 'Position', static::TEXT_DOMAIN ),
                            'left_top'                   => __( 'Left top', static::TEXT_DOMAIN ),
                            'left_center'                => __( 'Left center', static::TEXT_DOMAIN ),
                            'left_bottom'                => __( 'Left bottom', static::TEXT_DOMAIN ),
                            'top_left'                   => __( 'Top left', static::TEXT_DOMAIN ),
                            'top_center'                 => __( 'Top center', static::TEXT_DOMAIN ),
                            'top_right'                  => __( 'Top right', static::TEXT_DOMAIN ),
                            'middle_left'                => __( 'Middle left', static::TEXT_DOMAIN ),
                            'middle_center'              => __( 'Middle center', static::TEXT_DOMAIN ),
                            'middle_right'               => __( 'Middle right', static::TEXT_DOMAIN ),
                            'right_top'                  => __( 'Right top', static::TEXT_DOMAIN ),
                            'right_center'               => __( 'Right center', static::TEXT_DOMAIN ),
                            'right_bottom'               => __( 'Right bottom', static::TEXT_DOMAIN ),
                            'bottom_left'                => __( 'Bottom left', static::TEXT_DOMAIN ),
                            'bottom_center'              => __( 'Bottom center', static::TEXT_DOMAIN ),
                            'bottom_right'               => __( 'Bottom right', static::TEXT_DOMAIN ),
                            'background'                 => __( 'Background', static::TEXT_DOMAIN ),
                            'show_background'            => __( 'Show background', static::TEXT_DOMAIN ),
                            'image'                      => __( 'Image', static::TEXT_DOMAIN ),
                            'select_image'               => __( 'Select image', static::TEXT_DOMAIN ),
                            'delete_image'               => __( 'Delete image', static::TEXT_DOMAIN ),
                            'color'                      => __( 'Color', static::TEXT_DOMAIN ),
                            'picture'                    => __( 'Picture', static::TEXT_DOMAIN ),
                            'repeat'                     => __( 'Repeat', static::TEXT_DOMAIN ),
                            'no_repeat'                  => __( 'No repeat', static::TEXT_DOMAIN ),
                            'repeat_horizontal_vertical' => __( 'Repeat horizontal and vertical', static::TEXT_DOMAIN ),
                            'repeat_horizontal'          => __( 'Repeat horizontal', static::TEXT_DOMAIN ),
                            'repeat_vertical'            => __( 'Repeat vertical', static::TEXT_DOMAIN ),
                            'border'                     => __( 'Border', static::TEXT_DOMAIN ),
                            'border_width'               => __( 'Border width', static::TEXT_DOMAIN ),
                            'border_style'               => __( 'Border style', static::TEXT_DOMAIN ),
                            'dotted'                     => __( 'Dotted', static::TEXT_DOMAIN ),
                            'dashed'                     => __( 'Dashed', static::TEXT_DOMAIN ),
                            'solid'                      => __( 'Solid', static::TEXT_DOMAIN ),
                            'double'                     => __( 'Double', static::TEXT_DOMAIN ),
                            'shadow'                     => __( 'Shadow', static::TEXT_DOMAIN ),
                            'show_shadow'                => __( 'Show shadow', static::TEXT_DOMAIN ),
                            'shift_x'                    => __( 'Shift on X, px', static::TEXT_DOMAIN ),
                            'shift_y'                    => __( 'Shift on Y, px', static::TEXT_DOMAIN ),
                            'blurring'                   => __( 'Blurring, px', static::TEXT_DOMAIN ),
                            'stretching'                 => __( 'Stretching, px', static::TEXT_DOMAIN ),
                            'opacity'                    => __( 'Opacity', static::TEXT_DOMAIN ),
                            'title'                      => __( 'Title', static::TEXT_DOMAIN ),
                            'show_title'                 => __( 'Show title', static::TEXT_DOMAIN ),
                            'align'                      => __( 'Align', static::TEXT_DOMAIN ),
                            'not_set'                    => __( 'Not set', static::TEXT_DOMAIN ),
                            'by_width'                   => __( 'By width', static::TEXT_DOMAIN ),
                            'bold'                       => __( 'Bold', static::TEXT_DOMAIN ),
                            'italic'                     => __( 'Italic', static::TEXT_DOMAIN ),
                            'underline'                  => __( 'Underlined', static::TEXT_DOMAIN ),
                            'uppercase'                  => __( 'Uppercase', static::TEXT_DOMAIN ),
                            'font_size'                  => __( 'Font size, px', static::TEXT_DOMAIN ),
                            'line_height'                => __( 'Line height', static::TEXT_DOMAIN ),
                            'text'                       => __( 'Text', static::TEXT_DOMAIN ),
                            'color_settings'             => __( 'Color settings', static::TEXT_DOMAIN ),
                            'text_color'                 => __( 'Text color', static::TEXT_DOMAIN ),
                            'link_color'                 => __( 'Link color', static::TEXT_DOMAIN ),
                            'advanced_settings'          => __( 'Advanced settings', static::TEXT_DOMAIN ),
                            'inner_padding_top'          => __( 'Inner padding top', static::TEXT_DOMAIN ),
                            'inner_padding_right'        => __( 'Inner padding right', static::TEXT_DOMAIN ),
                            'inner_padding_bottom'       => __( 'Inner padding bottom', static::TEXT_DOMAIN ),
                            'inner_padding_left'         => __( 'Inner padding left', static::TEXT_DOMAIN ),
                            'external_indent_top'        => __( 'External indent top', static::TEXT_DOMAIN ),
                            'external_indent_right'      => __( 'External indent right', static::TEXT_DOMAIN ),
                            'external_indent_bottom'     => __( 'External indent bottom', static::TEXT_DOMAIN ),
                            'external_indent_left'       => __( 'External indent left', static::TEXT_DOMAIN ),
                            'rounding_corners'           => __( 'Rounding corners', static::TEXT_DOMAIN ),
                            'tag'                        => __( 'Tag', static::TEXT_DOMAIN ),

                            'presets_settings'   => $class_templates->get_templates( true, true ),
                            'icon_images'        => $icon_styles->get_icons(),
                            'preset_items'       => $preset_names,
                            'default_attributes' => PluginContainer::get( WPRemark::class )->get_default_attributes(),
                        ]
                    );
                } );
            } );
        }
    }

    /**
     * Classic tinymce enqueue styles with plugin
     *
     * @param $url
     *
     * @return string
     */
    public function mce_css_styles( $url ) {
        if ( ! empty( $url ) ) {
            $url .= ',';
        }
        $url .= trailingslashit( plugin_dir_url( $this->plugin_file ) ) . '/assets/admin/css/editor-styles.min.css';

        return $url;
    }

    /**
     * @return void
     */
    protected function init_metadata() {
//		add_action( 'plugins_loaded', function () {
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $data          = get_plugin_data( $this->plugin_file, false, false );
        $this->version = $data['Version'];
        $this->name    = $data['Name'];
//		} );
    }

    /**
     * @return void
     */
    public function init_updates() {
        if ( ! $this->verify() ) {
            return;
        }
        Puc_v4_Factory::buildUpdateChecker(
            $this->update_url,
            $this->plugin_file,
            $this->update_slug,
            $this->update_check_period,
            $this->update_option_name
        )->addQueryArgFilter( function ( $queryArgs ) {
            if ( $licence = $this->options->license ) {
                $queryArgs['license_key'] = $licence;
            }

            return $queryArgs;
        } );
    }

    /**
     * @return void
     */
    protected function license_notice() {
        if ( ! $this->verify() ) {
            echo '<div class="notice notice-error">';
            echo '<h2>' . __( 'Attention!', static::TEXT_DOMAIN ) . '</h2>';
            echo '<p>' . sprintf( __( 'To activate plugin %s you need to enter the license key on <a href="%s">this page</a>.', static::TEXT_DOMAIN ), $this->name, admin_url( 'admin.php?page=wpremark' ) ) . '</p>';
            echo '</div>';
        }
    }

    /**
     * @return bool
     */
    public function verify() {
        if ( null === $this->_verify ) {
            $license        = $this->options->license;
            $license_verify = $this->options->license_verify;
            $license_error  = $this->options->license_error;

            if ( ! empty( $license ) && ! empty( $license_verify ) && empty( $license_error ) ) {
                //TODO: проверка на истечение лицензии
                $this->_verify = true;
            } else {
                $this->_verify = false;
            }
        }

        return $this->_verify;
    }

    /**
     * @param string $license
     *
     * @return bool|\WP_Error
     */
    public function activate( $license ) {
        $url = trim( $this->verify_url );

        if ( ! $url ) {
            $this->options->license_verify = '';
            $this->options->license_error  = __( 'Unable to check license without activation url', static::TEXT_DOMAIN );

            return new \WP_Error( 'activation_failed', __( 'Unable to check license without activation url', static::TEXT_DOMAIN ) );
        }

        $args = [
            'timeout'   => 15,
            'sslverify' => false,
            'body'      => [
                'action'    => 'activate_license',
                'license'   => $license,
                'item_name' => $this->name,
                'version'   => $this->version,
                'type'      => 'plugin',
                'url'       => home_url(),
                'ip'        => Utilities::get_ip(),
            ],
        ];

        $response = wp_remote_post( $url, $args );
        if ( is_wp_error( $response ) ) {
            $response = wp_remote_post( str_replace( "https", "http", $url ), $args );
        }

        if ( is_wp_error( $response ) ) {
            $this->options->license_verify = '';
            $this->options->license_error  = __( 'Can\'t get response from license server', $this->options->text_domain );

            return new \WP_Error( 'activation_failed', __( 'Can\'t get response from license server', static::TEXT_DOMAIN ) );
        }

        $body = wp_remote_retrieve_body( $response );

        if ( mb_substr( $body, 0, 2 ) == 'ok' ) {
            $this->options->license        = $license;
            $this->options->license_verify = time() + ( WEEK_IN_SECONDS * 4 );
            $this->options->license_error  = '';

            return true;
        }

        $this->options->license_verify = '';
        $this->options->license_error  = $body;

        return new \WP_Error( 'activation_failed', __( 'Unable to check license without activation url', static::TEXT_DOMAIN ) );
    }

    /**
     * @return void
     */
    public function handle_activation() {
        if ( strtoupper( $_SERVER['REQUEST_METHOD'] ) !== 'POST' ) {
            return;
        }

        if ( is_admin() &&
             isset( $_POST['wpremark_nonce'] ) && wp_verify_nonce( $_POST['wpremark_nonce'], 'wpremark-activate' )
        ) {
            $this->activate( isset( $_POST['license'] ) ? $_POST['license'] : '' );
            wp_redirect( home_url( '/wp-admin/admin.php?page=' . AdminMenu::MAIN_SLUG ), 303 );
            die;
        }
    }
}
