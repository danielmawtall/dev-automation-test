<?php
/**
 * Enqueue styles and scripts.
 */

add_filter('wp_resource_hints', 'ai_dev_resource_hints', 10, 2);
function ai_dev_resource_hints($hints, $relation_type) {
  if ('preconnect' === $relation_type) {
    $hints[] = 'https://fonts.googleapis.com';
    $hints[] = array(
      'href'        => 'https://fonts.gstatic.com',
      'crossorigin' => 'anonymous',
    );
  }
  return $hints;
}

add_action('wp_enqueue_scripts', 'ai_dev_theme_scripts');
function ai_dev_theme_scripts() {
  $themeUri = ai_dev_theme_uri();
  $ver      = wp_get_theme()->get('Version');
  $fonts    = 'https://fonts.googleapis.com/css2?family=Anton&family=IBM+Plex+Mono:wght@400&family=Inter:wght@400;500;600;700&display=swap';

  wp_enqueue_style('google-fonts', $fonts, array(), null);
  wp_enqueue_style('ai-dev-styles', $themeUri . '/dist/css/styles.css', array(), $ver);
  wp_enqueue_script('ai-dev-main', $themeUri . '/dist/js/main.bundle.js', array(), $ver, true);
}

add_action('enqueue_block_editor_assets', 'ai_dev_admin_scripts');
function ai_dev_admin_scripts() {
  $themeUri = ai_dev_theme_uri();
  $ver      = wp_get_theme()->get('Version');
  $fonts    = 'https://fonts.googleapis.com/css2?family=Anton&family=IBM+Plex+Mono:wght@400&family=Inter:wght@400;500;600;700&display=swap';

  wp_enqueue_style('google-fonts', $fonts, array(), null);
  wp_enqueue_script('ai-dev-cms', $themeUri . '/dist/js/cms.bundle.js', array(), $ver, true);
}

add_editor_style('dist/css/styles.css');
add_editor_style('admin.css');
