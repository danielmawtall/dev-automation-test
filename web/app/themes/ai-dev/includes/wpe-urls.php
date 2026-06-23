<?php
/**
 * WP Engine / remote Bedrock URL rewrite hooks.
 */

if (!defined('ABSPATH') || defined('AI_DEV_WPE_URLS_LOADED')) {
  return;
}

define('AI_DEV_WPE_URLS_LOADED', true);

/**
 * @param mixed $url
 * @return mixed
 */
function ai_dev_maybe_fix_wpe_url($url) {
  static $fixing = false;

  if ($fixing || !ai_dev_is_wpe_host() || !is_string($url) || $url === '') {
    return $url;
  }

  $fixing = true;
  $fixed = ai_dev_fix_wpe_url($url);
  $fixing = false;

  return $fixed;
}

/**
 * @param mixed $value
 * @return mixed
 */
function ai_dev_fix_wpe_value($value) {
  if (is_string($value)) {
    return ai_dev_fix_wpe_url($value);
  }

  if (!is_array($value)) {
    return $value;
  }

  foreach ($value as $key => $item) {
    $value[$key] = ai_dev_fix_wpe_value($item);
  }

  return $value;
}

add_filter('pre_option_home', static function ($pre) {
  return ai_dev_is_wpe_host() ? ai_dev_public_home() : $pre;
}, 1);

add_filter('pre_option_siteurl', static function ($pre) {
  return ai_dev_is_wpe_host() ? ai_dev_public_home() : $pre;
}, 1);

add_filter('site_url', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('home_url', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('includes_url', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('content_url', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('plugins_url', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('admin_url', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('login_url', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('style_loader_src', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('script_loader_src', 'ai_dev_maybe_fix_wpe_url', 1);
add_filter('wp_get_attachment_url', 'ai_dev_maybe_fix_wpe_url', 1);

add_filter('wp_redirect', static function ($location) {
  if (!ai_dev_is_wpe_host() || !is_string($location) || $location === '') {
    return $location;
  }

  return ai_dev_fix_wpe_url($location);
}, 1);

add_filter('wp_get_attachment_image_src', static function ($image) {
  if (!ai_dev_is_wpe_host() || !is_array($image) || empty($image[0]) || !is_string($image[0])) {
    return $image;
  }

  $image[0] = ai_dev_fix_wpe_url($image[0]);

  return $image;
}, 1);

add_filter('upload_dir', static function (array $uploads): array {
  if (!ai_dev_is_wpe_host()) {
    return $uploads;
  }

  foreach (array('url', 'baseurl') as $key) {
    if (!empty($uploads[$key]) && is_string($uploads[$key])) {
      $uploads[$key] = ai_dev_fix_wpe_url($uploads[$key]);
    }
  }

  return $uploads;
}, 1);

add_filter('the_content', static function ($content) {
  if (!ai_dev_is_wpe_host() || !is_string($content) || $content === '') {
    return $content;
  }

  return ai_dev_fix_wpe_url($content);
}, 1);

add_filter('acf/load_value', static function ($value) {
  return ai_dev_is_wpe_host() ? ai_dev_fix_wpe_value($value) : $value;
}, 1);

add_filter('acf/format_value', static function ($value) {
  return ai_dev_is_wpe_host() ? ai_dev_fix_wpe_value($value) : $value;
}, 1);

add_filter('wp_calculate_image_srcset', static function ($sources) {
  if (!ai_dev_is_wpe_host() || !is_array($sources)) {
    return $sources;
  }

  foreach ($sources as $width => $source) {
    if (!empty($source['url']) && is_string($source['url'])) {
      $sources[$width]['url'] = ai_dev_fix_wpe_url($source['url']);
    }
  }

  return $sources;
}, 1);

add_action('template_redirect', static function () {
  if (!ai_dev_is_wpe_host() || is_admin() || wp_doing_ajax() || wp_is_json_request()) {
    return;
  }

  ob_start(static function ($html) {
    return is_string($html) ? ai_dev_fix_wpe_url($html) : $html;
  });
}, -99999);
