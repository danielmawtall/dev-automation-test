<?php
/**
 * Admin / editor styles.
 */

add_action('admin_enqueue_scripts', 'ai_dev_admin_css');
function ai_dev_admin_css() {
  wp_enqueue_style('ai-dev-admin', get_template_directory_uri() . '/admin.css', array(), wp_get_theme()->get('Version'));
}
