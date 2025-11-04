<?php
/**
 * Archive Stats Header - Заголовок категории со статистикой
 *
 * Использование:
 * В archive.php, category.php или через хук добавьте:
 * get_template_part( 'template-parts/archive-stats-header' );
 *
 * Или через хук:
 * add_action('cook_it_before_posts_loop', function() {
 *     get_template_part( 'template-parts/archive-stats-header' );
 * });
 */

// Получаем текущий объект архива
$current_term = get_queried_object();
$post_count = 0;
$avg_price = 0;
$avg_rating = 0;
$total_reviews = 0;

// Для категорий и таксономий
if ( is_category() || is_tax() ) {
    global $wp_query;
    $post_count = $wp_query->found_posts;

    // Можно добавить подсчет средней цены из мета полей
    // $avg_price = calculate_average_price( $current_term );

    // Можно добавить подсчет рейтинга
    // $avg_rating = calculate_average_rating( $current_term );
}

// Для обычных архивов
if ( is_archive() && !is_tax() && !is_category() ) {
    global $wp_query;
    $post_count = $wp_query->found_posts;
}

// Если нет статистики, можно не показывать блок
if ( $post_count === 0 ) {
    return;
}

// Получаем название страницы
$page_title = '';
if ( is_category() ) {
    $page_title = single_cat_title( '', false );
} elseif ( is_tax() ) {
    $page_title = single_term_title( '', false );
} elseif ( is_archive() ) {
    $page_title = get_the_archive_title();
}
?>

<div class="page-header">
    <h1 class="page-title"><?php echo esc_html( $page_title ); ?></h1>

    <?php if ( $post_count > 0 ) : ?>
        <div class="stats">
            <!-- Количество найденных рецептов -->
            <div class="stat-item">
                <span class="stat-icon">🔍</span>
                <span>
                    <strong>Найдено:</strong>
                    <?php
                    printf(
                        _n( '%s рецепт', '%s рецептов', $post_count, 'cook-it' ),
                        number_format_i18n( $post_count )
                    );
                    ?>
                </span>
            </div>

            <?php
            // Пример: Если есть данные о ценах (для рецептов это может быть стоимость ингредиентов)
            // Замените на реальный подсчет из ваших мета полей
            if ( false ) : // Замените на проверку реальных данных
            ?>
                <div class="stat-item">
                    <span class="stat-icon">💰</span>
                    <span>
                        <strong>Цена:</strong>
                        мин. <?php echo number_format( 100, 0, '.', ' ' ); ?> руб.
                        средн. <?php echo number_format( 500, 0, '.', ' ' ); ?> руб.
                        макс. <?php echo number_format( 2000, 0, '.', ' ' ); ?> руб.
                    </span>
                </div>
            <?php endif; ?>

            <?php
            // Пример: Если используется система рейтингов
            // Проверяем наличие плагина рейтингов
            if ( function_exists( 'the_ratings' ) || class_exists( 'WP_Star_Rating' ) ) :
                // Здесь можно добавить подсчет среднего рейтинга
                $avg_rating = 4.8; // Пример
                $total_reviews = 150; // Пример
            ?>
                <div class="stat-item">
                    <span class="stat-icon">⭐</span>
                    <span>
                        <strong>Количество отзывов:</strong> <?php echo number_format_i18n( $total_reviews ); ?>
                        <strong>Средний рейтинг:</strong>
                        <span class="rating-stars"><?php echo number_format( $avg_rating, 2 ); ?> ★★★★★</span>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php
    // Описание категории/таксономии
    if ( is_category() || is_tax() ) {
        $description = term_description();
        if ( ! empty( $description ) ) {
            echo '<div class="archive-description">' . wp_kses_post( $description ) . '</div>';
        }
    }
    ?>
</div>
