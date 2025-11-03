<?php
/**
 * Title: Hero Feature
 * Slug: custom-theme-3/hero-feature
 * Categories: acme-layouts
 * Viewport Width: 1200
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"},"blockGap":"2.5rem"}},"className":"acme-hero"} -->
<div class="wp-block-group acme-hero">
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"},"style":{"spacing":{"blockGap":"2.5rem"}}} -->
	<div class="wp-block-group">
		<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"1rem"}},"className":"acme-hero__content"} -->
		<div class="wp-block-group acme-hero__content">
			<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|accent"},"typography":{"letterSpacing":"0.2em","textTransform":"uppercase","fontSize":"0.85rem","fontWeight":"600"}},"fontFamily":"inter-sans"} -->
			<p class="has-text-color has-inter-sans-font-family" style="color:var(--wp--preset--color--accent);letter-spacing:0.2em;text-transform:uppercase;font-size:0.85rem;font-weight:600"><?php echo esc_html__( 'Featured insight', 'acme' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"fontSize":"xxl"} -->
			<h1 class="wp-block-heading has-xxl-font-size"><?php echo esc_html__( 'Share ideas worth reading.', 'acme' ); ?></h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"lg"} -->
			<p class="has-lg-font-size"><?php echo esc_html__( 'A minimalist space for long-form storytelling. Publish faster, focus harder, and give readers the calm they crave.', 'acme' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"layout":{"type":"flex"}} -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"accent","textColor":"background","style":{"spacing":{"padding":{"top":"0.85rem","bottom":"0.85rem","left":"1.75rem","right":"1.75rem"}}}} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-background-color has-accent-background-color has-text-color has-background" href="#latest"><?php echo esc_html__( 'Start reading', 'acme' ); ?></a></div>
				<!-- /wp:button -->
				<!-- wp:button {"className":"is-style-outline"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php echo esc_html__( 'About the author', 'acme' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->

		<!-- wp:cover {"overlayColor":"surface","minHeight":420,"style":{"border":{"radius":"28px"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
		<div class="wp-block-cover" style="border-radius:28px;min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-surface-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container">
			<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1rem","lineHeight":"1.65"},"spacing":{"padding":{"top":"3rem","right":"3rem","bottom":"3rem","left":"3rem"}}}} -->
			<p class="has-text-align-center" style="padding-top:3rem;padding-right:3rem;padding-bottom:3rem;padding-left:3rem;font-size:1rem;line-height:1.65"><?php echo esc_html__( '“Publishing on this theme feels effortless. Every post looks premium without the heavy tooling.”', 'acme' ); ?></p>
			<!-- /wp:paragraph -->
		</div></div>
		<!-- /wp:cover -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
