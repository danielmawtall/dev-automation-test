<?php
$className = ai_dev_block_classes('full-width-media', $block, array('block--full-width'));
$media_type = get_field('media_type') ?: 'image';
$has_content = ai_dev_block_has_content(array(get_field('image'), get_field('video')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <?php if ($has_content) : ?>
    <?php
    get_template_part('template-parts/components/media', null, array(
      'type' => $media_type,
      'image' => get_field('image'),
      'video' => get_field('video'),
      'gif' => get_field('image'),
      'ratio' => get_field('ratio') ?: '16-9',
    ));
    ?>
  <?php else : ?>
    <div class="container"><h2 class="block__placeholder">Full Width Media</h2></div>
  <?php endif; ?>
</section>
