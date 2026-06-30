<?php
/**
 * ACF field groups for content blocks.
 */

if (!function_exists('acf_add_local_field_group')) {
  return;
}

function ai_dev_button_subfields(string $prefix): array {
  return array(
    array('key' => "field_{$prefix}_btn_label", 'label' => 'Label', 'name' => 'label', 'type' => 'text'),
    array('key' => "field_{$prefix}_btn_url", 'label' => 'URL', 'name' => 'url', 'type' => 'url'),
    array(
      'key' => "field_{$prefix}_btn_style",
      'label' => 'Style',
      'name' => 'style',
      'type' => 'select',
      'choices' => array('underline' => 'Underline', 'solid' => 'Solid'),
      'default_value' => 'underline',
    ),
    array('key' => "field_{$prefix}_btn_new_tab", 'label' => 'Open in new tab', 'name' => 'new_tab', 'type' => 'true_false'),
  );
}

function ai_dev_media_grid_cell_subfields(string $prefix, string $name, string $label, bool $allow_stat = true): array {
  $type_choices = array('none' => 'Empty', 'image' => 'Image');
  if ($allow_stat) {
    $type_choices['stat'] = 'Stat panel';
  }

  return array(
    'key' => "field_{$prefix}_cell",
    'label' => $label,
    'name' => $name,
    'type' => 'group',
    'layout' => 'block',
    'sub_fields' => array(
      array(
        'key' => "field_{$prefix}_type",
        'label' => 'Cell type',
        'name' => 'type',
        'type' => 'select',
        'choices' => $type_choices,
        'default_value' => 'none',
      ),
      array(
        'key' => "field_{$prefix}_image",
        'label' => 'Image',
        'name' => 'image',
        'type' => 'image',
        'return_format' => 'array',
        'conditional_logic' => array(array(array('field' => "field_{$prefix}_type", 'operator' => '==', 'value' => 'image'))),
      ),
      array(
        'key' => "field_{$prefix}_ratio",
        'label' => 'Ratio',
        'name' => 'ratio',
        'type' => 'select',
        'choices' => array('16-9' => '16:9', '1-1' => '1:1', '4-5' => '4:5'),
        'default_value' => '16-9',
        'conditional_logic' => array(array(array('field' => "field_{$prefix}_type", 'operator' => '==', 'value' => 'image'))),
      ),
      array(
        'key' => "field_{$prefix}_stat_number",
        'label' => 'Stat number',
        'name' => 'stat_number',
        'type' => 'text',
        'conditional_logic' => array(array(array('field' => "field_{$prefix}_type", 'operator' => '==', 'value' => 'stat'))),
      ),
      array(
        'key' => "field_{$prefix}_stat_caption",
        'label' => 'Stat caption',
        'name' => 'stat_caption',
        'type' => 'text',
        'conditional_logic' => array(array(array('field' => "field_{$prefix}_type", 'operator' => '==', 'value' => 'stat'))),
      ),
    ),
  );
}

