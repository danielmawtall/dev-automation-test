<?php
/**
 * Up to three CTA buttons.
 *
 * @var array $args buttons (repeater rows with label, url, style, new_tab)
 */
$buttons = $args['buttons'] ?? array();
if (empty($buttons)) {
  return;
}
?>
<div class="ctas-list">
  <?php foreach ($buttons as $button) :
    $cta = $button['button'] ?? $button;
    get_template_part('template-parts/components/button', null, $cta);
  endforeach; ?>
</div>
