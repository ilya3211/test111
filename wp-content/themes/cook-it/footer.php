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
global $wpshop_advertising;

?>
        </div><!--.site-content-inner-->

        <?php echo $wpshop_advertising->show_ad( 'after_site_content' ); ?>

    </div><!-- #content -->

    <?php do_action( THEME_SLUG . '_after_site_content' ); ?>

    <?php get_template_part( 'template-parts/footer/footer' ) ?>

</div><!-- #page -->

<?php wp_footer(); ?>
<?php $wpshop_core->the_option( 'code_body' ) ?>

<?php
$slider_per_view = 1;

if ( $wpshop_core->get_option( 'slider_type' ) == 'three' ) {
    $slider_per_view = apply_filters( THEME_SLUG . '_slider_three_count', 3 );
}

if ( $wpshop_core->get_option( 'slider_type' ) == 'thumbnails' ) {
    $slider_per_view = 1;
}

if ( apply_filters( THEME_SLUG . '_slider_output', is_front_page() || is_home() ) && ! empty( $wpshop_core->get_option( 'slider_count' ) ) ) {
    if ( ! wp_is_mobile() || ( wp_is_mobile() && ! $wpshop_core->get_option( 'slider_mob_disable' ) ) ) { ?>
        <!-- Initialize Swiper -->
        <script>
            <?php if ( $wpshop_core->get_option( 'slider_type' ) == 'thumbnails' ) { ?>

            var wpshopSwiperThumbs = new Swiper('.js-swiper-home-thumbnails', {
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                loopedSlides: 5, //looped slides should be the same
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                breakpoints: {
                    1024: {
                        slidesPerView: 4,
                    },
                    900: {
                        slidesPerView: 3,
                    },
                    760: {
                        slidesPerView: 2,
                    },
                    600: {
                        slidesPerView: 1,
                    },
                },
            });

            <?php } ?>

            var wpshopSwiper = new Swiper('.js-swiper-home', {
                <?php if ( $wpshop_core->get_option( 'slider_type' ) != 'thumbnails' ) { ?>
                slidesPerView: <?php echo $slider_per_view ?>,
                <?php } ?>
                <?php if ( $wpshop_core->get_option( 'slider_type' ) == 'three' ) { ?>
                breakpoints: {
                    1201: {
                        slidesPerView: <?php echo $slider_per_view ?>,
                        spaceBetween: 30,
                    },
                    300: {
                        slidesPerView: 1,
                    }
                },
                <?php } ?>
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                <?php if ( is_numeric( $wpshop_core->get_option('slider_autoplay') ) && $wpshop_core->get_option('slider_autoplay') > 0 ) { ?>
                autoplay: {
                    delay: <?php $wpshop_core->the_option('slider_autoplay') ?>,
                    disableOnInteraction: true,
                },
                <?php } ?>
                <?php if ( $wpshop_core->get_option( 'slider_type' ) == 'thumbnails' ) { ?>
                thumbs: {
                    swiper: wpshopSwiperThumbs,
                },
                loopedSlides: 5, //looped slides should be the same
                <?php } ?>
            });
        </script>
    <?php }
} ?>
    
</body>
</html>