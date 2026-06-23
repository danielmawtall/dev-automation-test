<?php
$className = ai_dev_block_classes('cta-banner', $block);
$bg = get_field('background') ?: 'white';
$has_content = ai_dev_block_has_content(array(get_field('heading'), get_field('body')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?> cta-banner--<?php echo esc_attr($bg); ?>">
  <div class="container cta-banner__inner">
    <?php if ($has_content) : ?>
      <?php if (get_field('caption')) : ?>
        <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('caption'))); ?>
      <?php endif; ?>
      <?php if (get_field('heading')) : ?>
        <h2 class="cta-banner__heading"><?php echo esc_html(get_field('heading')); ?></h2>
      <?php endif; ?>
      <?php if (get_field('body')) : ?>
        <div class="cta-banner__body"><?php echo wp_kses_post(get_field('body')); ?></div>
      <?php endif; ?>
      <?php get_template_part('template-parts/components/ctas-list', null, array('buttons' => get_field('buttons'))); ?>
    <?php else : ?>
      <h2 class="block__placeholder">CTA Banner</h2>
    <?php endif; ?>
  </div>
</section>
