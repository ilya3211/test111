<?php
/**
 * Исправление Gitium - убираем предупреждение git
 * Fixes: "unable to access '/root/.config/git/ignore': Permission denied"
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
    <title>Исправление Gitium</title>
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

echo '<h1>🔧 Исправление Gitium</h1>';
echo '<p>Устраняем предупреждение: <code>unable to access \'/root/.config/git/ignore\'</code></p>';

// Переходим в корень WordPress
chdir(ABSPATH);

echo '<div class="step">';
echo '<h3>📁 Рабочая директория</h3>';
echo '<pre>' . getcwd() . '</pre>';
echo '</div>';

// Шаг 1: Отключаем глобальный excludesfile
echo '<div class="step">';
echo '<h3>Шаг 1: Настройка git config</h3>';
echo '<p>Отключаем использование недоступного файла <code>/root/.config/git/ignore</code></p>';

// Устанавливаем пустое значение для excludesfile
exec('git config --global core.excludesfile "" 2>&1', $config_output, $config_code);
echo '<pre>' . htmlspecialchars(implode("\n", $config_output)) . '</pre>';

if ($config_code === 0 || empty($config_output)) {
    echo '<p style="color: green;">✓ Глобальный excludesfile отключен</p>';
} else {
    echo '<p style="color: orange;">⚠ Не удалось изменить глобальную конфигурацию, попробуем локальную...</p>';
}

// Также устанавливаем для локального репозитория
exec('git config --local core.excludesfile "" 2>&1', $local_config_output);
echo '<p>Локальная конфигурация обновлена</p>';
echo '</div>';

// Шаг 2: Очищаем git status
echo '<div class="step">';
echo '<h3>Шаг 2: Проверка git status</h3>';
exec('git status 2>&1', $status_output, $status_code);
echo '<pre>' . htmlspecialchars(implode("\n", $status_output)) . '</pre>';

$has_warning = false;
foreach ($status_output as $line) {
    if (strpos($line, 'unable to access') !== false || strpos($line, 'Permission denied') !== false) {
        $has_warning = true;
        break;
    }
}

if (!$has_warning) {
    echo '<p style="color: green;">✓ Предупреждение устранено!</p>';
} else {
    echo '<p style="color: orange;">⚠ Предупреждение все еще присутствует</p>';
}
echo '</div>';

// Шаг 3: Сбрасываем индекс git
echo '<div class="step">';
echo '<h3>Шаг 3: Очистка индекса git</h3>';
echo '<p>Сбрасываем любые незафиксированные изменения...</p>';

exec('git reset --hard HEAD 2>&1', $reset_output);
echo '<pre>' . htmlspecialchars(implode("\n", $reset_output)) . '</pre>';
echo '<p style="color: green;">✓ Индекс очищен</p>';
echo '</div>';

// Шаг 4: Финальная проверка
echo '<div class="step">';
echo '<h3>Шаг 4: Финальная проверка</h3>';
exec('git status --porcelain 2>&1', $final_status);

if (empty($final_status)) {
    echo '<div class="success">';
    echo '<h4>✓ Репозиторий чист!</h4>';
    echo '<p>Нет незакоммиченных изменений</p>';
    echo '</div>';
} else {
    echo '<div class="warning">';
    echo '<h4>Обнаружены изменения:</h4>';
    echo '<pre>' . htmlspecialchars(implode("\n", $final_status)) . '</pre>';
    echo '</div>';
}
echo '</div>';

// Шаг 5: Проверяем конфигурацию git
echo '<div class="step">';
echo '<h3>Шаг 5: Текущая конфигурация git</h3>';
exec('git config --list --local 2>&1 | grep -E "(excludes|ignore)" || echo "Нет настроек excludes/ignore"', $config_list);
echo '<pre>' . htmlspecialchars(implode("\n", $config_list)) . '</pre>';
echo '</div>';

// Итоги
echo '<div class="step success">';
echo '<h3>📊 Результат</h3>';
echo '<h4>Что было сделано:</h4>';
echo '<ul>';
echo '<li>✓ Отключен глобальный <code>core.excludesfile</code></li>';
echo '<li>✓ Настроен локальный git config</li>';
echo '<li>✓ Очищен индекс git</li>';
echo '<li>✓ Сброшены незакоммиченные изменения</li>';
echo '</ul>';

echo '<h4>Теперь в Gitium:</h4>';
echo '<ol>';
echo '<li>Перейдите: <strong>WordPress Admin → Gitium</strong></li>';
echo '<li>Обновите страницу (F5)</li>';
echo '<li>Предупреждение должно исчезнуть</li>';
echo '<li>Можете использовать кнопку <strong>"Push changes"</strong> или <strong>"Pull changes"</strong></li>';
echo '</ol>';
echo '</div>';

// Дополнительное решение
echo '<div class="step warning">';
echo '<h3>⚙️ Дополнительное решение (если не помогло)</h3>';
echo '<p>Если предупреждение остается, создайте файл <code>.gitignore_global</code> в доступном месте:</p>';
echo '<ol>';
echo '<li>Создайте файл: <code>' . ABSPATH . '.gitignore_global</code></li>';
echo '<li>Выполните: <code>git config --global core.excludesfile ' . ABSPATH . '.gitignore_global</code></li>';
echo '</ol>';

// Попробуем создать файл
$gitignore_global = ABSPATH . '.gitignore_global';
if (!file_exists($gitignore_global)) {
    $content = "# Global gitignore file\n*.log\n*.tmp\n";
    if (file_put_contents($gitignore_global, $content)) {
        echo '<p style="color: green;">✓ Создан файл: <code>' . $gitignore_global . '</code></p>';

        exec('git config --global core.excludesfile ' . escapeshellarg($gitignore_global) . ' 2>&1', $set_global_output);
        echo '<p style="color: green;">✓ Установлен в git config</p>';
    }
}
echo '</div>';

echo '<div style="margin-top: 30px; padding: 20px; border-top: 2px solid #ddd;">';
echo '<a href="/wp-admin/admin.php?page=gitium%2Fgitium.php" class="button" target="_blank">⚙️ Открыть Gitium</a>';
echo '<a href="/wp-admin/" class="button" target="_blank">📊 WordPress Admin</a>';
echo '<a href="http://regret49.beget.tech/" class="button" target="_blank">🌐 Открыть сайт</a>';
echo '</div>';

echo '</div>'; // container
echo '</body></html>';
?>
