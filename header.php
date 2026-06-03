<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <div class="container nav">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/stax_logo.png" alt="Stax grupa logo" width="50px"
>
</a>
    <button class="menu-toggle" id="menuToggle" aria-label="Otvori izbornik">☰</button>
    <nav class="main-nav" id="mainNav">
      <a href="<?php echo is_front_page() ? '#hero' : esc_url(home_url('/#hero')); ?>">Početna</a>
      <a href="<?php echo is_front_page() ? '#products' : esc_url(home_url('/#products')); ?>">Proizvodi</a>
      <a href="<?php echo is_front_page() ? '#about' : esc_url(home_url('/#about')); ?>">O nama</a>
      <a href="<?php echo is_front_page() ? '#contact' : esc_url(home_url('/#contact')); ?>">Kontakt</a>
      <a href="<?php echo esc_url(home_url('/proizvodi/')); ?>"><b>Katalog proizvoda</b></a>
    </nav>
  </div>
</header>