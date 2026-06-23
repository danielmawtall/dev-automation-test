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
            $home . '/app/',
        ],
        [
            $home . '/wp-content/',
            $home . '/wp-includes/',
            $home . '/wp-admin/',
            $home . '/wp-content/',
        ],
        $url
    );
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

add_action('plugins_loaded', function () {
    if (!bedrock_wpe_is_platform()) {
        return;
    }

    add_filter('pre_option_home', function () {
        return WP_HOME;
    });

    add_filter('pre_option_siteurl', function () {
        return WP_SITEURL;
    });

    // Imported DB rows can pin uploads to /wp/wp-content; ignore them on WPE.
    add_filter('pre_option_upload_url_path', '__return_empty_string');
    add_filter('pre_option_upload_path', '__return_empty_string');

    add_filter('content_url', 'bedrock_wpe_maybe_fix_url');
    add_filter('plugins_url', 'bedrock_wpe_maybe_fix_url');
    add_filter('theme_root_uri', 'bedrock_wpe_maybe_fix_url');
    add_filter('stylesheet_directory_uri', 'bedrock_wpe_maybe_fix_url');
    add_filter('template_directory_uri', 'bedrock_wpe_maybe_fix_url');
    add_filter('style_loader_src', 'bedrock_wpe_maybe_fix_url');
    add_filter('script_loader_src', 'bedrock_wpe_maybe_fix_url');
    add_filter('wp_get_attachment_url', 'bedrock_wpe_maybe_fix_url');
    add_filter('the_content', 'bedrock_wpe_maybe_fix_url');

    add_filter('upload_dir', function (array $uploads): array {
        foreach (['url', 'baseurl'] as $key) {
            if (!empty($uploads[$key]) && is_string($uploads[$key])) {
                $uploads[$key] = bedrock_wpe_fix_url($uploads[$key]);
            }
        }

        return $uploads;
    });

    add_filter('acf/format_value/type=image', function ($value) {
        if (is_array($value) && !empty($value['url']) && is_string($value['url'])) {
            $value['url'] = bedrock_wpe_fix_url($value['url']);
        }

        return $value;
    }, 20);

    add_filter('acf/format_value/type=file', function ($value) {
        if (is_array($value) && !empty($value['url']) && is_string($value['url'])) {
            $value['url'] = bedrock_wpe_fix_url($value['url']);
        }

        return $value;
    }, 20);

    add_filter('wp_calculate_image_srcset', function ($sources) {
        if (!is_array($sources)) {
            return $sources;
        }

        foreach ($sources as $width => $source) {
            if (!empty($source['url']) && is_string($source['url'])) {
                $sources[$width]['url'] = bedrock_wpe_fix_url($source['url']);
            }
        }

        return $sources;
    });
}, 1);
