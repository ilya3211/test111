<?php

/**
 * Class Wpshop_Widget_Table_Of_Contents
 *
 * @version     1.1
 * @updated     2021-12-24
 */
class Wpshop_Widget_Table_Of_Contents extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wpshop_widget_table_of_contents',
            __( 'Contents', THEME_TEXTDOMAIN ),
            array( 'description' => __( 'Widget for contents', THEME_TEXTDOMAIN ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        $obj = get_queried_object();
        if ( ! $obj instanceof WP_Post ) {
            return;
        }

        $post_types = isset( $instance['post_types'] )
            ? $instance['post_types']
            : [
                'post' => 'on',
                'page' => 'on',
            ];

        $actual_types = $this->get_post_types( 'names' );
        $post_types   = array_filter( $post_types, function ( $key ) use ( $actual_types ) {
            return in_array( $key, $actual_types );
        }, ARRAY_FILTER_USE_KEY );

        if ( ! array_key_exists( $obj->post_type, $post_types ) ) {
            return;
        }

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        global $wpshop_table_of_contents;
        echo $wpshop_table_of_contents->get_toc_for_widget( $obj->post_content );

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = sanitize_text_field( $instance['title'] );

        $post_types = isset( $instance['post_types'] )
            ? $instance['post_types']
            : [
                'post' => 'on',
                'page' => 'on',
            ];
        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php echo __( 'Title', THEME_TEXTDOMAIN ) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name=<?php echo $this->get_field_name( 'title' ) ?>" type="text" value="<?php echo esc_attr( $title ) ?>">
        </p>

        <label><?php echo __( 'Output in post types', THEME_TEXTDOMAIN ) ?>:</label>
        <?php foreach ( $this->get_post_types() as $post_type ) : ?>
            <p>
                <label>
                    <input type="checkbox" name="<?php echo $this->get_field_name( "post_types[{$post_type->name}]" ) ?>"<?php checked( true, array_key_exists( $post_type->name, $post_types ) ) ?>>
                    <?php echo esc_html( $post_type->label ) ?>
                </label>
            </p>
        <?php endforeach;
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $actual_types = $this->get_post_types( 'names' );
        $types        = isset( $new_instance['post_types'] ) ? $new_instance['post_types'] : [];

        $instance['post_types'] = array_filter( $types, function ( $key ) use ( $actual_types ) {
            return in_array( $key, $actual_types );
        }, ARRAY_FILTER_USE_KEY );

        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }

    /**
     * @param string $output 'names' or 'objects'
     *
     * @return string[]|WP_Post_Type[]
     */
    protected function get_post_types( $output = 'objects' ) {
        $exclude_types = [
            'attachment',
        ];

        $post_types = get_post_types( [
            'public' => true,
        ], 'objects' );
        $post_types = array_filter( $post_types, function ( $item ) use ( $exclude_types ) {
            return ! in_array( $item->name, $exclude_types );
        } );

        if ( 'names' === $output ) {
            return array_map( function ( $item ) {
                return $item->name;
            }, $post_types );
        }

        return $post_types;
    }
}