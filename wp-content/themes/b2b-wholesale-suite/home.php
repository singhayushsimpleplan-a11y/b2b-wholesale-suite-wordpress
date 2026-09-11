<?php get_header(); ?>

<header class="page-hero">
  <div class="wrap">
    <span class="eyebrow" data-hero-in><span class="dot"></span>Blog</span>
    <h1 data-hero-in>Insights for wholesale sellers.</h1>
    <p class="lede" data-hero-in>Practical guidance on dealer programs, net terms, and running B2B alongside retail on Shopify.</p>
  </div>
</header>

<section>
  <div class="wrap">
    <div class="grid-cards" data-reveal-group>
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <a class="card post-card" href="<?php the_permalink(); ?>">
            <span class="post-date"><?php echo esc_html( get_the_date() ); ?></span>
            <h3><?php the_title(); ?></h3>
            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
            <span class="read-more">Read article &rarr;</span>
          </a>
        <?php endwhile; ?>
      <?php else : ?>
        <p>No posts yet. Check back soon.</p>
      <?php endif; ?>
    </div>

    <div class="center mt-32">
      <?php the_posts_pagination( array( 'prev_text' => '&larr; Newer', 'next_text' => 'Older &rarr;' ) ); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
