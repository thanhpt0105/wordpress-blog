<?php
/**
 * Title: Hero Feature
 * Slug: custom-theme-3/hero-feature
 * Categories: acme-layouts
 * Viewport Width: 1200
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"4rem","bottom":"2rem"},"blockGap":"1rem"}},"className":"acme-hero"} -->
<div class="wp-block-group acme-hero">
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"},"style":{"spacing":{"blockGap":"2.5rem"}}} -->
	<div class="wp-block-group">
		<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"1rem"}},"className":"acme-hero__content"} -->
		<div class="wp-block-group acme-hero__content">
<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|accent"},"typography":{"letterSpacing":"0.2em","textTransform":"uppercase","fontSize":"0.85rem","fontWeight":"600"}},"fontFamily":"arial-sans"} -->
<p class="has-text-color has-arial-sans-font-family" style="color:var(--wp--preset--color--accent);letter-spacing:0.2em;text-transform:uppercase;font-size:0.85rem;font-weight:600"><?php echo wp_kses_post( get_theme_mod( 'acme_hero_eyebrow', esc_html__( 'Featured insight', 'acme' ) ) ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"fontSize":"xxl"} -->
			<h1 class="wp-block-heading has-xxl-font-size"><?php echo wp_kses_post( get_theme_mod( 'acme_hero_heading', esc_html__( 'Share ideas worth reading.', 'acme' ) ) ); ?></h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"lg"} -->
			<p class="has-lg-font-size"><?php echo wp_kses_post( get_theme_mod( 'acme_hero_subheading', esc_html__( 'A minimalist space for long-form storytelling. Publish faster, focus harder, and give readers the calm they crave.', 'acme' ) ) ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"layout":{"type":"flex"}} -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"accent","textColor":"background","style":{"spacing":{"padding":{"top":"0.85rem","bottom":"0.85rem","left":"1.75rem","right":"1.75rem"}}}} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-accent-background-color has-text-color has-background" href="<?php echo esc_url( get_theme_mod( 'acme_hero_primary_link', '#latest' ) ); ?>"><?php echo wp_kses_post( get_theme_mod( 'acme_hero_primary_label', esc_html__( 'Start reading', 'acme' ) ) ); ?></a></div>
				<!-- /wp:button -->
				<!-- wp:button {"className":"is-style-outline"} -->
				<?php
				$acme_secondary_page_id = (int) get_theme_mod( 'acme_hero_secondary_page', 0 );
				$acme_secondary_url     = $acme_secondary_page_id ? get_permalink( $acme_secondary_page_id ) : '#';
				?>
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $acme_secondary_url ); ?>"><?php echo wp_kses_post( get_theme_mod( 'acme_hero_secondary_label', esc_html__( 'About the author', 'acme' ) ) ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"layout":{"type":"constrained"},"className":"acme-author-card","style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem","left":"2rem","right":"2rem"},"blockGap":"1.5rem"}}} -->
		<div class="wp-block-group acme-author-card">
			<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"1.5rem"}}} -->
			<div class="wp-block-group">
				<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
				<div class="wp-block-group">
				<!-- wp:paragraph {"fontSize":"lg","fontFamily":"arial-serif","style":{"typography":{"lineHeight":"1.6","fontStyle":"italic"}}} -->
				<p class="has-lg-font-size has-arial-serif-font-family" style="font-style:italic;line-height:1.6"><?php echo wp_kses_post( get_theme_mod( 'acme_hero_quote', esc_html__( '“Publishing on this theme feels effortless. Every post looks premium without the heavy tooling.”', 'acme' ) ) ); ?></p>
					<!-- /wp:paragraph -->

				<!-- wp:paragraph {"textColor":"muted","fontFamily":"arial-sans","style":{"typography":{"letterSpacing":"0.18em","textTransform":"uppercase","fontSize":"0.8rem","fontWeight":"600"}}} -->
				<p class="has-muted-color has-text-color has-arial-sans-font-family" style="letter-spacing:0.18em;text-transform:uppercase;font-size:0.8rem;font-weight:600"><?php echo wp_kses_post( get_theme_mod( 'acme_hero_quote_attribution', esc_html__( 'Reader feedback', 'acme' ) ) ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
