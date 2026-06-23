<?php
/**
 * Theme cleanup and Gutenberg restrictions.
 */

add_action('after_setup_theme', 'ai_dev_theme_setup');
function ai_dev_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('editor-styles');
  add_theme_support('custom-logo', array(
    'height'      => 48,
    'width'       => 120,
    'flex-height' => true,
    'flex-width'  => true,
  ));
}

add_action('init', 'ai_dev_disable_emojis');
function ai_dev_disable_emojis() {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
}

add_action('wp_enqueue_scripts', 'ai_dev_dequeue_block_library', 100);
function ai_dev_dequeue_block_library() {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
}

add_action('after_setup_theme', 'ai_dev_disable_editor_features');
function ai_dev_disable_editor_features() {
  add_theme_support('disable-custom-colors');
  add_theme_support('disable-custom-font-sizes');
  add_theme_support('disable-custom-gradients');
}
