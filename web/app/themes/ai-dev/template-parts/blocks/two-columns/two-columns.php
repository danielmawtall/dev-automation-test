<?php
$className = ai_dev_block_classes('two-columns', $block);
$has_content = ai_dev_block_has_content(array(
  get_field('left_heading'),
  get_field('left_body'),
  get_field('right_heading'),
  get_field('right_body'),
));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($has_content) : ?>
      <div class="two-columns__layout">
        <div class="two-columns__left">
          <?php if (get_field('left_heading')) : ?>
            <h2 class="two-columns__left-heading"><?php echo esc_html(get_field('left_heading')); ?></h2>
          <?php endif; ?>
          <?php if (get_field('left_body')) : ?>
            <div class="two-columns__left-body"><?php echo wp_kses_post(get_field('left_body')); ?></div>
          <?php endif; ?>
        </div>
        <div class="two-columns__meta">
          <?php if (get_field('right_caption') || get_field('right_heading')) : ?>
            <div class="two-columns__meta-block">
              <?php if (get_field('right_caption')) : ?>
                <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('right_caption'))); ?>
              <?php endif; ?>
              <?php if (get_field('right_heading')) : ?>
                <h3 class="two-columns__meta-heading"><?php echo esc_html(get_field('right_heading')); ?></h3>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if (get_field('right_caption_2') || get_field('right_body')) : ?>
            <div class="two-columns__meta-block">
              <?php if (get_field('right_caption_2')) : ?>
                <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('right_caption_2'))); ?>
              <?php endif; ?>
              <?php if (get_field('right_body')) : ?>
                <p class="two-columns__meta-body"><?php echo esc_html(get_field('right_body')); ?></p>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Two Columns', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
