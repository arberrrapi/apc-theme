<?php
/**
 * Debug Script - Clear Smileback Cache and Test
 * 
 * Add this to your functions.php temporarily or run via wp-admin/admin.php?page=debug-smileback
 */

// Add debug page to admin menu (temporary)
add_action('admin_menu', 'smileback_debug_menu');
function smileback_debug_menu() {
    add_submenu_page(
        'themes.php',
        'Debug Smileback',
        'Debug Smileback',
        'manage_options',
        'debug-smileback',
        'smileback_debug_page'
    );
}

function smileback_debug_page() {
    if (isset($_POST['clear_cache'])) {
        $api = new Smileback_API();
        $api->clear_cache();
        echo '<div class="notice notice-success"><p>Cache cleared!</p></div>';
    }
    
    if (isset($_POST['test_api'])) {
        $api = new Smileback_API();
        $reviews = $api->get_reviews();
        echo '<div class="notice notice-info"><p>Fresh API call made. Check error log for response data.</p></div>';
        echo '<h3>Reviews Found: ' . count($reviews) . '</h3>';
        echo '<pre>' . print_r($reviews, true) . '</pre>';
    }
    ?>
    <div class="wrap">
        <h1>Debug Smileback API</h1>
        
        <form method="post">
            <p>
                <button type="submit" name="clear_cache" class="button">Clear Cache</button>
                <button type="submit" name="test_api" class="button button-primary">Test API & Show Results</button>
            </p>
        </form>
        
        <h2>Current Settings:</h2>
        <ul>
            <li><strong>Client ID:</strong> <?php echo get_option('smileback_client_id') ? 'Set' : 'Not set'; ?></li>
            <li><strong>Username:</strong> <?php echo get_option('smileback_username') ? get_option('smileback_username') : 'Not set'; ?></li>
            <li><strong>Review Limit:</strong> <?php echo get_option('smileback_review_limit', 20); ?></li>
        </ul>
        
        <p><em>Check your WordPress error log for detailed API response data.</em></p>
    </div>
    <?php
}
?>