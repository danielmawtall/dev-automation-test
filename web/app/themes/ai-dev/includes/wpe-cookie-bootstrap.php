<?php
/**
 * Set WordPress cookie paths before core reads Bedrock /wp siteurl values.
 *
 * Loaded from config/application.php, db.php, and mu-plugins so login works
 * even when only the theme directory is deployed.
 */

$host = $_SERVER['HTTP_HOST'] ?? '';
$is_local = is_string($host) && $host !== ''
    && (str_contains($host, 'ssl.localhost') || preg_match('/(^|\.)localhost(?::\d+)?$/', $host));

if (!is_string($host) || $host === '' || $is_local) {
    return;
}

$scheme = 'http';

if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || !empty($_SERVER['HTTP_X_WPE_SSL'])) {
    $scheme = 'https';
}

$public_home = $scheme . '://' . $host;

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

if (!defined('COOKIEHASH')) {
    define('COOKIEHASH', md5($public_home));
}
