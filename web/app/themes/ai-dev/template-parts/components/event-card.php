<?php
/**
 * Event card (Figma 2A).
 *
 * @var array $args image, labels, title, url
 */
$image = $args['image'] ?? null;
$labels = $args['labels'] ?? array();
$title = $args['title'] ?? '';
$url = $args['url'] ?? '';
$tag = $url ? 'a' : 'div';
$attrs = $url ? ' href="' . esc_url($url) . '"' : '';
?>
<article class="event-card">
  <<?php echo $tag; ?> class="event-card__inner"<?php echo $attrs; ?>>
    <?php if ($image && !empty($image['ID'])) : ?>
      <div class="event-card__media">
        <?php echo wp_get_attachment_image($image['ID'], 'card-square', false, array('class' => 'event-card__image')); ?>
      </div>
    <?php endif; ?>
    <div class="event-card__body">
      <?php if ($labels) : ?>
        <p class="event-card__labels">
          <?php foreach ($labels as $index => $label) : ?>
            <?php if ($index > 0) : ?><span class="event-card__label-sep">/</span><?php endif; ?>
            <span><?php echo esc_html($label); ?></span>
          <?php endforeach; ?>
        </p>
      <?php endif; ?>
      <?php if ($title) : ?>
        <h3 class="event-card__title"><?php echo esc_html($title); ?></h3>
      <?php endif; ?>
    </div>
  </<?php echo $tag; ?>>
</article>
