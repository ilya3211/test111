<?php
/**
 * Update Gitium Branch to claude/analyze-cook-it-theme-011CUXgR33JgnR5pcjeDPo9q
 *
 * Usage: Open in browser http://your-site.com/update-gitium-branch.php?key=update-gitium-2025
 * Then DELETE this file after use!
 */

// Security key
$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== 'update-gitium-2025') {
    die('
    <html>
    <head><title>Update Gitium Branch</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
        h1 { color: #0073aa; }
    </style>
    </head>
    <body>
        <h1>🔐 Security Key Required</h1>
        <p>Add <code>?key=update-gitium-2025</code> to the URL</p>
        <p><strong>Example:</strong></p>
        <p><code>http://regret49.beget.tech/update-gitium-branch.php?key=update-gitium-2025</code></p>
    </body>
    </html>
    ');
}

// Load WordPress
define('WP_USE_THEMES', false);
if (!file_exists('./wp-load.php')) {
    die('Error: wp-load.php not found. Make sure this file is in WordPress root directory.');
}
require_once('./wp-load.php');

// UPDATED: Switching to branch that contains /tags/ changes
$target_branch = 'claude/sync-tags-slug-from-analyze-011CUe7KYpipheZxXMV5WPJs';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Gitium Branch</title>
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
            background: #f9f9f9;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #0073aa;
            border-radius: 4px;
        }
        .success {
            background: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }
        .warning {
            background: #fff3cd;
            border-left-color: #ffc107;
            color: #856404;
        }
        .info {
            background: #d1ecf1;
            border-left-color: #17a2b8;
            color: #0c5460;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f8;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 13px;
            line-height: 1.5;
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
        .btn-delete {
            background: #dc3545;
        }
        .btn-delete:hover { background: #c82333; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
        }
        table td:first-child {
            font-weight: 600;
            width: 200px;
            color: #555;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🔄 Update Gitium Branch</h1>

    <h2>📋 Current Configuration</h2>
    <div class="box info">
        <table>
            <tr>
                <td>Current Branch:</td>
                <td><code><?php echo get_option('gitium_remote_tracking_branch') ?: 'NOT SET'; ?></code></td>
            </tr>
            <tr>
                <td>Remote URL:</td>
                <td><code><?php echo get_option('gitium_remote_url') ?: 'NOT SET'; ?></code></td>
            </tr>
            <tr>
                <td>Webhook Status:</td>
                <td><?php echo get_option('gitium_webhook_key') ? '✓ Configured' : '✗ Not configured'; ?></td>
            </tr>
        </table>
    </div>

    <h2>🎯 Target Branch</h2>
    <div class="box">
        <p style="margin: 0;"><strong><?php echo $target_branch; ?></strong></p>
    </div>

    <?php
    // Update the branch
    $old_branch = get_option('gitium_remote_tracking_branch');
    $updated = update_option('gitium_remote_tracking_branch', $target_branch);
    $new_branch = get_option('gitium_remote_tracking_branch');

    if ($new_branch === $target_branch) {
        echo '<div class="box success">';
        echo '<h3 style="margin-top: 0;">✓ Branch Updated Successfully!</h3>';
        echo '<p style="margin-bottom: 0;">Gitium is now tracking: <strong>' . $target_branch . '</strong></p>';
        echo '</div>';
    } else {
        echo '<div class="box warning">';
        echo '<h3 style="margin-top: 0;">⚠ Update Failed</h3>';
        echo '<p style="margin-bottom: 0;">Could not update the branch. Current branch is still: <strong>' . $new_branch . '</strong></p>';
        echo '</div>';
    }

    // Now switch git repository to the new branch
    echo '<h2>🔧 Switching Git Repository</h2>';
    chdir(ABSPATH);

    // Fetch
    echo '<div class="box info">';
    echo '<h3 style="margin-top: 0;">Fetching branch from remote...</h3>';
    exec("git fetch origin " . escapeshellarg($target_branch) . " 2>&1", $fetch_output);
    echo '<pre>' . htmlspecialchars(implode("\n", $fetch_output)) . '</pre>';
    echo '</div>';

    // Checkout
    echo '<div class="box info">';
    echo '<h3 style="margin-top: 0;">Checking out branch...</h3>';
    exec("git checkout " . escapeshellarg($target_branch) . " 2>&1", $checkout_output, $checkout_code);
    echo '<pre>' . htmlspecialchars(implode("\n", $checkout_output)) . '</pre>';
    if ($checkout_code === 0) {
        echo '<p style="color: #28a745; font-weight: 600;">✓ Branch checked out successfully!</p>';
    }
    echo '</div>';

    // Pull
    echo '<div class="box info">';
    echo '<h3 style="margin-top: 0;">Pulling latest changes...</h3>';
    exec("git pull origin " . escapeshellarg($target_branch) . " 2>&1", $pull_output);
    echo '<pre>' . htmlspecialchars(implode("\n", $pull_output)) . '</pre>';
    echo '</div>';

    // Status
    echo '<div class="box info">';
    echo '<h3 style="margin-top: 0;">Current git status:</h3>';
    exec("git status 2>&1", $status_output);
    echo '<pre>' . htmlspecialchars(implode("\n", $status_output)) . '</pre>';
    echo '</div>';

    // Log
    echo '<div class="box info">';
    echo '<h3 style="margin-top: 0;">Latest commits:</h3>';
    exec("git log --oneline -5 2>&1", $log_output);
    echo '<pre>' . htmlspecialchars(implode("\n", $log_output)) . '</pre>';
    echo '</div>';
    ?>

    <h2>📊 Verification</h2>
    <div class="box info">
        <table>
            <tr>
                <td>Previous Branch:</td>
                <td><code><?php echo $old_branch ?: 'NOT SET'; ?></code></td>
            </tr>
            <tr>
                <td>New Branch:</td>
                <td><code><?php echo $new_branch; ?></code></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <?php
                    if ($new_branch === $target_branch) {
                        echo '<span style="color: #28a745; font-weight: 600;">✓ Successfully Changed</span>';
                    } elseif ($old_branch === $new_branch) {
                        echo '<span style="color: #856404;">→ No Change</span>';
                    } else {
                        echo '<span style="color: #dc3545;">✗ Error</span>';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <h2>✅ Next Steps - IMPORTANT!</h2>
    <div class="box success">
        <ol style="margin: 15px 0; padding-left: 25px;">
            <li style="margin-bottom: 10px;">✓ Branch switched to: <code><?php echo $target_branch; ?></code></li>
            <li style="margin-bottom: 10px;">✓ Changes with <strong>/tags/</strong> slug are now active</li>
            <li style="margin-bottom: 10px;"><strong style="color: #dc3545;">REQUIRED:</strong> Go to <strong>Settings → Permalinks</strong> and click "Save Changes" to flush rewrite rules!</li>
            <li style="margin-bottom: 10px;">Test new URLs: <code>http://your-site.com/tags/ingredient-name/</code></li>
            <li style="margin-bottom: 10px;"><strong style="color: #dc3545;">IMPORTANT:</strong> Delete this file after use!</li>
        </ol>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
        <a href="/wp-admin/options-permalink.php" class="btn" style="background: #28a745;">⚠️ Flush Permalinks (REQUIRED) →</a>
        <a href="/wp-admin/admin.php?page=gitium" class="btn">Open Gitium →</a>
        <a href="?key=update-gitium-2025&delete=yes" class="btn btn-delete">Delete This File</a>
    </div>

    <?php
    // Self-delete if requested
    if (isset($_GET['delete']) && $_GET['delete'] === 'yes') {
        echo '<div class="box warning" style="margin-top: 30px;">';
        echo '<h3 style="margin-top: 0;">🗑 Deleting file...</h3>';
        if (unlink(__FILE__)) {
            echo '<p style="color: #28a745; font-weight: 600;">✓ File deleted successfully!</p>';
            echo '<p>Redirecting to Gitium dashboard...</p>';
            echo '<script>setTimeout(function(){ window.location.href="/wp-admin/admin.php?page=gitium"; }, 2000);</script>';
        } else {
            echo '<p style="color: #dc3545; font-weight: 600;">✗ Could not delete file automatically.</p>';
            echo '<p>Please delete manually via FTP or File Manager:</p>';
            echo '<p><code>' . __FILE__ . '</code></p>';
        }
        echo '</div>';
    }
    ?>

</div>
</body>
</html>
