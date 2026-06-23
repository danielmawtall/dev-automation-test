<?php
/**
 * Gravity Forms integration stubs.
 */

add_filter('gform_submit_button', 'ai_dev_gform_submit_button', 10, 2);
function ai_dev_gform_submit_button($button, $form) {
  return str_replace("class='", "class='button button--primary ", $button);
}

/**
 * Resolve Let's Talk form ID: page override or theme default.
 */
function ai_dev_get_lets_talk_form_id($post_id = null) {
  $post_id = $post_id ?: get_queried_object_id();
  $override = $post_id ? get_field('lets_talk_form_id', $post_id) : null;
  if ($override) {
    return (int) $override;
  }
  $default = function_exists('get_field') ? get_field('default_gravity_form_id', 'option') : null;
  return $default ? (int) $default : 1;
}
