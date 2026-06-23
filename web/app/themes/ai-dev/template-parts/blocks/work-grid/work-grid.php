<?php
$className = ai_dev_block_classes('work-grid', $block);
$query = new WP_Query(array(
  'post_type'      => 'case-study',
  'posts_per_page' => -1,
  'orderby'        => 'date',
  'order'          => 'DESC',
));
$posts = $query->have_posts() ? $query->posts : array();
$left_posts = array();
$right_posts = array();
foreach ($posts as $i => $post) {
  if ($i % 2 === 0) {
    $left_posts[] = array('post' => $post, 'index' => $i + 1);
  } else {
    $right_posts[] = array('post' => $post, 'index' => $i + 1);
  }
}
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="work-grid__layout container">
    <aside class="work-grid__sidebar">
      <?php if (get_field('label')) : ?>
        <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('label'))); ?>
      <?php endif; ?>
      <?php if (get_field('heading')) : ?>
        <h2 class="work-grid__heading"><?php echo esc_html(get_field('heading')); ?></h2>
      <?php endif; ?>
    </aside>
    <div class="work-grid__columns">
      <div class="work-grid__col work-grid__col--left">
        <?php foreach ($left_posts as $item) :
          get_template_part('template-parts/components/case-study-card', null, array(
            'post'    => $item['post'],
            'variant' => 'work',
            'index'   => $item['index'],
          ));
        endforeach; ?>
      </div>
      <div class="work-grid__col work-grid__col--right">
        <?php if (get_field('caption') || get_field('body')) : ?>
          <div class="work-grid__intro">
            <?php if (get_field('caption')) : ?>
              <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('caption'))); ?>
            <?php endif; ?>
            <?php if (get_field('body')) : ?>
              <div class="work-grid__body"><?php echo wp_kses_post(get_field('body')); ?></div>
            <?php endif; ?>
            <?php
            $btn = get_field('button');
            if (!empty($btn['label']) && !empty($btn['url'])) {
              get_template_part('template-parts/components/button', null, $btn);
            }
            ?>
          </div>
        <?php endif; ?>
        <?php foreach ($right_posts as $item) :
          get_template_part('template-parts/components/case-study-card', null, array(
            'post'    => $item['post'],
            'variant' => 'work',
            'index'   => $item['index'],
          ));
        endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
