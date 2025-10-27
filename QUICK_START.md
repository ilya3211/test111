# Быстрый старт: Deployer for Git + Claude Code

## Что нужно сделать СЕЙЧАС (5 минут)

### 1. Активируйте плагин
```
WordPress Admin → Плагины → Deployer for Git → Активировать
```

### 2. Создайте GitHub токен
1. Откройте: https://github.com/settings/tokens/new
2. Название: `Deployer for Git - test111`
3. Права: ✅ `repo` (полный доступ)
4. Срок: `90 days` (или больше)
5. Нажмите **Generate token**
6. **ВАЖНО**: Скопируйте токен (он больше не будет показан!)

### 3. Добавьте репозиторий в плагин
```
WordPress Admin → Settings → Deployer for Git → Add Repository

Заполните:
├─ Repository Type: GitHub
├─ Repository URL: https://github.com/ilya3211/test111
├─ Branch: claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb
├─ Access Token: [вставьте токен из шага 2]
├─ Package Type: Full Site
└─ Deploy Path: /

Нажмите: Save
```

### 4. Настройте Webhook в GitHub
```
1. Откройте: https://github.com/ilya3211/test111/settings/hooks
2. Нажмите: Add webhook
3. Заполните:
   ├─ Payload URL: [скопируйте из плагина в WordPress]
   ├─ Content type: application/json
   ├─ Events: Just the push event
   └─ Active: ✅
4. Нажмите: Add webhook
```

### 5. Протестируйте
Скажите мне: **"Claude, создай тестовый файл для проверки деплоя"**

Я создам файл, сделаю commit и push. Через 10-30 секунд изменения должны появиться на вашем сайте!

---

## Как это работает дальше

После настройки вы просто говорите мне что нужно сделать:

### Примеры команд:
```
"Добавь страницу Контакты с формой обратной связи"
"Исправь баг в меню навигации"
"Создай новый виджет для сайдбара"
"Обнови дизайн главной страницы"
```

Я буду:
1. Вносить изменения в код
2. Делать commit
3. Делать push в ветку claude/*
4. GitHub отправит webhook
5. Deployer for Git применит изменения на сайте
6. ✅ Готово! (10-30 секунд)

---

## Проверка статуса

### Где смотреть логи деплоя:
```
WordPress Admin → Deployer for Git → Dashboard
```

Вы увидите:
- ✅ Последнее развертывание
- Дата и время
- Commit hash
- Статус (Success/Failed)

### Если что-то не работает:
```
GitHub → Settings → Webhooks → Recent Deliveries
```

Проверьте Response (должен быть 200 OK)

---

## Ручной деплой (если webhook не настроен)

Если не хотите возиться с webhook, можете обновлять вручную:

1. Я делаю изменения и push
2. Вы открываете: `Deployer for Git → Dashboard`
3. Нажимаете: **Deploy Now** или **Update**
4. Готово!

---

## Важно знать

### ✅ Что будет деплоиться:
- Темы (wp-content/themes/)
- Плагины (wp-content/plugins/)
- Любые файлы в корне проекта
- Изменения в test/ и test2/

### ❌ Что НЕ будет деплоиться (по .gitignore):
- Загруженные файлы (wp-content/uploads/)
- Кэш (wp-content/cache/)
- wp-config.php (конфигурация)
- База данных (.sql файлы)

### Безопасность:
- Я работаю только в ветках `claude/*`
- Вы можете проверить изменения перед слиянием в main
- Можно настроить уведомления на email

---

## Нужна помощь?

**Смотрите полную документацию**: `DEPLOYER_SETUP.md`

**Конфигурация**: `.deployer-config.json`

**Обратная связь**: Просто спросите меня!

---

Удачного деплоя! 🚀
