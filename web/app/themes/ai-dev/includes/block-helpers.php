<?php
/**
 * Shared block field definitions and render helpers.
 */

function ai_dev_standard_media_fields(string $prefix): array {
  return array(
    array(
      'key' => "field_{$prefix}_media_type",
      'label' => 'Media type',
      'name' => 'media_type',
      'type' => 'select',
      'choices' => array('image' => 'Image', 'video' => 'Video', 'gif' => 'GIF'),
      'default_value' => 'image',
    ),
    array('key' => "field_{$prefix}_image", 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
    array('key' => "field_{$prefix}_video", 'label' => 'Video', 'name' => 'video', 'type' => 'file', 'return_format' => 'array', 'mime_types' => 'mp4'),
    array(
      'key' => "field_{$prefix}_ratio",
      'label' => 'Ratio',
      'name' => 'ratio',
      'type' => 'select',
      'choices' => array('16-9' => '16:9', '1-1' => '1:1', '4-5' => '4:5'),
      'default_value' => '16-9',
    ),
  );
}

function ai_dev_list_item_subfields(string $prefix): array {
  return array(
    array('key' => "field_{$prefix}_item_cap", 'label' => 'Caption', 'name' => 'caption', 'type' => 'text'),
    array('key' => "field_{$prefix}_item_text", 'label' => 'Text', 'name' => 'text', 'type' => 'text'),
    array('key' => "field_{$prefix}_item_url", 'label' => 'URL', 'name' => 'url', 'type' => 'url'),
  );
}

function ai_dev_background_field(string $prefix, string $name = 'background'): array {
  return array(
    'key' => "field_{$prefix}_bg",
    'label' => 'Background',
    'name' => $name,
    'type' => 'select',
    'choices' => array(
      'white' => 'White',
      'ivory' => 'Ivory',
      'black' => 'Black',
      'orange' => 'Orange',
      'forest' => 'Forest',
    ),
    'default_value' => 'white',
  );
}

function ai_dev_render_block_media(): void {
  $media_type = get_field('media_type') ?: 'image';
  get_template_part('template-parts/components/media', null, array(
    'type' => $media_type,
    'image' => get_field('image'),
    'video' => get_field('video'),
    'gif' => get_field('image'),
    'ratio' => get_field('ratio') ?: '16-9',
    'size' => 'media-full',
  ));
}

function ai_dev_render_partial_container_media(array $block, string $slug, string $width): void {
  $className = ai_dev_block_classes($slug, $block, array("{$slug}--{$width}"));
  $has_content = ai_dev_block_has_content(array(get_field('image'), get_field('video')));
  ?>
  <section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
    <div class="container">
      <?php if ($has_content) : ?>
        <div class="<?php echo esc_attr($slug); ?>__inner">
          <?php ai_dev_render_block_media(); ?>
        </div>
      <?php else : ?>
        <h2 class="block__placeholder"><?php echo esc_html(ucwords(str_replace('-', ' ', $slug))); ?></h2>
      <?php endif; ?>
    </div>
  </section>
  <?php
}
