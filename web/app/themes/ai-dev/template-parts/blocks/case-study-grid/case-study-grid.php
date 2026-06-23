<?php
$className = ai_dev_block_classes('case-study-grid', $block);
$studies = get_field('case_studies') ?: array();
$title_rows = get_field('study_titles') ?: array();
$has_content = ai_dev_block_has_content(array(get_field('heading'), $studies));

$card_title = static function (int $index) use ($title_rows): ?string {
  if (empty($title_rows[$index]['title'])) {
    return null;
  }
  return $title_rows[$index]['title'];
};
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container case-study-grid__layout">
    <?php if ($has_content) : ?>
      <?php if (!empty($studies[0])) : ?>
        <div class="case-study-grid__primary">
          <?php
          get_template_part('template-parts/components/case-study-card', null, array(
            'post' => $studies[0],
            'variant' => 'home-square',
            'title' => $card_title(0),
          ));
          ?>
        </div>
      <?php endif; ?>
      <div class="case-study-grid__secondary">
        <div class="case-study-grid__intro">
          <?php if (get_field('caption')) : ?>
            <?php get_template_part('template-parts/components/caption', null, array('icon' => 'dot', 'text' => get_field('caption'))); ?>
          <?php endif; ?>
          <?php if (get_field('heading')) : ?>
            <h2 class="case-study-grid__heading"><?php echo esc_html(get_field('heading')); ?></h2>
          <?php endif; ?>
          <?php get_template_part('template-parts/components/ctas-list', null, array('buttons' => get_field('buttons'))); ?>
        </div>
        <?php if (!empty($studies[1])) : ?>
          <div class="case-study-grid__portrait">
            <?php
            get_template_part('template-parts/components/case-study-card', null, array(
              'post' => $studies[1],
              'variant' => 'home-portrait',
              'title' => $card_title(1),
            ));
            ?>
          </div>
        <?php endif; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder">Case Study Grid</h2>
    <?php endif; ?>
  </div>
</section>
