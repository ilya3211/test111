# 🚀 Рабочий процесс: Claude + Gitium

## ✅ Система работает!

Файл доступен: http://regret49.beget.tech/gitium-test.txt

---

## 📋 Как работает автоматическое развертывание

### Шаг 1: Claude делает изменения
- Claude работает в отдельной ветке: `claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb`
- Все изменения коммитятся и пушатся в эту ветку
- Claude **НЕ** имеет доступа к master (403 forbidden)

### Шаг 2: Вы создаете Pull Request
- Зайдите на GitHub: https://github.com/ilya3211/test111
- Создайте Pull Request из ветки `claude/*` в `master`
- Просмотрите изменения
- Нажмите **"Merge Pull Request"**

### Шаг 3: Gitium автоматически развертывает
- Gitium следит за веткой **master**
- После мерджа PR в master
- Gitium автоматически подтягивает изменения на сайт
- Или используйте кнопку **"Pull push changes"** вручную

---

## 🔧 Текущая конфигурация

### Gitium настройки:
- **Repository**: https://github.com/ilya3211/test111.git
- **Token**: ghp_YOUR_TOKEN_HERE (не храните токены в репозитории!)
- **Tracking branch**: master
- **Путь**: /home/user/test111 → regret49.beget.tech/public_html/

### Права доступа:
- Claude: может пушить только в `claude/*` ветки
- Master: защищена, изменения только через Pull Request
- GitHub Token: полный доступ к репозиторию

---

## 📝 Пример рабочего процесса

### Вы просите Claude добавить новый файл:

```
Вы: "Создай файл test-page.html с простой HTML страницей"
```

### Claude выполняет:

1. **Создает файл в своей ветке**
   ```bash
   # Claude создает: /home/user/test111/test-page.html
   ```

2. **Коммитит и пушит**
   ```bash
   git add test-page.html
   git commit -m "Add test-page.html"
   git push -u origin claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb
   ```

3. **Сообщает вам**
   ```
   Claude: "Файл создан и запушен в ветку claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb.
   Создайте PR для применения на сайте."
   ```

### Вы применяете изменения:

1. **Открываете GitHub**
   - https://github.com/ilya3211/test111/pulls

2. **Создаете новый PR**
   - From: `claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb`
   - To: `master`

3. **Мерджите PR**
   - Просматриваете изменения
   - Нажимаете "Merge Pull Request"

4. **Ждете или тригерите pull в Gitium**
   - Автоматически: Gitium сам подтянет (может занять несколько минут)
   - Вручную: WordPress Admin → Gitium → Commits → "Pull push changes"

5. **Проверяете результат**
   - http://regret49.beget.tech/test-page.html

---

## ⚠️ Важные замечания

### .gitignore
Следующие файлы исключены из Git:
```
wp-content/plugins/wppusher
wa
```

### Ветки
- `master` - продакшен, то что на сайте
- `claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb` - текущая рабочая ветка Claude
- `claude/analyze-structure-011CUQ9fCZoLqbGT3WBYbyiv` - старая ветка Claude

### Токены
⚠️ **КРИТИЧЕСКИ ВАЖНО**: Ваш GitHub токен был показан публично в этой сессии.

**Рекомендация**: Отозвите текущий токен и создайте новый после окончания работы:
1. https://github.com/settings/tokens
2. Отозвать текущий токен
3. Создать новый с теми же правами (repo, workflow)
4. Обновить в Gitium: WordPress Admin → Gitium → Settings

**Никогда не храните токены в Git репозитории!**

---

## 🎯 Тестовые файлы

В репозитории созданы тестовые файлы для проверки развертывания:

### gitium-test.txt
```
http://regret49.beget.tech/gitium-test.txt
```
**Статус**: ✅ Работает

### deploy-test.txt
```
http://regret49.beget.tech/deploy-test.txt
```
**Статус**: Проверьте доступность

---

## 📚 Документация

В репозитории созданы следующие гайды:

1. **GITIUM_SETUP.md** - Подробная настройка Gitium
2. **FIX_GITIUM_BRANCH.md** - Как переключать ветки в Gitium
3. **QUICK_START.md** - Быстрый старт (5 минут)
4. **DEPLOYER_SETUP.md** - Deployer for Git (не используется)
5. **WORKFLOW.md** - Этот файл

---

## ✅ Чеклист готовности

- [x] Gitium установлен и активирован
- [x] GitHub репозиторий подключен
- [x] Gitium следит за веткой master
- [x] Claude пушит в отдельную ветку
- [x] Pull Request процесс понятен
- [x] Тестовый файл доступен на сайте
- [x] Автоматическое развертывание работает

---

## 🎉 Система готова к работе!

Теперь вы можете:
1. Просить Claude делать изменения
2. Просматривать их через Pull Request
3. Мерджить в master
4. Автоматически видеть на сайте

**Дата настройки**: 2025-10-26
**Настроил**: Claude Code
