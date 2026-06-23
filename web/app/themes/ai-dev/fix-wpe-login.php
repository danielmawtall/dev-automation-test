<?php
/**
 * Bedrock-on-WPE login repair (theme-deployable, no SSH).
 *
 * Visit once after deploy, then log in at /wp-login.php and delete this file.
 */

declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');

$host = $_SERVER['HTTP_HOST'] ?? '';

if (!is_string($host) || $host === ''
    || str_contains($host, 'ssl.localhost')
    || preg_match('/(^|\.)localhost(?::\d+)?$/', $host)) {
    http_response_code(403);
    echo "This repair script only runs on remote staging/production hosts.\n";
    exit;
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || !empty($_SERVER['HTTP_X_WPE_SSL'])
    ? 'https'
    : 'http';

$public_home = $scheme . '://' . $host;
$content_dir = dirname(__DIR__, 2);
$webroot = dirname(__DIR__, 3);
$bootstrap = __DIR__ . '/includes/wpe-cookie-bootstrap.php';
$dropin_marker = 'AI Dev WPE cookie bootstrap';

echo "Tall AI Dev - WP Engine login repair\n";
echo "====================================\n\n";
echo 'Public home: ' . $public_home . "\n\n";

/**
 * @return array{ok:bool,message:string}
 */
function ai_dev_install_dropin(string $path, string $contents, string $label): array {
    if (!is_dir(dirname($path)) && !mkdir(dirname($path), 0755, true) && !is_dir(dirname($path))) {
        return array('ok' => false, 'message' => "{$label}: parent directory missing ({$path})");
    }

    if (is_readable($path)) {
        $existing = file_get_contents($path);

        if (is_string($existing) && str_contains($existing, 'wpe-cookie-bootstrap.php')) {
            return array('ok' => true, 'message' => "{$label}: already installed");
        }
    }

    if (@file_put_contents($path, $contents, LOCK_EX) === false) {
        return array('ok' => false, 'message' => "{$label}: could not write {$path}");
    }

    return array('ok' => true, 'message' => "{$label}: installed");
}

$db_dropin = $content_dir . '/db.php';
$mu_plugin = $content_dir . '/mu-plugins/00-ai-dev-wpe-cookies.php';

$db_contents = <<<PHP
<?php
/**
 * {$dropin_marker}
 */
require_once __DIR__ . '/themes/ai-dev/includes/wpe-cookie-bootstrap.php';

PHP;

$mu_contents = <<<PHP
<?php
/**
 * Plugin Name: AI Dev WPE Cookies
 * Description: {$dropin_marker}
 */
require_once dirname(__DIR__) . '/themes/ai-dev/includes/wpe-cookie-bootstrap.php';

PHP;

echo "Installing early loaders (before WordPress sets cookie paths):\n";

foreach (
    array(
        ai_dev_install_dropin($db_dropin, $db_contents, 'db.php drop-in'),
        ai_dev_install_dropin($mu_plugin, $mu_contents, 'mu-plugin'),
    ) as $result
) {
    echo '  ' . $result['message'] . "\n";
}

echo "\n";

$wp_load = $webroot . '/wp/wp-load.php';

if (!is_readable($wp_load)) {
    echo "Could not boot WordPress: missing {$wp_load}\n";
    echo "If drop-ins installed successfully, clear cookies and try /wp-login.php anyway.\n";
    exit;
}

define('WP_USE_THEMES', false);
require_once $wp_load;

if (!function_exists('get_option')) {
    echo "WordPress boot failed.\n";
    exit;
}

$siteurl = (string) get_option('siteurl');
$home = (string) get_option('home');
$changed = false;

foreach (array('siteurl', 'home') as $option_name) {
    $current = rtrim((string) get_option($option_name), '/');

    if ($current !== $public_home) {
        update_option($option_name, $public_home);
        $changed = true;
    }
}

if (function_exists('delete_option')) {
    delete_option('ai_dev_wpe_db_urls_migrated');
}

if (function_exists('ai_dev_maybe_migrate_wpe_db_urls')) {
    ai_dev_maybe_migrate_wpe_db_urls();
}

echo "Database:\n";
echo '  siteurl (before): ' . $siteurl . "\n";
echo '  home (before): ' . $home . "\n";
echo '  siteurl (now): ' . (string) get_option('siteurl') . "\n";
echo '  home (now): ' . (string) get_option('home') . "\n";
echo '  updated: ' . ($changed ? 'yes' : 'no') . "\n\n";

echo "Cookie constants (this request):\n";
echo '  COOKIEPATH=' . (defined('COOKIEPATH') ? COOKIEPATH : '(not set)') . "\n";
echo '  SITECOOKIEPATH=' . (defined('SITECOOKIEPATH') ? SITECOOKIEPATH : '(not set)') . "\n";
echo '  ADMIN_COOKIE_PATH=' . (defined('ADMIN_COOKIE_PATH') ? ADMIN_COOKIE_PATH : '(not set)') . "\n";
echo '  COOKIEHASH=' . (defined('COOKIEHASH') ? COOKIEHASH : '(not set)') . "\n\n";

echo "Drop-in files:\n";
echo '  db.php exists: ' . (is_readable($db_dropin) ? 'yes' : 'no') . "\n";
echo '  mu-plugin exists: ' . (is_readable($mu_plugin) ? 'yes' : 'no') . "\n\n";

echo "Next steps:\n";
echo "1. Clear browser cookies for this domain (or use a private window).\n";
echo "2. Log in at {$public_home}/wp-login.php\n";
echo "3. If login still loops, use Lost your password? (imported DB passwords may not match server salts).\n";
echo "4. Delete wp-content/themes/ai-dev/fix-wpe-login.php after login works.\n";
