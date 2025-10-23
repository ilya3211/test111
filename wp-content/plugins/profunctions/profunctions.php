<?php
/**
 * Plugin Name: ProFunctions
 * Plugin URI: https://wpshop.ru/
 * Description: Редактируйте этот плагин (Плагины - Редактор) вместо functions.php Вашей темы. Это поможет избежать потери информации при смене или обновлении темы
 * Version: 1.0.0
 * Author: WPShop
 * Author URI: https://wpshop.ru/
 * License: GPL v3
 */

/* Добавьте Ваш код ниже, открывать <?php не нужно */
add_filter( 'cook_it_archive_after_posts', 'insert_text_after_posts' );

function insert_text_after_posts( $content ) {
    // Проверяем ID текущего поста
    global $post;
    if ( $post->ID === 388 ) { // Замените 231 на нужный вам ID поста
        $text_to_insert = 'Здесь вставьте нужный текст или html-код для поста с ID 2315';
        $content .= $text_to_insert;
    }
    // Возвращаем контент
    return $content;
}


add_filter( 'cook_it_before_steps', function() {
    // Проверяем ID текущего поста
    global $post;
    if ( $post->ID === 231 ) { // Замените 123 на нужный вам ID поста
        return 'Здесь вставьте нужный текст или html-код для поста с ID 1234';
    }
    // Возвращаем пустую строку для остальных постов
    return '';
} );
add_filter( 'cook_it_steps_title', function() {
   return 'Преимущества';
} );
add_filter( 'cook_it_ingredients_title', function() {
   return 'Поиск по:';
} );

add_filter( 'cook_it_ingredients_nutrition_gram', function () {
    return '';
} );

add_action( 'cook_it_archive_after_title', 'custom_archive_content' );

function custom_archive_content() {
    // Проверяем, находимся ли мы на странице категории с ID 508
    if ( is_category( 508 ) ) {
        // Вставляем код после названия архива
        echo '<div class="custom-archive-content">Дополнительный контент после названия архива 508</div><br>';
    }
}
// Создайте функцию, которую вы хотите выполнить после события cook_it_archive_after_posts
function my_custom_function_after_archive_posts() {
    global $post;
    if ( $post->ID === 388 ) {
        echo '<div class="custom-after-archive-posts-content">Содержимое после архивных постов с ID 388</div>';
    }
}

add_action( 'cook_it_archive_after_posts', 'my_custom_function_after_archive_posts' );

// Создайте функцию, которую вы хотите выполнить после события cook_it_single_after_title
function my_custom_function_after_single_title() {
    // Проверяем ID текущего поста
    global $post;
    if ( $post->ID === 388 ) {
        // Ваш код здесь
        echo '<div class="custom-after-single-title-content">Содержимое после заголовка поста с ID 389</div>';
    }
}
add_action( 'cook_it_after_post_card', function( $n, $type ) {
   // блок после 388 и 197 карточек в рубрике 508
   if ( is_category( 508 ) && in_array( $n, [388, 197] ) ) {
      echo '<div style="width: 100%;background:#eee;padding: 15px;margin: 10px 0 20px;">Блок после 388 и 197 карточек в рубрике 508</div>';
   }
}, 10, 2 );

// Добавляем фильтр cook_it_nutritional_title для изменения заголовка "На порцию"
add_filter('cook_it_nutritional_title', 'custom_cook_it_nutritional_title');

function custom_cook_it_nutritional_title($title) {
    // Изменяем заголовок на желаемый
    $new_title = __('о компании', 'cook_it'); // Замените 'your-text-domain' на домен вашей темы
    
    return $new_title;
}
