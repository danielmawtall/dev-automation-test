<?php
$className = ai_dev_block_classes('sticky-scroll-media', $block);
$panels = get_field('panels') ?: array();
$has_media = ai_dev_block_has_content(array(get_field('image'), get_field('video')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($panels || $has_media) : ?>
      <div class="sticky-scroll-media__layout">
        <div class="sticky-scroll-media__panels">
          <?php foreach ($panels as $panel) : ?>
            <article class="sticky-scroll-media__panel">
              <?php if (!empty($panel['heading'])) : ?>
                <h2 class="sticky-scroll-media__heading"><?php echo esc_html($panel['heading']); ?></h2>
              <?php endif; ?>
              <?php if (!empty($panel['body'])) : ?>
                <div class="sticky-scroll-media__body"><?php echo wp_kses_post($panel['body']); ?></div>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
        <?php if ($has_media) : ?>
          <div class="sticky-scroll-media__media">
            <?php ai_dev_render_block_media(); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Sticky Scroll Media', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
