<?php
/**
 * Theme utilities.
 */

/**
 * Whether the theme is running on WP Engine (not local WPE stubs).
 */
function ai_dev_is_wpe_host(): bool {
  if (defined('PWP_NAME') && !in_array(PWP_NAME, array('auto-build-test-local', 'binder-local'), true)) {
    return true;
  }

  $host = $_SERVER['HTTP_HOST'] ?? '';

  return is_string($host) && $host !== '' && preg_match('/(^|\\.)wpengine(powered)?\\.com$/i', $host);
}

/**
 * Site home URL without Bedrock /wp suffix on WP Engine.
 */
function ai_dev_public_home(): string {
  if (ai_dev_is_wpe_host()) {
    $scheme = (is_ssl() || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? '';

    return $scheme . '://' . $host;
  }

  return defined('WP_HOME') ? rtrim(WP_HOME, '/') : '';
}

/**
 * Public URI for the active theme.
 */
function ai_dev_theme_uri(): string {
  if (ai_dev_is_wpe_host()) {
    return ai_dev_public_home() . '/wp-content/themes/' . get_stylesheet();
  }

  return content_url('themes/' . get_stylesheet());
}

/**
 * Rewrite legacy Bedrock /wp/wp-content and /app paths for public asset URLs.
 */
function ai_dev_fix_wpe_url(string $url): string {
  if (function_exists('bedrock_wpe_fix_url')) {
    return bedrock_wpe_fix_url($url);
  }

  if (!ai_dev_is_wpe_host()) {
    return $url;
  }

  $home = ai_dev_public_home();

  return str_replace(
    array($home . '/wp/wp-content/', $home . '/app/', '/wp/wp-content/', '/app/'),
    array($home . '/wp-content/', $home . '/wp-content/', '/wp-content/', '/wp-content/'),
    $url
  );
}

/**
 * Build BEM block class string from Gutenberg block data.
 */
function ai_dev_block_classes(string $slug, array $block, array $extra = array()): string {
  $classes = array_merge(array($slug, 'block'), $extra);

  if (!empty($block['align'])) {
    $classes[] = 'block--' . $block['align'] . '-width';
  }
  if (!empty($block['className'])) {
    $classes[] = $block['className'];
  }

  return esc_attr(implode(' ', array_filter($classes)));
}

/**
 * Render block anchor attribute.
 */
function ai_dev_block_anchor(array $block): string {
  if (empty($block['anchor'])) {
    return '';
  }
  return 'id="' . esc_attr($block['anchor']) . '"';
}

/**
 * Whether a block has any populated content fields.
 */
function ai_dev_block_has_content(array $fields): bool {
  foreach ($fields as $value) {
    if (is_array($value) && !empty($value)) {
      return true;
    }
    if (is_string($value) && trim($value) !== '') {
      return true;
    }
    if (is_numeric($value)) {
      return true;
    }
  }
  return false;
}

/**
 * Case study count for Work nav label.
 */
function ai_dev_case_study_count(): int {
  $counts = wp_count_posts('case-study');
  return isset($counts->publish) ? (int) $counts->publish : 0;
}

add_filter('nav_menu_item_title', 'ai_dev_work_menu_count', 10, 4);
function ai_dev_work_menu_count($title, $item, $args, $depth) {
  if ($depth !== 0 || !isset($args->theme_location) || $args->theme_location !== 'primary') {
    return $title;
  }
  if (stripos($title, 'work') === false) {
    return $title;
  }
  $count = ai_dev_case_study_count();
  if ($count > 0) {
    return $title . ' <span class="site-header__work-count">' . esc_html($count) . '</span>';
  }
  return $title;
}
