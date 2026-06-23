<?php
$className = ai_dev_block_classes('full-container-media', $block);
$media_type = get_field('media_type') ?: 'image';
$has_content = ai_dev_block_has_content(array(get_field('image'), get_field('video')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($has_content) : ?>
      <?php
      get_template_part('template-parts/components/media', null, array(
        'type' => $media_type,
        'image' => get_field('image'),
        'video' => get_field('video'),
        'gif' => get_field('image'),
        'ratio' => get_field('ratio') ?: '16-9',
        'size' => 'media-container',
      ));
      ?>
    <?php else : ?>
      <h2 class="block__placeholder">Full Container Media</h2>
    <?php endif; ?>
  </div>
</section>
