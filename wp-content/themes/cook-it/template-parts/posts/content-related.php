<?php
/**
 * ****************************************************************************
 *
 *   DON'T EDIT THIS FILE
 *   After update you will lose all changes. Use child theme
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *
 *   https://support.wpshop.ru/docs/general/child-themes/
 *
 * *****************************************************************************
 *
 * @package cook-it
 */

global $wpshop_core;
global $wpshop_helper;
global $wpshop_template;

$post_card_type = 'related';
$post_card_thumb_size = apply_filters( THEME_SLUG . '_post_card_' . $post_card_type . '_thumbnail_size', 'thumb-wide' );
$section_options = ( isset( $section_options ) ) ? $section_options : [];


/**
 * order
 */
$post_card_order = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order' );
$post_card_order = explode( ',', $post_card_order );

$post_card_order_meta = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order_meta' );
$post_card_order_meta = explode( ',', $post_card_order_meta );


/**
 * post card class
 */
$post_card = new \Wpshop\PostCard\PostCard();
$post_card->set_order( array_merge( $post_card_order, $post_card_order_meta ) );
$post_card->set_section_options( $section_options );


/**
 * default
 */
$post_card_classes    = [ 'content-card--small' ];
$description_length   = (int) $wpshop_core->get_option( 'post_card_' . $post_card_type . '_excerpt_length' );


/**
 * prepare data
 */
$recipe_serves = (int) get_post_meta( $post->ID, 'recipe_serves', true );
$cook_time     = cook_time_prepare();

$thumb = get_the_post_thumbnail( $post->ID, $post_card_thumb_size );

?>

<div id="post-<?php the_ID(); ?>" class="content-card <?php echo implode( ' ', $post_card_classes ) ?>">
    <?php
    foreach ( $post_card_order as $order ) {

        if ( $order == 'thumbnail' && $post_card->is_show_element( 'thumbnail' ) ) :
            echo '<div class="content-card__image">';
                if ( ! empty( $thumb ) ) :
                    echo '<a href="' . get_the_permalink() . '">';
                        echo $thumb;
                    echo '</a>';
                else :
                    echo '<a href="' . get_the_permalink() . '" class="content-card__no-image-link"></a>';
                endif;
            echo '</div>';
        endif;

        //echo '<div class="content-card__body">';

            if ( $order == 'title' && $post_card->is_show_element( 'title' ) ) {
                echo '<div class="content-card__title">';
                echo '<a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a>';
                echo '</div>';
            }

            if ( $order == 'meta' ) {

                echo '<div class="content-card__meta">';
                if (
                    $post_card->is_show_element( 'cooking_time' ) && ! empty( $cook_time ) ||
                    $post_card->is_show_element( 'serves' ) && $recipe_serves > 0
                ) {

                    echo '<span class="content-card__meta-left">';
                    foreach ( $post_card_order_meta as $meta_order ) {
                        if ( $meta_order == 'cooking_time' && $post_card->is_show_element( 'cooking_time' ) && ! empty( $cook_time ) ) {
                            echo '<span class="meta-cooking-time">' . $cook_time . '</span>';
                        }

                        if ( $meta_order == 'serves' && $post_card->is_show_element( 'serves' ) && $recipe_serves > 0 ) {
                            echo '<span class="meta-serves">' . $recipe_serves . '</span>';
                        }
                    }
                    echo '</span>';

                }

                if (
                    $post_card->is_show_element( 'comments_number' ) ||
                    $post_card->is_show_element( 'views' )
                ) {

                    echo '<span class="content-card__meta-right">';

                    foreach ( $post_card_order_meta as $meta_order ) {
                        if ( $meta_order == 'comments_number' && $post_card->is_show_element( 'comments_number' ) ) {
                            echo '<span class="meta-comments">' . get_comments_number() . '</span>';
                        }

                        if ( $meta_order == 'views' && $post_card->is_show_element( 'views' ) && $wpshop_template->get_views() > 0 ) {
                            echo '<span class="meta-views">' . $wpshop_helper->rounded_number( $wpshop_template->get_views() ) . '</span>';
                        }
                    }
                    echo '</span>';
                }

                echo '</div>';

            }

            if ( $order == 'excerpt' && $post_card->is_show_element( 'excerpt' ) ) {
                echo '<div class="content-card__excerpt">';
                $excerpt = get_the_excerpt();
                if ( apply_filters( THEME_SLUG . '_post_card_' . $post_card_type . '_excerpt_strip_tags', true ) ) {
                    $excerpt = strip_tags( $excerpt );
                }
                echo $wpshop_helper->substring_by_word( $excerpt, $description_length );
                echo '</div>';
            }

        //echo '</div>';

    }
    ?>

</div>
