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

$structure_single_hide  = $wpshop_core->get_option( 'structure_single_hide' );
if ( ! empty( $structure_single_hide ) ) {
    $structure_single_hide = explode( ',', $structure_single_hide );
} else {
    $structure_single_hide = array();
}

$big_thumbnail_image = ( 'checked' == get_post_meta( $post->ID, 'big_thumbnail_image', true ) ) ? true : false ;
$thumb_url = get_the_post_thumbnail_url( $post, 'full' );

$is_show_thumb         = ( ! in_array( 'thumbnail', $structure_single_hide ) && $wpshop_core->is_show_element( 'thumbnail' ) );
$is_show_meta          = $wpshop_core->is_show_element( 'meta' );
$is_show_breadcrumbs   = $wpshop_core->is_show_element( 'breadcrumbs' );
$is_show_social_top    = ( ! in_array( 'social_top', $structure_single_hide ) && $wpshop_core->is_show_element( 'social_top' ) );
$is_show_comments      = ( ! in_array( 'comments', $structure_single_hide ) && $wpshop_core->is_show_element( 'comments' ) );
$is_show_sidebar       = ( $wpshop_core->get_option( 'structure_single_sidebar' ) != 'none' && $wpshop_core->is_show_element( 'sidebar' ) );
$is_show_related_posts = $wpshop_core->is_show_element( 'related_posts' );

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php if ( $big_thumbnail_image ): ?>

        <?php if ( ! empty( $thumb_url ) && $is_show_thumb ) : ?>
            <div class="entry-image entry-image--big"<?php if ( ! empty( $thumb_url ) ) echo ' style="background-image: url('. $thumb_url .');"' ?>>

                <div class="entry-image__body">
                    <?php if ( $is_show_meta ) { ?>
                        <div class="entry-meta">
                            <?php get_template_part( 'template-parts/boxes/entry', 'meta' ) ?>
                        </div>
                    <?php } ?>

                    <?php if ( $is_show_social_top ) { ?>
                        <div class="social-buttons">
                            <?php get_template_part( 'template-parts/social', 'buttons' ); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <div id="primary" class="content-area" itemscope itemtype="http://schema.org/<?php echo ( is_recipe() ) ? 'Recipe' : 'Article' ; ?>">
        <main id="main" class="site-main">

            <?php if ( ! empty( $thumb_url ) && $big_thumbnail_image ) { ?>
                <meta itemprop="image" content="<?php echo $thumb_url ?>">
            <?php } ?>

            <?php if ( $is_show_breadcrumbs ) get_template_part( 'template-parts/boxes/breadcrumbs' ) ?>

            <?php

                get_template_part( 'template-parts/content', 'single' );

                if ( $is_show_related_posts && ! $wpshop_core->get_option( 'related_posts_after_comments' ) ) get_template_part( 'template-parts/related', 'posts' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( $is_show_comments ) {
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                }

                if ( $is_show_related_posts && $wpshop_core->get_option( 'related_posts_after_comments' ) ) get_template_part( 'template-parts/related', 'posts' );

            ?>

        </main><!--.site-main-->
    </div><!--.content-area-->

<?php endwhile; ?>

<?php if ( $is_show_sidebar ) get_sidebar(); ?>

<?php
get_footer();
