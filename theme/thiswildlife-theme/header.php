<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php bloginfo('name'); ?></title>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="site-header">
  <div class="header-inner">
    <a href="<?php echo home_url('/'); ?>" class="brand">
      <div class="logo-placeholder">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/branding/logo.png" alt="This Wild Life logo">
      </div>
      <span class="brand-title">This Wild Life</span>
    </a>

    <nav class="nav">
      <a href="<?php echo home_url('/'); ?>">Home</a>
      <a href="<?php echo home_url('/books/'); ?>">Books</a>
      <a href="<?php echo home_url('/discover/'); ?>">Discover</a>
      <a href="<?php echo home_url('/about/'); ?>">About</a>
      <a href="<?php echo home_url('/contact/'); ?>">Contact</a>
    </nav>
  </div>

  <div class="mobile-header">
    <div class="mobile-title">This Wild Life</div>
    <button class="hamburger" id="menuBtn"><span></span></button>
  </div>

  <div class="mobile-menu" id="mobileMenu">
    <a href="<?php echo home_url('/'); ?>">Home</a>
    <a href="<?php echo home_url('/books/'); ?>">Books</a>
    <a href="<?php echo home_url('/discover/'); ?>">Discover</a>
    <a href="<?php echo home_url('/about/'); ?>">About</a>
    <a href="<?php echo home_url('/contact/'); ?>">Contact</a>
    <a href="<?php echo home_url('/books/'); ?>">Shop on Amazon</a>
  </div>
</header>