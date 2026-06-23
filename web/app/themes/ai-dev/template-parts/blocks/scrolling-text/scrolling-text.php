<?php
$className = ai_dev_block_classes('scrolling-text', $block, array('block--full-width'));
$line1 = get_field('line_1');
$line2 = get_field('line_2');
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <?php if ($line1 || $line2) : ?>
    <div class="scrolling-text__lines" data-scrolling-text>
      <?php if ($line1) : ?><span class="scrolling-text__line scrolling-text__line--1"><?php echo esc_html($line1); ?></span><?php endif; ?>
      <?php if ($line2) : ?><span class="scrolling-text__line scrolling-text__line--2"><?php echo esc_html($line2); ?></span><?php endif; ?>
    </div>
  <?php else : ?>
    <div class="container"><h2 class="block__placeholder">Scrolling Text</h2></div>
  <?php endif; ?>
</section>
