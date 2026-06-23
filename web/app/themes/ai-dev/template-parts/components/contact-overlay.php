<?php
$form_id = ai_dev_get_lets_talk_form_id();
?>
<div class="contact-overlay" data-contact-overlay hidden>
  <div class="contact-overlay__backdrop" data-contact-close></div>
  <aside class="contact-overlay__panel" role="dialog" aria-labelledby="contact-overlay-title" aria-modal="true">
    <button class="contact-overlay__close" type="button" data-contact-close aria-label="<?php esc_attr_e('Close', 'ai-dev'); ?>">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="contact-overlay__inner">
      <h2 id="contact-overlay-title" class="contact-overlay__title"><?php esc_html_e("Let's Talk", 'ai-dev'); ?></h2>
      <?php if (function_exists('gravity_form') && $form_id) : ?>
        <?php gravity_form($form_id, false, false, false, null, true); ?>
      <?php else : ?>
        <p class="contact-overlay__placeholder"><?php esc_html_e('Add a Gravity Form and set the default form ID in Theme Settings.', 'ai-dev'); ?></p>
      <?php endif; ?>
    </div>
  </aside>
</div>
