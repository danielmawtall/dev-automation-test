<?php
$className = ai_dev_block_classes('heading-block', $block);
$layout = get_field('layout') ?: 'space-between';
$has_content = ai_dev_block_has_content(array(get_field('heading'), get_field('secondary')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?> heading-block--<?php echo esc_attr($layout); ?>">
  <div class="container">
    <?php if ($has_content) : ?>
      <div class="heading-block__row">
        <div class="heading-block__primary">
          <?php if (get_field('caption')) : ?>
            <?php get_template_part('template-parts/components/caption', null, array('icon' => get_field('caption_icon') ?: 'dot', 'text' => get_field('caption'))); ?>
          <?php endif; ?>
          <?php if (get_field('heading')) : ?>
            <h2 class="heading-block__heading"><?php echo esc_html(get_field('heading')); ?></h2>
          <?php endif; ?>
        </div>
        <?php if (get_field('secondary')) : ?>
          <p class="heading-block__secondary"><?php echo esc_html(get_field('secondary')); ?></p>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Heading', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
