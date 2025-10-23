<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *   After update you will lose all changes. Use child theme
 *
 *   https://support.wpshop.ru/docs/general/child-themes/
 *
 * *****************************************************************************
 *
 * @package cook-it
 */

global $authordata;
global $wpshop_core;
global $wpshop_social;

$author_link          = $wpshop_core->get_option( 'author_link' );
$author_link_target   = $wpshop_core->get_option( 'author_link_target' );
$author_social_enable = $wpshop_core->get_option( 'author_social_enable' );
$is_show_social_js    = $wpshop_core->get_option( 'author_social_js' );

?>

<!--noindex-->
<div class="author-box">
    <div class="author-box__ava">
        <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( THEME_SLUG . '_author_avatar_size', 70 ) ) ?>
    </div>

    <div class="author-box__body">
        <div class="author-box__author">
            <?php
            if ( $author_link ) {
                $author_link_target = $author_link_target ? '_blank' : '_self';

                echo '<a href ="' . get_author_posts_url( $authordata->ID ) . '" target="' . $author_link_target . '">' . get_the_author() . '</a><em>/ ' . __( 'author of the article', THEME_TEXTDOMAIN ) . '</em>';
            } else {
                echo get_the_author() . '<em>/ ' . __( 'author of the article', THEME_TEXTDOMAIN ) . '</em>';
            } ?>
        </div>
        <div class="author-box__description">
            <?php echo wpautop( get_the_author_meta( 'description' ) ) ?>
        </div>

        <?php
        if ( $author_social_enable ) {

            $author_social_profiles = wpshop_social_profiles();

            foreach ( $author_social_profiles as $author_social_profile ) {
                $user_meta_social = get_user_meta( $authordata->ID, $author_social_profile, true );

                if ( $user_meta_social ) {
                    $author_social_profile_links[$author_social_profile] = $user_meta_social;
                }
            }

            if ( ! empty( $author_social_profile_links ) ) { ?>
                <div class="author-box__social">
                    <?php if ( apply_filters( THEME_SLUG . '_author_social_title_show', true ) ) { ?>
                        <div class="author-box__social-title"><?php echo apply_filters( THEME_SLUG . '_author_social_title', __( 'Author profiles', THEME_TEXTDOMAIN ) ) ?></div>
                    <?php } ?>

                    <div class="social-links">
                        <div class="social-buttons social-buttons--square social-buttons--circle">
                            <?php $wpshop_social->social_profiles( $author_social_profile_links, $is_show_social_js ) ?>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>

    </div>
</div>
<!--/noindex-->