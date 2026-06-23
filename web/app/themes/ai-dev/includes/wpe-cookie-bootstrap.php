<?php
/**
 * Set WordPress cookie paths before core reads Bedrock /wp siteurl values.
 *
 * Loaded from config/application.php, db.php, mu-plugins, and wp-login.php.
 * Also repairs siteurl/home in the database when credentials are available.
 */

/**
 * Bedrock project root (parent of web/).
 */
function ai_dev_wpe_bedrock_root(): string {
    return dirname(__DIR__, 5);
}

/**
 * @return array{DB_NAME:string,DB_USER:string,DB_PASSWORD:string,DB_HOST:string,DB_PREFIX:string}|null
 */
function ai_dev_wpe_db_credentials(): ?array {
    static $credentials = null;

    if ($credentials !== null) {
        return $credentials === false ? null : $credentials;
    }

    $keys = array('DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST');
    $values = array();

    foreach ($keys as $key) {
        $value = getenv($key);

        if (!is_string($value) || $value === '') {
            $value = $_ENV[$key] ?? $_SERVER[$key] ?? '';
        }

        if (!is_string($value) || $value === '') {
            $credentials = false;

            return null;
        }

        $values[$key] = $value;
    }

    $prefix = getenv('DB_PREFIX');

    if (!is_string($prefix) || $prefix === '') {
        $prefix = $_ENV['DB_PREFIX'] ?? $_SERVER['DB_PREFIX'] ?? 'wp_';
    }

    $values['DB_PREFIX'] = is_string($prefix) && $prefix !== '' ? $prefix : 'wp_';
    $credentials = $values;

    return $credentials;
}

/**
 * Parse DB_* values from the Bedrock .env file when env vars are unavailable.
 *
 * @return array{DB_NAME:string,DB_USER:string,DB_PASSWORD:string,DB_HOST:string,DB_PREFIX:string}|null
 */
function ai_dev_wpe_db_credentials_from_env_file(): ?array {
    $env_file = ai_dev_wpe_bedrock_root() . '/.env';

    if (!is_readable($env_file)) {
        return null;
    }

    $values = array();
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (!is_array($lines)) {
        return null;
    }

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        if (!str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        if (in_array($key, array('DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST', 'DB_PREFIX'), true)) {
            $values[$key] = $value;
        }
    }

    foreach (array('DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST') as $required) {
        if (empty($values[$required])) {
            return null;
        }
    }

    if (empty($values['DB_PREFIX'])) {
        $values['DB_PREFIX'] = 'wp_';
    }

    return $values;
}

/**
 * Public site URL for the current request.
 */
function ai_dev_wpe_request_home(): string {
    $host = $_SERVER['HTTP_HOST'] ?? '';

    if (!is_string($host) || $host === '') {
        return '';
    }

    $scheme = 'http';

    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        || !empty($_SERVER['HTTP_X_WPE_SSL'])) {
        $scheme = 'https';
    }

    return $scheme . '://' . $host;
}

/**
 * Whether cookie/DB fixes should run for this request.
 */
function ai_dev_wpe_should_bootstrap(): bool {
    $host = $_SERVER['HTTP_HOST'] ?? '';

    if (!is_string($host) || $host === '') {
        return false;
    }

    if (str_contains($host, 'ssl.localhost') || preg_match('/(^|\.)localhost(?::\d+)?$/', $host)) {
        return false;
    }

    return true;
}

/**
 * Fix siteurl/home in the database before WordPress derives cookie paths from them.
 *
 * @return bool Whether a repair was attempted and succeeded.
 */
function ai_dev_wpe_repair_database_urls(): bool {
    static $ran = false;
    static $changed = false;

    if ($ran) {
        return $changed;
    }

    $ran = true;

    if (!ai_dev_wpe_should_bootstrap() || !extension_loaded('mysqli')) {
        return false;
    }

    $public_home = ai_dev_wpe_request_home();

    if ($public_home === '') {
        return false;
    }

    $credentials = ai_dev_wpe_db_credentials() ?? ai_dev_wpe_db_credentials_from_env_file();

    if ($credentials === null) {
        return false;
    }

    $mysqli = @new mysqli(
        $credentials['DB_HOST'],
        $credentials['DB_USER'],
        $credentials['DB_PASSWORD'],
        $credentials['DB_NAME']
    );

    if ($mysqli->connect_errno) {
        return false;
    }

    $table = $mysqli->real_escape_string($credentials['DB_PREFIX'] . 'options');
    $public_home_sql = $mysqli->real_escape_string($public_home);
    $changed = false;

    foreach (array('siteurl', 'home') as $option_name) {
        $option_sql = $mysqli->real_escape_string($option_name);
        $result = $mysqli->query(
            "SELECT option_value FROM `{$table}` WHERE option_name = '{$option_sql}' LIMIT 1"
        );

        if (!$result instanceof mysqli_result) {
            continue;
        }

        $row = $result->fetch_assoc();
        $result->free();

        if (!is_array($row) || !isset($row['option_value']) || !is_string($row['option_value'])) {
            continue;
        }

        $current = rtrim($row['option_value'], '/');

        if ($current === $public_home) {
            continue;
        }

        if ($mysqli->query(
            "UPDATE `{$table}` SET option_value = '{$public_home_sql}' WHERE option_name = '{$option_sql}' LIMIT 1"
        )) {
            $changed = true;
        }
    }

    $mysqli->close();

    return $changed;
}

$host = $_SERVER['HTTP_HOST'] ?? '';
$is_local = is_string($host) && $host !== ''
    && (str_contains($host, 'ssl.localhost') || preg_match('/(^|\.)localhost(?::\d+)?$/', $host));

if (!is_string($host) || $host === '' || $is_local) {
    return;
}

ai_dev_wpe_repair_database_urls();

$public_home = ai_dev_wpe_request_home();

if (!defined('COOKIEPATH')) {
    define('COOKIEPATH', '/');
}

if (!defined('SITECOOKIEPATH')) {
    define('SITECOOKIEPATH', '/');
}

if (!defined('ADMIN_COOKIE_PATH')) {
    define('ADMIN_COOKIE_PATH', '/wp-admin');
}

if (!defined('PLUGINS_COOKIE_PATH')) {
    define('PLUGINS_COOKIE_PATH', '/wp-content/plugins');
}

if (!defined('COOKIEHASH') && $public_home !== '') {
    define('COOKIEHASH', md5($public_home));
}
