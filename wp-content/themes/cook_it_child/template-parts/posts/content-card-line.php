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
global $wpshop_helper;
global $wpshop_template;
global $wpshop_rating;


$post_card_type = 'horizontal';
$post_card_thumb_size = apply_filters( THEME_SLUG . '_post_card_' . $post_card_type . '_thumbnail_size', 'thumb-wide' );
$section_options = ( isset( $section_options ) ) ? $section_options : [];


/**
 * order
 */
$post_card_order = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order' );
$post_card_order = explode( ',', $post_card_order );

$post_card_order_meta = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order_meta' );
$post_card_order_meta = explode( ',', $post_card_order_meta );


/**
 * post card class
 */
$post_card = new \Wpshop\PostCard\PostCard();
$post_card->set_order( array_merge( $post_card_order, $post_card_order_meta ) );
$post_card->set_section_options( $section_options );


/**
 * default
 */
$post_card_attributes = [ 'itemscope', 'itemtype="http://schema.org/BlogPosting"'  ];
$post_card_classes    = [ 'content-card--line' ];
$description_length   = (int) $wpshop_core->get_option( 'post_card_' . $post_card_type . '_excerpt_length' );


/**
 * prepare data
 */
$recipe_serves = (int) get_post_meta( $post->ID, 'recipe_serves', true );
$cook_time     = cook_time_prepare();

$thumb = get_the_post_thumbnail( $post->ID, $post_card_thumb_size, array( 'itemprop' => 'image' ) );

?>
<?php
$is_show_rating = true; // Установите значение true или false в зависимости от ваших потребностей
?>
<div id="post-<?php the_ID(); ?>" class="content-card <?php echo implode(' ', $post_card_classes) ?>" <?php echo implode(' ', $post_card_attributes) ?>>
    <?php if (!empty($thumb) && $post_card->is_show_element('thumbnail')) : ?>
        <table>
            <tr>
                <td class="content-card__image">
                    <?php if ('post' === get_post_type() && $post_card->is_show_element('category')) : ?>
                        <span class="entry-category"><?php echo $wpshop_template->get_category() ?></span>
                    <?php endif; ?>
                    <a href="<?php the_permalink() ?>">
                        <?php echo $thumb; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <!-- Блок рейтинга -->
                    <?php if ( $is_show_rating ) : ?>
                    <div class="entry-rating">
                        <div class="entry-bottom__header"><?php echo apply_filters( THEME_SLUG . '_rating_title', __( 'Rating', THEME_TEXTDOMAIN ) ) ?></div>
                        <?php $post_id = $post ? $post->ID : 0; $wpshop_rating->the_rating( $post_id, apply_filters( THEME_SLUG . '_rating_text_show', true ) ); ?>
                    </div>
                    <?php endif; ?>
                    <!-- Отображение рейтинга в виде звезд -->
                  
                </td>
            </tr>
        </table>
    <?php endif; ?>
                <!-- Конец блока рейтинга -->




    <div class="content-card__body">

        <?php
        foreach ( $post_card_order as $order ) {

            if ( $order == 'title' && $post_card->is_show_element( 'title' ) ) {
                echo '<div class="content-card__title" itemprop="name">';
                echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url"><span itemprop="headline">' . get_the_title() . '</span></a>';
                echo '</div>';
            }

            if ( 'post' === get_post_type() && $order == 'category' && $post_card->is_show_element( 'category' ) ) {
                if ( empty( $thumb ) || ! $post_card->is_show_element( 'thumbnail' ) ) {
                    echo '<span class="entry-category">' . $wpshop_template->get_category() . '</span>';
                }
            }

            if ( 'post' === get_post_type() && $order == 'meta' ) {

                echo '<div class="content-card__meta">';
                    if (
                        $post_card->is_show_element( 'cooking_time' ) && ! empty( $cook_time ) ||
                        $post_card->is_show_element( 'serves' ) && $recipe_serves > 0 ||
                        $post_card->is_show_element( 'author' ) ||
                        $post_card->is_show_element( 'date' )
                    ) {
                        echo '<span class="content-card__meta-left">';

                            foreach ( $post_card_order_meta as $meta_order ) {
                                if ( $meta_order == 'cooking_time' && $post_card->is_show_element( 'cooking_time' ) && ! empty( $cook_time ) ) {
                                    echo '<span class="meta-cooking-time">' . $cook_time . '</span>';
                                }

                                if ( $meta_order == 'serves' && $post_card->is_show_element( 'serves' ) && $recipe_serves > 0 ) {
                                    echo '<span class="meta-serves">' . $recipe_serves . '</span>';
                                }

                                if ( $meta_order == 'author' && $post_card->is_show_element( 'author' ) ) {
                                    echo '<span class="meta-author"><span itemprop="author">' . get_the_author() . '</span></span>';
                                }

                                if ( $meta_order == 'date' && $post_card->is_show_element( 'date' ) ) {
                                    echo '<span class="meta-date"><time itemprop="datePublished" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'd.m.Y' ) . '</time></span>';
                                }
                            }

                        echo '</span>';
                    }

                    if (
                        $post_card->is_show_element( 'comments_number' ) ||
                        $post_card->is_show_element( 'views' )
                    ) {
                        echo '<span class="content-card__meta-right">';

                            foreach ( $post_card_order_meta as $meta_order ) {
                                if ( $meta_order == 'comments_number' && $post_card->is_show_element( 'comments_number' ) ) {
                                    echo '<span class="meta-comments">' . get_comments_number() . '</span>';
                                }

                                if ( $meta_order == 'views' && $post_card->is_show_element( 'views' ) && $wpshop_template->get_views() > 0 ) {
                                    echo '<span class="meta-views">' . $wpshop_helper->rounded_number( $wpshop_template->get_views() ) . '</span>';
                                }
                            }

                        echo '</span>';
                    }

                echo '</div>';

            }
            ?>

            <?php if ( $order == 'excerpt' && $post_card->is_show_element( 'excerpt' ) ) {
                echo '<div class="content-card__excerpt" itemprop="articleBody">';
                $excerpt = get_the_excerpt();
                if ( apply_filters( THEME_SLUG . '_post_card_' . $post_card_type . '_excerpt_strip_tags', true ) ) {
                    $excerpt = strip_tags( $excerpt );
                }
                echo $wpshop_helper->substring_by_word( $excerpt, $description_length );
                echo '</div>';
            }

        } ?>
		
