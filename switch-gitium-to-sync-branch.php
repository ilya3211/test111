<?php
/**
 * Switch Gitium to claude/sync-tags-slug-from-analyze-011CUe7KYpipheZxXMV5WPJs
 * This branch contains the /tags/ slug changes
 *
 * Usage: http://your-site.com/switch-gitium-to-sync-branch.php?key=switch-2025
 * DELETE after use!
 */

$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== 'switch-2025') {
    die('
    <html>
    <head><title>Switch Gitium Branch</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
        h1 { color: #0073aa; }
    </style>
    </head>
    <body>
        <h1>🔐 Security Key Required</h1>
        <p>Add <code>?key=switch-2025</code> to the URL</p>
        <p><strong>Example:</strong></p>
        <p><code>http://regret49.beget.tech/switch-gitium-to-sync-branch.php?key=switch-2025</code></p>
    </body>
    </html>
    ');
}

define('WP_USE_THEMES', false);
if (!file_exists('./wp-load.php')) {
    die('Error: wp-load.php not found.');
}
require_once('./wp-load.php');

$target_branch = 'claude/sync-tags-slug-from-analyze-011CUe7KYpipheZxXMV5WPJs';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Switch Gitium Branch</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 { color: #0073aa; margin-top: 0; }
        h2 { color: #333; border-bottom: 2px solid #0073aa; padding-bottom: 10px; margin-top: 30px; }
        .box {
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #0073aa;
            border-radius: 4px;
        }
        .success { background: #d4edda; border-left-color: #28a745; color: #155724; }
        .warning { background: #fff3cd; border-left-color: #ffc107; color: #856404; }
        .info { background: #d1ecf1; border-left-color: #17a2b8; color: #0c5460; }
        pre {
            background: #2d2d2d;
            color: #00ff00;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 13px;
        }
        .btn {
            display: inline-block;
            background: #0073aa;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
            font-weight: 500;
        }
        .btn:hover { background: #005a87; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🔄 Switch Gitium Branch</h1>

    <div class="box warning">
        <h3 style="margin-top: 0;">⚠️ Why Switch?</h3>
        <p>The current branch <code>claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q</code> does NOT contain the /tags/ slug changes.</p>
        <p>The changes are in: <code><?php echo $target_branch; ?></code></p>
    </div>

    <h2>📋 Current Configuration</h2>
    <div class="box info">
        <p><strong>Current Branch:</strong> <code><?php echo get_option('gitium_remote_tracking_branch') ?: 'NOT SET'; ?></code></p>
        <p><strong>Remote URL:</strong> <code><?php echo get_option('gitium_remote_url') ?: 'NOT SET'; ?></code></p>
    </div>

    <?php
    // Update WordPress option
    $old_branch = get_option('gitium_remote_tracking_branch');
    update_option('gitium_remote_tracking_branch', $target_branch);
    $new_branch = get_option('gitium_remote_tracking_branch');

    echo '<h2>🔧 Updating Git Repository</h2>';
    chdir(ABSPATH);

    // Fetch the new branch
    echo '<div class="box info">';
    echo '<h3>Step 1: Fetching branch...</h3>';
    exec("git fetch origin $target_branch 2>&1", $fetch_out);
    echo '<pre>' . htmlspecialchars(implode("\n", $fetch_out)) . '</pre>';
    echo '</div>';

    // Checkout the branch
    echo '<div class="box info">';
    echo '<h3>Step 2: Checking out branch...</h3>';
    exec("git checkout $target_branch 2>&1", $checkout_out, $checkout_code);
    echo '<pre>' . htmlspecialchars(implode("\n", $checkout_out)) . '</pre>';

    if ($checkout_code === 0) {
        echo '<p style="color: #28a745; font-weight: 600;">✓ Branch checked out successfully!</p>';
    }
    echo '</div>';

    // Pull latest changes
    echo '<div class="box info">';
    echo '<h3>Step 3: Pulling latest changes...</h3>';
    exec("git pull origin $target_branch 2>&1", $pull_out);
    echo '<pre>' . htmlspecialchars(implode("\n", $pull_out)) . '</pre>';
    echo '</div>';

    // Show current status
    echo '<div class="box info">';
    echo '<h3>Step 4: Current status</h3>';
    exec("git status 2>&1", $status_out);
    echo '<pre>' . htmlspecialchars(implode("\n", $status_out)) . '</pre>';
    echo '</div>';

    // Show latest commits
    echo '<div class="box info">';
    echo '<h3>Latest Commits:</h3>';
    exec("git log --oneline -5 2>&1", $log_out);
    echo '<pre>' . htmlspecialchars(implode("\n", $log_out)) . '</pre>';
    echo '</div>';
    ?>

    <div class="box success">
        <h3 style="margin-top: 0;">✓ Branch Switched!</h3>
        <p><strong>Old Branch:</strong> <code><?php echo $old_branch; ?></code></p>
        <p><strong>New Branch:</strong> <code><?php echo $new_branch; ?></code></p>
    </div>

    <h2>✅ Next Steps</h2>
    <div class="box success">
        <ol>
            <li><strong>Verify changes:</strong> Check that <code>functions.php</code> now has <code>'slug' => 'tags'</code></li>
            <li><strong>Flush permalinks:</strong> Go to <strong>Settings → Permalinks</strong> and click "Save Changes"</li>
            <li><strong>Test URLs:</strong> Visit <code>http://regret49.beget.tech/tags/your-ingredient/</code></li>
            <li><strong>Delete this file!</strong></li>
        </ol>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
        <a href="/wp-admin/admin.php?page=gitium" class="btn">Open Gitium →</a>
        <a href="/wp-admin/options-permalink.php" class="btn">Flush Permalinks →</a>
        <a href="?key=switch-2025&delete=yes" class="btn btn-delete">Delete This File</a>
    </div>

    <?php
    if (isset($_GET['delete']) && $_GET['delete'] === 'yes') {
        echo '<div class="box warning" style="margin-top: 30px;">';
        echo '<h3>🗑 Deleting file...</h3>';
        if (unlink(__FILE__)) {
            echo '<p style="color: #28a745;">✓ File deleted!</p>';
            echo '<script>setTimeout(function(){ window.location.href="/wp-admin/admin.php?page=gitium"; }, 2000);</script>';
        } else {
            echo '<p style="color: #dc3545;">✗ Could not delete. Delete manually: <code>' . __FILE__ . '</code></p>';
        }
        echo '</div>';
    }
    ?>

</div>
</body>
</html>
