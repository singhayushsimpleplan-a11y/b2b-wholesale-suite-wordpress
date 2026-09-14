<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<script>(function(){try{var t=localStorage.getItem('b2bws-theme');if(t!=='light'&&t!=='dark'){t='dark';}document.documentElement.setAttribute('data-theme',t);}catch(e){document.documentElement.setAttribute('data-theme','dark');}})();</script>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="cursor-glow" aria-hidden="true"></div>
<?php wp_body_open(); ?>

<nav class="nav">
  <div class="wrap">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><span class="mark">B2B</span> B2B Wholesale Suite</a>
    <div class="nav-links">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_id'        => '',
        'menu_class'     => '',
        'items_wrap'     => '%3$s',
        'fallback_cb'    => function() {
          echo '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>';
          echo '<a href="' . esc_url( home_url( '/features/' ) ) . '">Features</a>';
          echo '<a href="' . esc_url( home_url( '/pricing/' ) ) . '">Pricing</a>';
          echo '<a href="' . esc_url( home_url( '/faq/' ) ) . '">FAQ</a>';
          echo '<a href="' . esc_url( home_url( '/blog/' ) ) . '">Blog</a>';
          echo '<a href="' . esc_url( home_url( '/contact/' ) ) . '">Contact</a>';
        },
      ) );
      ?>
    </div>
    <div class="nav-cta">
      <a href="#" class="btn btn-primary">Get the App</a>
      <button class="theme-toggle" id="theme-toggle" aria-label="Toggle dark mode" type="button">
        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
      </button>
      <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</nav>
