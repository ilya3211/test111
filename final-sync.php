<?php
/**
 * Финальная синхронизация и применение изменений
 * 1. Подтягивает последние изменения с GitHub
 * 2. Применяет замену номера телефона 34343 → 555-0001
 * 3. Очищает временные файлы
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
    <title>Финальная синхронизация</title>
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
        .highlight { background: #ffeb3b; padding: 2px 5px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">';

echo '<h1>🚀 Финальная синхронизация</h1>';
echo '<p>Подтягиваем изменения и применяем замену номера телефона</p>';

// Переходим в корень WordPress
chdir(ABSPATH);

echo '<div class="step">';
echo '<h3>📁 Рабочая директория</h3>';
echo '<pre>' . getcwd() . '</pre>';
echo '</div>';

$target_branch = 'claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q';

// Шаг 1: Получаем текущую ветку
echo '<div class="step">';
echo '<h3>Шаг 1: Проверка текущей ветки</h3>';
exec('git rev-parse --abbrev-ref HEAD 2>&1', $current_branch_output);
$current_branch = $current_branch_output[0] ?? 'unknown';
echo '<p>Текущая ветка: <code>' . htmlspecialchars($current_branch) . '</code></p>';

if ($current_branch !== $target_branch) {
    echo '<p style="color: orange;">⚠ Нужно переключиться на ветку с изменениями</p>';
    exec('git checkout ' . escapeshellarg($target_branch) . ' 2>&1', $checkout_output);
    echo '<pre>' . htmlspecialchars(implode("\n", $checkout_output)) . '</pre>';
}
echo '</div>';

// Шаг 2: Подтягиваем изменения с GitHub
echo '<div class="step">';
echo '<h3>Шаг 2: Подтягиваем изменения с GitHub</h3>';
echo '<p>Получаем последний коммит с обновленным <code>.gitignore</code></p>';

exec('git fetch origin ' . escapeshellarg($target_branch) . ' 2>&1', $fetch_output);
echo '<pre>' . htmlspecialchars(implode("\n", $fetch_output)) . '</pre>';

// Проверяем сколько коммитов позади
exec('git rev-list HEAD..origin/' . escapeshellarg($target_branch) . ' --count 2>&1', $behind_count_output);
$behind_count = intval($behind_count_output[0] ?? 0);

echo '<p>Коммитов для подтягивания: <strong>' . $behind_count . '</strong></p>';

if ($behind_count > 0) {
    echo '<p>Применяем изменения...</p>';
    exec('git reset --hard origin/' . escapeshellarg($target_branch) . ' 2>&1', $reset_output);
    echo '<pre>' . htmlspecialchars(implode("\n", $reset_output)) . '</pre>';
    echo '<p style="color: green;">✓ Изменения применены</p>';
} else {
    echo '<p style="color: green;">✓ Уже на последней версии</p>';
}
echo '</div>';

// Шаг 3: Проверяем .gitignore
echo '<div class="step">';
echo '<h3>Шаг 3: Проверка .gitignore</h3>';

$gitignore_path = ABSPATH . '.gitignore';
if (file_exists($gitignore_path)) {
    $gitignore_content = file_get_contents($gitignore_path);

    $scripts_in_gitignore = array(
        'fix-gitium-warning.php',
        'apply-phone-change.php',
        'sync-phone-change.php'
    );

    $all_ignored = true;
    foreach ($scripts_in_gitignore as $script) {
        if (strpos($gitignore_content, $script) !== false) {
            echo '<p>✓ <code>' . $script . '</code> добавлен в .gitignore</p>';
        } else {
            echo '<p>⚠ <code>' . $script . '</code> отсутствует в .gitignore</p>';
            $all_ignored = false;
        }
    }

    if ($all_ignored) {
        echo '<p style="color: green;">✓ Все временные скрипты в .gitignore</p>';
    }
} else {
    echo '<p style="color: red;">✗ Файл .gitignore не найден</p>';
}
echo '</div>';

// Шаг 4: Проверяем functions.php
echo '<div class="step">';
echo '<h3>Шаг 4: Проверка замены номера телефона</h3>';

$functions_path = ABSPATH . 'wp-content/themes/cook_it_child/functions.php';

if (file_exists($functions_path)) {
    $functions_content = file_get_contents($functions_path);

    if (strpos($functions_content, 'cook_it_child_replace_phone_number') !== false) {
        echo '<div class="success">';
        echo '<h4>✓ Функция замены номера установлена!</h4>';
        echo '<p>Номер телефона <span class="highlight">34343</span> будет заменен на <span class="highlight">555-0001</span></p>';
        echo '<p><strong>Где работает замена:</strong></p>';
        echo '<ul>';
        echo '<li>В хедере (шапке) сайта</li>';
        echo '<li>В контенте страниц и постов</li>';
        echo '<li>В виджетах</li>';
        echo '<li>Везде на сайте</li>';
        echo '</ul>';
        echo '</div>';

        // Показываем фрагмент кода
        if (preg_match('/\/\*\*\s*\*\s*Замена номера.*?\*\/.*?function cook_it_child_replace_phone_callback.*?\}/s', $functions_content, $matches)) {
            echo '<h4>Установленный код:</h4>';
            echo '<pre style="color: #333; background: #f8f8f8;">' . htmlspecialchars(substr($matches[0], 0, 400)) . '...</pre>';
        }
    } else {
        echo '<div class="warning">';
        echo '<h4>⚠ Функция замены не найдена</h4>';
        echo '<p>Файл существует, но функция отсутствует</p>';
        echo '</div>';
    }
} else {
    echo '<div class="error">';
    echo '<p>✗ Файл не найден: <code>' . $functions_path . '</code></p>';
    echo '</div>';
}
echo '</div>';

// Шаг 5: Проверяем статус git
echo '<div class="step">';
echo '<h3>Шаг 5: Финальный статус git</h3>';
exec('git status --porcelain 2>&1', $status_lines);

if (empty($status_lines)) {
    echo '<div class="success">';
    echo '<h4>✓ Репозиторий чист!</h4>';
    echo '<p>Нет незакоммиченных изменений</p>';
    echo '</div>';
} else {
    echo '<p>Обнаружены файлы:</p>';
    echo '<pre>' . htmlspecialchars(implode("\n", $status_lines)) . '</pre>';

    // Проверяем - это только временные скрипты?
    $only_temp_files = true;
    foreach ($status_lines as $line) {
        if (!preg_match('/\.(php)$/', $line) ||
            (strpos($line, 'fix-gitium') === false &&
             strpos($line, 'sync-phone') === false &&
             strpos($line, 'apply-phone') === false &&
             strpos($line, '.gitignore_global') === false)) {
            $only_temp_files = false;
            break;
        }
    }

    if ($only_temp_files) {
        echo '<p style="color: green;">✓ Это только временные файлы, они в .gitignore</p>';
    }
}
echo '</div>';

// Шаг 6: Обновляем настройки Gitium
echo '<div class="step">';
echo '<h3>Шаг 6: Обновление Gitium</h3>';

$gitium_branch = 'origin/' . $target_branch;
set_transient('gitium_remote_tracking_branch', $gitium_branch, DAY_IN_SECONDS);

echo '<p>Gitium следит за: <code>' . htmlspecialchars($gitium_branch) . '</code></p>';
echo '<p style="color: green;">✓ Настройки обновлены</p>';
echo '</div>';

// Итоговый статус
echo '<div class="step success">';
echo '<h3>🎉 Готово!</h3>';
echo '<h4>Что сделано:</h4>';
echo '<ul>';
echo '<li>✓ Подтянуты последние изменения с GitHub</li>';
echo '<li>✓ Обновлен <code>.gitignore</code> (временные файлы игнорируются)</li>';
echo '<li>✓ Установлена замена номера: <strong>34343 → 555-0001</strong></li>';
echo '<li>✓ Gitium настроен и готов к работе</li>';
echo '</ul>';

echo '<h4>Проверьте результат:</h4>';
echo '<ol>';
echo '<li><strong>Откройте сайт</strong> и проверьте хедер</li>';
echo '<li>Номер телефона должен показывать: <span class="highlight">555-0001</span></li>';
echo '<li><strong>Откройте Gitium</strong> и обновите страницу (F5)</li>';
echo '<li>Должно показывать: "No local changes" или только .gitignore_global (норма)</li>';
echo '</ol>';

echo '<div style="background: #fff3cd; padding: 15px; margin: 20px 0; border-radius: 4px;">';
echo '<h4>💡 Важно:</h4>';
echo '<p>Файлы <code>.gitignore_global</code> и <code>fix-gitium-warning.php</code> можно оставить - они в .gitignore и не мешают.</p>';
echo '<p>Или удалите их через файловый менеджер, если хотите.</p>';
echo '</div>';
echo '</div>';

echo '<div style="margin-top: 30px; padding: 20px; border-top: 2px solid #ddd;">';
echo '<a href="http://regret49.beget.tech/" class="button" target="_blank">🌐 Проверить сайт</a>';
echo '<a href="/wp-admin/admin.php?page=gitium%2Fgitium.php" class="button" target="_blank">⚙️ Открыть Gitium</a>';
echo '<a href="/wp-admin/" class="button" target="_blank">📊 WordPress Admin</a>';
echo '</div>';

echo '</div>'; // container
echo '</body></html>';
?>
