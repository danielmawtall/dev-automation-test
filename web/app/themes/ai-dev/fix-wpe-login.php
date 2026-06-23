<?php
/**
 * One-time Bedrock-on-WPE login repair (theme-deployable, no SSH).
 *
 * Visit once after deploy, then log in at /wp-login.php and delete this file.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/wpe-cookie-bootstrap.php';

header('Content-Type: text/plain; charset=utf-8');

if (!ai_dev_wpe_should_bootstrap()) {
    http_response_code(403);
    echo "This repair script only runs on remote staging/production hosts.\n";
    exit;
}

$public_home = ai_dev_wpe_request_home();
$repaired = ai_dev_wpe_repair_database_urls();

echo "Tall AI Dev - WP Engine login repair\n";
echo "====================================\n\n";
echo 'Public home: ' . $public_home . "\n";
echo 'Database URLs repaired: ' . ($repaired ? 'yes' : 'no (already correct or credentials unavailable)') . "\n\n";
echo "Cookie paths (when bootstrap loads):\n";
echo '  COOKIEPATH=' . (defined('COOKIEPATH') ? COOKIEPATH : '(not set)') . "\n";
echo '  SITECOOKIEPATH=' . (defined('SITECOOKIEPATH') ? SITECOOKIEPATH : '(not set)') . "\n";
echo '  ADMIN_COOKIE_PATH=' . (defined('ADMIN_COOKIE_PATH') ? ADMIN_COOKIE_PATH : '(not set)') . "\n\n";
echo "Next steps:\n";
echo "1. Clear browser cookies for this domain (or use a private window).\n";
echo "2. Log in at {$public_home}/wp-login.php\n";
echo "3. Delete wp-content/themes/ai-dev/fix-wpe-login.php after login works.\n";
