<?php
/**
 * Theme utilities.
 */

/**
 * Public URI for the active theme. Uses Bedrock CONTENT_DIR when set so asset
 * URLs resolve to /app/themes/... instead of /wp/wp-content/themes/... on WP Engine.
 */
function ai_dev_theme_uri(): string {
  if (defined('CONTENT_DIR') && is_string(CONTENT_DIR) && CONTENT_DIR !== '') {
    return home_url(CONTENT_DIR . '/themes/' . get_stylesheet());
  }

  return get_template_directory_uri();
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
