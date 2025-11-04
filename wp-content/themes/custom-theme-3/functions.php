<?php
/**
 * Theme bootstrap.
 *
 * @package Custom_Theme_3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function acme_theme_setup() {
	load_theme_textdomain( 'acme', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'acme' ),
			'footer'  => __( 'Footer Navigation', 'acme' ),
		)
	);
}
add_action( 'after_setup_theme', 'acme_theme_setup' );

/**
 * Enqueue theme styles and scripts.
 */
function acme_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'acme-frontend',
		get_theme_file_uri( 'assets/css/frontend.css' ),
		array(),
		filemtime( get_theme_file_path( 'assets/css/frontend.css' ) )
	);

	wp_enqueue_script(
		'acme-theme',
		get_theme_file_uri( 'assets/js/theme.js' ),
		array(),
		filemtime( get_theme_file_path( 'assets/js/theme.js' ) ),
		true
	);

	wp_script_add_data( 'acme-theme', 'type', 'module' );

	wp_localize_script(
		'acme-theme',
		'acmeTheme',
		array(
			'restUrl'      => esc_url_raw( rest_url( 'wp/v2/posts' ) ),
			'restNonce'    => wp_create_nonce( 'wp_rest' ),
			'siteUrl'      => esc_url( home_url( '/' ) ),
			'strings'      => array(
				'loading'   => esc_html__( 'Loading…', 'acme' ),
				'loadMore'  => esc_html__( 'Load more stories', 'acme' ),
				'noMore'    => esc_html__( 'You have reached the end.', 'acme' ),
				'shareCopy' => esc_html__( 'Link copied to clipboard', 'acme' ),
				'shareFail' => esc_html__( 'Unable to copy link', 'acme' ),
				'dark'      => esc_html__( 'Dark', 'acme' ),
				'light'     => esc_html__( 'Light', 'acme' ),
			),
			'breakpoints' => array(
				'desktop' => 1024,
			),
			'progress'    => array(
				'enabled' => true,
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'acme_enqueue_assets' );

/**
 * Editor-only assets.
 */
function acme_enqueue_block_editor_assets() {
	wp_enqueue_style(
		'acme-editor',
		get_theme_file_uri( 'assets/css/editor.css' ),
		array(),
		filemtime( get_theme_file_path( 'assets/css/editor.css' ) )
	);
}
add_action( 'enqueue_block_editor_assets', 'acme_enqueue_block_editor_assets' );

/**
 * Register Customizer settings.
 *
 * Allows swapping the author bio image used in the Author Bio card pattern.
 *
 * @param WP_Customize_Manager $wp_customize Manager instance.
 */
function acme_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'acme_author_bio',
		array(
			'title'       => __( 'Author Bio', 'acme' ),
			'description' => __( 'Configure the image displayed in the Author Bio card.', 'acme' ),
			'priority'    => 160,
		)
	);

	$wp_customize->add_section(
		'acme_footer_socials',
		array(
			'title'       => __( 'Footer Social Links', 'acme' ),
			'description' => __( 'URLs for the social icons displayed in the footer.', 'acme' ),
			'priority'    => 170,
		)
	);

	$wp_customize->add_setting(
		'acme_author_bio_image',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'acme_sanitize_author_bio_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'acme_author_bio_image',
			array(
				'label'       => __( 'Author Bio Image', 'acme' ),
				'section'     => 'acme_author_bio',
				'settings'    => 'acme_author_bio_image',
				'description' => __( 'Upload or choose the portrait shown in the author bio card.', 'acme' ),
			)
		)
	);

	$wp_customize->add_setting(
		'acme_author_bio_heading',
		array(
			'default'           => __( 'Hi, I’m Alex', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_author_bio_heading',
		array(
			'type'        => 'text',
			'section'     => 'acme_author_bio',
			'label'       => __( 'Heading', 'acme' ),
			'description' => __( 'Main heading text displayed next to the portrait.', 'acme' ),
		)
	);

	$wp_customize->add_setting(
		'acme_author_bio_description',
		array(
			'default'           => __( 'Writer, product person, long-form enthusiast. Weekly essays on craft, clarity, and living with more intention.', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_author_bio_description',
		array(
			'type'        => 'textarea',
			'section'     => 'acme_author_bio',
			'label'       => __( 'Description', 'acme' ),
			'description' => __( 'Short bio text shown beneath the heading.', 'acme' ),
		)
	);

	$footer_social_settings = array(
		'acme_footer_facebook'  => array(
			'label'   => __( 'Facebook URL', 'acme' ),
			'default' => 'https://www.facebook.com/',
		),
		'acme_footer_instagram' => array(
			'label'   => __( 'Instagram URL', 'acme' ),
			'default' => 'https://www.instagram.com/',
		),
		'acme_footer_linkedin'  => array(
			'label'   => __( 'LinkedIn URL', 'acme' ),
			'default' => 'https://www.linkedin.com/',
		),
	);

	foreach ( $footer_social_settings as $setting_id => $meta ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $meta['default'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'type'        => 'url',
				'section'     => 'acme_footer_socials',
				'label'       => $meta['label'],
			)
		);
	}

	$wp_customize->add_section(
		'acme_hero_feature',
		array(
			'title'       => __( 'Hero Feature', 'acme' ),
			'description' => __( 'Content for the homepage hero card.', 'acme' ),
			'priority'    => 165,
		)
	);

	$wp_customize->add_setting(
		'acme_hero_eyebrow',
		array(
			'default'           => __( 'Featured insight', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_hero_eyebrow',
		array(
			'type'        => 'text',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Eyebrow Label', 'acme' ),
			'description' => __( 'Short label shown above the hero heading.', 'acme' ),
		)
	);

	$wp_customize->add_setting(
		'acme_hero_heading',
		array(
			'default'           => __( 'Share ideas worth reading.', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_hero_heading',
		array(
			'type'        => 'text',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Heading', 'acme' ),
			'description' => __( 'Main hero headline.', 'acme' ),
		)
	);

	$wp_customize->add_setting(
		'acme_hero_subheading',
		array(
			'default'           => __( 'A minimalist space for long-form storytelling. Publish faster, focus harder, and give readers the calm they crave.', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_hero_subheading',
		array(
			'type'        => 'textarea',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Subheading', 'acme' ),
			'description' => __( 'Supporting copy under the main headline.', 'acme' ),
		)
	);

	$wp_customize->add_setting(
		'acme_hero_primary_label',
		array(
			'default'           => __( 'Start reading', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_hero_primary_label',
		array(
			'type'        => 'text',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Primary Button Label', 'acme' ),
		)
	);

	$wp_customize->add_setting(
		'acme_hero_primary_link',
		array(
			'default'           => '#latest',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'acme_hero_primary_link',
		array(
			'type'        => 'url',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Primary Button Link', 'acme' ),
		)
	);

	$wp_customize->add_setting(
		'acme_hero_secondary_label',
		array(
			'default'           => __( 'About the author', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_hero_secondary_label',
		array(
			'type'        => 'text',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Secondary Button Label', 'acme' ),
		)
	);

    $wp_customize->add_setting(
        'acme_hero_secondary_page',
        array(
            'default'           => 0,
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh',
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        'acme_hero_secondary_page',
        array(
            'type'        => 'dropdown-pages',
            'section'     => 'acme_hero_feature',
            'label'       => __( 'Secondary Button Page', 'acme' ),
            'description' => __( 'Select the page linked from the secondary button.', 'acme' ),
        )
    );

	$wp_customize->add_setting(
		'acme_hero_quote',
		array(
			'default'           => __( '“Publishing on this theme feels effortless. Every post looks premium without the heavy tooling.”', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_hero_quote',
		array(
			'type'        => 'textarea',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Testimonial Quote', 'acme' ),
		)
	);

	$wp_customize->add_setting(
		'acme_hero_quote_attribution',
		array(
			'default'           => __( 'Reader feedback', 'acme' ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'acme_hero_quote_attribution',
		array(
			'type'        => 'text',
			'section'     => 'acme_hero_feature',
			'label'       => __( 'Testimonial Attribution', 'acme' ),
		)
	);
}
add_action( 'customize_register', 'acme_customize_register' );

/**
 * Sanitize the author bio image setting.
 *
 * @param mixed $value Value input from the Customizer.
 * @return int|string Sanitized attachment ID or URL.
 */
function acme_sanitize_author_bio_image( $value ) {
	if ( is_numeric( $value ) ) {
		return absint( $value );
	}

	if ( is_string( $value ) ) {
		$value = trim( $value );

		if ( filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return esc_url_raw( $value );
		}
	}

	return '';
}

/**
 * Output skip link target helper.
 */
function acme_skip_link_target() {
	echo '<div id="main-content" class="skip-target" tabindex="-1"></div>';
}
add_action( 'wp_body_open', 'acme_skip_link_target' );

/**
 * Render reading progress bar container.
 */
function acme_render_progress_bar() {
	echo '<div class="acme-reading-progress" aria-hidden="true"><div class="acme-reading-progress__bar"></div></div>';
}
add_action( 'wp_body_open', 'acme_render_progress_bar', 5 );

/**
 * Shortcode: estimated reading time.
 *
 * @return string
 */
function acme_estimated_reading_time_shortcode() {
	if ( ! is_singular() ) {
		return '';
	}

	$post = get_post();

	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$content = apply_filters( 'the_content', $post->post_content );
	$content = wp_strip_all_tags( $content );
	$words   = str_word_count( $content );

	$minutes = (int) ceil( $words / 225 );
	$minutes = max( 1, $minutes );

	return sprintf(
		'<span class="acme-reading-time" aria-label="%1$s">%2$s</span>',
		esc_attr( sprintf( _n( '%s minute read', '%s minutes read', $minutes, 'acme' ), number_format_i18n( $minutes ) ) ),
		esc_html( sprintf( _n( '%s min read', '%s min read', $minutes, 'acme' ), number_format_i18n( $minutes ) ) )
	);
}
add_shortcode( 'acme_estimated_reading_time', 'acme_estimated_reading_time_shortcode' );

/**
 * Shortcode: related posts by category/tag.
 *
 * @return string
 */
function acme_related_posts_shortcode() {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	$post = get_post();

	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$categories = wp_get_post_terms(
		$post->ID,
		'category',
		array(
			'fields' => 'ids',
		)
	);

	$tags = wp_get_post_terms(
		$post->ID,
		'post_tag',
		array(
			'fields' => 'ids',
		)
	);

	$related_args = array(
		'post_type'           => 'post',
		'post__not_in'        => array( $post->ID ),
		'posts_per_page'      => 3,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	);

	$tax_query = array();

	if ( ! empty( $categories ) ) {
		$tax_query[] = array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $categories,
		);
	}

	if ( ! empty( $tags ) ) {
		$tax_query[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'term_id',
			'terms'    => $tags,
		);
	}

	if ( ! empty( $tax_query ) ) {
		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'OR';
		}

		$related_args['tax_query'] = $tax_query;
	}

	$query = new WP_Query( $related_args );

	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	?>
	<section class="acme-related-posts" aria-labelledby="acme-related-title">
		<h2 id="acme-related-title" class="acme-related-posts__heading"><?php esc_html_e( 'Related stories', 'acme' ); ?></h2>
		<ul class="acme-related-posts__list">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>
				<li class="acme-related-posts__item">
					<a href="<?php the_permalink(); ?>" class="acme-related-posts__link">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="acme-related-posts__thumb">
								<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
							</div>
						<?php endif; ?>
						<div class="acme-related-posts__content">
							<h3 class="acme-related-posts__title"><?php the_title(); ?></h3>
							<p class="acme-related-posts__meta"><?php echo esc_html( get_the_date() ); ?></p>
						</div>
					</a>
				</li>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</ul>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'acme_related_posts', 'acme_related_posts_shortcode' );

/**
 * Shortcode: floating share buttons.
 *
 * @return string
 */
function acme_share_bar_shortcode() {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	$url   = urlencode( get_permalink() );
	$title = urlencode( wp_strip_all_tags( get_the_title() ) );

	ob_start();
	?>
	<div class="acme-floating-share" aria-label="<?php esc_attr_e( 'Share this article', 'acme' ); ?>">
		<button type="button" data-share="copy" aria-label="<?php esc_attr_e( 'Copy link', 'acme' ); ?>">⧉</button>
		<button type="button" data-share="native" aria-label="<?php esc_attr_e( 'Share with device menu', 'acme' ); ?>">⇪</button>
		<a href="<?php echo esc_url( "https://twitter.com/intent/tweet?url={$url}&text={$title}" ); ?>" data-share="twitter" aria-label="<?php esc_attr_e( 'Share on X/Twitter', 'acme' ); ?>">𝕏</a>
		<a href="<?php echo esc_url( "https://www.facebook.com/sharer/sharer.php?u={$url}" ); ?>" data-share="facebook" aria-label="<?php esc_attr_e( 'Share on Facebook', 'acme' ); ?>">f</a>
		<a href="<?php echo esc_url( "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}" ); ?>" data-share="linkedin" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'acme' ); ?>">in</a>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'acme_share_bar', 'acme_share_bar_shortcode' );

/**
 * Shortcode: footer social icons.
 *
 * @return string
 */
function acme_footer_socials_shortcode() {
	$profiles = array(
		array(
			'service' => 'facebook',
			'label'   => __( 'Facebook', 'acme' ),
			'url'     => get_theme_mod( 'acme_footer_facebook', '' ),
		),
		array(
			'service' => 'instagram',
			'label'   => __( 'Instagram', 'acme' ),
			'url'     => get_theme_mod( 'acme_footer_instagram', '' ),
		),
		array(
			'service' => 'linkedin',
			'label'   => __( 'LinkedIn', 'acme' ),
			'url'     => get_theme_mod( 'acme_footer_linkedin', '' ),
		),
	);

    $profiles = array_filter(
        $profiles,
        function ( $item ) {
            return ! empty( $item['url'] );
        }
    );

    if ( empty( $profiles ) ) {
        return '';
    }

    $inner_blocks = '';
    foreach ( $profiles as $item ) {
        $block = array(
            'service' => $item['service'],
            'url'     => esc_url_raw( $item['url'] ),
            'label'   => $item['label'],
        );
        $inner_blocks .= sprintf(
            '<!-- wp:social-link %s /-->',
            wp_json_encode( $block )
        );
    }

    $wrapper = '<!-- wp:social-links {"openInNewTab":true,"className":"footer-social","layout":{"type":"flex","justifyContent":"right"}} -->%s<!-- /wp:social-links -->';

    return do_blocks( sprintf( $wrapper, $inner_blocks ) );
}
add_shortcode( 'acme_footer_socials', 'acme_footer_socials_shortcode' );

/**
 * Shortcode: footer note with dynamic year/site name.
 *
 * @return string
 */
function acme_footer_note_shortcode() {
	return sprintf(
		'<p class="has-text-align-center has-text-color" style="color:%1$s;font-size:0.9rem;">© %2$s %3$s · %4$s</p>',
		esc_attr( 'var(--wp--preset--color--muted)' ),
		esc_html( gmdate( 'Y' ) ),
		esc_html( get_bloginfo( 'name' ) ),
		esc_html__( 'Tuno', 'acme' )
	);
}
add_shortcode( 'acme_footer_note', 'acme_footer_note_shortcode' );

/**
 * Shortcode: load more button for archives.
 *
 * @return string
 */
function acme_load_more_shortcode() {
	if ( ! ( is_home() || is_archive() ) ) {
		return '';
	}

	global $wp_query;

	if ( ! $wp_query instanceof WP_Query ) {
		return '';
	}

	$total_pages = max( 1, (int) $wp_query->max_num_pages );
	$per_page    = max( 1, (int) get_query_var( 'posts_per_page' ) );

	if ( $total_pages < 2 ) {
		return '';
	}

	return sprintf(
		'<div class="acme-load-more__wrapper"><button type="button" class="acme-load-more" data-load-more data-total-pages="%1$d" data-per-page="%2$d">%3$s</button></div>',
		esc_attr( $total_pages ),
		esc_attr( $per_page ),
		esc_html__( 'Load more stories', 'acme' )
	);
}
add_shortcode( 'acme_load_more', 'acme_load_more_shortcode' );

/**
 * Output JSON-LD structured data.
 */
function acme_output_json_ld() {
	if ( is_admin() ) {
		return;
	}

	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(),
	);

	$schema['@graph'][] = array(
		'@type'       => 'WebSite',
		'@id'         => $site_url . '#website',
		'url'         => $site_url,
		'name'        => $site_name,
		'inLanguage'  => get_bloginfo( 'language' ),
		'publisher'   => array(
			'@type' => 'Organization',
			'name'  => $site_name,
			'url'   => $site_url,
		),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => $site_url . '?s={search_term_string}',
			'query-input' => 'required name=search_term_string',
		),
	);

	if ( is_home() || is_front_page() ) {
		$schema['@graph'][] = array(
			'@type'      => 'Blog',
			'@id'        => $site_url . '#blog',
			'url'        => $site_url,
			'name'       => $site_name,
			'description'=> get_bloginfo( 'description' ),
			'publisher'  => array(
				'@id' => $site_url . '#website',
			),
		);
	}

	if ( is_singular( 'post' ) ) {
		$post      = get_queried_object();
		$author_id = $post->post_author;
		$author    = get_userdata( $author_id );

		$schema['@graph'][] = array(
			'@type'            => 'Person',
			'@id'              => $site_url . '#/schema/person/' . $author_id,
			'name'             => $author ? $author->display_name : '',
			'url'              => get_author_posts_url( $author_id ),
			'description'      => get_user_meta( $author_id, 'description', true ),
			'image'            => get_avatar_url( $author_id, array( 'size' => 256 ) ),
		);

		$schema['@graph'][] = array(
			'@type'            => 'BlogPosting',
			'@id'              => get_permalink( $post ),
			'headline'         => get_the_title( $post ),
			'description'      => wp_strip_all_tags( get_the_excerpt( $post ) ),
			'articleBody'      => wp_strip_all_tags( apply_filters( 'the_content', $post->post_content ) ),
			'datePublished'    => get_the_date( DATE_W3C, $post ),
			'dateModified'     => get_the_modified_date( DATE_W3C, $post ),
			'author'           => array(
				'@id' => $site_url . '#/schema/person/' . $author_id,
			),
			'publisher'        => array(
				'@id' => $site_url . '#website',
			),
			'mainEntityOfPage' => get_permalink( $post ),
			'image'            => get_the_post_thumbnail_url( $post, 'full' ),
		);

		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'@type' => 'ListItem',
			'position' => 1,
			'name' => __( 'Home', 'acme' ),
			'item' => $site_url,
		);

		$i = 2;
		$categories = get_the_category( $post->ID );
		if ( ! empty( $categories ) ) {
			$primary = $categories[0];
			$breadcrumbs[] = array(
				'@type' => 'ListItem',
				'position' => $i,
				'name' => $primary->name,
				'item' => get_category_link( $primary->term_id ),
			);
			++$i;
		}

		$breadcrumbs[] = array(
			'@type' => 'ListItem',
			'position' => $i,
			'name' => get_the_title( $post ),
		);

		$schema['@graph'][] = array(
			'@type'            => 'BreadcrumbList',
			'@id'              => get_permalink( $post ) . '#breadcrumb',
			'itemListElement'  => $breadcrumbs,
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';
}
add_action( 'wp_head', 'acme_output_json_ld', 20 );

/**
 * Output OpenGraph and Twitter card metadata.
 */
function acme_output_social_meta() {
	if ( is_admin() ) {
		return;
	}

	$title       = wp_get_document_title();
	$description = get_bloginfo( 'description' );
	$url         = home_url( add_query_arg( array(), $_SERVER['REQUEST_URI'] ?? '' ) );
	$image       = '';

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		if ( has_post_thumbnail( $post_id ) ) {
			$image = get_the_post_thumbnail_url( $post_id, 'large' );
		}

		$description = get_the_excerpt( $post_id );
		$url         = get_permalink( $post_id );
	}

	printf( '<meta property="og:site_name" content="%s" />' . PHP_EOL, esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s" />' . PHP_EOL, esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s" />' . PHP_EOL, esc_attr( wp_strip_all_tags( $description ) ) );
	printf( '<meta property="og:url" content="%s" />' . PHP_EOL, esc_url( $url ) );
	printf( '<meta property="og:type" content="%s" />' . PHP_EOL, esc_attr( is_singular() ? 'article' : 'website' ) );

	if ( $image ) {
		printf( '<meta property="og:image" content="%s" />' . PHP_EOL, esc_url( $image ) );
	}

	printf( '<meta name="twitter:card" content="%s" />' . PHP_EOL, esc_attr( $image ? 'summary_large_image' : 'summary' ) );
	printf( '<meta name="twitter:title" content="%s" />' . PHP_EOL, esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s" />' . PHP_EOL, esc_attr( wp_strip_all_tags( $description ) ) );

	if ( $image ) {
		printf( '<meta name="twitter:image" content="%s" />' . PHP_EOL, esc_url( $image ) );
	}
}
add_action( 'wp_head', 'acme_output_social_meta', 5 );

/**
 * Register pattern categories.
 */
function acme_register_pattern_categories() {
	register_block_pattern_category(
		'acme-media',
		array( 'label' => __( 'Acme Media', 'acme' ) )
	);
	register_block_pattern_category(
		'acme-cta',
		array( 'label' => __( 'Acme Calls to Action', 'acme' ) )
	);
	register_block_pattern_category(
		'acme-layouts',
		array( 'label' => __( 'Acme Layouts', 'acme' ) )
	);
}
add_action( 'init', 'acme_register_pattern_categories' );

/**
 * Add async/defer attributes for scripts where appropriate.
 *
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return string
 */
function acme_filter_script_tag( $tag, $handle ) {
	if ( 'acme-theme' === $handle ) {
		$tag = str_replace( '<script', '<script async', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'acme_filter_script_tag', 10, 2 );

/**
 * Extend searchform accessibility.
 *
 * @param string $form Default HTML.
 * @return string
 */
function acme_accessible_search_form( $form ) {
	return str_replace( 'type="search"', 'type="search" aria-label="' . esc_attr__( 'Search', 'acme' ) . '"', $form );
}
add_filter( 'get_search_form', 'acme_accessible_search_form' );

/**
 * Filter REST API post queries for context specific ordering.
 *
 * @param array           $args    WP_Query args.
 * @param WP_REST_Request $request Request.
 * @return array
 */
function acme_filter_rest_post_query( $args, $request ) {
	if ( 'minimal-list' !== $request->get_param( 'acme_context' ) ) {
		return $args;
	}

	$args['orderby'] = 'date';
	$args['order']   = 'DESC';

	return $args;
}
add_filter( 'rest_post_query', 'acme_filter_rest_post_query', 10, 2 );

/**
 * Handle theme REST endpoints (placeholder for extensibility).
 */
function acme_register_rest_routes() {
	register_rest_route(
		'acme/v1',
		'/settings',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => '__return_empty_array',
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'acme_register_rest_routes' );
