# ❌ НЕ заполняйте форму "Install Theme"!

## Вы открыли НЕ ту форму

Форма **"Install Theme"** в Deployer for Git предназначена для установки **отдельной темы** из её собственного репозитория.

### Пример когда это нужно:
```
У вас есть репозиторий ТОЛЬКО с темой:
https://github.com/username/my-wordpress-theme/
└── style.css
└── functions.php
└── index.php
└── ... (только файлы темы)

Тогда вы заполняете:
Provider Type: GitHub
Repository URL: https://github.com/username/my-wordpress-theme
Branch: main
```

---

## ❌ Ваш случай - ДРУГОЙ!

У вас репозиторий со ВСЕМ сайтом:
```
https://github.com/ilya3211/test111/
├── wp-content/
│   ├── themes/
│   │   ├── cook-it/
│   │   ├── twentytwentyfour/
│   │   └── ...
│   ├── plugins/
│   └── languages/
├── test/
├── test2/
├── .gitignore
└── ... (весь WordPress)
```

Для такого репозитория **"Install Theme" НЕ РАБОТАЕТ!**

---

## ✅ Что делать ПРАВИЛЬНО

### Вариант 1: Gitium (РЕКОМЕНДУЮ)

**Это то, что вам нужно!**

1. **Закройте** форму "Install Theme"
2. **Откройте**: WordPress Admin → Settings → Gitium
3. **Активируйте** плагин (если не активирован)
4. **Настройте**:
   ```
   Remote URL: https://github.com/ilya3211/test111.git
   Branch: claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb
   ```
5. **Готово!** Gitium будет управлять всем сайтом

**Полная инструкция**: См. файл `GITIUM_SETUP.md`

---

### Вариант 2: Deployer for Git (только для отдельной темы)

Если хотите использовать Deployer for Git для автообновления **только одной темы** (например, cook-it):

1. Создайте отдельный репозиторий ТОЛЬКО для темы
2. Переместите тему в этот репозиторий
3. Тогда заполните форму "Install Theme":
   ```
   Provider Type: GitHub
   Repository URL: https://github.com/ilya3211/cook-it-theme
   Branch: main
   ```

**НО**: Это не решит вашу задачу с автодеплоем всего сайта!

---

## Сравнение: Что вам нужно

| Задача | Правильный инструмент |
|--------|----------------------|
| Автодеплой ВСЕГО сайта | ✅ **Gitium** |
| Автодеплой одной темы | Deployer for Git: Install Theme |
| Автодеплой одного плагина | Deployer for Git: Install Plugin |
| Работа с Claude Code | ✅ **Gitium** |

---

## Что делать ПРЯМО СЕЙЧАС

### Шаг 1: Закройте форму "Install Theme"
Она вам не нужна для вашего случая.

### Шаг 2: Откройте Gitium
```
WordPress Admin → Плагины → Gitium → Активировать
```

### Шаг 3: Настройте Gitium
```
Settings → Gitium

Заполните:
Remote URL: https://github.com/ilya3211/test111.git
Branch: claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb

Если приватный репозиторий:
Remote URL: https://TOKEN@github.com/ilya3211/test111.git
```

### Шаг 4: Добавьте webhook в GitHub
```
GitHub → Settings → Webhooks → Add webhook
Payload URL: [скопируйте из Gitium]
```

### Шаг 5: Готово!
Скажите мне: **"Claude, создай тестовый файл для проверки Gitium"**

Я сделаю push, и через 10-30 секунд изменения появятся на сайте!

---

## FAQ

### Q: А можно ли использовать Deployer for Git для всего сайта?
**A**: Нет, этот плагин работает только с отдельными темами/плагинами.

### Q: У меня приватный репозиторий, Gitium будет работать?
**A**: Да! Используйте Personal Access Token в URL:
```
https://ghp_xxxxxxxxxxxx@github.com/ilya3211/test111.git
```

### Q: Нужно ли мне заполнять форму "Install Theme"?
**A**: НЕТ! Вам нужен Gitium.

### Q: Что если я уже заполнил форму "Install Theme"?
**A**: Ничего страшного, просто не работает. Используйте Gitium.

### Q: Gitium требует Git на сервере?
**A**: Да, но у вас Git уже установлен (v2.43.0) ✅

---

## Визуальная схема

```
❌ НЕПРАВИЛЬНО:
┌─────────────────────────────────────┐
│  Deployer for Git → Install Theme   │
│                                     │
│  Provider: GitHub                   │
│  URL: ilya3211/test111             │
│  Branch: claude/analyze-...        │
└─────────────────────────────────────┘
        ↓
    НЕ РАБОТАЕТ!
    (плагин ожидает репозиторий только с темой)


✅ ПРАВИЛЬНО:
┌─────────────────────────────────────┐
│  Settings → Gitium                  │
│                                     │
│  Remote: github.com/ilya3211/test111│
│  Branch: claude/analyze-...         │
└─────────────────────────────────────┘
        ↓
    ✅ РАБОТАЕТ!
    (Gitium работает со всем сайтом)
```

---

## Итог

1. ❌ **НЕ используйте** форму "Install Theme"
2. ✅ **Используйте** Gitium для всего сайта
3. 📖 **Читайте** GITIUM_SETUP.md для подробностей
4. 🚀 **Готово** - начинайте работать с автодеплоем!

---

**Нужна помощь с настройкой Gitium?** Просто спросите!
