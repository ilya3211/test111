<?php
/**
 * Force Git Pull Script
 * Open this file in browser ONCE to pull changes from GitHub
 * URL: http://regret49.beget.tech/force-pull.php
 */

// Security: only allow from localhost or specific IP (optional)
// Uncomment and set your IP if needed:
// if ($_SERVER['REMOTE_ADDR'] !== 'YOUR_IP') die('Access denied');

echo "<h1>Force Git Pull</h1>";
echo "<pre>";

// Get current directory
$dir = __DIR__;
echo "Working directory: $dir\n\n";

// Check if git is available
exec('which git 2>&1', $output, $return);
if ($return !== 0) {
    echo "ERROR: Git is not installed or not in PATH\n";
    exit;
}

echo "Git found: " . implode("\n", $output) . "\n\n";

// Change to the WordPress directory
chdir($dir);

echo "=== Current Git Status ===\n";
exec('git status 2>&1', $status_output);
echo implode("\n", $status_output) . "\n\n";

echo "=== Fetching from remote ===\n";
exec('git fetch origin master 2>&1', $fetch_output);
echo implode("\n", $fetch_output) . "\n\n";

echo "=== Resetting to remote master (discarding local changes) ===\n";
exec('git reset --hard origin/master 2>&1', $reset_output);
echo implode("\n", $reset_output) . "\n\n";

echo "=== Checking result ===\n";
exec('git log -1 --oneline 2>&1', $log_output);
echo "Latest commit: " . implode("\n", $log_output) . "\n\n";

// Check if test file exists
if (file_exists($dir . '/gitium-test.txt')) {
    echo "✅ SUCCESS! File gitium-test.txt is now present!\n";
    echo "\nTest it: http://regret49.beget.tech/gitium-test.txt\n";
} else {
    echo "⚠️ WARNING: gitium-test.txt not found after pull.\n";
    echo "Files in directory:\n";
    exec('ls -la | head -20 2>&1', $ls_output);
    echo implode("\n", $ls_output) . "\n";
}

echo "\n=== DONE ===\n";
echo "You can now delete this file (force-pull.php) for security.\n";
echo "</pre>";

// Optional: Auto-delete this script after execution (uncomment if you want)
// unlink(__FILE__);
?>