<?php
/**
 * Registered navigation menus.
 */

add_action('after_setup_theme', 'ai_dev_register_menus');
function ai_dev_register_menus() {
  register_nav_menus(array(
    'primary'       => __('Primary Navigation', 'ai-dev'),
    'footer-links'  => __('Footer Links', 'ai-dev'),
    'footer-info'   => __('Footer Info', 'ai-dev'),
  ));
}
