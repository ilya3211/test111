#!/bin/bash
# Скрипт для переключения Gitium на ветку Claude

echo "Переключаю Gitium на ветку claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb..."

# Переключаем локальную ветку
cd /home/user/test111
git checkout claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb
git pull origin claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb

echo "✅ Git переключен на правильную ветку"
echo ""
echo "Теперь в WordPress:"
echo "1. Откройте: Gitium → Commits"
echo "2. Нажмите: Pull from remote"
echo "3. Файл появится на сайте!"
