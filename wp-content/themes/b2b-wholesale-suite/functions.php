<?php
/**
 * B2B Wholesale Suite theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function b2bws_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'b2b-wholesale-suite' ),
	) );
}
add_action( 'after_setup_theme', 'b2bws_setup' );

function b2bws_assets() {
	$theme_uri = get_template_directory_uri();
	$ver       = wp_get_theme()->get( 'Version' );

	// Fonts
	wp_enqueue_style( 'b2bws-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;650;700;800&family=Bricolage+Grotesque:opsz,wght@12..96,500..800&display=swap', array(), null );

	// Design system
	wp_enqueue_style( 'b2bws-site', $theme_uri . '/assets/site.css', array(), $ver );

	// Motion libraries (CDN)
	wp_enqueue_script( 'threejs', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', array(), '128', true );
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
	wp_enqueue_script( 'lenis', 'https://cdn.jsdelivr.net/npm/lenis@1.1.13/dist/lenis.min.js', array(), '1.1.13', true );

	// Theme scripts
	wp_enqueue_script( 'b2bws-hero-bg', $theme_uri . '/assets/hero-bg.js', array( 'threejs' ), $ver, true );
	wp_enqueue_script( 'b2bws-main', $theme_uri . '/assets/main.js', array( 'gsap', 'gsap-scrolltrigger', 'lenis', 'b2bws-hero-bg' ), $ver, true );

	// Blog filter/sort — only needed on the blog listing page.
	if ( is_home() ) {
		wp_enqueue_script( 'b2bws-blog', $theme_uri . '/assets/blog.js', array(), $ver, true );
	}
}
add_action( 'wp_enqueue_scripts', 'b2bws_assets' );

/**
 * Show every post on the blog listing in one go, so the client-side
 * category filter/sort always has the full set to work with instead of
 * only whatever fits on the current paginated page.
 */
function b2bws_blog_query( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_home() ) {
		$query->set( 'posts_per_page', 100 );
	}
}
add_action( 'pre_get_posts', 'b2bws_blog_query' );

/**
 * Rough reading time estimate (~200 words/minute), minimum 1 minute.
 */
function b2bws_reading_time( $post_id = null ) {
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) round( $words / 200 ) );
}

/**
 * Sensible excerpt length for the blog grid.
 */
function b2bws_excerpt_length( $length ) {
	return 22;
}
add_filter( 'excerpt_length', 'b2bws_excerpt_length' );

function b2bws_excerpt_more( $more ) {
	return '…';
}
add_filter( 'excerpt_more', 'b2bws_excerpt_more' );
