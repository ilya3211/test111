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

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php
            if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', THEME_TEXTDOMAIN ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                </header><!-- .page-header -->

                <div class="page-separator"></div>

                <?php
                get_template_part( 'template-parts/posts/container', $wpshop_core->get_option( 'structure_archive_posts' ) );

                the_posts_pagination();

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif; ?>

        </main><!--.site-main-->
    </div><!--.content-area-->

<?php
get_sidebar();
get_footer();
