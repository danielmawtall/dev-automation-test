<?php
$className = ai_dev_block_classes('text-block', $block);
$layout = get_field('layout') ?: 'two-col';
$style = get_field('style') ?: '';
$has_content = ai_dev_block_has_content(array(get_field('heading'), get_field('body'), get_field('caption'), get_field('image')));
$modifiers = array('text-block--' . $layout);
if ($style) {
  $modifiers[] = 'text-block--' . $style;
}
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo esc_attr(implode(' ', array_merge(array($className), $modifiers))); ?>">
  <div class="container text-block__grid">
    <?php if ($has_content) : ?>
      <?php if (get_field('caption')) : ?>
        <div class="text-block__caption-col">
          <?php get_template_part('template-parts/components/caption', null, array('icon' => get_field('caption_icon') ?: 'dot', 'text' => get_field('caption'))); ?>
        </div>
      <?php endif; ?>
      <div class="text-block__content">
        <?php if (get_field('heading')) : ?>
          <h2 class="text-block__heading"><?php echo esc_html(get_field('heading')); ?></h2>
        <?php endif; ?>
        <?php if (get_field('body')) : ?>
          <div class="text-block__body"><?php echo wp_kses_post(get_field('body')); ?></div>
        <?php endif; ?>
        <?php get_template_part('template-parts/components/ctas-list', null, array('buttons' => get_field('buttons'))); ?>
      </div>
      <?php if (get_field('image')) : ?>
        <div class="text-block__image-col">
          <?php get_template_part('template-parts/components/media', null, array(
            'type' => 'image',
            'image' => get_field('image'),
            'size' => 'media-full',
          )); ?>
        </div>
      <?php endif; ?>
    <?php else : ?>
      <h2 class="block__placeholder">Text Block</h2>
    <?php endif; ?>
  </div>
</section>
