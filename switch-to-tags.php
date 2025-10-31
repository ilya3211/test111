<?php
// Switch Gitium to branch with /tags/ changes
// Open: http://regret49.beget.tech/switch-to-tags.php?go=yes

if (!isset($_GET['go']) || $_GET['go'] !== 'yes') {
    die('Add ?go=yes to URL');
}

define('WP_USE_THEMES', false);
require_once('./wp-load.php');

echo "<h1>Switching to /tags/ branch</h1>";

// Update Gitium option
$old = get_option('gitium_remote_tracking_branch');
$new = 'claude/sync-tags-slug-from-analyze-011CUe7KYpipheZxXMV5WPJs';
update_option('gitium_remote_tracking_branch', $new);

echo "<p>Old branch: <code>$old</code></p>";
echo "<p>New branch: <code>$new</code></p>";

// Switch git branch
chdir(ABSPATH);

echo "<h2>Git commands:</h2>";

echo "<h3>1. Fetch:</h3><pre>";
system("git fetch origin $new 2>&1");
echo "</pre>";

echo "<h3>2. Checkout:</h3><pre>";
system("git checkout $new 2>&1");
echo "</pre>";

echo "<h3>3. Pull:</h3><pre>";
system("git pull origin $new 2>&1");
echo "</pre>";

echo "<h3>4. Status:</h3><pre>";
system("git status 2>&1");
echo "</pre>";

echo "<h3>5. Latest commits:</h3><pre>";
system("git log --oneline -5 2>&1");
echo "</pre>";

echo "<hr>";
echo "<h2 style='color: green;'>✓ Done!</h2>";
echo "<ol>";
echo "<li><strong>REQUIRED:</strong> Go to <a href='/wp-admin/options-permalink.php'>Settings → Permalinks</a> and click Save</li>";
echo "<li>Check Gitium: <a href='/wp-admin/admin.php?page=gitium'>Gitium Dashboard</a></li>";
echo "<li>Delete this file: switch-to-tags.php</li>";
echo "</ol>";
?>