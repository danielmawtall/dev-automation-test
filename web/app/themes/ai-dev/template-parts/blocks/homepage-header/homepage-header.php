<?php
$className = ai_dev_block_classes('homepage-header', $block, array('block--full-width'));
$heading = get_field('heading');
$body = get_field('body');
$captions = get_field('captions');
$media_type = get_field('media_type') ?: 'video';
$has_content = ai_dev_block_has_content(array($heading, $body, $captions, get_field('image'), get_field('video')));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <?php if ($has_content) : ?>
    <?php if ($heading) : ?>
      <div class="homepage-header__marquee" aria-hidden="true">
        <span class="homepage-header__marquee-text"><?php echo esc_html($heading); ?></span>
      </div>
    <?php endif; ?>
    <div class="homepage-header__stage">
      <?php if ($captions) : ?>
        <div class="homepage-header__captions">
          <?php foreach ($captions as $caption) :
            get_template_part('template-parts/components/caption', null, $caption);
          endforeach; ?>
        </div>
      <?php endif; ?>
      <div class="homepage-header__media">
        <?php
        get_template_part('template-parts/components/media', null, array(
          'type' => $media_type,
          'image' => get_field('image'),
          'video' => get_field('video'),
          'gif' => get_field('image'),
          'ratio' => '4-5',
          'loading' => 'eager',
        ));
        ?>
      </div>
      <div class="homepage-header__copy">
        <?php if ($body) : ?>
          <div class="homepage-header__body"><?php echo wp_kses_post($body); ?></div>
        <?php endif; ?>
        <?php
        $cta = get_field('cta');
        if (!empty($cta['label']) && !empty($cta['url'])) {
          get_template_part('template-parts/components/button', null, $cta);
        }
        ?>
      </div>
    </div>
  <?php else : ?>
    <div class="container"><h2 class="block__placeholder">Homepage Header</h2></div>
  <?php endif; ?>
</section>
