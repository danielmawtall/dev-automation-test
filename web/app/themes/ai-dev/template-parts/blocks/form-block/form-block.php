<?php
$className = ai_dev_block_classes('form-block', $block);
$layout = get_field('layout') ?: 'left';
$bg = get_field('background') ?: 'white';
$form_id = (int) (get_field('form_id') ?: ai_dev_get_lets_talk_form_id());
$has_intro = ai_dev_block_has_content(array(get_field('heading'), get_field('body'), get_field('caption')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?> form-block--<?php echo esc_attr($layout); ?> form-block--<?php echo esc_attr($bg); ?>">
  <div class="container">
    <div class="form-block__layout">
      <?php if ($has_intro) : ?>
        <div class="form-block__intro">
          <?php if (get_field('caption')) : ?>
            <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('caption'))); ?>
          <?php endif; ?>
          <?php if (get_field('heading')) : ?>
            <h2 class="form-block__heading"><?php echo esc_html(get_field('heading')); ?></h2>
          <?php endif; ?>
          <?php if (get_field('body')) : ?>
            <div class="form-block__body"><?php echo wp_kses_post(get_field('body')); ?></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <div class="form-block__form">
        <?php if (function_exists('gravity_form') && $form_id) : ?>
          <?php gravity_form($form_id, false, false, false, null, true); ?>
        <?php else : ?>
          <p class="block__placeholder"><?php esc_html_e('Gravity Form', 'ai-dev'); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
