<?php
$className = 'spacer block';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
$style = sprintf(
  '--spacer-top-desktop:%dpx;--spacer-bottom-desktop:%dpx;--spacer-top-mobile:%dpx;--spacer-bottom-mobile:%dpx;',
  (int) get_field('padding_top_desktop'),
  (int) get_field('padding_bottom_desktop'),
  (int) get_field('padding_top_mobile'),
  (int) get_field('padding_bottom_mobile')
);
?>
<div <?php if (!empty($block['anchor'])) { echo 'id="' . esc_attr($block['anchor']) . '"'; } ?> class="<?php echo esc_attr($className); ?>" style="<?php echo esc_attr($style); ?>" aria-hidden="true"></div>
