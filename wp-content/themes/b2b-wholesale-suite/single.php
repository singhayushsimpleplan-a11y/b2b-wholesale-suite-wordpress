<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="post-hero-media">
  <?php if ( has_post_thumbnail() ) : ?>
    <?php the_post_thumbnail( 'full' ); ?>
  <?php else : ?>
    <div class="post-thumb-fallback post-thumb-fallback-lg">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
    </div>
  <?php endif; ?>
</div>

<article class="post-body">
  <div class="wrap wrap-narrow">
    <div class="post-head">
      <div class="post-head-text">
        <h1><?php the_title(); ?></h1>
        <p class="post-meta">
          <?php echo esc_html( get_the_date( 'jS F, Y' ) ); ?>
          <?php
          $b2bws_cats = get_the_category();
          $b2bws_cats = array_values( array_filter( $b2bws_cats, function( $c ) { return 'featured' !== $c->slug; } ) );
          if ( ! empty( $b2bws_cats ) ) :
          ?>
            <span class="post-meta-sep">&middot;</span><?php echo esc_html( $b2bws_cats[0]->name ); ?>
          <?php endif; ?>
          <span class="post-meta-sep">&middot;</span><?php echo esc_html( b2bws_reading_time() ); ?> min read
        </p>
      </div>
      <div class="post-share">
        <span>Share</span>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12Z"/></svg>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&amp;text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on X">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 2H22l-7.2 8.2L22.5 22h-6.9l-5.4-7-6.2 7H1l7.7-8.8L1 2h7l4.9 6.4L18.9 2Zm-2.4 18h1.9L7.6 4H5.6l10.9 16Z"/></svg>
        </a>
        <a href="https://pinterest.com/pin/create/button/?url=<?php echo rawurlencode( get_permalink() ); ?>&amp;description=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Share on Pinterest">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-3.65 19.31c-.03-.78-.06-1.98.02-2.83.07-.77.47-2.44.47-2.44s-.12-.24-.12-.6c0-.56.32-.98.73-.98.34 0 .5.26.5.57 0 .35-.22.87-.34 1.35-.1.4.2.73.6.73.72 0 1.3-.76 1.3-1.85 0-.97-.7-1.65-1.7-1.65-1.16 0-1.84.87-1.84 1.77 0 .35.13.72.3.92.03.04.04.07.03.11l-.11.46c-.02.08-.06.1-.15.06-.55-.23-.9-.94-.9-1.7 0-1.38 1-2.65 2.9-2.65 1.52 0 2.7 1.08 2.7 2.53 0 1.51-.95 2.72-2.27 2.72-.44 0-.86-.23-1-.5 0 0-.24.9-.29 1.11-.1.4-.4.9-.6 1.2A10 10 0 1 0 12 2Z"/></svg>
        </a>
      </div>
    </div>

    <div class="post-content" data-reveal>
      <?php the_content(); ?>
    </div>

    <p class="mt-32">
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn btn-secondary">&larr; Back to blog</a>
    </p>
  </div>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
