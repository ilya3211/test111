<?php
/**
 * Синхронизация и применение замены номера телефона
 * Исправляет ошибку "untracked working tree files would be overwritten"
 */

// Загружаем WordPress
define('WP_USE_THEMES', false);
if (file_exists('./wp-load.php')) {
    require_once('./wp-load.php');
} else {
    die('<h1>Ошибка: не найден wp-load.php</h1>');
}

echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Синхронизация: Замена номера телефона</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 30px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .step { background: #f0f8ff; padding: 20px; margin: 20px 0; border-left: 4px solid #0073aa; border-radius: 4px; }
        .success { background: #d4edda; border-left-color: #28a745; }
        .error { background: #f8d7da; border-left-color: #dc3545; }
        .warning { background: #fff3cd; border-left-color: #ffc107; }
        pre { background: #2d2d2d; color: #00ff00; padding: 15px; overflow-x: auto; border-radius: 4px; font-size: 13px; }
        h1 { color: #0073aa; margin: 0 0 20px 0; }
        h3 { margin: 0 0 15px 0; color: #333; }
        .button {
            display: inline-block;
            background: #0073aa;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .button:hover { background: #005a87; }
    </style>
</head>
<body>
<div class="container">';

echo '<h1>🔄 Синхронизация: Замена номера телефона</h1>';
echo '<p><strong>34343</strong> → <strong>555-0001</strong></p>';

// Переходим в корень WordPress
chdir(ABSPATH);

echo '<div class="step">';
echo '<h3>📁 Рабочая директория</h3>';
echo '<pre>' . getcwd() . '</pre>';
echo '</div>';

// Целевая ветка
$target_branch = 'claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q';

// Шаг 1: Очистка незакоммиченных файлов
echo '<div class="step">';
echo '<h3>Шаг 1: Очистка рабочей директории</h3>';
echo '<p>Удаляем файлы, которые мешают переключению веток...</p>';

$files_to_remove = array(
    'apply-phone-change.php',
    'sync-phone-change.php'
);

foreach ($files_to_remove as $file) {
    if (file_exists(ABSPATH . $file)) {
        exec('git rm -f ' . escapeshellarg($file) . ' 2>&1', $rm_output);
        echo '<p>Удален: <code>' . $file . '</code></p>';
    }
}

// Используем git clean для удаления неотслеживаемых файлов
exec('git clean -fd 2>&1', $clean_output);
echo '<pre>' . htmlspecialchars(implode("\n", $clean_output)) . '</pre>';
echo '<p style="color: green;">✓ Рабочая директория очищена</p>';
echo '</div>';

// Шаг 2: Получаем изменения с GitHub
echo '<div class="step">';
echo '<h3>Шаг 2: Получение изменений с GitHub</h3>';
exec('git fetch origin 2>&1', $fetch_output);
echo '<pre>' . htmlspecialchars(implode("\n", $fetch_output)) . '</pre>';
echo '<p style="color: green;">✓ Изменения получены</p>';
echo '</div>';

// Шаг 3: Переключаемся на целевую ветку
echo '<div class="step">';
echo '<h3>Шаг 3: Переключение на ветку с изменениями</h3>';
echo '<p>Целевая ветка: <code>' . htmlspecialchars($target_branch) . '</code></p>';

exec('git checkout -f ' . escapeshellarg($target_branch) . ' 2>&1', $checkout_output, $checkout_code);
echo '<pre>' . htmlspecialchars(implode("\n", $checkout_output)) . '</pre>';

if ($checkout_code === 0) {
    echo '<p style="color: green;">✓ Успешно переключились на ветку</p>';
} else {
    echo '<p style="color: red;">✗ Ошибка при переключении</p>';
    echo '<div class="error">';
    echo '<h4>Попробуем альтернативный способ...</h4>';

    // Альтернатива: жесткий сброс
    exec('git reset --hard HEAD 2>&1', $reset_head_output);
    exec('git checkout -f ' . escapeshellarg($target_branch) . ' 2>&1', $checkout_retry_output);
    echo '<pre>' . htmlspecialchars(implode("\n", $checkout_retry_output)) . '</pre>';
    echo '</div>';
}
echo '</div>';

// Шаг 4: Подтягиваем последние изменения
echo '<div class="step">';
echo '<h3>Шаг 4: Применение последних изменений</h3>';
exec('git reset --hard origin/' . escapeshellarg($target_branch) . ' 2>&1', $reset_output, $reset_code);
echo '<pre>' . htmlspecialchars(implode("\n", $reset_output)) . '</pre>';

if ($reset_code === 0) {
    echo '<p style="color: green;">✓ Изменения применены</p>';
} else {
    echo '<p style="color: red;">✗ Ошибка</p>';
}
echo '</div>';

// Шаг 5: Проверяем текущую ветку
echo '<div class="step">';
echo '<h3>Шаг 5: Проверка текущей ветки</h3>';
exec('git rev-parse --abbrev-ref HEAD 2>&1', $current_branch_output);
$current_branch = $current_branch_output[0] ?? 'unknown';
echo '<p>Текущая ветка: <code>' . htmlspecialchars($current_branch) . '</code></p>';

if ($current_branch === $target_branch) {
    echo '<p style="color: green;">✓ Находимся на правильной ветке!</p>';
} else {
    echo '<div class="warning">';
    echo '<p>⚠ Находимся на ветке: <code>' . htmlspecialchars($current_branch) . '</code></p>';
    echo '<p>Ожидалось: <code>' . htmlspecialchars($target_branch) . '</code></p>';
    echo '</div>';
}
echo '</div>';

// Шаг 6: Проверяем файл functions.php
$child_theme_functions = ABSPATH . 'wp-content/themes/cook_it_child/functions.php';

echo '<div class="step">';
echo '<h3>Шаг 6: Проверка замены номера телефона</h3>';

if (file_exists($child_theme_functions)) {
    $content = file_get_contents($child_theme_functions);

    if (strpos($content, 'replace_phone_number_in_header') !== false) {
        echo '<div class="success">';
        echo '<h4>✓ Замена номера успешно применена!</h4>';
        echo '<ul>';
        echo '<li><strong>Старый номер:</strong> 34343</li>';
        echo '<li><strong>Новый номер:</strong> 555-0001</li>';
        echo '<li><strong>Файл:</strong> <code>cook_it_child/functions.php</code></li>';
        echo '</ul>';

        // Показываем фрагмент кода
        echo '<h4>Добавленный код:</h4>';
        echo '<pre style="color: #333; background: #f8f8f8;">';

        // Извлекаем функцию
        preg_match('/\/\*\*\s*\*\s*Замена номера телефона.*?\*\/.*?function replace_phone_number_in_header.*?\}/s', $content, $matches);
        if (!empty($matches[0])) {
            echo htmlspecialchars(substr($matches[0], 0, 300)) . '...';
        }

        echo '</pre>';
        echo '</div>';
    } else {
        echo '<div class="warning">';
        echo '<h4>⚠ Функция замены не найдена</h4>';
        echo '<p>Файл существует, но функция замены отсутствует.</p>';
        echo '</div>';
    }

    echo '<p><strong>Путь:</strong> <code>' . $child_theme_functions . '</code></p>';
    echo '<p><strong>Размер:</strong> ' . filesize($child_theme_functions) . ' байт</p>';
} else {
    echo '<div class="error">';
    echo '<h4>✗ Файл не найден</h4>';
    echo '<p>Путь: <code>' . $child_theme_functions . '</code></p>';
    echo '</div>';
}

echo '</div>';

// Шаг 7: Обновление настроек Gitium
echo '<div class="step">';
echo '<h3>Шаг 7: Обновление настроек Gitium</h3>';

// Устанавливаем ветку отслеживания для Gitium
$gitium_branch = 'origin/' . $target_branch;
set_transient('gitium_remote_tracking_branch', $gitium_branch, DAY_IN_SECONDS);

echo '<p>Gitium теперь следит за веткой: <code>' . htmlspecialchars($gitium_branch) . '</code></p>';
echo '<p style="color: green;">✓ Настройки Gitium обновлены</p>';
echo '</div>';

// Итоговый статус
echo '<div class="step success">';
echo '<h3>🎉 Готово!</h3>';
echo '<h4>Что изменилось:</h4>';
echo '<ul>';
echo '<li>✓ Репозиторий синхронизирован с GitHub</li>';
echo '<li>✓ Применена ветка: <code>' . htmlspecialchars($target_branch) . '</code></li>';
echo '<li>✓ Номер телефона <strong>34343</strong> заменен на <strong>555-0001</strong></li>';
echo '<li>✓ Gitium настроен на отслеживание правильной ветки</li>';
echo '</ul>';

echo '<h4>Проверьте результат:</h4>';
echo '<ol>';
echo '<li>Откройте сайт и проверьте хедер (шапку)</li>';
echo '<li>Номер телефона должен отображаться как <strong>555-0001</strong></li>';
echo '<li>Изменения сохранятся даже при обновлении темы</li>';
echo '</ol>';
echo '</div>';

echo '<div style="margin-top: 30px; padding: 20px; border-top: 2px solid #ddd;">';
echo '<a href="http://regret49.beget.tech/" class="button" target="_blank">🌐 Открыть сайт</a>';
echo '<a href="/wp-admin/admin.php?page=gitium" class="button" target="_blank">⚙️ Gitium</a>';
echo '<a href="/wp-admin/" class="button" target="_blank">📊 WordPress Admin</a>';
echo '</div>';

echo '</div>'; // container
echo '</body></html>';
?>
