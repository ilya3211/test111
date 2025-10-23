<?php
/**
 * @package cook-it
 */

function wpshop_core_metabox() {

    class Posts_Hide_Elements extends Wpshop\Core\MetaBox {

        public function __construct() {
            $this->set_settings( array(
                'prefix'            => 'posts_hide_',
                'post_type'         => apply_filters( THEME_SLUG . '_metabox_hide_elements_post_type', array( 'post' ) ),
                'meta_box_title'    => __( 'Hide elements', THEME_TEXTDOMAIN ),
                'context'           => 'side',
            ) );

            parent::__construct();
        }

        public function render_fields() {
            $this->field_checkboxes( 'hide_elements',      '', array(
                'header'        => __( 'Header', THEME_TEXTDOMAIN ),
                'header_menu'   => __( 'Header menu', THEME_TEXTDOMAIN ),
                'breadcrumbs'   => __( 'Breadcrumbs', THEME_TEXTDOMAIN ),
                'title_h1'      => __( 'Title', THEME_TEXTDOMAIN ),
                'meta'          => __( 'Meta-information (date, category, author)', THEME_TEXTDOMAIN ),
                'thumbnail'     => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                'social_top'    => __( 'Top social buttons', THEME_TEXTDOMAIN ),
                'ingredients'   => __( 'Ingredients', THEME_TEXTDOMAIN ),
                'steps'         => __( 'Steps', THEME_TEXTDOMAIN ),
                'toc'           => __( 'Contents', THEME_TEXTDOMAIN ),
                'author_box'    => __( 'Author block', THEME_TEXTDOMAIN ),
                'social_bottom' => __( 'Bottom social buttons', THEME_TEXTDOMAIN ),
                'rating'        => __( 'Rating', THEME_TEXTDOMAIN ),
                'related_posts' => __( 'Related posts', THEME_TEXTDOMAIN ),
                'comments'      => __( 'Comments', THEME_TEXTDOMAIN ),
                'sidebar'       => __( 'Sidebar', THEME_TEXTDOMAIN ),
                'footer_menu'   => __( 'Footer menu', THEME_TEXTDOMAIN ),
                'footer'        => __( 'Footer', THEME_TEXTDOMAIN ),
            ) );
        }

    }

    new Posts_Hide_Elements;



    class Posts_Settings extends Wpshop\Core\MetaBox {

        public function __construct() {
            $this->set_settings( array(
                'prefix'            => 'posts_settings_',
                'post_type'         => 'post',
                'meta_box_title'    => __( 'Post settings', THEME_TEXTDOMAIN ),
                'context'           => 'side',
            ) );

            parent::__construct();
        }

        public function render_fields() {
            $this->field_text( 'source_link', __( 'Source', THEME_TEXTDOMAIN ), 'http://...', __( 'If you need to provide a link to an external site as a source, fill in this field', THEME_TEXTDOMAIN ) );
            $this->field_checkbox( 'source_hide', '', __( 'Hide link to source using JS', THEME_TEXTDOMAIN ) );
            $this->field_text( 'related_posts_ids', __( 'ID related posts', THEME_TEXTDOMAIN ), '', __( 'Enter the ID of the posts separated by commas to display certain posts in related posts', THEME_TEXTDOMAIN ) );
        }

    }

    new Posts_Settings;



    class Pages_Hide_Elements extends Wpshop\Core\MetaBox {

        public function __construct() {
            $this->set_settings( array(
                'prefix'            => 'pages_hide_',
                'post_type'         => 'page',
                'meta_box_title'    => __( 'Hide elements', THEME_TEXTDOMAIN ),
                'context'           => 'side',
            ) );

            parent::__construct();
        }

        public function render_fields() {
            $this->field_checkboxes( 'hide_elements',      '', array(
                'header'        => __( 'Header', THEME_TEXTDOMAIN ),
                'header_menu'   => __( 'Header menu', THEME_TEXTDOMAIN ),
                'breadcrumbs'   => __( 'Breadcrumbs', THEME_TEXTDOMAIN ),
                'title_h1'      => __( 'Title', THEME_TEXTDOMAIN ),
                'thumbnail'     => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                'social_top'    => __( 'Top social buttons', THEME_TEXTDOMAIN ),
                'toc'           => __( 'Contents', THEME_TEXTDOMAIN ),
                'social_bottom' => __( 'Bottom social buttons', THEME_TEXTDOMAIN ),
                'rating'        => __( 'Rating', THEME_TEXTDOMAIN ),
                'related_posts' => __( 'Related posts', THEME_TEXTDOMAIN ),
                'comments'      => __( 'Comments', THEME_TEXTDOMAIN ),
                'sidebar'       => __( 'Sidebar', THEME_TEXTDOMAIN ),
                'footer_menu'   => __( 'Footer menu', THEME_TEXTDOMAIN ),
                'footer'        => __( 'Footer', THEME_TEXTDOMAIN ),
            ) );
        }

    }

    new Pages_Hide_Elements;



    class Pages_Settings extends Wpshop\Core\MetaBox {

        public function __construct() {
            $this->set_settings( [
                'prefix'         => 'pages_settings_',
                'post_type'      => 'page',
                'meta_box_title' => __( 'Page settings', THEME_TEXTDOMAIN ),
                'context'        => 'side',
            ] );

            parent::__construct();
        }

        public function render_fields() {
            $this->field_text( 'related_posts_ids', __( 'ID related posts', THEME_TEXTDOMAIN ), '', __( 'Enter the ID of the posts separated by commas to display certain posts in related posts', THEME_TEXTDOMAIN ) );
        }

    }

    new Pages_Settings;
}
add_action( 'after_setup_theme', 'wpshop_core_metabox' );