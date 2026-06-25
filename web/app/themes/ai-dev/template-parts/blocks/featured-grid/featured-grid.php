<?php
$className = ai_dev_block_classes('featured-grid', $block);
$items = get_field('items');
$has_content = ai_dev_block_has_content(array(get_field('heading'), $items));
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="featured-grid__layout container">
    <?php if ($has_content) : ?>
      <aside class="featured-grid__sidebar">
        <?php if (get_field('label') || get_field('heading')) : ?>
          <div class="featured-grid__sidebar-intro">
            <?php if (get_field('label')) : ?>
              <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('label'))); ?>
            <?php endif; ?>
            <?php if (get_field('heading')) : ?>
              <h2 class="featured-grid__heading"><?php echo esc_html(get_field('heading')); ?></h2>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <?php if (get_field('show_button')) :
          $btn = get_field('button');
          if (!empty($btn['label']) && !empty($btn['url'])) {
            get_template_part('template-parts/components/button', null, $btn);
          }
        endif; ?>
      </aside>
      <div class="featured-grid__columns">
        <?php
        $cols = array(array(), array());
        if ($items) {
          foreach ($items as $i => $item) {
            $cols[$i % 2][] = $item;
          }
        }
        foreach ($cols as $col) : ?>
          <div class="featured-grid__col">
            <?php foreach ($col as $item) :
              $ratio = $item['ratio'] ?? '16-9';
              $media_id = is_array($item['media'] ?? null)
                ? (int) ($item['media']['ID'] ?? $item['media']['id'] ?? 0)
                : (int) ($item['media'] ?? 0);
              ?>
              <article class="featured-card featured-card--<?php echo esc_attr($ratio); ?><?php echo !empty($item['title']) ? '' : ' featured-card--media-only'; ?>">
                <?php if (!empty($item['pin'])) : ?><span class="featured-card__pin" aria-label="<?php esc_attr_e('Pinned', 'ai-dev'); ?>"></span><?php endif; ?>
                <?php if ($media_id && !in_array($ratio, array('forest', 'short'), true)) : ?>
                  <div class="featured-card__media">
                    <?php
                    echo wp_get_attachment_image($media_id, 'card-landscape', false, array(
                      'class' => 'featured-card__image',
                      'loading' => 'lazy',
                    ));
                    ?>
                    <?php if (!empty($item['label'])) : ?>
                      <span class="featured-card__label"><?php echo esc_html($item['label']); ?></span>
                    <?php endif; ?>
                  </div>
                <?php elseif ($ratio === 'forest') : ?>
                  <div class="featured-card__media featured-card__media--forest" aria-hidden="true"></div>
                <?php elseif ($ratio === 'short' && $media_id) : ?>
                  <div class="featured-card__media featured-card__media--short">
                    <?php
                    echo wp_get_attachment_image($media_id, 'card-landscape', false, array(
                      'class' => 'featured-card__image',
                      'loading' => 'lazy',
                    ));
                    ?>
                    <?php if (!empty($item['label'])) : ?>
                      <span class="featured-card__label"><?php echo esc_html($item['label']); ?></span>
                    <?php endif; ?>
                  </div>
                <?php elseif ($ratio === 'short') : ?>
                  <div class="featured-card__media featured-card__media--short featured-card__media--short-empty" aria-hidden="true">
                    <?php if (!empty($item['label'])) : ?>
                      <span class="featured-card__label"><?php echo esc_html($item['label']); ?></span>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                <?php if (!empty($item['title'])) : ?>
                  <h3 class="featured-card__title"><?php echo esc_html($item['title']); ?></h3>
                <?php endif; ?>
                <?php if (!empty($item['url'])) : ?>
                  <a class="featured-card__link" href="<?php echo esc_url($item['url']); ?>"><span class="screen-reader-text"><?php esc_html_e('View', 'ai-dev'); ?></span></a>
                <?php endif; ?>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder">Featured Grid</h2>
    <?php endif; ?>
  </div>
</section>
