<?php
$className = ai_dev_block_classes('two-column-list', $block);
$bg = get_field('background') ?: 'white';
$left = get_field('left_items') ?: array();
$right = get_field('right_items') ?: array();
$has_content = ai_dev_block_has_content(array(get_field('heading'), $left, $right));

$render_items = static function (array $items): void {
  if (!$items) {
    return;
  }
  echo '<ul class="two-column-list__items">';
  foreach ($items as $item) {
    echo '<li class="two-column-list__item">';
    if (!empty($item['caption'])) {
      echo '<span class="two-column-list__item-caption">' . esc_html($item['caption']) . '</span>';
    }
    if (!empty($item['url'])) {
      echo '<a href="' . esc_url($item['url']) . '">' . esc_html($item['text']) . '</a>';
    } else {
      echo '<span>' . esc_html($item['text']) . '</span>';
    }
    echo '</li>';
  }
  echo '</ul>';
};
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?> two-column-list--<?php echo esc_attr($bg); ?>">
  <div class="container">
    <?php if ($has_content) : ?>
      <?php if (get_field('heading')) : ?>
        <h2 class="two-column-list__heading"><?php echo esc_html(get_field('heading')); ?></h2>
      <?php endif; ?>
      <div class="two-column-list__layout">
        <div class="two-column-list__col"><?php $render_items($left); ?></div>
        <div class="two-column-list__col"><?php $render_items($right); ?></div>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Two Column List', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
