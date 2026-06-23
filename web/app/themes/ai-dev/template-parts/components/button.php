<?php
/**
 * Button / CTA link.
 *
 * @var array $args label, url, style, new_tab
 */
if (empty($args['label']) || empty($args['url'])) {
  return;
}
$style = $args['style'] ?? 'underline';
$class = 'button button--' . esc_attr($style);
?>
<a
  href="<?php echo esc_url($args['url']); ?>"
  class="<?php echo $class; ?>"
  <?php if (!empty($args['new_tab'])) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
>
  <span class="button__label"><?php echo esc_html($args['label']); ?></span>
  <span class="button__arrow" aria-hidden="true"></span>
</a>
