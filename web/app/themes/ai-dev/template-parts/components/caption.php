<?php
/**
 * Caption / label component.
 *
 * @var array $args icon, text
 */
if (empty($args['text'])) {
  return;
}
$icon = $args['icon'] ?? 'dot';
?>
<span class="caption caption--<?php echo esc_attr($icon); ?>">
  <span class="caption__icon" aria-hidden="true"></span>
  <span class="caption__text"><?php echo esc_html($args['text']); ?></span>
</span>
