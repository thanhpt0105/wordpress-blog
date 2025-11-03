<?php
/**
 * Custom Theme 2 functions and definitions.
 *
 * @package Custom_Theme_2
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'acme_setup' ) ) {
	/**
	 * Theme setup.
	 */
	function acme_setup(): void {
		load_theme_textdomain( 'acme', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'html5', [ 'comment-form', 'comment-list', 'search-form', 'gallery', 'caption', 'style', 'script' ] );
		add_theme_support( 'custom-spacing' );
		add_theme_support( 'custom-line-height' );
		add_theme_support( 'link-color' );
		add_theme_support( 'appearance-tools' );

		register_nav_menus(
			[
				'primary'   => esc_html__( 'Primary Menu', 'acme' ),
				'footer'    => esc_html__( 'Footer Menu', 'acme' ),
				'social'    => esc_html__( 'Social Menu', 'acme' ),
			]
		);

		add_editor_style( 'assets/css/editor.css' );
	}
}
add_action( 'after_setup_theme', 'acme_setup' );

if ( ! function_exists( 'acme_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function acme_scripts(): void {
		$theme   = wp_get_theme();
		$version = $theme->get( 'Version' ) ?: '1.0.0';

		wp_enqueue_style( 'acme-style', get_stylesheet_uri(), [], $version );
		wp_enqueue_style( 'acme-frontend', get_template_directory_uri() . '/assets/css/frontend.css', [ 'acme-style' ], $version );

		wp_enqueue_script( 'acme-theme', get_template_directory_uri() . '/assets/js/theme.js', [], $version, true );
		wp_script_add_data( 'acme-theme', 'defer', true );

		$defaults = [
			'toggles' => [
				'darkMode'        => true,
				'readingProgress' => true,
				'tableOfContents' => true,
				'copyHeadings'    => true,
				'readingTime'     => 'minutes',
			],
		];

		$settings = apply_filters( 'acme_theme_js_settings', $defaults );
		wp_localize_script( 'acme-theme', 'acmeThemeSettings', $settings );
	}
}
add_action( 'wp_enqueue_scripts', 'acme_scripts' );

if ( ! function_exists( 'acme_block_assets' ) ) {
	/**
	 * Enqueue editor assets.
	 */
	function acme_block_assets(): void {
		$theme   = wp_get_theme();
		$version = $theme->get( 'Version' ) ?: '1.0.0';
		wp_enqueue_script( 'acme-editor', get_template_directory_uri() . '/assets/js/editor.js', [], $version, true );
		wp_script_add_data( 'acme-editor', 'defer', true );
	}
}
add_action( 'enqueue_block_editor_assets', 'acme_block_assets' );

/**
 * Register pattern categories.
 */
function acme_register_pattern_categories(): void {
	$categories = [
		'acme-blog'   => [
			'label' => esc_html__( 'Custom Theme 2 – Blog', 'acme' ),
		],
		'acme-author' => [
			'label' => esc_html__( 'Custom Theme 2 – Author', 'acme' ),
		],
		'acme-utility' => [
			'label' => esc_html__( 'Custom Theme 2 – Utility', 'acme' ),
		],
	];

	foreach ( $categories as $slug => $args ) {
		register_block_pattern_category( $slug, $args );
	}
}
add_action( 'init', 'acme_register_pattern_categories' );

/**
 * Compute reading time.
 *
 * @param int|null $post_id Post ID.
 */
function acme_get_reading_time( ?int $post_id = null ): string {
	$post_id = $post_id ?: get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	$content = get_post_field( 'post_content', $post_id );
	if ( ! $content ) {
		return '';
	}

	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = max( 1, (int) ceil( $word_count / 225 ) );

	/* translators: %d: estimated reading time in minutes. */
	return sprintf( _n( '%d minute read', '%d minute read', $minutes, 'acme' ), $minutes );
}

/**
 * Reading time shortcode.
 */
function acme_reading_time_shortcode(): string {
	$reading_time = acme_get_reading_time();

	return $reading_time ? esc_html( $reading_time ) : '';
}
add_shortcode( 'acme_reading_time', 'acme_reading_time_shortcode' );

/**
 * Share links shortcode.
 */
function acme_share_links_shortcode(): string {
	if ( ! is_singular() ) {
		return '';
	}

	$permalink = urlencode( get_permalink() );
	$title     = urlencode( get_the_title() );

	$links = [
		'twitter'  => [
			'url'   => sprintf( 'https://twitter.com/intent/tweet?url=%s&text=%s', $permalink, $title ),
			'label' => __( 'Share on X', 'acme' ),
		],
		'linkedin' => [
			'url'   => sprintf( 'https://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s', $permalink, $title ),
			'label' => __( 'Share on LinkedIn', 'acme' ),
		],
		'facebook' => [
			'url'   => sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%s', $permalink ),
			'label' => __( 'Share on Facebook', 'acme' ),
		],
		'copy'     => [
			'url'   => get_permalink(),
			'label' => __( 'Copy link', 'acme' ),
		],
	];

	$items = [];

	foreach ( $links as $network => $data ) {
		$attrs = [
			'href'   => esc_url( $data['url'] ),
			'target' => 'copy' === $network ? '_self' : '_blank',
			'rel'    => 'copy' === $network ? 'nofollow' : 'noopener noreferrer',
			'class'  => 'acme-share-link acme-share-link--' . sanitize_html_class( $network ),
		];

		if ( 'copy' === $network ) {
			$attrs['data-acme-share-copy'] = esc_url( get_permalink() );
		}

		$items[] = sprintf(
			'<a %s>%s</a>',
			acme_html_attributes( $attrs ),
			esc_html( $data['label'] )
		);
	}

	return '<div class="acme-share-links">' . implode( '', $items ) . '</div>';
}
add_shortcode( 'acme_share_links', 'acme_share_links_shortcode' );

