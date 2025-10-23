<?php

/**
 * Class Wpshop_Widget_Top_Commentators
 *
 * @version     1.1
 * @updated     2021-03-29
 */
class Wpshop_Widget_Top_Commentators extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wpshop_widget_top_commentators',
            __( 'TOP commentators', THEME_TEXTDOMAIN ),
            array( 'description' => __( 'TOP commentators', THEME_TEXTDOMAIN ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $period = ( ! empty( $instance['period'] ) ) ? $instance['period'] : 'all';
        $count  = ( ! empty( $instance['count'] ) ) ? absint( $instance['count'] ) : 6;

        $length = 10;
        $exclude_email = apply_filters( THEME_SLUG. 'top_commentators_exclude_email', get_option( 'admin_email' ) );

        $month = ( ! empty( $period ) && $period == 'month' ) ? true : false;

        global $wpdb;
        $results = $wpdb->get_results('
            SELECT
            COUNT(comment_author_email) AS comments_count, comment_author_email, comment_author, comment_author_url
            FROM
            (select * from '.$wpdb->comments.' order by comment_ID desc) as pc
            WHERE
            comment_author_email != "" AND
            comment_type = "comment" AND
            comment_approved = 1 AND
            comment_author_email NOT IN ('.preg_replace('/([\w\d\.\-_]+@[\w\d\.\-_]+)(,? ?)/','"\\1"\\2',$exclude_email).')'.
            ($month ? 'AND month(comment_date) = month(now()) AND year(comment_date) = year(now())' : '').
            'GROUP BY
            comment_author_email
            ORDER BY
            comments_count DESC
            LIMIT '.$count
        );

        if ( ! empty( $results ) ) {
            echo '<div class="top-commentators">';
                echo '<ul>';

                    foreach( $results as $result ) {
                        global $comment_author_name;
                        global $comment_author_email;
                        global $comment_author_url;
                        global $comment_author_count;

                        if ( ! empty( $result->comment_author ) ) {
                            if ( $length and $length < mb_strlen( $result->comment_author ) ) $result->comment_author = trim( mb_substr( $result->comment_author, 0, $length ) ) . '.';
                            $comment_author_name = $result->comment_author;
                        } else {
                            $comment_author_name = '';
                        }
                        $comment_author_email = ( ! empty( $result->comment_author_email ) ) ? $result->comment_author_email : '';
                        $comment_author_url   = ( ! empty( $result->comment_author_url ) ) ? base64_encode( $result->comment_author_url ) : '';
                        $comment_author_count = ( ! empty( $result->comments_count ) ) ? $result->comments_count : '';

                        get_template_part( 'template-parts/widgets/widget', 'top-commentators' );
                    }

                echo '</ul>';
            echo '</div>';
        } else {
            echo apply_filters( THEME_SLUG . 'top_commentators_no_comments', __( 'You can be first', THEME_TEXTDOMAIN ) );
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = sanitize_text_field( $instance['title'] );

        $period = ( isset( $instance['period'] ) ) ? $instance['period'] : 'all';
        $count  = ( isset( $instance['count'] ) ) ? absint( $instance['count'] ) : 6;

        echo '<p>';
        echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', THEME_TEXTDOMAIN ) . '</label>';
        echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '">';
        echo '</p>';

        echo '<p>';
        echo '<label for="' . $this->get_field_id( 'period' ) . '">' . __( 'Period', THEME_TEXTDOMAIN ) . '</label><br>';
        echo '<select name="' . $this->get_field_name( 'period' ) . '" id="' . $this->get_field_id( 'period' ) . '">';
        echo '<option value="all"' . selected( $period, 'all' ) . '>' . __( 'For all the time', THEME_TEXTDOMAIN ) . '</option>';
        echo '<option value="month"' . selected( $period, 'month' ) . '>' . __( 'Per month', THEME_TEXTDOMAIN ) . '</option>';
        echo '</select>';
        echo '</p>';

        echo '<p>';
        echo '<label for="' . $this->get_field_id( 'count' ) . '">' . __( 'Count of commentators', THEME_TEXTDOMAIN ) . '</label><br>';
        echo '<input id="' . $this->get_field_id( 'count' ) . '" name="' . $this->get_field_name( 'count' ) . '" type="number" min="1" step="1" value="' . esc_attr( $count ) . '">';
        echo '</p>';
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']  = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['period'] = ( ! empty( $new_instance['period'] ) ) ? $new_instance['period'] : '';
        $instance['count']  = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : '';

        return $instance;
    }
}