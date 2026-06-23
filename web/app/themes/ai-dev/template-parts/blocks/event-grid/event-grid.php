<?php
$className = ai_dev_block_classes('event-grid', $block);
$items = get_field('events') ?: array();
$layout = get_field('layout') ?: 'grid';
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?> event-grid--<?php echo esc_attr($layout); ?>">
  <div class="container">
    <?php if ($items) : ?>
      <?php if (get_field('heading')) : ?>
        <h2 class="event-grid__heading"><?php echo esc_html(get_field('heading')); ?></h2>
      <?php endif; ?>
      <div class="event-grid__items">
        <?php foreach ($items as $item) :
          $labels = array();
          if (!empty($item['label_1'])) {
            $labels[] = $item['label_1'];
          }
          if (!empty($item['label_2'])) {
            $labels[] = $item['label_2'];
          }
          if (!empty($item['label_3'])) {
            $labels[] = $item['label_3'];
          }
          get_template_part('template-parts/components/event-card', null, array(
            'image' => $item['image'] ?? null,
            'labels' => $labels,
            'title' => $item['title'] ?? '',
            'url' => $item['url'] ?? '',
          ));
        endforeach; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Event Grid', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
