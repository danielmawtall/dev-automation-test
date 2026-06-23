<?php get_header(); ?>
<section class="archive-case-study">
  <div class="container">
    <h1 class="archive-case-study__title"><?php post_type_archive_title(); ?></h1>
    <?php if (have_posts()) : ?>
      <div class="archive-case-study__grid">
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class('case-study-card'); ?>>
            <a href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()) : the_post_thumbnail('card-landscape'); endif; ?>
              <h2><?php the_title(); ?></h2>
            </a>
          </article>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
