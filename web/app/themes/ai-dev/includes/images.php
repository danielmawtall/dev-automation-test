<?php
/**
 * Custom image sizes.
 */

add_action('after_setup_theme', 'ai_dev_image_sizes');
function ai_dev_image_sizes() {
  add_image_size('hero', 1920, 1080, false);
  add_image_size('card-square', 800, 800, true);
  add_image_size('card-portrait', 800, 1000, true);
  add_image_size('card-landscape', 1280, 720, true);
  add_image_size('media-full', 1920, 9999, false);
  add_image_size('media-container', 1440, 9999, false);
  add_image_size('logo', 200, 100, false);
  add_image_size('og', 1200, 630, true);
}

add_filter('image_size_names_choose', 'ai_dev_custom_image_sizes');
function ai_dev_custom_image_sizes($sizes) {
  return array_merge($sizes, array(
    'hero'            => __('Hero', 'ai-dev'),
    'card-square'     => __('Card Square', 'ai-dev'),
    'card-portrait'   => __('Card Portrait', 'ai-dev'),
    'card-landscape'  => __('Card Landscape', 'ai-dev'),
    'media-full'      => __('Media Full', 'ai-dev'),
    'media-container' => __('Media Container', 'ai-dev'),
    'logo'            => __('Logo', 'ai-dev'),
    'og'              => __('Open Graph', 'ai-dev'),
  ));
}
