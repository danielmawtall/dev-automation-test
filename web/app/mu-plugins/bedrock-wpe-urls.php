<?php
/**
 * Plugin Name: Bedrock WPE URL Fix
 * Description: Rewrites Bedrock /wp/wp-* and /app URLs stored in the database on WP Engine.
 */

if (!defined('ABSPATH')) {
    exit;
}

$pwp_name = defined('PWP_NAME') ? PWP_NAME : '';

if (!is_string($pwp_name) || $pwp_name === '' || in_array($pwp_name, ['auto-build-test-local', 'binder-local'], true)) {
    return;
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

add_filter('wp_get_attachment_url', 'bedrock_wpe_fix_url');
add_filter('the_content', 'bedrock_wpe_fix_url');

add_filter('acf/format_value/type=image', function ($value) {
    if (is_array($value) && !empty($value['url'])) {
        $value['url'] = bedrock_wpe_fix_url($value['url']);
    }

    return $value;
}, 20);

add_filter('acf/format_value/type=file', function ($value) {
    if (is_array($value) && !empty($value['url'])) {
        $value['url'] = bedrock_wpe_fix_url($value['url']);
    }

    return $value;
}, 20);

add_filter('wp_calculate_image_srcset', function ($sources) {
    if (!is_array($sources)) {
        return $sources;
    }

    foreach ($sources as $width => $source) {
        if (!empty($source['url'])) {
            $sources[$width]['url'] = bedrock_wpe_fix_url($source['url']);
        }
    }

    return $sources;
});
