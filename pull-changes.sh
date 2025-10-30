#!/bin/bash
# Script to pull changes from GitHub for the analyze branch

echo "🔄 Pulling changes from claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q"
echo ""

# Navigate to WordPress root
cd "$(dirname "$0")" || exit 1

# Show current branch
echo "📍 Current branch:"
git branch --show-current
echo ""

# Fetch latest changes
echo "📥 Fetching from origin..."
git fetch origin claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q

echo ""

# Show status
echo "📊 Status:"
git status
echo ""

# Pull changes
echo "⬇️ Pulling changes..."
git pull origin claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q

echo ""
echo "✅ Done! Latest commits:"
git log --oneline -5

echo ""
echo "🔧 IMPORTANT: Go to WordPress Admin → Settings → Permalinks → Click 'Save Changes'"
echo "   This will flush rewrite rules for the new /tags/ URL structure."
