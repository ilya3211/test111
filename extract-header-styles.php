<?php
/**
 * Извлечение и анализ стилей хедера
 */

// Читаем CSS файл
$css_file = __DIR__ . '/wp-content/themes/cook-it/assets/css/style.min.css';
$css_content = file_get_contents($css_file);

// Функция для красивого форматирования CSS
function beautify_css($css) {
    $css = preg_replace('/\s+/', ' ', $css); // Убираем лишние пробелы
    $css = str_replace('{', " {\n    ", $css);
    $css = str_replace('}', "\n}\n\n", $css);
    $css = str_replace(';', ";\n    ", $css);
    return $css;
}

// Ищем все стили связанные с header
$patterns = [
    '\.site-header[^{]*{[^}]*}',
    '\.header-[a-z\-_0-9]+[^{]*{[^}]*}',
    '\.site-header-inner[^{]*{[^}]*}',
    '\.site-branding[^{]*{[^}]*}',
];

$header_styles = [];

foreach ($patterns as $pattern) {
    preg_match_all('/' . $pattern . '/i', $css_content, $matches);
    if (!empty($matches[0])) {
        $header_styles = array_merge($header_styles, $matches[0]);
    }
}

// HTML вывод
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Стили Header - Cook It Theme</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0073aa;
            border-bottom: 3px solid #0073aa;
            padding-bottom: 10px;
        }
        h2 {
            color: #333;
            margin-top: 30px;
            background: #f0f8ff;
            padding: 10px 15px;
            border-left: 4px solid #0073aa;
        }
        .css-block {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 4px;
            overflow-x: auto;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
        }
        .selector { color: #66d9ef; }
        .property { color: #f92672; }
        .value { color: #a6e22e; }
        .suggestion {
            background: #fff3cd;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
            border-radius: 4px;
        }
        .suggestion h3 {
            margin-top: 0;
            color: #856404;
        }
        .code-example {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        .preview {
            border: 2px solid #0073aa;
            padding: 15px;
            margin: 15px 0;
            background: white;
        }
        .option {
            background: #e7f3ff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            border-left: 3px solid #0073aa;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🎨 Стили Header темы Cook It</h1>
    <p><strong>Всего найдено стилей:</strong> <?php echo count($header_styles); ?></p>

    <h2>📋 Текущие стили хедера</h2>
    <?php
    // Показываем найденные стили
    $shown = 0;
    foreach (array_slice($header_styles, 0, 10) as $style) {
        $beautified = beautify_css($style);
        echo '<div class="css-block">' . htmlspecialchars($beautified) . '</div>';
        $shown++;
    }

    if (count($header_styles) > 10) {
        echo '<p><em>Показано первых ' . $shown . ' из ' . count($header_styles) . ' стилей</em></p>';
    }
    ?>

    <h2>💡 Варианты изменения хедера</h2>

    <div class="suggestion">
        <h3>1️⃣ Изменение цвета фона хедера</h3>
        <p><strong>Что изменить:</strong> Цвет фона шапки сайта</p>
        <div class="code-example">
<strong>/* Добавьте в style.css дочерней темы */</strong>

.site-header {
    background-color: #1a1a1a !important;  /* Темный фон */
}

<strong>/* Или светлый вариант */</strong>
.site-header {
    background-color: #ffffff !important;  /* Белый фон */
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

<strong>/* Или с градиентом */</strong>
.site-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
        </div>
    </div>

    <div class="suggestion">
        <h3>2️⃣ Изменение высоты и отступов</h3>
        <p><strong>Что изменить:</strong> Сделать хедер выше/ниже, изменить отступы</p>
        <div class="code-example">
<strong>/* Компактный хедер */</strong>
.site-header {
    padding: 10px 0 !important;
}

.site-branding img {
    max-height: 40px !important;  /* Меньший логотип */
}

<strong>/* Или просторный хедер */</strong>
.site-header {
    padding: 30px 0 !important;
}

.site-branding img {
    max-height: 80px !important;  /* Больший логотип */
}
        </div>
    </div>

    <div class="suggestion">
        <h3>3️⃣ Фиксированный (липкий) хедер</h3>
        <p><strong>Что изменить:</strong> Хедер остается вверху при прокрутке</p>
        <div class="code-example">
.site-header {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 9999 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

<strong>/* Компенсируем отступ для контента */</strong>
.site-content {
    margin-top: 100px !important;  /* Подберите под высоту хедера */
}
        </div>
    </div>

    <div class="suggestion">
        <h3>4️⃣ Стилизация телефона и контактов</h3>
        <p><strong>Что изменить:</strong> Внешний вид номера телефона в хедере</p>
        <div class="code-example">
<strong>/* Крупный заметный телефон */</strong>
.header-html-1,
.header-html-2 {
    font-size: 24px !important;
    font-weight: bold !important;
    color: #ff6b6b !important;
}

<strong>/* Телефон с иконкой и фоном */</strong>
.header-html-1 a,
.header-html-2 a {
    background: #4CAF50 !important;
    color: white !important;
    padding: 10px 20px !important;
    border-radius: 25px !important;
    text-decoration: none !important;
    display: inline-block !important;
}

.header-html-1 a:hover,
.header-html-2 a:hover {
    background: #45a049 !important;
    transform: scale(1.05);
    transition: all 0.3s ease;
}
        </div>
    </div>

    <div class="suggestion">
        <h3>5️⃣ Изменение цвета меню</h3>
        <p><strong>Что изменить:</strong> Цвета пунктов меню, hover эффекты</p>
        <div class="code-example">
<strong>/* Цвет пунктов меню */</strong>
.menu-top li a {
    color: #333 !important;
    font-weight: 600 !important;
}

<strong>/* При наведении */</strong>
.menu-top li a:hover {
    color: #ff6b6b !important;
    background: rgba(255,107,107,0.1) !important;
}

<strong>/* Активный пункт */</strong>
.menu-top li.current-menu-item a {
    color: #ff6b6b !important;
    border-bottom: 3px solid #ff6b6b !important;
}
        </div>
    </div>

    <div class="suggestion">
        <h3>6️⃣ Прозрачный хедер на главной</h3>
        <p><strong>Что изменить:</strong> Хедер поверх изображения на главной странице</p>
        <div class="code-example">
<strong>/* Только на главной странице */</strong>
.home .site-header {
    background: transparent !important;
    position: absolute !important;
    width: 100% !important;
}

.home .site-header .menu-top li a {
    color: white !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.home .site-content {
    padding-top: 100px !important;
}
        </div>
    </div>

    <div class="suggestion">
        <h3>7️⃣ Тени и эффекты</h3>
        <p><strong>Что изменить:</strong> Добавить глубину и современный вид</p>
        <div class="code-example">
<strong>/* Тень под хедером */</strong>
.site-header {
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
}

<strong>/* Граница снизу */</strong>
.site-header {
    border-bottom: 3px solid #ff6b6b !important;
}

<strong>/* Плавные переходы */</strong>
.site-header * {
    transition: all 0.3s ease !important;
}
        </div>
    </div>

    <div class="suggestion">
        <h3>8️⃣ Адаптивность для мобильных</h3>
        <p><strong>Что изменить:</strong> Оптимизация для телефонов и планшетов</p>
        <div class="code-example">
<strong>/* На экранах меньше 768px */</strong>
@media (max-width: 768px) {
    .site-header {
        padding: 15px 10px !important;
    }

    .header-html-1,
    .header-html-2 {
        font-size: 16px !important;
    }

    .site-branding img {
        max-height: 40px !important;
    }
}
        </div>
    </div>

    <h2>🎯 Как применить изменения</h2>
    <div class="option">
        <h4>Способ 1: Через дочернюю тему (РЕКОМЕНДУЕТСЯ)</h4>
        <p>Откройте: <code>wp-content/themes/cook_it_child/style.css</code></p>
        <p>Добавьте нужные стили в конец файла</p>
        <p><strong>Преимущества:</strong></p>
        <ul>
            <li>✓ Сохраняется при обновлении темы</li>
            <li>✓ Легко откатить изменения</li>
            <li>✓ Правильный подход</li>
        </ul>
    </div>

    <div class="option">
        <h4>Способ 2: Через Customizer</h4>
        <p>Перейдите: <strong>Внешний вид → Настроить → Дополнительный CSS</strong></p>
        <p>Вставьте нужные стили</p>
        <p><strong>Преимущества:</strong></p>
        <ul>
            <li>✓ Визуальный предпросмотр</li>
            <li>✓ Не нужно редактировать файлы</li>
            <li>✓ Быстро и удобно</li>
        </ul>
    </div>

    <h2>💻 Готовый пример для копирования</h2>
    <p>Современный стильный хедер - готовый код для вставки:</p>
    <div class="css-block">
/* ============================================
   СТИЛЬНЫЙ HEADER ДЛЯ COOK IT
   ============================================ */

/* Основной хедер */
.site-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    padding: 20px 0 !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
}

/* Логотип */
.site-branding img {
    max-height: 60px !important;
    transition: transform 0.3s ease !important;
}

.site-branding:hover img {
    transform: scale(1.05);
}

/* Телефон в хедере */
.header-html-1 a,
.header-html-2 a {
    background: rgba(255,255,255,0.2) !important;
    color: white !important;
    padding: 12px 24px !important;
    border-radius: 30px !important;
    text-decoration: none !important;
    font-weight: bold !important;
    font-size: 18px !important;
    display: inline-block !important;
    border: 2px solid rgba(255,255,255,0.3) !important;
    transition: all 0.3s ease !important;
}

.header-html-1 a:hover,
.header-html-2 a:hover {
    background: rgba(255,255,255,0.3) !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Меню */
.menu-top li a {
    color: white !important;
    font-weight: 600 !important;
    padding: 10px 15px !important;
    transition: all 0.3s ease !important;
}

.menu-top li a:hover {
    background: rgba(255,255,255,0.1) !important;
    border-radius: 5px;
}

/* Адаптивность */
@media (max-width: 768px) {
    .site-header {
        padding: 15px 0 !important;
    }

    .site-branding img {
        max-height: 45px !important;
    }

    .header-html-1 a,
    .header-html-2 a {
        font-size: 16px !important;
        padding: 10px 20px !important;
    }
}
    </div>

    <div style="background: #d4edda; padding: 20px; margin: 30px 0; border-radius: 8px; border-left: 4px solid #28a745;">
        <h3 style="margin-top: 0; color: #155724;">✅ Что дальше?</h3>
        <ol>
            <li>Выберите понравившийся вариант стилей выше</li>
            <li>Скопируйте код</li>
            <li>Вставьте в <code>wp-content/themes/cook_it_child/style.css</code></li>
            <li>Сохраните и проверьте на сайте!</li>
        </ol>
        <p><strong>Или создать через Claude Code?</strong> Скажите какой стиль хотите - я сразу создам файл и закоммичу!</p>
    </div>

    <div style="text-align: center; padding: 30px; border-top: 2px solid #ddd; margin-top: 30px;">
        <a href="http://regret49.beget.tech/" style="display: inline-block; background: #0073aa; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 10px;">
            🌐 Открыть сайт
        </a>
        <a href="/wp-admin/customize.php" style="display: inline-block; background: #0073aa; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 10px;">
            🎨 Открыть Customizer
        </a>
    </div>
</div>
</body>
</html>
