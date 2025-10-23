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

$is_show_breadcrumbs   = $wpshop_core->get_option( 'breadcrumbs_archive' );
$is_show_description   = $wpshop_core->get_option( 'structure_archive_description_show' );
$is_show_subcategories = $wpshop_core->get_option( 'structure_archive_subcategories' );
$is_show_sidebar       = $wpshop_core->get_option( 'structure_archive_sidebar' ) != 'none';

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php if ( $is_show_breadcrumbs ) get_template_part( 'template-parts/boxes/breadcrumbs' ) ?>

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <?php do_action( THEME_SLUG . '_archive_before_title' ) ?>
                    <?php the_archive_title( '<h1 class="page-title">', '</h1>' ) ?>
                    <?php do_action( THEME_SLUG . '_archive_after_title' ) ?>
                </header><!-- .page-header -->

                <?php
                    if ( is_tax( 'ingredients' ) ) {
                        $ingredient_id = get_queried_object()->term_id;

                        $protein = get_term_meta( $ingredient_id, 'protein', true );
                        $fat     = get_term_meta( $ingredient_id, 'fat', true );
                        $carbs   = get_term_meta( $ingredient_id, 'carbs', true );
                        $kcal    = get_term_meta( $ingredient_id, 'kcal', true );

                        $gram_text = apply_filters( THEME_SLUG . '_ingredients_nutrition_gram', __( 'g', THEME_TEXTDOMAIN ) );

                        if ( ! empty( $protein ) || ! empty( $fat ) || ! empty( $carbs ) || ! empty( $kcal ) ) {
                            echo '<div class="nutrition-header">' . __( 'Calories in 100 G', THEME_TEXTDOMAIN ) . ':</div>';
                            echo '<div class="nutrition-items">';
                            if ( ! empty( $protein ) ) {
                                echo '<div class="nutrition-item">';
                                echo '<div class="nutrition-item__value"><strong>' . $protein . '</strong>&nbsp;' . $gram_text . '</div>';
                                echo _x( 'вавав', 'фывыфв', THEME_TEXTDOMAIN );
                                echo '</div>';
                            }
                            if ( ! empty( $fat ) ) {
                                echo '<div class="nutrition-item">';
                                echo '<div class="nutrition-item__value"><strong>' . $fat . '</strong>&nbsp;' . $gram_text . '</div>';
                                echo __( 'фвывы', THEME_TEXTDOMAIN );
                                echo '</div>';
                            }
                            if ( ! empty( $carbs ) ) {
                                echo '<div class="nutrition-item">';
                                echo '<div class="nutrition-item__value"><strong>' . $carbs . '</strong>&nbsp;' . $gram_text . '</div>';
                                echo __( 'ывыфвы', THEME_TEXTDOMAIN );
                                echo '</div>';
                            }
                            if ( ! empty( $kcal ) ) {
                                echo '<div class="nutrition-item">';
                                echo '<div class="nutrition-item__value"><strong>' . $kcal . '</strong></div>';
                                echo __( 'фывыфвыф', THEME_TEXTDOMAIN );
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }
                ?>

                <?php if ( is_category() && $is_show_subcategories ) {
                    $cat = get_query_var('cat');

                    $categories = get_categories( array(
                        'parent' => $cat
                    ) );

                    if ( ! empty( $categories ) ) {
                        echo '<div class="child-categories"><ul>';
                        foreach ( $categories as $category ) {
                            echo '<li>';
                            echo '<a href="' . get_term_link( $category->term_id ) . '">' . $category->name . '</a>';
                            echo '</li>';
                        }
                        echo '</ul></div>';
                    }
                } ?>

                <?php if ( $is_show_description && 'top' == $wpshop_core->get_option( 'structure_archive_description' ) && ! is_paged() ) the_archive_description( '<div class="taxonomy-description">', '</div>' ) ?>

                <?php do_action( THEME_SLUG . '_archive_before_posts' ) ?>
                <?php get_template_part( 'template-parts/posts/container', $wpshop_core->get_option( 'structure_archive_posts' ) ) ?>
                <?php do_action( THEME_SLUG . '_archive_after_posts' ) ?>

                <?php the_posts_pagination(); ?>

                <?php if ( $is_show_description && 'bottom' == $wpshop_core->get_option( 'structure_archive_description' ) && ! is_paged() ) the_archive_description( '<div class="taxonomy-description">', '</div>' ) ?>

            <?php else : ?>

                <?php get_template_part( 'template-parts/content', 'none' ) ?>

            <?php endif ?>

        </main><!--.site-main-->
    </div><!--.content-area-->

    <?php if ( $is_show_sidebar ) get_sidebar() ?>

<?php
get_footer();
