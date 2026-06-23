<?php
/**
 * Force WordPress auth cookies to the site root on remote hosts (WP Engine).
 *
 * Bedrock .env often sets WP_SITEURL with a /wp suffix, which makes WordPress
 * scope cookies to /wp/ and breaks /wp-admin/ login on WPE.
 */

$host = $_SERVER['HTTP_HOST'] ?? '';
$is_local = is_string($host) && $host !== ''
    && (str_contains($host, 'ssl.localhost') || preg_match('/(^|\.)localhost(?::\d+)?$/', $host));

if (!is_string($host) || $host === '' || $is_local) {
    return;
}

foreach (array('COOKIEPATH', 'SITECOOKIEPATH', 'ADMIN_COOKIE_PATH', 'PLUGINS_COOKIE_PATH') as $constant) {
    if (!defined($constant)) {
        define($constant, '/');
    }
}
