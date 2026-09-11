<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
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
      <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</nav>
