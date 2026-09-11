<?php get_header(); ?>

<header class="page-hero">
  <div class="wrap">
    <span class="eyebrow" data-hero-in><span class="dot"></span>Blog</span>
    <h1 data-hero-in>Insights for wholesale sellers.</h1>
    <p class="lede" data-hero-in>Practical guidance on dealer programs, net terms, and running B2B alongside retail on Shopify.</p>
  </div>
</header>

<?php
$b2bws_featured = new WP_Query( array(
	'category_name'       => 'featured',
	'posts_per_page'      => 3,
	'ignore_sticky_posts'  => true,
) );
if ( $b2bws_featured->have_posts() ) :
?>
<section class="tight">
  <div class="wrap">
    <div class="section-head left" data-reveal>
      <span class="eyebrow"><span class="dot"></span>Featured</span>
    </div>
    <div class="blog-grid" data-reveal-group>
      <?php while ( $b2bws_featured->have_posts() ) : $b2bws_featured->the_post(); ?>
        <?php get_template_part( 'template-parts/post-card' ); ?>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php
endif;
wp_reset_postdata();
?>

<section class="section-alt">
  <div class="wrap">
    <div class="blog-toolbar" data-reveal>
      <h2 class="section-title">All News</h2>
      <div class="blog-controls">
        <div class="blog-tabs" role="tablist">
          <button type="button" class="blog-tab active" data-filter="all" role="tab" aria-selected="true">All</button>
          <?php
          $b2bws_cats = get_categories( array( 'hide_empty' => true ) );
          foreach ( $b2bws_cats as $b2bws_cat ) :
            if ( 'featured' === $b2bws_cat->slug ) {
              continue;
            }
            ?>
            <button type="button" class="blog-tab" data-filter="<?php echo esc_attr( $b2bws_cat->slug ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $b2bws_cat->name ); ?></button>
          <?php endforeach; ?>
        </div>
        <div class="blog-sort">
          <select id="blog-sort-select">
            <option value="" selected disabled hidden>Sort by</option>
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
            <option value="title-asc">Title A&ndash;Z</option>
          </select>
        </div>
      </div>
    </div>

    <div class="blog-grid" id="blog-grid" data-reveal-group>
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'template-parts/post-card' ); ?>
        <?php endwhile; ?>
      <?php else : ?>
        <p>No posts yet. Check back soon.</p>
      <?php endif; ?>
    </div>

    <p class="blog-empty" id="blog-empty" hidden>No posts in this category yet.</p>
  </div>
</section>

<?php get_footer(); ?>
