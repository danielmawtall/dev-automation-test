</main>

<?php
$footer_address = get_field('footer_address', 'option');
$footer_info = get_field('footer_info', 'option');
$footer_copyright = get_field('footer_copyright', 'option') ?: 'Copyright © ' . gmdate('Y') . ' Tall Agency Ltd';
$reshape_image = get_field('footer_reshape_image', 'option');
$reshape_fallback = ai_dev_theme_uri() . '/assets/img/footer-reshape-possible.svg';
?>
<footer id="site-footer" class="site-footer">
  <?php if (has_nav_menu('footer-links')) : ?>
    <nav class="site-footer__top-links container" aria-label="<?php esc_attr_e('Footer features', 'ai-dev'); ?>">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'footer-links',
        'container'      => false,
        'menu_class'     => 'site-footer__top-menu',
        'fallback_cb'    => false,
      ));
      ?>
    </nav>
  <?php endif; ?>

  <div class="site-footer__main container">
    <?php if ($footer_address) : ?>
      <div class="site-footer__col site-footer__col--address">
        <?php echo wp_kses_post(wpautop($footer_address)); ?>
      </div>
    <?php endif; ?>

    <?php if ($footer_info) : ?>
      <div class="site-footer__col site-footer__col--info">
        <?php echo wp_kses_post(make_clickable(wpautop($footer_info))); ?>
      </div>
    <?php endif; ?>

    <?php if (has_nav_menu('footer-info')) : ?>
      <nav class="site-footer__col site-footer__col--links" aria-label="<?php esc_attr_e('Footer pages', 'ai-dev'); ?>">
        <p class="site-footer__col-heading"><?php esc_html_e('Links', 'ai-dev'); ?></p>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'footer-info',
          'container'      => false,
          'menu_class'     => 'site-footer__menu',
          'fallback_cb'    => false,
        ));
        ?>
      </nav>
    <?php endif; ?>

    <?php if ($logos = get_field('footer_logos', 'option')) : ?>
      <div class="site-footer__col site-footer__col--logos">
        <?php foreach ($logos as $logo) :
          if (empty($logo['url'])) {
            continue;
          }
          ?>
          <img src="<?php echo esc_url(ai_dev_fix_wpe_url($logo['sizes']['logo'] ?? $logo['url'])); ?>" alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>" loading="lazy">
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="site-footer__reshape" aria-hidden="true">
    <?php if ($reshape_image && !empty($reshape_image['ID'])) : ?>
      <?php echo wp_get_attachment_image($reshape_image['ID'], 'full', false, array('class' => 'site-footer__reshape-image')); ?>
    <?php else : ?>
      <img class="site-footer__reshape-image" src="<?php echo esc_url($reshape_fallback); ?>" alt="" loading="lazy">
    <?php endif; ?>
  </div>

  <div class="site-footer__bar container">
    <p class="site-footer__copyright"><?php echo esc_html($footer_copyright); ?></p>
    <button class="site-footer__back-to-top button button--underline" type="button" data-back-to-top>
      <span class="button__label"><?php esc_html_e('Back to top', 'ai-dev'); ?></span>
      <span class="button__arrow" aria-hidden="true"></span>
    </button>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
