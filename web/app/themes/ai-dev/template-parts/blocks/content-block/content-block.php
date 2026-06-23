<?php
$className = 'content-block block';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<section <?php if (!empty($block['anchor'])) { echo 'id="' . esc_attr($block['anchor']) . '"'; } ?> class="<?php echo esc_attr($className); ?>">
  <div class="container">
    <h2 class="block__placeholder"><?php echo esc_html('Content Block'); ?> Block</h2>
  </div>
</section>
