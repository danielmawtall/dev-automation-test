<?php
/**
 * Theme settings field group.
 */

if (!function_exists('acf_add_local_field_group')) {
  return;
}

acf_add_local_field_group(array(
  'key'    => 'group_ai_dev_theme_settings',
  'title'  => 'Theme Settings',
  'fields' => array(
    array(
      'key'   => 'field_ai_dev_meta_description',
      'label' => 'Homepage meta description',
      'name'  => 'meta_description',
      'type'  => 'textarea',
      'rows'  => 2,
    ),
    array(
      'key'   => 'field_ai_dev_default_gravity_form_id',
      'label' => 'Default Gravity Form ID',
      'name'  => 'default_gravity_form_id',
      'type'  => 'number',
      'default_value' => 1,
    ),
    array(
      'key'   => 'field_ai_dev_mobile_menu_text',
      'label' => 'Mobile Menu Text',
      'name'  => 'mobile_menu_text',
      'type'  => 'text',
      'default_value' => 'Menu',
    ),
    array(
      'key'   => 'field_ai_dev_reshape_text',
      'label' => 'Mobile Menu Scrolling Text',
      'name'  => 'reshape_text',
      'type'  => 'text',
      'default_value' => 'RESHAPE POSSIBLE',
    ),
    array(
      'key'   => 'field_ai_dev_footer_address',
      'label' => 'Footer address',
      'name'  => 'footer_address',
      'type'  => 'textarea',
      'rows'  => 6,
      'default_value' => "Address\n\nTall Agency Ltd\n5A Brewery Place\nLeeds\nLS10 1NE",
    ),
    array(
      'key'   => 'field_ai_dev_footer_info',
      'label' => 'Footer info',
      'name'  => 'footer_info',
      'type'  => 'textarea',
      'rows'  => 6,
      'default_value' => "Info\n\nCompany No. 10616180\nVAT No. 262 1974 96\n0113 519 7773\nhello@tall.agency",
    ),
    array(
      'key'   => 'field_ai_dev_footer_copyright',
      'label' => 'Footer copyright',
      'name'  => 'footer_copyright',
      'type'  => 'text',
      'default_value' => 'Copyright © 2025 Tall Agency Ltd',
    ),
    array(
      'key'   => 'field_ai_dev_footer_reshape_image',
      'label' => 'Footer reshape graphic',
      'name'  => 'footer_reshape_image',
      'type'  => 'image',
      'return_format' => 'array',
      'instructions' => 'Figma reshape/possible wordmark. Falls back to theme asset.',
    ),
    array(
      'key'   => 'field_ai_dev_agency_email',
      'label' => 'Agency Email',
      'name'  => 'agency_email',
      'type'  => 'email',
      'default_value' => 'hello@tall.agency',
    ),
    array(
      'key'   => 'field_ai_dev_footer_logos',
      'label' => 'Footer Logos',
      'name'  => 'footer_logos',
      'type'  => 'gallery',
      'return_format' => 'array',
      'preview_size' => 'logo',
    ),
    array(
      'key'   => 'field_ai_dev_default_og_image',
      'label' => 'Default OG Image',
      'name'  => 'default_og_image',
      'type'  => 'image',
      'return_format' => 'url',
    ),
  ),
  'location' => array(
    array(
      array(
        'param'    => 'options_page',
        'operator' => '==',
        'value'    => 'theme-settings',
      ),
    ),
  ),
));

acf_add_local_field_group(array(
  'key'    => 'group_ai_dev_page_settings',
  'title'  => 'Page Settings',
  'fields' => array(
    array(
      'key'   => 'field_ai_dev_nav_theme',
      'label' => 'Nav Theme',
      'name'  => 'nav_theme',
      'type'  => 'select',
      'choices' => array(
        'light' => 'Light',
        'dark'  => 'Dark',
      ),
      'default_value' => 'light',
    ),
    array(
      'key'   => 'field_ai_dev_lets_talk_form_id',
      'label' => "Let's Talk Form ID Override",
      'name'  => 'lets_talk_form_id',
      'type'  => 'number',
      'instructions' => 'Leave empty to use theme default.',
    ),
  ),
  'location' => array(
    array(
      array(
        'param'    => 'post_type',
        'operator' => '==',
        'value'    => 'page',
      ),
    ),
  ),
));
