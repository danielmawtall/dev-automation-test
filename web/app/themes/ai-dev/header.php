<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_template_part('template-parts/components/preloader'); ?>

<header id="site-header" class="site-header site-header--<?php echo esc_attr(get_field('nav_theme') ?: 'light'); ?>" data-nav-theme="<?php echo esc_attr(get_field('nav_theme') ?: 'light'); ?>">
  <div class="site-header__inner container">
    <a class="site-header__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
      <?php if (has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <span class="site-header__logo-text">TALL</span>
      <?php endif; ?>
    </a>

    <nav class="site-header__nav" aria-label="<?php esc_attr_e('Primary', 'ai-dev'); ?>">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'site-header__menu',
        'fallback_cb'    => false,
      ));
      ?>
    </nav>

    <button class="site-header__cta button button--underline" type="button" data-contact-trigger>
      <span class="button__label"><?php esc_html_e("Let's talk", 'ai-dev'); ?></span>
      <span class="button__arrow" aria-hidden="true"></span>
    </button>

    <button class="site-header__toggle" type="button" data-mobile-menu-toggle aria-expanded="false">
      <span class="site-header__toggle-label" data-menu-label data-default="<?php echo esc_attr(get_field('mobile_menu_text', 'option') ?: 'Menu'); ?>"><?php echo esc_html(get_field('mobile_menu_text', 'option') ?: 'Menu'); ?></span>
      <span class="site-header__toggle-icon" aria-hidden="true"></span>
    </button>
  </div>

  <div class="site-header__mobile-panel" data-mobile-menu hidden>
    <p class="site-header__reshape"><?php echo esc_html(get_field('reshape_text', 'option') ?: 'RESHAPE POSSIBLE'); ?></p>
    <?php
    wp_nav_menu(array(
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => 'site-header__mobile-menu',
      'fallback_cb'    => false,
    ));
    ?>
    <button class="button button--underline" type="button" data-contact-trigger>
      <?php esc_html_e("Let's Talk", 'ai-dev'); ?>
    </button>
  </div>
</header>

<?php get_template_part('template-parts/components/contact-overlay'); ?>

<main id="site-content" class="site-main">
