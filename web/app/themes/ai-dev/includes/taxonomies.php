<?php
/**
 * Taxonomies.
 */

add_action('init', 'ai_dev_register_service_taxonomy');
function ai_dev_register_service_taxonomy() {
  register_taxonomy('service', array('case-study'), array(
    'labels' => array(
      'name'          => __('Services', 'ai-dev'),
      'singular_name' => __('Service', 'ai-dev'),
    ),
    'hierarchical'      => false,
    'public'            => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'show_in_rest'      => true,
    'rewrite'           => array('slug' => 'service'),
  ));
}