function ai_dev_buttons_repeater(string $prefix, int $max = 3): array {
  return array(
    'key' => "field_{$prefix}_buttons",
    'label' => 'Buttons',
    'name' => 'buttons',
    'type' => 'repeater',
    'max' => $max,
    'layout' => 'block',
    'button_label' => 'Add button',
    'sub_fields' => array(
      array(
        'key' => "field_{$prefix}_button_group",
        'label' => 'Button',
        'name' => 'button',
        'type' => 'group',
        'sub_fields' => ai_dev_button_subfields("{$prefix}_bg"),
      ),
    ),
  );
}

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_homepage_header',
  'title' => 'Block: Homepage Header',
  'fields' => array(
    array('key' => 'field_ai_dev_hh_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'textarea', 'rows' => 2),
    array('key' => 'field_ai_dev_hh_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
    array(
      'key' => 'field_ai_dev_hh_captions',
      'label' => 'Captions',
      'name' => 'captions',
      'type' => 'repeater',
      'max' => 5,
      'layout' => 'table',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_hh_cap_icon', 'label' => 'Icon', 'name' => 'icon', 'type' => 'select', 'choices' => array('dot' => 'Dot', 'star' => 'Star', 'pin' => 'Pin'), 'default_value' => 'dot'),
        array('key' => 'field_ai_dev_hh_cap_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text'),
      ),
    ),
    array(
      'key' => 'field_ai_dev_hh_media_type',
      'label' => 'Media type',
      'name' => 'media_type',
      'type' => 'select',
      'choices' => array('video' => 'Video', 'image' => 'Image', 'gif' => 'GIF'),
      'default_value' => 'video',
    ),
    array('key' => 'field_ai_dev_hh_video', 'label' => 'Video', 'name' => 'video', 'type' => 'file', 'return_format' => 'array', 'mime_types' => 'mp4'),
    array('key' => 'field_ai_dev_hh_image', 'label' => 'Image / GIF', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array(
      'key' => 'field_ai_dev_hh_cta',
      'label' => 'CTA Button',
      'name' => 'cta',
      'type' => 'group',
      'sub_fields' => ai_dev_button_subfields('ai_dev_hh_cta'),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/homepage-header'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_media_header',
  'title' => 'Block: Media Header',
  'fields' => array(
    array('key' => 'field_ai_dev_mh_media_type', 'label' => 'Media type', 'name' => 'media_type', 'type' => 'select', 'choices' => array('image' => 'Image', 'video' => 'Video', 'gif' => 'GIF'), 'default_value' => 'image'),
    array('key' => 'field_ai_dev_mh_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array('key' => 'field_ai_dev_mh_video', 'label' => 'Video', 'name' => 'video', 'type' => 'file', 'return_format' => 'array', 'mime_types' => 'mp4'),
    array('key' => 'field_ai_dev_mh_overlay', 'label' => 'Dark overlay', 'name' => 'overlay', 'type' => 'true_false', 'default_value' => 1),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/media-header'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_text_block',
  'title' => 'Block: Text',
  'fields' => array(
    array('key' => 'field_ai_dev_tb_caption_icon', 'label' => 'Caption icon', 'name' => 'caption_icon', 'type' => 'select', 'choices' => array('dot' => 'Dot', 'star' => 'Star'), 'allow_null' => 1),
    array('key' => 'field_ai_dev_tb_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_tb_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_tb_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
    array('key' => 'field_ai_dev_tb_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array('key' => 'field_ai_dev_tb_layout', 'label' => 'Layout', 'name' => 'layout', 'type' => 'select', 'choices' => array('two-col' => 'Two column', 'left' => 'Left aligned', 'right' => 'Right aligned'), 'default_value' => 'two-col'),
    array('key' => 'field_ai_dev_tb_style', 'label' => 'Style', 'name' => 'style', 'type' => 'select', 'choices' => array('' => 'Default', 'intro' => 'Homepage intro'), 'allow_null' => 1),
    ai_dev_buttons_repeater('ai_dev_tb'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/text-block'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_scrolling_logos',
  'title' => 'Block: Scrolling Logos',
  'fields' => array(
    array('key' => 'field_ai_dev_sl_logos', 'label' => 'Logos', 'name' => 'logos', 'type' => 'gallery', 'return_format' => 'array', 'preview_size' => 'logo', 'min' => 1, 'max' => 15),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/scrolling-logos'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_scrolling_text',
  'title' => 'Block: Scrolling Text',
  'fields' => array(
    array('key' => 'field_ai_dev_st_line1', 'label' => 'Line 1', 'name' => 'line_1', 'type' => 'text'),
    array('key' => 'field_ai_dev_st_line2', 'label' => 'Line 2', 'name' => 'line_2', 'type' => 'text'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/scrolling-text'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_case_study_grid',
  'title' => 'Block: Case Study Grid',
  'fields' => array(
    array('key' => 'field_ai_dev_csg_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_csg_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    ai_dev_buttons_repeater('ai_dev_csg'),
    array('key' => 'field_ai_dev_csg_studies', 'label' => 'Case studies', 'name' => 'case_studies', 'type' => 'relationship', 'post_type' => array('case-study'), 'filters' => array('search'), 'return_format' => 'object', 'max' => 6),
    array(
      'key' => 'field_ai_dev_csg_titles',
      'label' => 'Card title overrides',
      'name' => 'study_titles',
      'type' => 'repeater',
      'max' => 6,
      'layout' => 'table',
      'instructions' => 'Optional display titles matched to case study order.',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_csg_title_text', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/case-study-grid'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_featured_grid',
  'title' => 'Block: Featured Grid',
  'fields' => array(
    array('key' => 'field_ai_dev_fg_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'),
    array('key' => 'field_ai_dev_fg_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_fg_show_button', 'label' => 'Show button', 'name' => 'show_button', 'type' => 'true_false', 'default_value' => 1),
    array('key' => 'field_ai_dev_fg_button', 'label' => 'Button', 'name' => 'button', 'type' => 'group', 'sub_fields' => ai_dev_button_subfields('ai_dev_fg_btn')),
    array(
      'key' => 'field_ai_dev_fg_items',
      'label' => 'Featured items',
      'name' => 'items',
      'type' => 'repeater',
      'layout' => 'block',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_fg_item_media', 'label' => 'Media', 'name' => 'media', 'type' => 'image', 'return_format' => 'array', 'required' => 1),
        array('key' => 'field_ai_dev_fg_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
        array('key' => 'field_ai_dev_fg_item_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'),
        array('key' => 'field_ai_dev_fg_item_url', 'label' => 'Link URL', 'name' => 'url', 'type' => 'url'),
        array('key' => 'field_ai_dev_fg_item_ratio', 'label' => 'Ratio', 'name' => 'ratio', 'type' => 'select', 'choices' => array('16-9' => '16:9', '1-1' => '1:1', '4-5' => '4:5', 'short' => 'Short banner', 'forest' => 'Forest panel'), 'default_value' => '16-9'),
        array('key' => 'field_ai_dev_fg_item_pin', 'label' => 'Pin to top', 'name' => 'pin', 'type' => 'true_false'),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/featured-grid'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_skewed_reveal',
  'title' => 'Block: Skewed Reveal',
  'fields' => array(
    array('key' => 'field_ai_dev_sr_top', 'label' => 'Top word', 'name' => 'top_word', 'type' => 'text', 'default_value' => 'reshape'),
    array('key' => 'field_ai_dev_sr_bottom', 'label' => 'Bottom word', 'name' => 'bottom_word', 'type' => 'text', 'default_value' => 'possible'),
    array('key' => 'field_ai_dev_sr_image', 'label' => 'Centre image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array('key' => 'field_ai_dev_sr_study', 'label' => 'Case study (image fallback)', 'name' => 'case_study', 'type' => 'post_object', 'post_type' => array('case-study'), 'return_format' => 'object'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/skewed-reveal'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_work_grid',
  'title' => 'Block: Work Grid',
  'fields' => array(
    array('key' => 'field_ai_dev_wg_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'),
    array('key' => 'field_ai_dev_wg_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_wg_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_wg_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
    array('key' => 'field_ai_dev_wg_button', 'label' => 'Button', 'name' => 'button', 'type' => 'group', 'sub_fields' => ai_dev_button_subfields('ai_dev_wg_btn')),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/work-grid'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_centered_list',
  'title' => 'Block: Centered List',
  'fields' => array(
    array('key' => 'field_ai_dev_cl_title', 'label' => 'Module caption', 'name' => 'module_caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_cl_bg', 'label' => 'Background', 'name' => 'background', 'type' => 'select', 'choices' => array('white' => 'White', 'ivory' => 'Ivory', 'black' => 'Black', 'orange' => 'Orange'), 'default_value' => 'white'),
    array(
      'key' => 'field_ai_dev_cl_items',
      'label' => 'List items',
      'name' => 'items',
      'type' => 'repeater',
      'min' => 1,
      'max' => 15,
      'layout' => 'table',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_cl_item_cap', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
        array('key' => 'field_ai_dev_cl_item_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text'),
        array('key' => 'field_ai_dev_cl_item_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url'),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/centered-list'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_full_width_media',
  'title' => 'Block: Full Width Media',
  'fields' => array(
    array('key' => 'field_ai_dev_fwm_type', 'label' => 'Media type', 'name' => 'media_type', 'type' => 'select', 'choices' => array('image' => 'Image', 'video' => 'Video', 'gif' => 'GIF'), 'default_value' => 'image'),
    array('key' => 'field_ai_dev_fwm_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array('key' => 'field_ai_dev_fwm_video', 'label' => 'Video', 'name' => 'video', 'type' => 'file', 'return_format' => 'array', 'mime_types' => 'mp4'),
    array('key' => 'field_ai_dev_fwm_ratio', 'label' => 'Ratio', 'name' => 'ratio', 'type' => 'select', 'choices' => array('16-9' => '16:9', '1-1' => '1:1', '4-5' => '4:5'), 'default_value' => '16-9'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/full-width-media'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_full_container_media',
  'title' => 'Block: Full Container Media',
  'fields' => array(
    array('key' => 'field_ai_dev_fcm_type', 'label' => 'Media type', 'name' => 'media_type', 'type' => 'select', 'choices' => array('image' => 'Image', 'video' => 'Video', 'gif' => 'GIF'), 'default_value' => 'image'),
    array('key' => 'field_ai_dev_fcm_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array('key' => 'field_ai_dev_fcm_video', 'label' => 'Video', 'name' => 'video', 'type' => 'file', 'return_format' => 'array', 'mime_types' => 'mp4'),
    array('key' => 'field_ai_dev_fcm_ratio', 'label' => 'Ratio', 'name' => 'ratio', 'type' => 'select', 'choices' => array('16-9' => '16:9', '1-1' => '1:1', '4-5' => '4:5'), 'default_value' => '16-9'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/full-container-media'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_two_columns',
  'title' => 'Block: Two Columns',
  'fields' => array(
    array('key' => 'field_ai_dev_tc_left_heading', 'label' => 'Left heading', 'name' => 'left_heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_tc_left_body', 'label' => 'Left body', 'name' => 'left_body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
    array('key' => 'field_ai_dev_tc_right_cap', 'label' => 'Right caption', 'name' => 'right_caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_tc_right_heading', 'label' => 'Right heading', 'name' => 'right_heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_tc_right_cap2', 'label' => 'Right caption 2', 'name' => 'right_caption_2', 'type' => 'text'),
    array('key' => 'field_ai_dev_tc_right_body', 'label' => 'Right body', 'name' => 'right_body', 'type' => 'textarea', 'rows' => 3),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/two-columns'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_media_grid',
  'title' => 'Block: Media Grid',
  'fields' => array(
    ai_dev_media_grid_cell_subfields('ai_dev_mg_lt', 'left_top', 'Left top', true),
    ai_dev_media_grid_cell_subfields('ai_dev_mg_lb', 'left_bottom', 'Left bottom', true),
    ai_dev_media_grid_cell_subfields('ai_dev_mg_rt', 'right', 'Right (tall)', false),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/media-grid'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_cta_banner',
  'title' => 'Block: CTA Banner',
  'fields' => array(
    array('key' => 'field_ai_dev_cb_cap', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_cb_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_cb_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
    array('key' => 'field_ai_dev_cb_bg', 'label' => 'Background', 'name' => 'background', 'type' => 'select', 'choices' => array('white' => 'White', 'black' => 'Black', 'ivory' => 'Ivory', 'orange' => 'Orange', 'forest' => 'Forest'), 'default_value' => 'white'),
    ai_dev_buttons_repeater('ai_dev_cb'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/cta-banner'))),
));

$partial_media_location = static function (string $block): array {
  return array(array(array('param' => 'block', 'operator' => '==', 'value' => $block)));
};

foreach (array('three-quarter-media', 'half-container-media', 'quarter-container-media') as $partial_slug) {
  $prefix = 'ai_dev_' . str_replace('-', '_', $partial_slug);
  acf_add_local_field_group(array(
    'key' => 'group_' . $prefix,
    'title' => 'Block: ' . ucwords(str_replace('-', ' ', $partial_slug)),
    'fields' => ai_dev_standard_media_fields($prefix),
    'location' => $partial_media_location('acf/' . $partial_slug),
  ));
}

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_heading_block',
  'title' => 'Block: Heading',
  'fields' => array(
    array('key' => 'field_ai_dev_hb_caption_icon', 'label' => 'Caption icon', 'name' => 'caption_icon', 'type' => 'select', 'choices' => array('dot' => 'Dot', 'star' => 'Star'), 'allow_null' => 1),
    array('key' => 'field_ai_dev_hb_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_hb_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_hb_secondary', 'label' => 'Secondary text', 'name' => 'secondary', 'type' => 'text'),
    array('key' => 'field_ai_dev_hb_layout', 'label' => 'Layout', 'name' => 'layout', 'type' => 'select', 'choices' => array('space-between' => 'Space between', 'left' => 'Left aligned'), 'default_value' => 'space-between'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/heading-block'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_three_columns',
  'title' => 'Block: Three Columns',
  'fields' => array(
    array(
      'key' => 'field_ai_dev_thc_columns',
      'label' => 'Columns',
      'name' => 'columns',
      'type' => 'repeater',
      'min' => 1,
      'max' => 3,
      'layout' => 'block',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_thc_cap', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
        array('key' => 'field_ai_dev_thc_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
        array('key' => 'field_ai_dev_thc_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/three-columns'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_two_column_list',
  'title' => 'Block: Two Column List',
  'fields' => array(
    array('key' => 'field_ai_dev_tcl_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    ai_dev_background_field('ai_dev_tcl'),
    array(
      'key' => 'field_ai_dev_tcl_left',
      'label' => 'Left items',
      'name' => 'left_items',
      'type' => 'repeater',
      'layout' => 'table',
      'sub_fields' => ai_dev_list_item_subfields('ai_dev_tcl_left'),
    ),
    array(
      'key' => 'field_ai_dev_tcl_right',
      'label' => 'Right items',
      'name' => 'right_items',
      'type' => 'repeater',
      'layout' => 'table',
      'sub_fields' => ai_dev_list_item_subfields('ai_dev_tcl_right'),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/two-column-list'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_text_media',
  'title' => 'Block: Text & Media',
  'fields' => array(
    ai_dev_background_field('ai_dev_tm'),
    array('key' => 'field_ai_dev_tm_layout', 'label' => 'Layout', 'name' => 'layout', 'type' => 'select', 'choices' => array('default' => 'Default', 'reversed' => 'Reversed', 'split' => 'Split'), 'default_value' => 'default'),
    array('key' => 'field_ai_dev_tm_caption_icon', 'label' => 'Caption icon', 'name' => 'caption_icon', 'type' => 'select', 'choices' => array('dot' => 'Dot', 'star' => 'Star'), 'allow_null' => 1),
    array('key' => 'field_ai_dev_tm_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_tm_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_tm_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
    ai_dev_buttons_repeater('ai_dev_tm'),
    ...ai_dev_standard_media_fields('ai_dev_tm'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/text-media'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_sticky_scroll_media',
  'title' => 'Block: Sticky Scroll Media',
  'fields' => array(
    array(
      'key' => 'field_ai_dev_ssm_panels',
      'label' => 'Text panels',
      'name' => 'panels',
      'type' => 'repeater',
      'layout' => 'block',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_ssm_panel_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
        array('key' => 'field_ai_dev_ssm_panel_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
      ),
    ),
    ...ai_dev_standard_media_fields('ai_dev_ssm'),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/sticky-scroll-media'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_review_carousel',
  'title' => 'Block: Review Carousel',
  'fields' => array(
    array('key' => 'field_ai_dev_rc_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array(
      'key' => 'field_ai_dev_rc_reviews',
      'label' => 'Reviews',
      'name' => 'reviews',
      'type' => 'repeater',
      'layout' => 'block',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_rc_quote', 'label' => 'Quote', 'name' => 'quote', 'type' => 'textarea', 'rows' => 3),
        array('key' => 'field_ai_dev_rc_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text'),
        array('key' => 'field_ai_dev_rc_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text'),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/review-carousel'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_mobile_cs_carousel',
  'title' => 'Block: Mobile Case Study Carousel',
  'fields' => array(
    array('key' => 'field_ai_dev_mcc_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_mcc_studies', 'label' => 'Case studies', 'name' => 'case_studies', 'type' => 'relationship', 'post_type' => array('case-study'), 'filters' => array('search'), 'return_format' => 'object', 'max' => 8),
    array(
      'key' => 'field_ai_dev_mcc_titles',
      'label' => 'Card title overrides',
      'name' => 'study_titles',
      'type' => 'repeater',
      'max' => 8,
      'layout' => 'table',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_mcc_title_text', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/mobile-case-study-carousel'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_event_header',
  'title' => 'Block: Event Header',
  'fields' => array(
    array(
      'key' => 'field_ai_dev_eh_media_type',
      'label' => 'Media type',
      'name' => 'media_type',
      'type' => 'select',
      'choices' => array('image' => 'Image', 'video' => 'Video', 'gif' => 'GIF'),
      'default_value' => 'image',
    ),
    array('key' => 'field_ai_dev_eh_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array('key' => 'field_ai_dev_eh_video', 'label' => 'Video', 'name' => 'video', 'type' => 'file', 'return_format' => 'array', 'mime_types' => 'mp4'),
    array('key' => 'field_ai_dev_eh_location', 'label' => 'Location', 'name' => 'location', 'type' => 'text'),
    array('key' => 'field_ai_dev_eh_date', 'label' => 'Date', 'name' => 'date', 'type' => 'text'),
    array('key' => 'field_ai_dev_eh_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'textarea', 'rows' => 2),
    ai_dev_buttons_repeater('ai_dev_eh', 2),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/event-header'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_event_grid',
  'title' => 'Block: Event Grid',
  'fields' => array(
    array('key' => 'field_ai_dev_eg_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array(
      'key' => 'field_ai_dev_eg_layout',
      'label' => 'Layout',
      'name' => 'layout',
      'type' => 'select',
      'choices' => array('grid' => 'Grid', 'single' => 'Single card'),
      'default_value' => 'grid',
    ),
    array(
      'key' => 'field_ai_dev_eg_events',
      'label' => 'Events',
      'name' => 'events',
      'type' => 'repeater',
      'layout' => 'block',
      'min' => 1,
      'button_label' => 'Add event',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_eg_evt_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
        array('key' => 'field_ai_dev_eg_evt_label_1', 'label' => 'Label 1', 'name' => 'label_1', 'type' => 'text'),
        array('key' => 'field_ai_dev_eg_evt_label_2', 'label' => 'Label 2', 'name' => 'label_2', 'type' => 'text'),
        array('key' => 'field_ai_dev_eg_evt_label_3', 'label' => 'Label 3', 'name' => 'label_3', 'type' => 'text'),
        array('key' => 'field_ai_dev_eg_evt_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
        array('key' => 'field_ai_dev_eg_evt_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url'),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/event-grid'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_form_block',
  'title' => 'Block: Form',
  'fields' => array(
    array(
      'key' => 'field_ai_dev_fb_layout',
      'label' => 'Layout',
      'name' => 'layout',
      'type' => 'select',
      'choices' => array('left' => 'Intro left', 'right' => 'Intro right', 'centered' => 'Centered'),
      'default_value' => 'left',
    ),
    ai_dev_background_field('ai_dev_fb'),
    array('key' => 'field_ai_dev_fb_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => 'field_ai_dev_fb_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array('key' => 'field_ai_dev_fb_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
    array(
      'key' => 'field_ai_dev_fb_form_id',
      'label' => 'Gravity Form ID',
      'name' => 'form_id',
      'type' => 'number',
      'instructions' => 'Leave empty to use the site default Let\'s Talk form.',
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/form-block'))),
));

acf_add_local_field_group(array(
  'key' => 'group_ai_dev_text_media_carousel',
  'title' => 'Block: Text & Media Carousel',
  'fields' => array(
    array('key' => 'field_ai_dev_tmc_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
    array(
      'key' => 'field_ai_dev_tmc_slides',
      'label' => 'Slides',
      'name' => 'slides',
      'type' => 'repeater',
      'layout' => 'block',
      'min' => 1,
      'button_label' => 'Add slide',
      'sub_fields' => array(
        array('key' => 'field_ai_dev_tmc_slide_caption', 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
        array('key' => 'field_ai_dev_tmc_slide_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
        array('key' => 'field_ai_dev_tmc_slide_body', 'label' => 'Body', 'name' => 'body', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0),
        array('key' => 'field_ai_dev_tmc_slide_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
        array(
          'key' => 'field_ai_dev_tmc_slide_ratio',
          'label' => 'Ratio',
          'name' => 'ratio',
          'type' => 'select',
          'choices' => array('16-9' => '16:9', '1-1' => '1:1', '4-5' => '4:5'),
          'default_value' => '16-9',
        ),
      ),
    ),
  ),
  'location' => array(array(array('param' => 'block', 'operator' => '==', 'value' => 'acf/text-media-carousel'))),
));
