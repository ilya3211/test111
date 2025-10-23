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

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

                <section class="error-404 not-found">
                    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', THEME_TEXTDOMAIN ); ?></h1>

                    <div class="page-content">
                        <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', THEME_TEXTDOMAIN ); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </section><!-- .error-404 -->

                <?php get_template_part( 'template-parts/related', 'posts' ) ?>
            
        </main><!--.site-main-->
    </div><!--.content-area-->

<?php
get_sidebar();
get_footer();
