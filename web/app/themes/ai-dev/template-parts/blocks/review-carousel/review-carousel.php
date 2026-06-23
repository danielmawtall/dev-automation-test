<?php
$className = ai_dev_block_classes('review-carousel', $block);
$items = get_field('reviews') ?: array();
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($items) : ?>
      <?php if (get_field('heading')) : ?>
        <h2 class="review-carousel__title"><?php echo esc_html(get_field('heading')); ?></h2>
      <?php endif; ?>
      <div class="review-carousel__track" tabindex="0">
        <?php foreach ($items as $item) : ?>
          <blockquote class="review-carousel__slide">
            <?php if (!empty($item['quote'])) : ?>
              <p class="review-carousel__quote"><?php echo esc_html($item['quote']); ?></p>
            <?php endif; ?>
            <?php if (!empty($item['name']) || !empty($item['role'])) : ?>
              <footer class="review-carousel__meta">
                <?php if (!empty($item['name'])) : ?>
                  <cite class="review-carousel__name"><?php echo esc_html($item['name']); ?></cite>
                <?php endif; ?>
                <?php if (!empty($item['role'])) : ?>
                  <span class="review-carousel__role"><?php echo esc_html($item['role']); ?></span>
                <?php endif; ?>
              </footer>
            <?php endif; ?>
          </blockquote>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Review Carousel', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
