# Настройка Deployer for Git для автоматического развертывания

## Информация о текущей конфигурации

- **Репозиторий**: `ilya3211/test111`
- **Текущая ветка**: `claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb`
- **Плагин**: Deployer for Git v1.0.8 (уже установлен)

---

## Шаг 1: Активация плагина в WordPress

1. Войдите в админ-панель WordPress
2. Перейдите: **Плагины → Установленные плагины**
3. Найдите **Deployer for Git**
4. Нажмите **Активировать** (если еще не активирован)

---

## Шаг 2: Настройка плагина

### 2.1 Откройте настройки

1. В админ-панели перейдите: **Settings → Deployer for Git**
2. Или найдите в меню слева: **Deployer for Git → Dashboard**

### 2.2 Добавьте репозиторий для автообновления всего сайта

**Для развертывания всего сайта:**

1. Нажмите **"Add Repository"** или **"Add Package"**
2. Заполните форму:

```
Repository Type: GitHub (или ваш сервис)
Repository URL: https://github.com/ilya3211/test111
Branch: claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb
Package Type: Full Site (весь сайт)
Deploy Path: / (корень WordPress)
```

3. **Access Token** (для приватных репозиториев):
   - Перейдите: GitHub → Settings → Developer settings → Personal access tokens
   - Создайте токен с правами: `repo` (полный доступ к репозиториям)
   - Скопируйте токен и вставьте в поле

4. Нажмите **"Save"** или **"Add Repository"**

---

## Шаг 3: Настройка автоматического развертывания (Webhook)

### 3.1 Получите Webhook URL из плагина

1. В Deployer for Git найдите добавленный репозиторий
2. Откройте настройки репозитория
3. Скопируйте **Webhook URL** (должен выглядеть примерно так):
   ```
   https://ваш-сайт.com/wp-json/dfg/v1/deploy/webhook?token=XXXXX
   ```

### 3.2 Добавьте Webhook в GitHub

1. Откройте GitHub: https://github.com/ilya3211/test111
2. Перейдите: **Settings → Webhooks → Add webhook**
3. Заполните:
   ```
   Payload URL: [вставьте Webhook URL из плагина]
   Content type: application/json
   Secret: [оставьте пустым или используйте из плагина]
   Which events?: Just the push event
   Active: ✓
   ```
4. Нажмите **Add webhook**

---

## Шаг 4: Тестирование workflow

### Автоматический тест

Я (Claude) сейчас создам тестовый файл и сделаю commit:

```bash
# Создам тестовый файл
echo "Test deploy $(date)" > deploy-test.txt

# Commit и push
git add deploy-test.txt
git commit -m "Test: Deployer for Git webhook

🤖 Generated with Claude Code
Co-Authored-By: Claude <noreply@anthropic.com>"

git push -u origin claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb
```

### Проверка в WordPress

1. Откройте **Deployer for Git → Dashboard**
2. Вы должны увидеть:
   - ✅ Последнее развертывание
   - Дата и время
   - Commit hash
   - Статус: Success

3. Проверьте файл на сервере:
   ```bash
   ls -la /path/to/wordpress/deploy-test.txt
   ```

---

## Шаг 5: Настройка дополнительных параметров

### 5.1 Очистка кэша после деплоя

В настройках Deployer for Git включите:
- ✅ **Clear cache after deploy**
- Выберите ваш кэш-плагин (WP Rocket, W3 Total Cache, и т.д.)

### 5.2 Уведомления

Настройте email-уведомления:
- ✅ **Email notifications on success**
- ✅ **Email notifications on failure**
- Email: ваш-email@example.com

### 5.3 Безопасность

- ✅ **Verify webhook signature** (если используете GitHub Secret)
- ✅ **Only allow specific branches**: `claude/*` (для безопасности)

---

## Как это работает с Claude Code

### Обычный workflow:

```
1. Вы: "Claude, добавь функцию поиска на сайт"
   ↓
2. Claude: Вношу изменения в файлы
   ↓
3. Claude: git commit -m "Add search functionality"
           git push origin claude/analyze-task-...
   ↓
4. GitHub: Получает push → отправляет webhook
   ↓
5. Deployer for Git: Получает webhook → подтягивает изменения
   ↓
6. ✅ Изменения автоматически применены на сайте!
```

### Временная задержка:
- Push на GitHub: ~1-3 секунды
- Webhook срабатывание: ~1-5 секунд
- Развертывание на сайте: ~5-30 секунд (зависит от размера изменений)
- **Итого**: ~10-40 секунд от commit до применения на сайте

---

## Альтернативный вариант: Ручное развертывание

Если webhook не работает или вы хотите контролировать деплой вручную:

1. Откройте **Deployer for Git → Dashboard**
2. Найдите репозиторий
3. Нажмите кнопку **"Deploy Now"** или **"Update"**
4. Плагин подтянет последние изменения из ветки

---

## Решение проблем

### Webhook не срабатывает

1. **Проверьте URL webhook**:
   - GitHub → Settings → Webhooks → Recent Deliveries
   - Посмотрите Response (должен быть 200 OK)

2. **Проверьте права**:
   - Access Token должен иметь права `repo`
   - Webhook URL должен быть доступен извне

3. **Проверьте логи**:
   - Deployer for Git → Logs
   - WordPress → Tools → Site Health

### Не подтягиваются изменения

1. **Проверьте ветку**: убедитесь, что в настройках указана правильная ветка
2. **Проверьте права на файлы**: WordPress должен иметь права записи
3. **Проверьте .gitignore**: убедитесь, что нужные файлы не игнорируются

### Приватный репозиторий

Для приватных репозиториев нужна **PRO версия** Deployer for Git или используйте Git Updater.

---

## Команды для Claude

Чтобы я (Claude) мог работать с автодеплоем, используйте:

- "Добавь функцию X и задеплой" - я внесу изменения и сделаю push
- "Исправь баг Y и обнови сайт" - я исправлю и задеплою
- "Создай новую страницу Z" - я создам и автоматически применю на сайте

---

## Следующие шаги

1. ✅ Активируйте плагин
2. ✅ Добавьте репозиторий в настройках
3. ✅ Настройте webhook в GitHub
4. ✅ Протестируйте с тестовым commit
5. ✅ Начните работу: все мои изменения будут автоматически применяться!

---

**Документация создана**: $(date)
**Версия**: 1.0
**Автор**: Claude Code
