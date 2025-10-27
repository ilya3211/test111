<?php
/**
 * Script to set Gitium tracking branch
 * Run this once to switch Gitium to claude branch
 */

// Load WordPress
require_once(__DIR__ . '/wp-load.php');

// Set the tracking branch
$branch = 'origin/claude/analyze-task-011CUVxqfvcmXpncFzGgTDdb';
set_transient('gitium_remote_tracking_branch', $branch);

echo "✅ Gitium tracking branch set to: $branch\n";
echo "\n";
echo "Now:\n";
echo "1. Go to WordPress Admin → Gitium → Commits\n";
echo "2. Click 'Pull from remote' or refresh the page\n";
echo "3. Check: http://regret49.beget.tech/gitium-test.txt\n";
echo "\n";
echo "Files should appear on your site!\n";
