# К СЕБЕ - Быстрая шпаргалка
## Quick Reference Guide

**Версия:** 1.0 | **Обновлено:** Ноябрь 2024

---

## 📁 Файлы

| Файл | Размер | Описание |
|------|--------|----------|
| `style-k-sebe-cards.css` | 18 KB | ⭐ **Основной файл стилей** |
| `functions.php` | | PHP подключение |
| `README.md` | | Полная документация |
| `STYLE-MAP.md` | | Карта стилей (этот файл) |

---

## 🎨 Цвета (копируй-вставляй)

```css
#FF9966  /* Оранжевый (primary) */
#FF8C5A  /* Темно-оранжевый (hover) */
#FFB800  /* Золотой (звёзды) */
#333     /* Текст */
#666     /* Вторичный текст */
#999     /* Светлый текст */
#F9F9F9  /* Фон страницы */
#fff     /* Фон карточек */
#e0e0e0  /* Границы */
```

---

## ⚡ Частые задачи

### 1. Изменить основной цвет

```css
/* style-k-sebe-cards.css - строка 2 */
:root {
    --ksebe-primary: #3498db; /* Синий вместо оранжевого */
}
```

### 2. Увеличить badge

```css
/* style-k-sebe-cards.css - строка ~390 */
.content-card__image .entry-category {
    font-size: 11px !important;
    padding: 4px 10px !important;
}
```

### 3. Изменить цвет звёзд

```css
/* style-k-sebe-cards.css - строка ~470 */
.star-rating-item svg path {
    fill: #FF6B6B !important; /* Красные звёзды */
}
```

### 4. Отключить тени

```css
.content-card,
.entry-rating,
.nutritional {
    box-shadow: none !important;
}
```

### 5. Изменить иконку времени

```css
/* style-k-sebe-cards.css - строка ~234 */
.meta-cooking-time::before {
    content: "⏱️" !important;
}
```

---

## 🔍 Где что находится?

| Что ищу? | Файл | Строка | Селектор |
|----------|------|--------|----------|
| Цвета | style-k-sebe-cards.css | 1-20 | `:root` |
| Badge размер | style-k-sebe-cards.css | ~390 | `.entry-category` |
| Badge цвет | style-k-sebe-cards.css | ~388 | `.entry-category` |
| Цвет звёзд | style-k-sebe-cards.css | ~470 | `.star-rating-item svg path` |
| Hover карточки | style-k-sebe-cards.css | ~60 | `.content-card:hover` |
| Радиус углов | style-k-sebe-cards.css | 13 | `--ksebe-radius` |
| Иконки мета | style-k-sebe-cards.css | 234-240 | `.meta-*::before` |
| Nutritional gap | style-k-sebe-cards.css | ~297 | `.nutritional-list` |

---

## 🐛 Быстрые фиксы

### Стили не применяются?
```
1. Очистить кеш WordPress
2. Ctrl+Shift+R в браузере
3. Проверить загрузку: View Source → найти style-k-sebe-cards.css
```

### Badge синий?
```css
/* Проверить строку ~387 */
.entry-category a {
    background-color: transparent !important;
}
```

### Текст накладывается в nutritional?
```css
/* Проверить строку ~297 */
.nutritional-list {
    gap: 10px;
}
```

### Badge прыгает при hover?
```css
/* Проверить строку ~402 */
.content-card:hover .entry-category {
    bottom: 10px !important;
}
```

---

## 📐 Размеры

### Desktop
```
Badge: 9px, padding 2px 6px
Title: 20px
Card: 20px padding, 12px radius
Meta: 13px
```

### Tablet (max-width: 968px)
```
Badge: 9px
Title: 18px
Card: 18px padding
Meta: 12px
```

### Mobile (max-width: 640px)
```
Badge: 8px, padding 2px 5px
Title: 16px
Card: 15px padding, 10px radius
Meta: 11px
```

---

## 🎯 Основные селекторы

