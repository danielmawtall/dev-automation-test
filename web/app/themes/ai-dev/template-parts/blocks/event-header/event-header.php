<?php
$className = ai_dev_block_classes('event-header', $block, array('block--full-width'));
$media_type = get_field('media_type') ?: 'image';
$has_media = ai_dev_block_has_content(array(get_field('image'), get_field('video')));
$has_content = ai_dev_block_has_content(array(get_field('heading'), get_field('location'), get_field('date'), $has_media));
$buttons = get_field('buttons') ?: array();
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <?php if ($has_content) : ?>
    <div class="event-header__media-wrap">
      <?php if ($has_media) : ?>
        <?php
        get_template_part('template-parts/components/media', null, array(
          'type' => $media_type,
          'image' => get_field('image'),
          'video' => get_field('video'),
          'gif' => get_field('image'),
          'ratio' => '16-9',
          'loading' => 'eager',
        ));
        ?>
      <?php endif; ?>
      <div class="event-header__overlay" aria-hidden="true"></div>
    </div>
    <div class="container event-header__content">
      <div class="event-header__meta">
        <?php if (get_field('location')) : ?>
          <?php get_template_part('template-parts/components/caption', null, array('icon' => 'pin', 'text' => get_field('location'))); ?>
        <?php endif; ?>
        <?php if (get_field('date')) : ?>
          <?php get_template_part('template-parts/components/caption', null, array('icon' => 'star', 'text' => get_field('date'))); ?>
        <?php endif; ?>
      </div>
      <?php if (get_field('heading')) : ?>
        <h1 class="event-header__heading"><?php echo esc_html(get_field('heading')); ?></h1>
      <?php endif; ?>
      <?php if ($buttons) : ?>
        <div class="event-header__actions">
          <?php foreach ($buttons as $index => $row) :
            $btn = $row['button'] ?? array();
            if (empty($btn['label'])) {
              continue;
            }
            $position = $index === 0 ? 'left' : 'right';
            ?>
            <div class="event-header__action event-header__action--<?php echo esc_attr($position); ?>">
              <?php
              get_template_part('template-parts/components/button', null, array(
                'label' => $btn['label'],
                'url' => $btn['url'] ?? '#',
                'style' => $btn['style'] ?? 'underline',
                'new_tab' => !empty($btn['new_tab']),
              ));
              ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php else : ?>
    <div class="container"><h2 class="block__placeholder"><?php esc_html_e('Event Header', 'ai-dev'); ?></h2></div>
  <?php endif; ?>
</section>
