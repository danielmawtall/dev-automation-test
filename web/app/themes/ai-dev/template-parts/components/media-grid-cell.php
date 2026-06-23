<?php
/**
 * Single cell for the media grid block.
 *
 * @var array  $args cell, slot (left-top|left-bottom|right)
 */
$cell = $args['cell'] ?? array();
$slot = $args['slot'] ?? '';
$type = $cell['type'] ?? 'none';

if ($type === 'none' || $type === '') {
  return;
}

$modifiers = array('media-grid__cell');
if ($slot) {
  $modifiers[] = 'media-grid__cell--' . $slot;
}
?>
<div class="<?php echo esc_attr(implode(' ', $modifiers)); ?>">
  <?php if ($type === 'image' && !empty($cell['image'])) :
    $ratio = $cell['ratio'] ?? ($slot === 'right' ? '4-5' : '16-9');
    if ($slot === 'left-bottom') {
      $ratio = $cell['ratio'] ?? '1-1';
    }
    get_template_part('template-parts/components/media', null, array(
      'type' => 'image',
      'image' => $cell['image'],
      'ratio' => $ratio,
      'size' => 'media-container',
    ));
  elseif ($type === 'stat' && (!empty($cell['stat_number']) || !empty($cell['stat_caption']))) : ?>
    <div class="media-grid__stat">
      <?php if (!empty($cell['stat_caption'])) : ?>
        <div class="media-grid__stat-caption">
          <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => $cell['stat_caption'])); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($cell['stat_number'])) : ?>
        <p class="media-grid__stat-number" aria-hidden="true"><?php echo esc_html($cell['stat_number']); ?></p>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
