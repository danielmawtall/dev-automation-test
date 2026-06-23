<?php
/**
 * Image, video, or GIF media.
 *
 * @var array $args type (image|video|gif), image, video, gif
 */
$type = $args['type'] ?? 'image';
$ratio = $args['ratio'] ?? '16-9';
$class = 'media media--' . esc_attr($ratio);
?>
<div class="<?php echo $class; ?>">
  <?php
  switch ($type) {
    case 'video':
      $video = $args['video'] ?? null;
      if ($video) :
        $url = is_array($video) ? ($video['url'] ?? '') : $video;
        if ($url) :
          ?>
          <video class="media__video" playsinline muted loop autoplay>
            <source src="<?php echo esc_url($url); ?>" type="video/mp4">
          </video>
          <?php
        endif;
      endif;
      break;
    case 'gif':
      $gif = $args['gif'] ?? $args['image'] ?? null;
      if ($gif && !empty($gif['url'])) :
        ?>
        <img class="media__image" src="<?php echo esc_url($gif['url']); ?>" alt="<?php echo esc_attr($gif['alt'] ?? ''); ?>" loading="lazy">
        <?php
      endif;
      break;
    default:
      $image = $args['image'] ?? null;
      if ($image) :
        $size = $args['size'] ?? 'media-full';
        echo wp_get_attachment_image($image['ID'] ?? $image['id'], $size, false, array(
          'class' => 'media__image',
          'loading' => $args['loading'] ?? 'lazy',
        ));
      endif;
      break;
  }
  ?>
</div>
