# Gitium: Полное руководство по настройке автоматического деплоя

## Почему Gitium, а не Deployer for Git?

### Deployer for Git (НЕ подходит):
- ❌ Работает только с отдельными темами/плагинами
- ❌ Требует, чтобы каждая тема была в своем репозитории
- ❌ Не может управлять всем WordPress сайтом

### Gitium (ИДЕАЛЬНО подходит):
- ✅ Управляет всем WordPress сайтом
- ✅ Работает с любой структурой репозитория
- ✅ Автоматический pull при push
- ✅ Webhook поддержка
- ✅ Git v2.43.0 уже установлен на сервере

---

## Быстрая настройка (5 минут)

### Шаг 1: Активируйте Gitium
```
WordPress Admin → Плагины → Gitium → Активировать
```

### Шаг 2: Откройте настройки Gitium
```
WordPress Admin → Settings → Gitium
```

### Шаг 3: Настройте SSH Key (если нужен)

Gitium покажет SSH ключ. Скопируйте его и добавьте в GitHub:

```
GitHub → Settings → SSH and GPG keys → New SSH key
```

**Или используйте HTTPS** (проще):
В следующих шагах выберите HTTPS URL вместо SSH.

### Шаг 4: Подключите репозиторий

В настройках Gitium заполните:

```
Remote URL: https://github.com/ilya3211/test111.git
Branch: claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb

Если приватный репозиторий, используйте:
https://YOUR_TOKEN@github.com/ilya3211/test111.git
```

Для создания токена:
1. GitHub → Settings → Developer settings → Personal access tokens
2. Generate new token (classic)
3. Права: ✅ repo (полный доступ)
4. Скопируйте токен

### Шаг 5: Сделайте первый Commit/Merge

Gitium автоматически обнаружит существующий Git репозиторий.

Если есть локальные изменения, Gitium предложит:
- **Commit** - закоммитить локальные изменения
- **Merge** - слить удаленные изменения

Выберите **Merge** чтобы подтянуть изменения из ветки Claude.

---

## Настройка автоматического Pull (Webhook)

### Опция 1: Webhook от GitHub (рекомендуется)

1. **В WordPress**: Скопируйте Webhook URL из Gitium
   ```
   Settings → Gitium → Webhook URL
   Пример: https://your-site.com/?gitium-webhook&k=SECRET_KEY
   ```

2. **В GitHub**: Добавьте webhook
   ```
   https://github.com/ilya3211/test111/settings/hooks

   Add webhook:
   ├─ Payload URL: [вставьте URL из Gitium]
   ├─ Content type: application/json
   ├─ Events: Just the push event
   └─ Active: ✅
   ```

3. **Готово!** Теперь при каждом push в ветку `claude/*` сайт автоматически обновится.

### Опция 2: Автоматический Pull по Cron (альтернатива)

Если webhook не работает, настройте автоматический pull каждые N минут:

```php
// Добавьте в wp-config.php:
define('GIT_WEBHOOK_URL', 'auto');
```

Gitium будет автоматически проверять обновления каждые 5 минут.

### Опция 3: Ручной Pull

В любой момент можете нажать **"Pull"** в:
```
Settings → Gitium → Pull from remote
```

---

## Как это работает с Claude

### Workflow:

```
1. Вы: "Claude, добавь форму обратной связи"
   ↓
2. Claude:
   - Создаю файлы
   - git add .
   - git commit -m "Add contact form"
   - git push origin claude/analyze-task-...
   ↓
3. GitHub: Получает push → отправляет webhook
   ↓
4. Gitium:
   - Получает webhook
   - git pull
   - Применяет изменения на сайте
   ↓
5. ✅ Готово! (10-30 секунд)
```

### Что будет автоматически деплоиться:

✅ Темы (wp-content/themes/)
✅ Плагины (wp-content/plugins/)
✅ Файлы test/ и test2/
✅ Любые изменения в wp-content/
❌ wp-config.php (игнорируется по .gitignore)
❌ Загрузки (wp-content/uploads/ - игнорируются)

---

## Безопасность

### Рекомендации:

1. **Работайте в ветках `claude/*`**:
   - Я всегда работаю в отдельных ветках
   - Вы можете проверить изменения перед слиянием в main

2. **Защитите webhook**:
   - Gitium генерирует секретный ключ в webhook URL
   - Никому не показывайте этот URL

3. **Бэкапы**:
   - Делайте регулярные бэкапы базы данных
   - Git не бэкапит БД, только файлы

4. **Проверка изменений**:
   - В Gitium → Commits можете видеть все изменения
   - Всегда можно откатиться к предыдущей версии

---

## Проверка работы

### Тест 1: Ручной Pull

1. Откройте: Settings → Gitium
2. Нажмите: **"Pull from remote"**
3. Должны увидеть: "Successfully pulled from remote"
4. Проверьте файл `deploy-test.txt` в корне WordPress

### Тест 2: Автоматический webhook

Скажите мне: **"Claude, создай тестовый файл для Gitium"**

Я создам файл, сделаю push, и через 10-30 секунд он появится на вашем сайте!

---

## Команды для работы

После настройки просто говорите:

- "Добавь страницу Контакты"
- "Исправь баг в меню"
- "Обнови дизайн главной"
- "Создай новый виджет"

Я делаю изменения → push → webhook → автоматический деплой! 🚀

---

## Отличия от Deployer for Git

| Функция | Deployer for Git | Gitium |
|---------|------------------|---------|
| Деплой всего сайта | ❌ Нет | ✅ Да |
| Деплой отдельной темы | ✅ Да | ❌ Не нужно |
| Отслеживание изменений | ❌ Нет | ✅ Да |
| Webhook | ✅ Да | ✅ Да |
| Работа с Git на сервере | ❌ Не требует | ✅ Требует |
| Ваш случай | ❌ Не подходит | ✅ Идеально! |

---

## Если что-то пошло не так

### Git конфликты

Если Gitium показывает конфликты:

1. Откройте: Settings → Gitium → Commits
2. Посмотрите что конфликтует
3. Можно:
   - **Reset to remote** - откатиться к удаленной версии
   - **Commit local** - сохранить локальные изменения
   - Решить вручную через SSH

### Webhook не работает

Проверьте:
1. GitHub → Settings → Webhooks → Recent Deliveries
2. Должен быть Response: 200 OK
3. Если ошибка - проверьте URL и доступность сайта

### Git не установлен

```bash
# Проверка:
git --version
# Должно показать: git version 2.43.0 ✅
```

---

## Резюме: Что делать СЕЙЧАС

1. **НЕ используйте** "Install Theme" в Deployer for Git
2. **Активируйте** Gitium (Settings → Plugins)
3. **Настройте** репозиторий в Gitium (Settings → Gitium)
4. **Добавьте** webhook в GitHub
5. **Скажите** мне создать тестовый файл для проверки
6. **Готово!** Все мои изменения будут автоматически применяться

---

**Нужна помощь?** Просто спросите, я помогу на каждом шаге!

**Файлы:**
- Эта инструкция: `GITIUM_SETUP.md`
- Альтернатива (Deployer): `DEPLOYER_SETUP.md`
- Быстрый старт: `QUICK_START.md`
