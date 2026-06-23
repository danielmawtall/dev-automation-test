<?php
/**
 * Spacer block field group.
 */

if (!function_exists('acf_add_local_field_group')) {
  return;
}

acf_add_local_field_group(array(
  'key'    => 'group_ai_dev_spacer',
  'title'  => 'Block: Spacer',
  'fields' => array(
    array(
      'key'   => 'field_ai_dev_spacer_top_desktop',
      'label' => 'Padding Top (Desktop)',
      'name'  => 'padding_top_desktop',
      'type'  => 'number',
      'default_value' => 0,
    ),
    array(
      'key'   => 'field_ai_dev_spacer_bottom_desktop',
      'label' => 'Padding Bottom (Desktop)',
      'name'  => 'padding_bottom_desktop',
      'type'  => 'number',
      'default_value' => 0,
    ),
    array(
      'key'   => 'field_ai_dev_spacer_top_mobile',
      'label' => 'Padding Top (Mobile)',
      'name'  => 'padding_top_mobile',
      'type'  => 'number',
      'default_value' => 0,
    ),
    array(
      'key'   => 'field_ai_dev_spacer_bottom_mobile',
      'label' => 'Padding Bottom (Mobile)',
      'name'  => 'padding_bottom_mobile',
      'type'  => 'number',
      'default_value' => 0,
    ),
  ),
  'location' => array(
    array(
      array(
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/spacer',
      ),
    ),
  ),
));
