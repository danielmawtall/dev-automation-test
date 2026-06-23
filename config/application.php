<?php
/**
 * Base application configuration. Environment overrides: config/environments/{{WP_ENV}}.php
 */

use Roots\WPConfig\Config;
use function Env\env;

$root_dir = dirname(__DIR__);
$webroot_dir = $root_dir . '/web';

$wpe_cookie_bootstrap = $webroot_dir . '/app/themes/ai-dev/includes/wpe-cookie-bootstrap.php';

if (is_readable($wpe_cookie_bootstrap)) {
    require_once $wpe_cookie_bootstrap;
}

if (file_exists($root_dir . '/.env')) {
    $env_files = file_exists($root_dir . '/.env.local')
        ? ['.env', '.env.local']
        : ['.env'];

    $dotenv = Dotenv\Dotenv::createUnsafeImmutable($root_dir, $env_files, false);

    $dotenv->load();

    $dotenv->required(['WP_HOME', 'WP_SITEURL']);
    if (!env('DATABASE_URL')) {
        $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
    }
}

define('WP_ENV', env('WP_ENV') ?: 'production');

if (!env('WP_ENVIRONMENT_TYPE') && in_array(WP_ENV, ['production', 'staging', 'development', 'local'], true)) {
    Config::define('WP_ENVIRONMENT_TYPE', WP_ENV);
}

$wp_home = rtrim((string) env('WP_HOME'), '/');

$local_wpe_stubs = ['auto-build-test-local', 'binder-local'];
$pwp_name = env('PWP_NAME');

if (!is_string($pwp_name) || $pwp_name === '') {
    $pwp_env = getenv('PWP_NAME');
    $pwp_name = is_string($pwp_env) ? $pwp_env : '';
}

$http_host = $_SERVER['HTTP_HOST'] ?? '';
$is_local_host = is_string($http_host) && $http_host !== ''
    && (str_contains($http_host, 'ssl.localhost') || preg_match('/(^|\.)localhost(?::\d+)?$/', $http_host));

$is_wpe_host = is_string($http_host) && $http_host !== ''
    && preg_match('/(^|\\.)wpengine(powered)?\\.com$/i', $http_host);

$is_wpe = $is_wpe_host
    || (bool) getenv('IS_WPE')
    || !empty($_SERVER['IS_WPE'])
    || !empty($_SERVER['HTTP_X_WPE_SSL'])
    || (is_string($pwp_name) && $pwp_name !== '' && !in_array($pwp_name, $local_wpe_stubs, true));

$uses_wpe_public_urls = false;

if (is_string($http_host) && $http_host !== '' && !$is_local_host) {
    // Remote web requests: serve core and content from the site root, not /wp or /app.
    $scheme = 'http';

    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        || !empty($_SERVER['HTTP_X_WPE_SSL'])) {
        $scheme = 'https';
    }

    $wp_home = $scheme . '://' . $http_host;
    $uses_wpe_public_urls = true;
} elseif ($is_wpe) {
    // WP-CLI / cron: strip a trailing /wp from Bedrock-style .env values.
    $wp_home = (string) preg_replace('#/wp$#', '', $wp_home);
    $uses_wpe_public_urls = true;
}

Config::define('WP_HOME', $wp_home);

Config::define('CONTENT_DIR', '/app');
Config::define('WP_CONTENT_DIR', $webroot_dir . Config::get('CONTENT_DIR'));

if ($uses_wpe_public_urls) {
    Config::define('BEDROCK_USE_WPE_PUBLIC_URLS', true);
    // WPE serves core and content from root URLs. Ignore Bedrock /wp and /app .env values.
    Config::define('WP_SITEURL', $wp_home);
    Config::define('WP_CONTENT_URL', $wp_home . '/wp-content');
    Config::define('COOKIEPATH', '/');
    Config::define('SITECOOKIEPATH', '/');
    Config::define('ADMIN_COOKIE_PATH', '/wp-admin');
    Config::define('PLUGINS_COOKIE_PATH', '/wp-content/plugins');
} else {
    Config::define('WP_SITEURL', env('WP_SITEURL'));
    Config::define('WP_CONTENT_URL', env('WP_CONTENT_URL') ?: (Config::get('WP_HOME') . Config::get('CONTENT_DIR')));
}

if (env('DB_SSL')) {
    Config::define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL);
}

Config::define('DB_NAME', env('DB_NAME'));
Config::define('DB_USER', env('DB_USER'));
Config::define('DB_PASSWORD', env('DB_PASSWORD'));
Config::define('DB_HOST', env('DB_HOST') ?: 'localhost');
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

if (env('DATABASE_URL')) {
    $dsn = (object) parse_url(env('DATABASE_URL'));

    Config::define('DB_NAME', substr($dsn->path, 1));
    Config::define('DB_USER', $dsn->user);
    Config::define('DB_PASSWORD', isset($dsn->pass) ? $dsn->pass : null);
    Config::define('DB_HOST', isset($dsn->port) ? "{$dsn->host}:{$dsn->port}" : $dsn->host);
}

Config::define('AUTH_KEY', env('AUTH_KEY'));
Config::define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
Config::define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
Config::define('NONCE_KEY', env('NONCE_KEY'));
Config::define('AUTH_SALT', env('AUTH_SALT'));
Config::define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
Config::define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
Config::define('NONCE_SALT', env('NONCE_SALT'));

Config::define('BE_MEDIA_FROM_PRODUCTION_URL', env('BE_MEDIA_FROM_PRODUCTION_URL') ?: '');

Config::define('AUTOMATIC_UPDATER_DISABLED', true);
Config::define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);

Config::define('DISALLOW_FILE_EDIT', true);
Config::define('DISALLOW_FILE_MODS', true);

Config::define('WP_POST_REVISIONS', env('WP_POST_REVISIONS') ?? true);

Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', false);
Config::define('SCRIPT_DEBUG', false);
ini_set('display_errors', '0');

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

Config::apply();

if (!defined('WPMU_PLUGIN_DIR')) {
    define('WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins');
}

if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}
