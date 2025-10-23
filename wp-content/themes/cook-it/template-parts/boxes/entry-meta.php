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
global $wpshop_template;
global $wpshop_helper;

$structure_single_hide  = $wpshop_core->get_option( 'structure_single_hide' );
if ( ! empty( $structure_single_hide ) ) {
    $structure_single_hide = explode( ',', $structure_single_hide );
} else {
    $structure_single_hide = array();
}

$is_show_category   = ( ! in_array( 'category', $structure_single_hide ) );
$is_show_author     = ( ! in_array( 'author', $structure_single_hide ) );
$is_show_date       = ( ! in_array( 'date', $structure_single_hide ) );
$is_show_social_top = ( ! in_array( 'social_top', $structure_single_hide ) && $wpshop_core->is_show_element( 'social_top' ) );
$is_show_comments   = ( ! in_array( 'comments_count', $structure_single_hide ) );
$is_show_views      = ( ! in_array( 'views', $structure_single_hide ) );

if ( $is_show_category && is_singular( 'post' ) ) {
    echo '<span class="entry-category">' . $wpshop_template->get_category( array( 'micro' => false ) ) . '</span>';
}

if ( $is_show_author ) {
    echo '<span class="meta-author"><span>' . get_the_author() . '</span></span>';
}

if ( $is_show_date ) {
    echo '<span class="meta-date"><time datetime="' . get_the_time('Y-m-d') . '">' . get_the_date() . '</time></span>';
}

if ( $is_show_comments ) {
    echo '<span class="meta-comments">' . get_comments_number(). '</span>';
}

if ( $is_show_views && $wpshop_template->get_views() > 0 ) {
    echo '<span class="meta-views">' .
        '<span class="js-views-count" data-post_id="' . $post->ID . '">' .
        $wpshop_helper->rounded_number( $wpshop_template->get_views() ) . '</span>'.
        '</span>';
}