/**
 * Related posts shortcode.
 *
 * @param array<string, string> $atts Attributes.
 */
function acme_related_posts_shortcode( array $atts = [] ): string {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	$atts = shortcode_atts(
		[
			'title' => __( 'Related reads', 'acme' ),
			'count' => 3,
		],
		$atts,
		'acme_related_posts'
	);

	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return '';
	}

	$cat_ids = wp_get_post_terms( $post_id, 'category', [ 'fields' => 'ids' ] );
	$tag_ids = wp_get_post_terms( $post_id, 'post_tag', [ 'fields' => 'ids' ] );

	$tax_query = [];

	if ( ! empty( $cat_ids ) ) {
		$tax_query[] = [
			'taxonomy' => 'category',
			'terms'    => $cat_ids,
			'field'    => 'term_id',
		];
	}

	if ( ! empty( $tag_ids ) ) {
		$tax_query[] = [
			'taxonomy' => 'post_tag',
			'terms'    => $tag_ids,
			'field'    => 'term_id',
		];
	}

	if ( empty( $tax_query ) ) {
		return '';
	}

	$query_args = [
		'post__not_in'        => [ $post_id ],
		'post_type'           => 'post',
		'posts_per_page'      => (int) $atts['count'],
		'ignore_sticky_posts' => true,
		'tax_query'           => [
			'relation' => 'OR',
			...$tax_query,
		],
	];

	$related = new WP_Query( $query_args );

	if ( ! $related->have_posts() ) {
		return '';
	}

	ob_start();
	?>
	<div class="acme-related-loop">
		<h2 class="wp-block-heading has-h4-font-size"><?php echo esc_html( $atts['title'] ); ?></h2>
		<div class="acme-related-loop__grid">
			<?php
			while ( $related->have_posts() ) :
				$related->the_post();
				?>
				<article <?php post_class(); ?>>
					<a class="acme-related-loop__thumb" href="<?php the_permalink(); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'medium_large', [ 'style' => 'border-radius:var(--acme-border-radius);width:100%;height:auto;' ] );
						}
						?>
					</a>
					<h3 class="acme-related-loop__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="acme-related-loop__meta"><?php echo esc_html( get_the_date() ); ?></p>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</div>
	<?php
	wp_reset_postdata();

	return (string) ob_get_clean();
}
add_shortcode( 'acme_related_posts', 'acme_related_posts_shortcode' );

/**
 * Current year shortcode.
 */
function acme_year_shortcode(): string {
	return esc_html( date_i18n( 'Y' ) );
}
add_shortcode( 'acme_year', 'acme_year_shortcode' );

/**
 * Feed link shortcode.
 *
 * @param array<string, string> $atts Atts.
 */
function acme_feed_link_shortcode( array $atts ): string {
	$atts = shortcode_atts(
		[
			'label' => __( 'RSS', 'acme' ),
		],
		$atts,
		'acme_feed_link'
	);

	$url = get_bloginfo( 'rss2_url' );

	return sprintf(
		'<a href="%1$s" rel="noopener">%2$s</a>',
		esc_url( $url ),
		esc_html( $atts['label'] )
	);
}
add_shortcode( 'acme_feed_link', 'acme_feed_link_shortcode' );

/**
 * Helper to build HTML attributes.
 *
 * @param array<string, string> $attributes Attributes.
 */
function acme_html_attributes( array $attributes ): string {
	$compiled = [];

	foreach ( $attributes as $key => $value ) {
		$compiled[] = sprintf( '%1$s="%2$s"', esc_attr( trim( (string) $key ) ), esc_attr( (string) $value ) );
	}

	return implode( ' ', $compiled );
}

/**
 * Add honeypot field to comment form.
 */
function acme_comment_honeypot( array $fields ): array {
	$fields['acme_hp'] = '<p class="comment-form-url acme-comment-honeypot"><label for="acme_hp">' . esc_html__( 'Leave this field empty', 'acme' ) . '</label><input type="text" name="acme_hp" id="acme_hp" value="" tabindex="-1" autocomplete="off" /></p>';

	return $fields;
}
add_filter( 'comment_form_default_fields', 'acme_comment_honeypot' );

/**
 * Block comment submission if honeypot filled.
 */
