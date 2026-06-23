<?php
/**
 * ACF bootstrap — PHP registration only, no JSON sync.
 */

add_filter('acf/settings/save_json', '__return_false');
add_filter('acf/settings/load_json', '__return_false');

add_action('acf/init', 'ai_dev_load_acf_field_groups');
function ai_dev_load_acf_field_groups() {
  $dir = get_template_directory() . '/includes/acf/field-groups';
  if (!is_dir($dir)) {
    return;
  }
  foreach (glob($dir . '/*.php') as $file) {
    include_once $file;
  }
}
