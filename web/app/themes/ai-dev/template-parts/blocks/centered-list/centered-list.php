<?php
$className = ai_dev_block_classes('centered-list', $block);
$bg = get_field('background') ?: 'white';
$items = get_field('items');
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?> centered-list--<?php echo esc_attr($bg); ?>">
  <div class="container">
    <?php if (get_field('module_caption')) : ?>
      <p class="centered-list__module-caption"><?php echo esc_html(get_field('module_caption')); ?></p>
    <?php endif; ?>
    <?php if ($items) : ?>
      <ul class="centered-list__items">
        <?php foreach ($items as $item) : ?>
          <li class="centered-list__item">
            <?php if (!empty($item['caption'])) : ?>
              <span class="centered-list__item-caption"><?php echo esc_html($item['caption']); ?></span>
            <?php endif; ?>
            <?php if (!empty($item['url'])) : ?>
              <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['text']); ?></a>
            <?php else : ?>
              <span><?php echo esc_html($item['text']); ?></span>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else : ?>
      <h2 class="block__placeholder">Centered List</h2>
    <?php endif; ?>
  </div>
</section>