```css
/* Карточка */
.content-card
.content-card--line
.content-card__image
.content-card__body
.content-card__title
.content-card__meta
.content-card__excerpt

/* Badge */
.entry-category
.entry-category a

/* Рейтинг */
.entry-rating
.wp-star-rating
.star-rating-item
.rating-text

/* Nutritional */
.nutritional
.nutritional__header
.nutritional-list
.nutritional-list .strong

/* Meta */
.meta-cooking-time   /* 💸 */
.meta-serves         /* 👥 */
.meta-views          /* 👁 */
.meta-comments       /* 💬 */
.meta-date           /* 📅 */
```

---

## 🔧 functions.php

### Подключение CSS (строка 18-28)

```php
$css_file = get_stylesheet_directory() . '/style-k-sebe-cards.css';
$css_version = file_exists($css_file) ? filemtime($css_file) : '1.0.2';

wp_enqueue_style(
    'k-sebe-cards',
    get_stylesheet_directory_uri() . '/style-k-sebe-cards.css',
    array( 'cook-it-style-child' ),
    $css_version  // ⭐ Auto cache busting
);
```

**Важно:** Версия обновляется автоматически при изменении файла!

---

## 📱 Breakpoints

```css
/* Desktop */
По умолчанию (без media query)

/* Tablet */
@media (max-width: 968px) { }

/* Mobile */
@media (max-width: 640px) { }
```

---

## ⚠️ НЕ УДАЛЯТЬ!

Эти стили критичны для работы:

1. **`.entry-category a { background-color: transparent !important; }`**
   - Без этого badge будет синим

2. **`.nutritional-list { gap: 10px; }`**
   - Без этого текст накладывается

3. **`.content-card:hover .entry-category { bottom: 10px !important; }`**
   - Без этого badge прыгает

4. **`.star-rating--score-5` стили (строки 480-510)**
   - Без этого рейтинг 4.65 показывает 5 звёзд

5. **`.entry-category a:link, :visited, :hover, etc.`**
   - Без этого ссылки синие/фиолетовые

---

## 📊 Приоритет загрузки CSS

```
cook-it/style.css               (родительская тема)
    ↓
cook-it-child/style.css         (базовая детская)
    ↓
cook-it-child/style-k-sebe-cards.css   (⭐ К СЕБЕ стили - последний)
```

**Важно:** К СЕБЕ стили загружаются последними, поэтому перебивают всё остальное.

---

## 🎨 CSS Переменные

```css
:root {
    --ksebe-primary: #FF9966;
    --ksebe-primary-dark: #FF8C5A;
    --ksebe-text: #333;
    --ksebe-text-light: #666;
    --ksebe-text-lighter: #999;
    --ksebe-bg: #F9F9F9;
    --ksebe-card-bg: #fff;
    --ksebe-border: #e0e0e0;
    --ksebe-shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
    --ksebe-shadow-md: 0 2px 12px rgba(0,0,0,0.06);
    --ksebe-radius: 12px;
    --ksebe-radius-sm: 8px;
}
```

**Использование:**
```css
.my-element {
    color: var(--ksebe-primary);
    border-radius: var(--ksebe-radius);
}
```

---

## 💡 Примеры кода

### Новый badge справа-сверху

```css
.content-card__custom-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--ksebe-primary);
    color: #fff;
    padding: 4px 8px;
    border-radius: var(--ksebe-radius-sm);
    font-size: 10px;
}
```

### Изменить hover на scale

```css
.content-card:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}
```

### Анимация появления

```css
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.content-card {
    animation: fadeIn 0.5s ease-out;
}
```

---

## 📞 Помощь

### Полная документация
→ `README.md`

### Карта стилей (детально)
→ `STYLE-MAP.md`

### Эта шпаргалка
→ `QUICK-REFERENCE.md`

---

## ✅ Checklist после изменений

- [ ] Изменения внесены в `style-k-sebe-cards.css`
- [ ] Сохранён файл
- [ ] Закоммичено в Git
- [ ] Запушено в ветку
- [ ] Применено в Gitium
- [ ] Очищен кеш WordPress
- [ ] Очищен кеш браузера (Ctrl+Shift+R)
- [ ] Проверено на desktop
- [ ] Проверено на tablet
- [ ] Проверено на mobile

---

**Последнее обновление:** Ноябрь 2024