function acme_verify_comment_honeypot( array $commentdata ) {
	if ( ! empty( $_POST['acme_hp'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		wp_die( esc_html__( 'Spam detected.', 'acme' ), 403 );
	}

	return $commentdata;
}
add_filter( 'preprocess_comment', 'acme_verify_comment_honeypot' );

/**
 * Output structured data.
 */
function acme_output_json_ld(): void {
	if ( is_admin() ) {
		return;
	}

	$schema = [];

	$site_name = wp_strip_all_tags( get_bloginfo( 'name' ) );
	$site_url  = home_url( '/' );
	$logo_id   = get_theme_mod( 'custom_logo' );
	$logo_url  = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';

	$schema['@context'] = 'https://schema.org';
	$schema['@graph']   = [];

	$schema['@graph'][] = [
		'@type'       => 'WebSite',
		'@id'         => trailingslashit( $site_url ) . '#website',
		'url'         => $site_url,
		'name'        => $site_name,
		'alternateName' => wp_strip_all_tags( get_bloginfo( 'description' ) ),
		'potentialAction' => [
			'@type'  => 'SearchAction',
			'target' => $site_url . '?s={search_term_string}',
			'query-input' => 'required name=search_term_string',
		],
	];

	if ( is_singular() ) {
		$post      = get_queried_object();
		$author_id = (int) $post->post_author;
		$person    = [
			'@type' => 'Person',
			'@id'   => get_author_posts_url( $author_id ) . '#author',
			'name'  => get_the_author_meta( 'display_name', $author_id ),
		];

		$author_url = get_the_author_meta( 'user_url', $author_id );
		if ( $author_url ) {
			$person['url'] = esc_url_raw( $author_url );
		}

		$schema['@graph'][] = $person;

		$schema['@graph'][] = [
			'@type'        => 'BlogPosting',
			'@id'          => get_permalink( $post ) . '#blogposting',
			'headline'     => wp_strip_all_tags( get_the_title( $post ) ),
			'description'  => wp_strip_all_tags( get_the_excerpt( $post ) ),
			'datePublished' => get_post_time( DATE_W3C, false, $post ),
			'dateModified' => get_post_modified_time( DATE_W3C, false, $post ),
			'author'       => [
				'@id' => get_author_posts_url( $author_id ) . '#author',
			],
			'publisher'    => [
				'@type' => 'Organization',
				'name'  => $site_name,
				'logo'  => $logo_url ? [
					'@type' => 'ImageObject',
					'url'   => esc_url_raw( $logo_url ),
				] : null,
			],
			'mainEntityOfPage' => get_permalink( $post ),
		];
	}

	$schema['@graph'][] = [
		'@type' => 'Blog',
		'@id'   => trailingslashit( $site_url ) . '#blog',
		'name'  => $site_name,
		'url'   => $site_url,
		'publisher' => [
			'@type' => 'Organization',
			'name'  => $site_name,
		],
	];

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . PHP_EOL;
}
add_action( 'wp_head', 'acme_output_json_ld', 5 );

/**
 * Breadcrumb schema.
 */
function acme_output_breadcrumb_schema(): void {
	if ( is_admin() ) {
		return;
	}

	if ( ! function_exists( 'yoast_breadcrumb' ) && ! function_exists( 'rank_math_get_breadcrumbs' ) ) {
		return;
	}

	$breadcrumbs = [];

	if ( function_exists( 'yoast_breadcrumb' ) ) {
		$breadcrumbs = yoast_breadcrumb( '', '', false );
	} elseif ( function_exists( 'rank_math_get_breadcrumbs' ) ) {
		$breadcrumbs = rank_math_get_breadcrumbs();
	}

	if ( empty( $breadcrumbs ) ) {
		return;
	}

	if ( is_string( $breadcrumbs ) ) {
		return;
	}

	$list = [
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => [],
	];

	foreach ( $breadcrumbs as $index => $crumb ) {
		if ( empty( $crumb['url'] ) ) {
			continue;
		}

		$list['itemListElement'][] = [
			'@type'    => 'ListItem',
			'position' => $index + 1,
			'name'     => wp_strip_all_tags( $crumb['text'] ),
			'item'     => esc_url_raw( $crumb['url'] ),
		];
	}

	if ( empty( $list['itemListElement'] ) ) {
		return;
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $list, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . PHP_EOL;
}
add_action( 'wp_head', 'acme_output_breadcrumb_schema', 6 );

/**
 * Register block styles.
 */
function acme_register_block_styles(): void {
	register_block_style( 'core/pullquote', [
		'name'  => 'acme-highlighted',
		'label' => __( 'Highlighted', 'acme' ),
	] );
}
add_action( 'init', 'acme_register_block_styles' );

/**
 * WooCommerce compatibility tweaks.
 */
function acme_woocommerce_support(): void {
	if ( class_exists( 'WooCommerce' ) ) {
		add_theme_support( 'woocommerce' );
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	}
}
add_action( 'after_setup_theme', 'acme_woocommerce_support', 11 );

/**
 * Ensure comment form honeypot field is not output on admin.
 */
function acme_remove_honeypot_admin(): void {
	if ( is_admin() ) {
		remove_filter( 'comment_form_default_fields', 'acme_comment_honeypot' );
	}
}
add_action( 'admin_init', 'acme_remove_honeypot_admin' );
