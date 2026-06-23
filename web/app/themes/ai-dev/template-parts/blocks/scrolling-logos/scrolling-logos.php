<?php
$className = ai_dev_block_classes('scrolling-logos', $block, array('block--full-width'));
$logos = get_field('logos');
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <?php if ($logos) : ?>
    <div class="scrolling-logos__track" data-scrolling-logos>
      <div class="scrolling-logos__inner">
        <?php foreach (array_merge($logos, $logos) as $logo) : ?>
          <img class="scrolling-logos__logo" src="<?php echo esc_url(ai_dev_fix_wpe_url($logo['sizes']['logo'] ?? $logo['url'])); ?>" alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>" loading="lazy">
        <?php endforeach; ?>
      </div>
    </div>
  <?php else : ?>
    <div class="container"><h2 class="block__placeholder">Scrolling Logos</h2></div>
  <?php endif; ?>
</section>
