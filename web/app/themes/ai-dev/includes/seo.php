<?php
/**
 * Basic SEO helpers.
 */

add_filter('document_title_parts', 'ai_dev_document_title_parts');
function ai_dev_document_title_parts(array $title): array {
  if (is_front_page()) {
    $title['title'] = get_bloginfo('name');
    $title['tagline'] = get_bloginfo('description');
  }
  return $title;
}

add_action('wp_head', 'ai_dev_meta_description', 1);
function ai_dev_meta_description(): void {
  if (!is_front_page()) {
    return;
  }

  $description = get_field('meta_description', 'option');
  if (!$description) {
    $description = 'Tall is a lean, focused team of full-time brand, digital and design experts backed by a trusted network of top-tier partners.';
  }

  echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
}
