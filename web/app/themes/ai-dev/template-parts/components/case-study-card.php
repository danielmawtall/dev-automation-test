<?php
/**
 * Case study card.
 *
 * @var WP_Post $args post, variant (home|home-square|home-portrait|work), title, index
 */
$post = $args['post'] ?? null;
if (!$post) {
  return;
}
$variant = $args['variant'] ?? 'work';
$permalink = get_permalink($post);
$title = $args['title'] ?? get_the_title($post);
$terms = get_the_terms($post, 'service');
$index = isset($args['index']) ? (int) $args['index'] : 0;
$thumb_size = 'card-landscape';
if (in_array($variant, array('home', 'home-portrait', 'work'), true)) {
  $thumb_size = 'card-portrait';
} elseif ($variant === 'home-square') {
  $thumb_size = 'card-square';
}
?>
<article class="case-study-card case-study-card--<?php echo esc_attr($variant); ?>">
  <a class="case-study-card__link" href="<?php echo esc_url($permalink); ?>">
    <div class="case-study-card__media">
      <?php echo get_the_post_thumbnail($post, $thumb_size, array('class' => 'case-study-card__image')); ?>
      <span class="case-study-card__overlay"></span>
    </div>
    <?php if ($variant === 'work') : ?>
      <div class="case-study-card__meta">
        <?php if ($terms && !is_wp_error($terms)) : ?>
          <div class="case-study-card__labels">
            <?php foreach ($terms as $term) : ?>
              <span class="case-study-card__label"><?php echo esc_html($term->name); ?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if ($index > 0) : ?>
          <div class="case-study-card__index">
            <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => sprintf('(%02d)', $index))); ?>
          </div>
        <?php endif; ?>
      </div>
      <h3 class="case-study-card__title"><?php echo esc_html($title); ?></h3>
    <?php else : ?>
      <?php if ($terms && !is_wp_error($terms)) : ?>
        <div class="case-study-card__labels">
          <?php foreach ($terms as $term) : ?>
            <span class="case-study-card__label"><?php echo esc_html($term->name); ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <h3 class="case-study-card__title"><?php echo esc_html($title); ?></h3>
    <?php endif; ?>
  </a>
</article>
