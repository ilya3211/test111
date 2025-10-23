<?php

class Wpshop_Upgrade {

    private $db_version;

    public function __construct() {
        //update_option( 'theme_' . THEME_SLUG . '_version', '' );

        $this->db_version = get_option( 'theme_' . THEME_SLUG . '_version', '' );

        if ( version_compare( $this->db_version, THEME_ORIGINAL_VERSION, '<' ) ) {
            if ( function_exists( 'opcache_reset' ) ) {
                @opcache_reset();
            }

            $this->upgrade();
            $this->finish_up();
        }
    }


    /**
     * Upgrade function
     */
    public function upgrade() {

        if ( version_compare( $this->db_version, '1.1', '<' ) ) {
            $this->upgrade_11();
        }

        if ( version_compare( $this->db_version, '1.2', '<' ) ) {
            $this->upgrade_12();
        }

    }

    /**
     * Perform the 1.1 upgrade.
     *
     * @return void
     */
    private function upgrade_11() {
        global $wpshop_core;

        if ( $social_vk = $wpshop_core->get_option( 'social_vk' ) ) {
            $wpshop_core->set_option( 'social_vkontakte', $social_vk );
        }

        if ( $social_ok = $wpshop_core->get_option( 'social_ok' ) ) {
            $wpshop_core->set_option( 'social_odnoklassniki', $social_ok );
        }

        add_action( 'init', 'add_all_ingredients' );
    }


    /**
     * Perform the 1.2 upgrade.
     *
     * @return void
     */
    private function upgrade_12() {
        add_action( 'admin_notices', function() {
            $theme_info = wp_get_theme();
            $theme_template = $theme_info->get( 'Template' );

            if ( ! empty ( $theme_template ) && file_exists( get_stylesheet_directory() . '/template-parts/content-single.php' ) ) {
                echo '<div class="notice notice-warning is-dismissible"><p>Вы используете устаревший файл content-single.php в дочерней теме. Обновите данный файл из родительской темы.</p></div>';
            }
        } );
    }


    /**
     * Update version in db and flush rewrite rules
     */
    protected function finish_up() {
        update_option( 'theme_' . THEME_SLUG . '_version', THEME_ORIGINAL_VERSION );
        add_action( 'shutdown', 'flush_rewrite_rules' );
    }
}
new Wpshop_Upgrade();