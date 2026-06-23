<?php
$className = ai_dev_block_classes('mobile-case-study-carousel', $block);
$studies = get_field('case_studies') ?: array();
$title_rows = get_field('study_titles') ?: array();

$card_title = static function (int $index) use ($title_rows): ?string {
  if (empty($title_rows[$index]['title'])) {
    return null;
  }
  return $title_rows[$index]['title'];
};
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>">
  <div class="container">
    <?php if ($studies) : ?>
      <?php if (get_field('heading')) : ?>
        <h2 class="mobile-case-study-carousel__title"><?php echo esc_html(get_field('heading')); ?></h2>
      <?php endif; ?>
      <div class="mobile-case-study-carousel__track" tabindex="0">
        <?php foreach ($studies as $index => $study) : ?>
          <div class="mobile-case-study-carousel__slide">
            <?php
            get_template_part('template-parts/components/case-study-card', null, array(
              'post' => $study,
              'variant' => 'work',
              'title' => $card_title((int) $index),
            ));
            ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <h2 class="block__placeholder"><?php esc_html_e('Mobile Case Study Carousel', 'ai-dev'); ?></h2>
    <?php endif; ?>
  </div>
</section>
