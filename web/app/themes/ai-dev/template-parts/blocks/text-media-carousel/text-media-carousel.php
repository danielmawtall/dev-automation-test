<?php
$className = ai_dev_block_classes('text-media-carousel', $block);
$slides = get_field('slides') ?: array();
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($slides) : ?>
      <?php if (get_field('heading')) : ?>
        <h2 class="text-media-carousel__title"><?php echo esc_html(get_field('heading')); ?></h2>
      <?php endif; ?>
      <div class="text-media-carousel__track" tabindex="0">
        <?php foreach ($slides as $slide) : ?>
          <article class="text-media-carousel__slide">
            <div class="text-media-carousel__content">
              <?php if (!empty($slide['caption'])) : ?>
                <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => $slide['caption'])); ?>
              <?php endif; ?>
              <?php if (!empty($slide['heading'])) : ?>
                <h3 class="text-media-carousel__heading"><?php echo esc_html($slide['heading']); ?></h3>
              <?php endif; ?>
              <?php if (!empty($slide['body'])) : ?>
                <div class="text-media-carousel__body"><?php echo wp_kses_post($slide['body']); ?></div>
              <?php endif; ?>
            </div>
            <?php if (!empty($slide['image'])) : ?>
              <div class="text-media-carousel__media">
                <?php
                get_template_part('template-parts/components/media', null, array(
                  'type' => 'image',
                  'image' => $slide['image'],
                  'ratio' => $slide['ratio'] ?? '16-9',
                ));
                ?>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Text & Media Carousel', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
