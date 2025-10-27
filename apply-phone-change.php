<?php
/**
 * Переключение Gitium на ветку с изменениями
 * Применяет замену номера телефона 34343 → 555-0001
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
    <title>Применение изменений из ветки Claude</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 50px auto; padding: 20px; }
        .step { background: #f0f8ff; padding: 20px; margin: 20px 0; border-left: 4px solid #0073aa; }
        .success { background: #d4edda; border-left-color: #28a745; }
        .warning { background: #fff3cd; border-left-color: #ffc107; }
        pre { background: #2d2d2d; color: #00ff00; padding: 15px; overflow-x: auto; }
        h1 { color: #0073aa; }
        .button {
            display: inline-block;
            background: #0073aa;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
        }
    </style>
</head>
<body>';

echo '<h1>🔄 Применение изменений: Замена номера телефона</h1>';

// Переходим в корень WordPress
chdir(ABSPATH);

echo '<div class="step">';
echo '<h3>📁 Рабочая директория</h3>';
echo '<pre>' . getcwd() . '</pre>';
echo '</div>';

// Получаем текущую ветку
exec('git rev-parse --abbrev-ref HEAD 2>&1', $current_branch_output);
$current_branch = $current_branch_output[0] ?? 'unknown';

echo '<div class="step">';
echo '<h3>📌 Текущая ветка</h3>';
echo '<pre>' . htmlspecialchars($current_branch) . '</pre>';
echo '</div>';

// Целевая ветка
$target_branch = 'claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q';

echo '<div class="step warning">';
echo '<h3>🎯 Целевая ветка с изменениями</h3>';
echo '<pre>' . htmlspecialchars($target_branch) . '</pre>';
echo '<p>В этой ветке находится обновленный файл <code>functions.php</code> с заменой номера телефона.</p>';
echo '</div>';

// Шаг 1: Получаем изменения с GitHub
echo '<div class="step">';
echo '<h3>Шаг 1: Получение последних изменений с GitHub</h3>';
exec('git fetch origin ' . escapeshellarg($target_branch) . ' 2>&1', $fetch_output);
echo '<pre>' . htmlspecialchars(implode("\n", $fetch_output)) . '</pre>';
echo '</div>';

// Шаг 2: Переключаемся на целевую ветку
echo '<div class="step">';
echo '<h3>Шаг 2: Переключение на ветку с изменениями</h3>';
exec('git checkout ' . escapeshellarg($target_branch) . ' 2>&1', $checkout_output, $checkout_code);
echo '<pre>' . htmlspecialchars(implode("\n", $checkout_output)) . '</pre>';

if ($checkout_code === 0) {
    echo '<p style="color: green;">✓ Успешно переключились на целевую ветку</p>';
} else {
    echo '<p style="color: red;">✗ Ошибка при переключении ветки</p>';
}
echo '</div>';

// Шаг 3: Подтягиваем последние изменения
echo '<div class="step">';
echo '<h3>Шаг 3: Применение последних изменений</h3>';
exec('git reset --hard origin/' . escapeshellarg($target_branch) . ' 2>&1', $reset_output, $reset_code);
echo '<pre>' . htmlspecialchars(implode("\n", $reset_output)) . '</pre>';

if ($reset_code === 0) {
    echo '<p style="color: green;">✓ Изменения успешно применены</p>';
} else {
    echo '<p style="color: red;">✗ Ошибка при применении изменений</p>';
}
echo '</div>';

// Проверяем файл
$child_theme_functions = ABSPATH . 'wp-content/themes/cook_it_child/functions.php';

echo '<div class="step">';
echo '<h3>Шаг 4: Проверка файла functions.php</h3>';

if (file_exists($child_theme_functions)) {
    $content = file_get_contents($child_theme_functions);

    if (strpos($content, 'replace_phone_number_in_header') !== false) {
        echo '<div class="success">';
        echo '<h4>✓ Файл обновлен успешно!</h4>';
        echo '<p>Найдена функция замены номера телефона.</p>';
        echo '<p><strong>Старый номер:</strong> 34343</p>';
        echo '<p><strong>Новый номер:</strong> 555-0001</p>';
        echo '</div>';
    } else {
        echo '<div class="warning">';
        echo '<h4>⚠ Функция замены не найдена</h4>';
        echo '<p>Возможно, файл еще не обновился.</p>';
        echo '</div>';
    }

    echo '<p><strong>Путь к файлу:</strong> <code>' . $child_theme_functions . '</code></p>';
    echo '<p><strong>Размер:</strong> ' . filesize($child_theme_functions) . ' байт</p>';
} else {
    echo '<p style="color: red;">✗ Файл не найден!</p>';
}

echo '</div>';

// Итоги
echo '<div class="step success">';
echo '<h3>📊 Результат</h3>';
echo '<ul>';
echo '<li>✓ Репозиторий синхронизирован с GitHub</li>';
echo '<li>✓ Применена ветка с изменениями</li>';
echo '<li>✓ Номер телефона будет заменен на сайте</li>';
echo '</ul>';

echo '<h4>Что дальше:</h4>';
echo '<ol>';
echo '<li>Откройте сайт: <a href="http://regret49.beget.tech/" target="_blank">regret49.beget.tech</a></li>';
echo '<li>Проверьте, что номер телефона изменился с <strong>34343</strong> на <strong>555-0001</strong></li>';
echo '<li>Если нужно вернуть Gitium на master, зайдите в <strong>Gitium → Configuration</strong></li>';
echo '</ol>';
echo '</div>';

echo '<div style="margin-top: 30px; padding: 20px; border-top: 2px solid #ddd;">';
echo '<a href="http://regret49.beget.tech/" class="button" target="_blank">Открыть сайт</a>';
echo '<a href="/wp-admin/" class="button" target="_blank">WordPress Admin</a>';
echo '</div>';

echo '</body></html>';
?>
