<?php
/**
 * ACF Blocks registration and whitelist.
 */

add_theme_support('align-wide');
remove_theme_support('core-block-patterns');

add_filter('block_categories_all', 'ai_dev_block_categories', 10, 2);
function ai_dev_block_categories($categories, $post) {
  return array_merge($categories, array(
    array(
      'slug'  => 'custom-blocks',
      'title' => __('Custom Blocks', 'ai-dev'),
      'icon'  => 'layout',
    ),
  ));
}

add_action('init', 'ai_dev_register_acf_blocks', 5);
function ai_dev_register_acf_blocks() {
  $parentDir = realpath(__DIR__ . '/..');
  $themeUri  = get_template_directory_uri();
  $ver       = wp_get_theme()->get('Version');

  $blocks = array(
    'spacer',
    'homepage-header',
    'skewed-reveal',
    'case-study-grid',
    'scrolling-logos',
    'featured-grid',
    'media-header',
    'event-header',
    'text-block',
    'centered-list',
    'scrolling-text',
    'text-media-carousel',
    'work-grid',
    'two-columns',
    'full-width-media',
    'full-container-media',
    'media-grid',
    'cta-banner',
    'content-block',
    'form-block',
    'event-grid',
    'two-column-list',
    'text-media',
    'sticky-scroll-media',
    'heading-block',
    'three-columns',
    'three-quarter-media',
    'half-container-media',
    'quarter-container-media',
    'review-carousel',
    'mobile-case-study-carousel',
  );

  foreach ($blocks as $slug) {
    wp_register_script(
      'block-' . $slug,
      $themeUri . '/dist/js/' . $slug . '.bundle.js',
      array('jquery'),
      $ver,
      true
    );
    register_block_type($parentDir . '/template-parts/blocks/' . $slug);
  }
}

add_filter('allowed_block_types_all', 'ai_dev_allowed_block_types', 10, 2);
function ai_dev_allowed_block_types($allowed_blocks, $editor_context) {
  return array(
    'core/block',
    'acf/spacer',
    'acf/homepage-header',
    'acf/skewed-reveal',
    'acf/case-study-grid',
    'acf/scrolling-logos',
    'acf/featured-grid',
    'acf/media-header',
    'acf/event-header',
    'acf/text-block',
    'acf/centered-list',
    'acf/scrolling-text',
    'acf/text-media-carousel',
    'acf/work-grid',
    'acf/two-columns',
    'acf/full-width-media',
    'acf/full-container-media',
    'acf/media-grid',
    'acf/cta-banner',
    'acf/content-block',
    'acf/form-block',
    'acf/event-grid',
    'acf/two-column-list',
    'acf/text-media',
    'acf/sticky-scroll-media',
    'acf/heading-block',
    'acf/three-columns',
    'acf/three-quarter-media',
    'acf/half-container-media',
    'acf/quarter-container-media',
    'acf/review-carousel',
    'acf/mobile-case-study-carousel',
  );
}

add_filter('should_load_separate_core_block_assets', '__return_true');
