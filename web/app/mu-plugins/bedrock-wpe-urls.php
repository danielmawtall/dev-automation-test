<?php
/**
 * Plugin Name: Bedrock WPE URL Fix
 * Description: Aligns Bedrock URLs with WP Engine public paths and rewrites legacy /wp/wp-* and /app URLs.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Whether the site is running on WP Engine (not local WPE stubs).
 */
function bedrock_wpe_is_platform(): bool
{
    static $is_wpe = null;

    if ($is_wpe !== null) {
        return $is_wpe;
    }

    $local_stubs = ['auto-build-test-local', 'binder-local'];

    if (getenv('IS_WPE')) {
        return $is_wpe = true;
    }

    if (!empty($_SERVER['IS_WPE'])) {
        return $is_wpe = true;
    }

    if (!empty($_SERVER['HTTP_X_WPE_SSL'])) {
        return $is_wpe = true;
    }

    $http_host = $_SERVER['HTTP_HOST'] ?? '';

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
 * @param string $url
 */
function bedrock_wpe_fix_url(string $url): string
{
    if ($url === '') {
        return $url;
    }

    $home = home_url();

    return str_replace(
        [
            $home . '/wp/wp-content/',
            $home . '/wp/wp-includes/',
            $home . '/wp/wp-admin/',
            $home . '/wp/wp-login.php',
            $home . '/app/',
            '/wp/wp-content/',
            '/wp/wp-includes/',
            '/wp/wp-admin/',
            '/wp/wp-login.php',
            '/app/',
        ],
        [
            $home . '/wp-content/',
            $home . '/wp-includes/',
            $home . '/wp-admin/',
            $home . '/wp-login.php',
            $home . '/wp-content/',
            '/wp-content/',
            '/wp-includes/',
            '/wp-admin/',
            '/wp-login.php',
            '/wp-content/',
        ],
        $url
    );
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
    if (!bedrock_wpe_is_platform() || !is_string($url) || $url === '') {
        return $url;
    }

    return bedrock_wpe_fix_url($url);
}

add_filter('pre_option_home', function ($pre) {
    if (!bedrock_wpe_is_platform()) {
        return $pre;
    }

    return WP_HOME;
});

add_filter('pre_option_siteurl', function ($pre) {
    if (!bedrock_wpe_is_platform()) {
        return $pre;
    }

    return WP_HOME;
});

add_filter('pre_option_upload_url_path', function ($pre) {
    if (!bedrock_wpe_is_platform()) {
        return $pre;
    }

    return '';
});

add_filter('pre_option_upload_path', function ($pre) {
    if (!bedrock_wpe_is_platform()) {
        return $pre;
    }

    return '';
});

add_filter('site_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('network_site_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('admin_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('login_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('logout_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('content_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('plugins_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('theme_root_uri', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('stylesheet_directory_uri', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('template_directory_uri', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('style_loader_src', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('script_loader_src', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('wp_get_attachment_url', 'bedrock_wpe_maybe_fix_url', 20);
add_filter('the_content', 'bedrock_wpe_maybe_fix_url', 20);

add_filter('wp_get_attachment_image_src', function ($image) {
    if (!bedrock_wpe_is_platform() || !is_array($image) || empty($image[0]) || !is_string($image[0])) {
        return $image;
    }

    $image[0] = bedrock_wpe_fix_url($image[0]);

    return $image;
}, 20);

add_filter('upload_dir', function (array $uploads): array {
    if (!bedrock_wpe_is_platform()) {
        return $uploads;
    }

    foreach (['url', 'baseurl'] as $key) {
        if (!empty($uploads[$key]) && is_string($uploads[$key])) {
            $uploads[$key] = bedrock_wpe_fix_url($uploads[$key]);
        }
    }

    return $uploads;
}, 20);

add_filter('acf/format_value', function ($value, $post_id, $field) {
    if (!bedrock_wpe_is_platform()) {
        return $value;
    }

    if (!is_array($field) || empty($field['type'])) {
        return $value;
    }

    $url_field_types = ['image', 'file', 'url', 'link', 'gallery', 'oembed'];

    if (!in_array($field['type'], $url_field_types, true)) {
        return $value;
    }

    return bedrock_wpe_fix_value($value);
}, 20, 3);

add_filter('wp_calculate_image_srcset', function ($sources) {
    if (!bedrock_wpe_is_platform() || !is_array($sources)) {
        return $sources;
    }

    foreach ($sources as $width => $source) {
        if (!empty($source['url']) && is_string($source['url'])) {
            $sources[$width]['url'] = bedrock_wpe_fix_url($source['url']);
        }
    }

    return $sources;
}, 20);
