<?php

namespace Wpshop\WPRemark;

class AdminMenu {

    use TemplateRendererTrait;

    const MAIN_SLUG    = 'wpremark';
    const PRESETS_SLUG = 'wpremark-presets';
    const ICONS_SLUG = 'wpremark-icons';

    /**
     * @var string|null
     */
    protected $plugin_file;

    /**
     * @param string $plugin_file
     *
     * @return void
     */
    public function init( $plugin_file ) {
        $this->plugin_file = $plugin_file;

        add_action( 'admin_menu', [ $this, '_setup_menu' ] );

        do_action( __METHOD__, $this );
    }

    /**
     * @return void
     */
    public function _setup_menu() {
        add_menu_page(
            'WPRemark',
            'WPRemark',
            'edit_posts',
            self::MAIN_SLUG,
            '',
            'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" style="fill:#a0a5aa"><path d="M504 395.45L304.18 58.22a56 56 0 00-96.36 0L8 395.45A56 56 0 0056.16 480h399.68A56 56 0 00504 395.45zM462.79 428a7.73 7.73 0 01-7 4H56.16a8 8 0 01-6.88-12.08L249.12 82.69a8 8 0 0113.76 0l199.84 337.23a7.72 7.72 0 01.07 8.08zM284 380c0 16-10.95 28-27.84 28S228 396 228 380c0-16.31 11.58-28 28.16-28s27.53 11.69 27.84 28zm-44.95-60l-6.9-128.2h47.7l-6.6 128.2z"/></svg>' )
        );
        add_submenu_page(
            self::MAIN_SLUG,
            'WPRemark',
            'WPRemark',
            'edit_posts',
            self::MAIN_SLUG,
            [ $this, 'render_info' ],
            100
        );

        if ( PluginContainer::get( Plugin::class )->verify() ) {
            add_submenu_page(
                self::MAIN_SLUG,
                'WPRemark Presets',
                __( 'Presets' , Plugin::TEXT_DOMAIN ),
                'edit_posts',
                self::PRESETS_SLUG,
                [ $this, 'render_presets' ],
                110
            );
            add_submenu_page(
                self::MAIN_SLUG,
                'WPRemark Icons',
                __( 'Icons' , Plugin::TEXT_DOMAIN ),
                'edit_posts',
                self::ICONS_SLUG,
                [ $this, 'render_icons' ],
                120
            );
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function render_info() {
        echo $this->render( 'info' );
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function render_presets() {
        echo $this->render( 'presets' );
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function render_icons() {
        echo $this->render( 'icons' );
    }
}
