<?php
/**
 * Shared Bedrock-on-WPE URL fix. Loaded from mu-plugins; delegates to the active theme.
 */

require_once dirname(__DIR__) . '/wpe-cookie-bootstrap.php';

if (!defined('ABSPATH')) {
    exit;
}

if (defined('BEDROCK_WPE_URLS_LOADED') || defined('AI_DEV_WPE_URLS_LOADED')) {
    return;
}

$theme_utils = WP_CONTENT_DIR . '/themes/ai-dev/includes/utils.php';
$theme_urls = WP_CONTENT_DIR . '/themes/ai-dev/includes/wpe-urls.php';

if (is_readable($theme_utils)) {
    require_once $theme_utils;
}

if (is_readable($theme_urls)) {
    require_once $theme_urls;
}
