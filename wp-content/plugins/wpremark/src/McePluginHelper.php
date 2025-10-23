<?php

namespace Wpshop\WPRemark;

class McePluginHelper {

    use TemplateRendererTrait;

    /**
     * McePluginHelper constructor.
     *
     */
    public function __construct() {
    }

    /**
     * @return void
     */
    public function init() {
        $this->prepare_media_templates();

        do_action( __METHOD__, $this );
    }

    /**
     * @return void
     */
    protected function prepare_media_templates() {

        if ( is_admin() ) {
            add_action( 'print_media_templates', function () {
                echo $this->render( 'tmpl-wpremark-popup' ) .
                     $this->render( 'tmpl-wpremark-live-preview' );
            } );
        }
    }
}
