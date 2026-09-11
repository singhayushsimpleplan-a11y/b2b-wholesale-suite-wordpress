<?php
/**
 * A single blog post card — used on the blog listing (both the
 * Featured strip and the main "All News" grid). Falls back to a
 * gradient illustration when no featured image has been set, so the
 * grid never looks broken while content is still being filled in.
 */

$b2bws_cats       = get_the_category();
$b2bws_cat_slugs  = wp_list_pluck( $b2bws_cats, 'slug' );
?>
<a
	class="post-card"
	href="<?php the_permalink(); ?>"
	data-category="<?php echo esc_attr( implode( ',', $b2bws_cat_slugs ) ); ?>"
	data-date="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"
	data-title="<?php echo esc_attr( get_the_title() ); ?>"
>
	<div class="post-card-media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large' ); ?>
		<?php else : ?>
			<div class="post-thumb-fallback">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
			</div>
		<?php endif; ?>
	</div>
	<h3><?php the_title(); ?></h3>
	<span class="post-date"><?php echo esc_html( get_the_date( 'jS F, Y' ) ); ?></span>
</a>