<table width="90%">
    <tr>
        <td  style="vertical-align: top;">
            <?php
            // Создайте ассоциативный массив для хранения значений
            $nutritional_info = array(
                'calories2'      => get_post_meta( $post->ID, 'recipe_calories', true ),
                'proteins1'      => get_post_meta( $post->ID, 'recipe_proteins', true ),
                'fats1'          => get_post_meta( $post->ID, 'recipe_fats', true ),
                'carbohydrates1' => get_post_meta( $post->ID, 'recipe_carbohydrates', true ),
            );

            // Проверьте, есть ли значения для каждого элемента
            if ( ! empty( $nutritional_info['calories2'] ) ||
                 ! empty( $nutritional_info['proteins1'] ) ||
                 ! empty( $nutritional_info['fats1'] ) ||
                 ! empty( $nutritional_info['carbohydrates1'] ) ) {
                // Вывод информации о пищевой ценности
                echo '<div class="nutritional" itemprop="nutrition" itemscope itemtype="http://schema.org/NutritionInformation">';
                echo '<div class="nutritional__header">' . apply_filters( THEME_SLUG . '_nutritional_title', __( 'Per serving', THEME_TEXTDOMAIN ) ) . '</div>';

                // Вывод данных о пищевой ценности, если они есть
                foreach ( $nutritional_info as $key => $value ) {
                    if ( ! empty( $value ) ) {
                        echo '<div class="nutritional-list">';
                        echo '<span>' . ucwords( str_replace( '_', ' ', $key ) ) . '</span>';
                        echo '<span itemprop="' . $key . '"><span class="strong">' . esc_html( $value ) . '</span></span>';
                        echo '</div>';
                    }
                }

                echo '</div>';
            }
            ?>
        </td>
    </tr>
    <tr width="90%">
        <td>
      <?php
      $current_url = $_SERVER['REQUEST_URI'];
      // Changed from /ingredients/ to /search/
      $target_url1 = '/search/%d1%81%d0%b0%d1%85%d0%b0%d1%80-%d0%bf%d0%b5%d1%81%d0%be%d0%ba/';
      $target_url2 = '/category/%d0%bc%d1%80%d1%82/';

      if (strpos($current_url, $target_url1) !== false || strpos($current_url, $target_url2) !== false) {
          // Ваш динамический контент для обоих целевых URL
          if (is_archive()) {
              global $post;
              $allowed_post_id = 219;
              if ($post->ID === $allowed_post_id) {
                  echo do_shortcode('[ninja_table_builder id="735"]');
              } else {
                  echo 'Динамический контент для других постов на этой странице архива';
              }
          }
      } else {
          echo 'Динамический контент для других страниц';
      }
?>
        </td>
    </tr>
</table>





    </div>

    <?php if ( ! $post_card->is_show_element( 'excerpt' )  ) { ?>
        <meta itemprop="articleBody" content="<?php echo strip_tags( get_the_excerpt() ) ?>">
    <?php } ?>
    <?php if ( ! $post_card->is_show_element( 'author' )  ) { ?>
        <meta itemprop="author" content="<?php echo esc_attr( get_the_author() ) ?>">
    <?php } ?>
    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php echo esc_attr( get_the_permalink() ) ?>" content="<?php echo esc_attr( get_the_title()) ?>">
    <meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_time( 'Y-m-d' ) ) ?>">
    <?php if ( ! $post_card->is_show_element( 'date' )  ) { ?>
        <meta itemprop="datePublished" content="<?php echo esc_attr( get_the_time( 'c' ) ) ?>">
    <?php } ?>
    <?php echo $wpshop_template->get_microdata_publisher() ?>

</div><!-- #post-## -->