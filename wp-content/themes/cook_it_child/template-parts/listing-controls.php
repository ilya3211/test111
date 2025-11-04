<?php
/**
 * Listing Controls - Блок управления листингом
 * Отображает счетчик рецептов и сортировку
 *
 * Использование: Добавьте в начало archive.php или category.php:
 * get_template_part( 'template-parts/listing-controls' );
 */

global $wp_query;
$post_count = $wp_query->found_posts;
?>

<div class="listing-controls">
    <div class="listing-controls__count">
        <?php
        /* translators: %s: number of recipes found */
        printf(
            _n(
                'Найден %s рецепт',
                'Найдено %s рецептов',
                $post_count,
                'cook-it'
            ),
            '<strong>' . number_format_i18n( $post_count ) . '</strong>'
        );
        ?>
    </div>

    <div class="listing-controls__sort">
        <form method="get" action="" id="listing-sort-form">
            <select name="orderby" id="listing-orderby" onchange="this.form.submit()">
                <option value=""><?php _e( 'Сортировка', 'cook-it' ); ?></option>
                <option value="date" <?php selected( isset($_GET['orderby']) && $_GET['orderby'] === 'date' ); ?>>
                    <?php _e( 'По дате (новые)', 'cook-it' ); ?>
                </option>
                <option value="date_asc" <?php selected( isset($_GET['orderby']) && $_GET['orderby'] === 'date_asc' ); ?>>
                    <?php _e( 'По дате (старые)', 'cook-it' ); ?>
                </option>
                <option value="title" <?php selected( isset($_GET['orderby']) && $_GET['orderby'] === 'title' ); ?>>
                    <?php _e( 'По названию (А-Я)', 'cook-it' ); ?>
                </option>
                <option value="comment_count" <?php selected( isset($_GET['orderby']) && $_GET['orderby'] === 'comment_count' ); ?>>
                    <?php _e( 'По популярности', 'cook-it' ); ?>
                </option>
                <option value="meta_value_num" <?php selected( isset($_GET['orderby']) && $_GET['orderby'] === 'meta_value_num' ); ?>>
                    <?php _e( 'По рейтингу', 'cook-it' ); ?>
                </option>
            </select>

            <?php
            // Preserve other GET parameters (like category, page, etc.)
            foreach ( $_GET as $key => $value ) {
                if ( $key !== 'orderby' && ! empty( $value ) ) {
                    echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
                }
            }
            ?>
        </form>
    </div>
</div>

<?php
/**
 * Handle sorting query modification
 */
add_action( 'pre_get_posts', 'cook_it_child_listing_sort' );
function cook_it_child_listing_sort( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( is_archive() || is_category() || is_tax() ) ) {
        if ( isset( $_GET['orderby'] ) && ! empty( $_GET['orderby'] ) ) {
            switch ( $_GET['orderby'] ) {
                case 'date':
                    $query->set( 'orderby', 'date' );
                    $query->set( 'order', 'DESC' );
                    break;
                case 'date_asc':
                    $query->set( 'orderby', 'date' );
                    $query->set( 'order', 'ASC' );
                    break;
                case 'title':
                    $query->set( 'orderby', 'title' );
                    $query->set( 'order', 'ASC' );
                    break;
                case 'comment_count':
                    $query->set( 'orderby', 'comment_count' );
                    $query->set( 'order', 'DESC' );
                    break;
                case 'meta_value_num':
                    $query->set( 'orderby', 'meta_value_num' );
                    $query->set( 'meta_key', 'wpshop_post_rating' );
                    $query->set( 'order', 'DESC' );
                    break;
            }
        }
    }
}
?>
