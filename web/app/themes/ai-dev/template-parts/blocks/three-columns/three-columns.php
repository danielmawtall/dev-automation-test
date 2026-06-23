<?php
$className = ai_dev_block_classes('three-columns', $block);
$columns = get_field('columns') ?: array();
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($columns) : ?>
      <div class="three-columns__grid">
        <?php foreach ($columns as $column) : ?>
          <div class="three-columns__col">
            <?php if (!empty($column['caption'])) : ?>
              <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => $column['caption'])); ?>
            <?php endif; ?>
            <?php if (!empty($column['heading'])) : ?>
              <h3 class="three-columns__heading"><?php echo esc_html($column['heading']); ?></h3>
            <?php endif; ?>
            <?php if (!empty($column['body'])) : ?>
              <div class="three-columns__body"><?php echo wp_kses_post($column['body']); ?></div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Three Columns', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
