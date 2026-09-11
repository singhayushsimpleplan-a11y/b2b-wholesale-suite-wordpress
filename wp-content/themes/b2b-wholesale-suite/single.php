<?php get_header(); ?>

<header class="page-hero">
  <div class="wrap">
    <span class="eyebrow" data-hero-in><span class="dot"></span>Blog</span>
    <h1 data-hero-in><?php the_title(); ?></h1>
    <p class="lede" data-hero-in><?php echo esc_html( get_the_date() ); ?></p>
  </div>
</header>

<section>
  <div class="wrap wrap-narrow">
    <div class="post-content" data-reveal>
      <?php
      while ( have_posts() ) :
        the_post();
        the_content();
      endwhile;
      ?>
    </div>
    <p class="mt-32">
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn btn-secondary">&larr; Back to blog</a>
    </p>
  </div>
</section>

<?php get_footer(); ?>
