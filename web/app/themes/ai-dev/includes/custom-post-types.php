<?php
/**
 * Custom post types.
 */

add_action('init', 'ai_dev_register_case_study');
function ai_dev_register_case_study() {
  $labels = array(
    'name'               => _x('Case Studies', 'post type general name', 'ai-dev'),
    'singular_name'      => _x('Case Study', 'post type singular name', 'ai-dev'),
    'add_new'            => _x('Add New', 'case study', 'ai-dev'),
    'add_new_item'       => __('Add New Case Study', 'ai-dev'),
    'edit_item'          => __('Edit Case Study', 'ai-dev'),
    'new_item'           => __('New Case Study', 'ai-dev'),
    'view_item'          => __('View Case Study', 'ai-dev'),
    'search_items'       => __('Search Case Studies', 'ai-dev'),
    'not_found'          => __('No case studies found', 'ai-dev'),
    'not_found_in_trash' => __('No case studies found in Trash', 'ai-dev'),
    'menu_name'          => __('Case Studies', 'ai-dev'),
  );

  register_post_type('case-study', array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'query_var'          => true,
    'rewrite'            => array(
      'slug'       => 'work',
      'with_front' => false,
    ),
    'capability_type'    => 'page',
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => 5,
    'menu_icon'          => 'dashicons-portfolio',
    'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    'show_in_rest'       => true,
    'taxonomies'         => array('service'),
  ));
}
