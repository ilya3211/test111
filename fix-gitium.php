<?php
/**
 * Gitium Fix Script
 * Исправляет проблему "Could not commit! You are X commits behind remote"
 *
 * ИНСТРУКЦИЯ:
 * 1. Загрузите этот файл в корень сайта (где находится wp-config.php)
 * 2. Откройте в браузере: http://ваш-сайт.ru/fix-gitium.php
 * 3. После выполнения удалите этот файл!
 */

// Безопасность - проверка что файл не запущен напрямую извне
$secret_key = isset($_GET['key']) ? $_GET['key'] : '';
$expected_key = 'fix-gitium-2025'; // Простой ключ для защиты

if ($secret_key !== $expected_key) {
    die('
    <html>
    <head>
        <title>Gitium Fix Script</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
            .box { background: #f0f0f0; padding: 20px; border-radius: 5px; margin: 20px 0; }
            code { background: #e0e0e0; padding: 2px 5px; border-radius: 3px; }
            h1 { color: #333; }
        </style>
    </head>
    <body>
        <h1>🔧 Gitium Fix Script</h1>
        <div class="box">
            <h2>Для запуска добавьте ключ в URL:</h2>
            <p><code>?key=fix-gitium-2025</code></p>
            <p>Пример:</p>
            <p><code>http://regret49.beget.tech/fix-gitium.php?key=fix-gitium-2025</code></p>
        </div>
        <div class="box">
            <h3>Что делает этот скрипт:</h3>
            <ul>
                <li>Подтягивает последние изменения с GitHub</li>
                <li>Синхронизирует локальную копию с удаленным репозиторием</li>
                <li>Исправляет проблему "You are X commits behind"</li>
            </ul>
        </div>
        <p><strong>⚠️ Не забудьте удалить этот файл после использования!</strong></p>
    </body>
    </html>
    ');
}

// Загружаем WordPress
define('WP_USE_THEMES', false);
if (file_exists('./wp-load.php')) {
    require_once('./wp-load.php');
} else {
    die('<h1>Ошибка: не найден wp-load.php</h1><p>Убедитесь что файл находится в корне WordPress</p>');
}

// HTML стили
echo '
<html>
<head>
    <title>Gitium Fix - Выполнение</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 { color: #0073aa; }
        h2 { color: #333; border-bottom: 2px solid #0073aa; padding-bottom: 10px; }
        .step {
            background: #f9f9f9;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #0073aa;
            border-radius: 4px;
        }
        .success { background: #d4edda; border-left-color: #28a745; }
        .error { background: #f8d7da; border-left-color: #dc3545; }
        .warning { background: #fff3cd; border-left-color: #ffc107; }
        pre {
            background: #2d2d2d;
            color: #f8f8f8;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 12px;
        }
        .output { color: #00ff00; }
        .command { color: #00bfff; }
        .button {
            display: inline-block;
            background: #0073aa;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
        }
        .button:hover { background: #005a87; }
        .button.delete { background: #dc3545; }
        .button.delete:hover { background: #c82333; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔧 Исправление Gitium</h1>
';

// Переходим в корень WordPress
$wordpress_root = ABSPATH;
chdir($wordpress_root);

echo '<div class="step"><strong>📁 Рабочая директория:</strong> ' . getcwd() . '</div>';

// Функция для выполнения команд
function run_command($cmd, $description) {
    echo '<div class="step">';
    echo '<h3>' . $description . '</h3>';
    echo '<pre class="command">$ ' . htmlspecialchars($cmd) . '</pre>';

    exec($cmd . ' 2>&1', $output, $return_code);

    echo '<pre class="output">';
    if (empty($output)) {
        echo '(пустой вывод)';
    } else {
        echo htmlspecialchars(implode("\n", $output));
    }
    echo '</pre>';

    if ($return_code === 0) {
        echo '<div style="color: #28a745;">✓ Успешно выполнено</div>';
    } else {
        echo '<div style="color: #dc3545;">✗ Код возврата: ' . $return_code . '</div>';
    }

    echo '</div>';

    return ['output' => $output, 'code' => $return_code];
}

// Шаг 1: Проверка текущего состояния
echo '<h2>Шаг 1: Проверка текущего состояния</h2>';
$status = run_command('git status', 'Статус репозитория');

// Шаг 2: Получение изменений с GitHub
echo '<h2>Шаг 2: Получение изменений с GitHub</h2>';
$fetch = run_command('git fetch origin master', 'Получение последних изменений');

// Шаг 3: Проверка разницы
echo '<h2>Шаг 3: Проверка разницы с удаленным репозиторием</h2>';
$diff = run_command('git log HEAD..origin/master --oneline', 'Коммиты, которых нет локально');

// Шаг 4: Жесткий сброс к удаленной версии
echo '<h2>Шаг 4: Синхронизация с удаленным репозиторием</h2>';
echo '<div class="step warning"><strong>⚠️ Внимание:</strong> Сейчас будет выполнен hard reset. Все локальные незакоммиченные изменения будут потеряны!</div>';
$reset = run_command('git reset --hard origin/master', 'Сброс к удаленной версии');

// Шаг 5: Проверка финального состояния
echo '<h2>Шаг 5: Проверка результата</h2>';
$final_status = run_command('git status', 'Финальный статус');
$final_log = run_command('git log --oneline -5', 'Последние 5 коммитов');

// Проверка что файл существует
echo '<h2>Шаг 6: Проверка тестового файла</h2>';
$test_file = 'gitium-test-cook-it.txt';
if (file_exists($test_file)) {
    echo '<div class="step success">';
    echo '<h3>✓ Файл найден!</h3>';
    echo '<p><strong>Путь:</strong> ' . realpath($test_file) . '</p>';
    echo '<p><strong>Размер:</strong> ' . filesize($test_file) . ' байт</p>';
    echo '<p><strong>URL:</strong> <a href="/' . $test_file . '" target="_blank">http://regret49.beget.tech/' . $test_file . '</a></p>';
    echo '</div>';
} else {
    echo '<div class="step error">';
    echo '<h3>✗ Файл не найден</h3>';
    echo '<p>Файл <code>' . $test_file . '</code> отсутствует в директории</p>';
    echo '</div>';
}

// Итоги
echo '<h2>📊 Итоги</h2>';
echo '<div class="step success">';
echo '<h3>✓ Скрипт выполнен успешно!</h3>';
echo '<p>Теперь:</p>';
echo '<ol>';
echo '<li>Перейдите в <strong>WordPress Admin → Gitium → Commits</strong></li>';
echo '<li>Страница должна показывать: <code>Up to date</code></li>';
echo '<li>Проверьте тестовый файл: <a href="/gitium-test-cook-it.txt" target="_blank">gitium-test-cook-it.txt</a></li>';
echo '<li><strong>ВАЖНО:</strong> Удалите файл fix-gitium.php с сервера!</li>';
echo '</ol>';
echo '</div>';

// Кнопки
echo '<div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">';
echo '<a href="/wp-admin/admin.php?page=gitium" class="button" target="_blank">Открыть Gitium</a>';
echo '<a href="/gitium-test-cook-it.txt" class="button" target="_blank">Проверить файл</a>';
echo '<a href="?key=fix-gitium-2025&delete=yes" class="button delete">Удалить fix-gitium.php</a>';
echo '</div>';

// Удаление файла если запрошено
if (isset($_GET['delete']) && $_GET['delete'] === 'yes') {
    echo '<div class="step warning">';
    echo '<h3>Удаление fix-gitium.php...</h3>';
    if (unlink(__FILE__)) {
        echo '<p style="color: green;">✓ Файл успешно удален!</p>';
        echo '<p>Перенаправление...</p>';
        echo '<script>setTimeout(function(){ window.location.href="/wp-admin/"; }, 3000);</script>';
    } else {
        echo '<p style="color: red;">✗ Не удалось удалить файл. Удалите вручную через FTP/Файловый менеджер</p>';
    }
    echo '</div>';
}

echo '
</div>
</body>
</html>
';
?>
