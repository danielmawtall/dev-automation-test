<?php
$className = ai_dev_block_classes('media-grid', $block);
$cells = array(
  array('cell' => get_field('left_top') ?: array(), 'slot' => 'left-top'),
  array('cell' => get_field('left_bottom') ?: array(), 'slot' => 'left-bottom'),
  array('cell' => get_field('right') ?: array(), 'slot' => 'right'),
);

$has_content = false;
foreach ($cells as $item) {
  $type = $item['cell']['type'] ?? 'none';
  if ($type === 'image' && !empty($item['cell']['image'])) {
    $has_content = true;
    break;
  }
  if ($type === 'stat' && (!empty($item['cell']['stat_number']) || !empty($item['cell']['stat_caption']))) {
    $has_content = true;
    break;
  }
}
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($has_content) : ?>
      <div class="media-grid__layout">
        <?php foreach ($cells as $item) :
          get_template_part('template-parts/components/media-grid-cell', null, $item);
        endforeach; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Media Grid', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
