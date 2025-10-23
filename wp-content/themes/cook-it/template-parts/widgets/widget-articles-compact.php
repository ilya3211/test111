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

global $wpshop_template;
global $wpshop_helper;
global $single_post;
global $hide_thumbnail;
global $hide_category;
global $hide_description;
global $hide_meta;
global $link_target;

$recipe_serves = (int) get_post_meta( $single_post->ID, 'recipe_serves', true );
$cook_time     = cook_time_prepare( $single_post->ID );
?>

<div class="widget-article widget-article--compact">
    <?php $thumb = get_the_post_thumbnail( $single_post->ID, apply_filters( THEME_SLUG . '_widget_article_compact_thumbnail', 'thumb-small' ) ); if ( ! $hide_thumbnail && ! empty( $thumb ) ) : ?>
    <div class="widget-article__image">
        <a href="<?php echo get_permalink( $single_post->ID ) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>>
            <?php echo $thumb ?>
        </a>
    </div>
    <?php endif ?>

    <div class="widget-article__body">
        <div class="widget-article__title"><a href="<?php echo get_permalink( $single_post->ID ) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>><?php echo get_the_title( $single_post->ID ) ?></a></div>

        <?php if ( ! $hide_description ) : ?>
            <div class="widget-article__description">
                <?php
                $excerpt = get_the_excerpt( $single_post->ID );
                if ( apply_filters( THEME_SLUG . '_widget_article_compact_excerpt_strip_tags', true ) ) {
                    $excerpt = strip_tags( $excerpt );
                }
                $excerpt = $wpshop_helper->substring_by_word( $excerpt, apply_filters( THEME_SLUG . '_widget_article_compact_excerpt', 50 ) );
                echo $excerpt;
                ?>
            </div>
        <?php endif ?>

        <?php if ( ! $hide_meta && ( ! empty( $cook_time ) || ! empty( $recipe_serves ) ) ) : ?>
           <div class="widget-article__meta">
               <?php if ( ! empty( $cook_time ) ) { echo '<span class="meta-cooking-time">' . $cook_time . '</span>'; } ?>
               <?php if ( $recipe_serves > 0 ) { echo '<span class="meta-serves">' . $recipe_serves . '</span>'; } ?>
           </div>
        <?php endif ?>
        <?php if ( ! $hide_category ) : ?>
            <div class="widget-article__category">
                <?php echo $wpshop_template->get_category( array( 'post' => $single_post->ID, 'micro' => false ) ) ?>
            </div>
        <?php endif ?>
    </div>
</div>