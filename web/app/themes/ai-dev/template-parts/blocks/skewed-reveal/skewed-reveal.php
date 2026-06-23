<?php
$className = ai_dev_block_classes('skewed-reveal', $block, array('block--full-width'));
$top_word = get_field('top_word') ?: 'reshape';
$bottom_word = get_field('bottom_word') ?: 'possible';
$image = get_field('image');
$study = get_field('case_study');
$has_media = $image || $study;
?>
<section <?php echo ai_dev_block_anchor($block); ?> class="<?php echo $className; ?>" data-skewed-reveal>
  <?php if ($has_media) : ?>
    <div class="skewed-reveal__inner">
      <h2 class="skewed-reveal__word skewed-reveal__word--top" aria-hidden="true"><?php echo esc_html($top_word); ?></h2>
      <div class="skewed-reveal__media">
        <?php
        if ($image) {
          echo wp_get_attachment_image($image['ID'], 'media-full', false, array(
            'class' => 'skewed-reveal__image',
            'loading' => 'eager',
            'alt' => $image['alt'] ?? '',
          ));
        } elseif ($study) {
          echo get_the_post_thumbnail($study, 'media-full', array('class' => 'skewed-reveal__image'));
        }
        ?>
      </div>
      <h2 class="skewed-reveal__word skewed-reveal__word--bottom" aria-hidden="true"><?php echo esc_html($bottom_word); ?></h2>
      <p class="screen-reader-text"><?php echo esc_html($top_word . ' ' . $bottom_word); ?></p>
    </div>
  <?php else : ?>
    <div class="container"><h2 class="block__placeholder">Skewed Reveal</h2></div>
  <?php endif; ?>
</section>
