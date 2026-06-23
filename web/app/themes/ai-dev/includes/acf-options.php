<?php
/**
 * Theme options pages.
 */

add_action('acf/init', 'ai_dev_register_options_pages');
function ai_dev_register_options_pages() {
  if (!function_exists('acf_add_options_page')) {
    return;
  }

  acf_add_options_page(array(
    'page_title' => __('Theme Settings', 'ai-dev'),
    'menu_title' => __('Theme Settings', 'ai-dev'),
    'menu_slug'  => 'theme-settings',
    'capability' => 'edit_posts',
    'redirect'   => false,
  ));
}
