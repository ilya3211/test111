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

function cook_it_add_featured_image_display_settings( $content, $post_id ) {
    $field_text_before  = sprintf( esc_html__( 'Рекомендуемый размер %s', THEME_TEXTDOMAIN ), '680x300' );
    $content = '<p class="howto">'. $field_text_before . '</p>' . $content;

    return $content;
}
add_filter( 'admin_post_thumbnail_html', 'cook_it_add_featured_image_display_settings', 10, 2 );


function wpshop_core_thumbnails() {

    class Posts_Thumbnails extends Wpshop\Core\MetaBox {

        public function __construct() {
            $this->set_settings( array(
                'prefix'         => 'posts_thumb_',
                'post_type'      => apply_filters( THEME_SLUG . '_metabox_thumbnail_post_type', array( 'post', 'page' ) ),
                'meta_box_title' => __( 'Thumbnail settings', THEME_TEXTDOMAIN ),
                'context'        => 'side',
            ) );

            parent::__construct();
        }

        public function render_fields() {
            $field_text = '<p class="howto">' . sprintf( esc_html__( 'A thumbnail will be displayed on the page for the full width of the site. Recommended size %s', THEME_TEXTDOMAIN ), '1140x400' ) . '</p>';
            $this->field_checkbox( 'big_thumbnail_image',      '', __( 'Big thumbnail', THEME_TEXTDOMAIN ) . $field_text );
        }

    }

    new Posts_Thumbnails;

}
add_action( 'after_setup_theme', 'wpshop_core_thumbnails' );