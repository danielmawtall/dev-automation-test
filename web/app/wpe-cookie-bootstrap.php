<?php
/**
 * Force WordPress auth cookies to the site root on remote hosts (WP Engine).
 *
 * Bedrock .env often sets WP_SITEURL with a /wp suffix, which makes WordPress
 * set ADMIN_COOKIE_PATH to /wp/wp-admin while WPE serves admin at /wp-admin/.
 */

$host = $_SERVER['HTTP_HOST'] ?? '';
$is_local = is_string($host) && $host !== ''
    && (str_contains($host, 'ssl.localhost') || preg_match('/(^|\.)localhost(?::\d+)?$/', $host));

if (!is_string($host) || $host === '' || $is_local) {
    return;
}

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
