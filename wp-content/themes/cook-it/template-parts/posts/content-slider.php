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

global $wpshop_core;
global $wpshop_template;
global $wpshop_helper;

$thumb_url = get_the_post_thumbnail_url( $post, 'full' );

$is_show_category = $wpshop_core->get_option( 'slider_show_category' );
$is_show_title    = $wpshop_core->get_option( 'slider_show_title' );
$is_show_excerpt  = $wpshop_core->get_option( 'slider_show_excerpt' );

?>

    <div class="swiper-slide">

        <a href="<?php the_permalink() ?>">
            <div class="card-slider__image" <?php if ( ! empty( $thumb_url ) ) echo ' style="background-image: url('. $thumb_url .');"' ?>></div>

            <div class="card-slider__body">
                <div class="card-slider__body-inner">
                    <?php if ( $is_show_category ) : ?>
                        <?php echo $wpshop_template->get_category( [ 'classes' => 'card-slider__category', 'micro' => false, 'link' => false ] ) ?>
                    <?php endif; ?>

                    <?php if ( $is_show_title ) : ?>
                        <div class="card-slider__title"><?php the_title() ?></div>
                    <?php endif; ?>

                    <?php if ( $is_show_excerpt ) : ?>
                        <?php echo '<div class="card-slider__excerpt">'; ?>
                            <?php echo $wpshop_helper->substring_by_word( strip_tags( get_the_excerpt() ) ); ?>
                        <?php echo '</div>'; ?>
                    <?php endif; ?>
                </div>
            </div>
        </a>

    </div>