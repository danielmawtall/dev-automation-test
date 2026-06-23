<?php
$className = ai_dev_block_classes('text-media', $block);
$bg = get_field('background') ?: 'white';
$layout = get_field('layout') ?: 'default';
$has_text = ai_dev_block_has_content(array(get_field('heading'), get_field('body'), get_field('caption')));
$has_media = ai_dev_block_has_content(array(get_field('image'), get_field('video')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?> text-media--<?php echo esc_attr($bg); ?> text-media--<?php echo esc_attr($layout); ?>">
  <div class="container">
    <?php if ($has_text || $has_media) : ?>
      <div class="text-media__layout">
        <div class="text-media__content">
          <?php if (get_field('caption')) : ?>
            <?php get_template_part('template-parts/components/caption', null, array('icon' => get_field('caption_icon') ?: 'dot', 'text' => get_field('caption'))); ?>
          <?php endif; ?>
          <?php if (get_field('heading')) : ?>
            <h2 class="text-media__heading"><?php echo esc_html(get_field('heading')); ?></h2>
          <?php endif; ?>
          <?php if (get_field('body')) : ?>
            <div class="text-media__body"><?php echo wp_kses_post(get_field('body')); ?></div>
          <?php endif; ?>
          <?php get_template_part('template-parts/components/ctas-list', null, array('buttons' => get_field('buttons'))); ?>
        </div>
        <?php if ($has_media) : ?>
          <div class="text-media__media">
            <?php ai_dev_render_block_media(); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Text & Media', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
