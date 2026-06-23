<?php
/**
 * Shared Bedrock-on-WPE URL fix. Loaded from mu-plugins and the active theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (defined('BEDROCK_WPE_URLS_LOADED')) {
    return;
}

define('BEDROCK_WPE_URLS_LOADED', true);

/**
 * Whether public URLs should use the site root instead of Bedrock /wp or /app paths.
 */
function bedrock_wpe_is_platform(): bool
{
    static $is_wpe = null;

    if ($is_wpe !== null) {
        return $is_wpe;
    }

    if (defined('BEDROCK_USE_WPE_PUBLIC_URLS') && BEDROCK_USE_WPE_PUBLIC_URLS) {
        return $is_wpe = true;
    }

    $http_host = $_SERVER['HTTP_HOST'] ?? '';

    if (is_string($http_host) && $http_host !== ''
        && !str_contains($http_host, 'ssl.localhost')
        && !preg_match('/(^|\.)localhost(?::\d+)?$/', $http_host)) {
        return $is_wpe = true;
    }

    $local_stubs = ['auto-build-test-local', 'binder-local'];

    if (getenv('IS_WPE') || !empty($_SERVER['IS_WPE']) || !empty($_SERVER['HTTP_X_WPE_SSL'])) {
        return $is_wpe = true;
    }

    if (is_string($http_host) && $http_host !== '' && preg_match('/(^|\\.)wpengine(powered)?\\.com$/i', $http_host)) {
        return $is_wpe = true;
    }

    $pwp_name = defined('PWP_NAME') ? PWP_NAME : getenv('PWP_NAME');

    if (is_string($pwp_name) && $pwp_name !== '' && !in_array($pwp_name, $local_stubs, true)) {
        return $is_wpe = true;
    }

    return $is_wpe = false;
}

/**
 * Canonical public site URL (ignores Bedrock /wp suffix in .env).
 */
function bedrock_wpe_site_url(): string
{
    $scheme = 'http';

    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        || !empty($_SERVER['HTTP_X_WPE_SSL'])) {
        $scheme = 'https';
    }

    $host = $_SERVER['HTTP_HOST'] ?? '';

    return $scheme . '://' . $host;
}

/**
 * @param string $url
 */
function bedrock_wpe_fix_url(string $url): string
{
    if ($url === '') {
        return $url;
    }

    $home = bedrock_wpe_is_platform() ? bedrock_wpe_site_url() : (defined('WP_HOME') ? rtrim((string) WP_HOME, '/') : '');

    $search = [
        '/wp/wp-content/',
        '/wp/wp-includes/',
        '/wp/wp-admin/',
        '/wp/wp-login.php',
        '/app/',
    ];

    $replace = [
        '/wp-content/',
        '/wp-includes/',
        '/wp-admin/',
        '/wp-login.php',
        '/wp-content/',
    ];

    if ($home !== '') {
        $absolute_search = [];
        $absolute_replace = [];

        foreach ($search as $index => $path) {
            $absolute_search[] = $home . $path;
            $absolute_replace[] = $home . $replace[$index];
        }

        $search = array_merge($search, $absolute_search);
        $replace = array_merge($replace, $absolute_replace);
    }

    return str_replace($search, $replace, $url);
}

/**
 * @param mixed $value
 * @return mixed
 */
function bedrock_wpe_fix_value($value)
{
    if (is_string($value)) {
        return bedrock_wpe_fix_url($value);
    }

    if (!is_array($value)) {
        return $value;
    }

    foreach ($value as $key => $item) {
        $value[$key] = bedrock_wpe_fix_value($item);
    }

    return $value;
}

/**
 * @param mixed $url
 * @return mixed
 */
function bedrock_wpe_maybe_fix_url($url)
{
    static $fixing = false;

    if ($fixing || !bedrock_wpe_is_platform() || !is_string($url) || $url === '') {
        return $url;
    }

    $fixing = true;
    $fixed = bedrock_wpe_fix_url($url);
    $fixing = false;

    return $fixed;
}

add_filter('pre_option_home', static function ($pre) {
    return bedrock_wpe_is_platform() ? bedrock_wpe_site_url() : $pre;
}, 1);

add_filter('pre_option_siteurl', static function ($pre) {
    return bedrock_wpe_is_platform() ? bedrock_wpe_site_url() : $pre;
}, 1);

add_filter('pre_option_upload_url_path', static function ($pre) {
    return bedrock_wpe_is_platform() ? '' : $pre;
}, 1);

add_filter('pre_option_upload_path', static function ($pre) {
    return bedrock_wpe_is_platform() ? '' : $pre;
}, 1);

add_filter('site_url', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('home_url', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('includes_url', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('content_url', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('plugins_url', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('admin_url', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('login_url', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('style_loader_src', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('script_loader_src', 'bedrock_wpe_maybe_fix_url', 1);
add_filter('wp_get_attachment_url', 'bedrock_wpe_maybe_fix_url', 1);

add_filter('wp_redirect', static function ($location) {
    if (!bedrock_wpe_is_platform() || !is_string($location) || $location === '') {
        return $location;
    }

    return bedrock_wpe_fix_url($location);
}, 1);

add_filter('redirect_canonical', static function ($redirect_url) {
    if (!bedrock_wpe_is_platform() || !is_string($redirect_url) || $redirect_url === '') {
        return $redirect_url;
    }

    return bedrock_wpe_fix_url($redirect_url);
}, 1);

add_filter('wp_get_attachment_image_src', static function ($image) {
    if (!bedrock_wpe_is_platform() || !is_array($image) || empty($image[0]) || !is_string($image[0])) {
        return $image;
    }

    $image[0] = bedrock_wpe_fix_url($image[0]);

    return $image;
}, 1);

add_filter('upload_dir', static function (array $uploads): array {
    if (!bedrock_wpe_is_platform()) {
        return $uploads;
    }

    foreach (['url', 'baseurl'] as $key) {
        if (!empty($uploads[$key]) && is_string($uploads[$key])) {
            $uploads[$key] = bedrock_wpe_fix_url($uploads[$key]);
        }
    }

    return $uploads;
}, 1);

add_filter('the_content', static function ($content) {
    if (!bedrock_wpe_is_platform() || !is_string($content) || $content === '') {
        return $content;
    }

    return bedrock_wpe_fix_url($content);
}, 1);

add_filter('acf/load_value', static function ($value) {
    if (!bedrock_wpe_is_platform()) {
        return $value;
    }

    return bedrock_wpe_fix_value($value);
}, 1);

add_filter('acf/format_value', static function ($value) {
    if (!bedrock_wpe_is_platform()) {
        return $value;
    }

    return bedrock_wpe_fix_value($value);
}, 1);

add_filter('wp_calculate_image_srcset', static function ($sources) {
    if (!bedrock_wpe_is_platform() || !is_array($sources)) {
        return $sources;
    }

    foreach ($sources as $width => $source) {
        if (!empty($source['url']) && is_string($source['url'])) {
            $sources[$width]['url'] = bedrock_wpe_fix_url($source['url']);
        }
    }

    return $sources;
}, 1);

add_action('template_redirect', static function () {
    if (!bedrock_wpe_is_platform() || is_admin() || wp_doing_ajax() || wp_is_json_request()) {
        return;
    }

    ob_start(static function ($html) {
        return is_string($html) ? bedrock_wpe_fix_url($html) : $html;
    });
}, -99999);
