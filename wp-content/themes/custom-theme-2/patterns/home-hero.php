<?php
/**
 * Title: Home hero intro
 * Slug: custom-theme-2/home-hero
 * Categories: acme-blog
 * Viewport Width: 1200
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var(--wp--preset--spacing--xxl)","bottom":"var(--wp--preset--spacing--xxl)"},"blockGap":"var(--wp--preset--spacing--xl)"},"border":{"radius":"var(--acme-border-radius-lg)"},"shadow":"var(--wp--preset--shadow--soft)"},"layout":{"type":"constrained"},"backgroundColor":"neutral-5"} -->
<div class="wp-block-group has-neutral-5-background-color has-background" style="border-radius:var(--acme-border-radius-lg);padding-top:var(--wp--preset--spacing--xxl);padding-right:var(--wp--preset--spacing--xl);padding-bottom:var(--wp--preset--spacing--xxl);padding-left:var(--wp--preset--spacing--xl)">
	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var(--wp--preset--spacing--xl)"}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"hero-overline","fontSize":"small"} -->
			<p class="hero-overline has-small-font-size">Welcome to</p>
			<!-- /wp:paragraph -->
			<!-- wp:site-title {"className":"hero-title","level":1,"fontSize":"display","isLink":false} /-->
			<!-- wp:site-tagline {"className":"hero-tagline"} /-->
			<!-- wp:paragraph {"fontSize":"lead"} -->
			<p class="has-lead-font-size">Stories, notes, and lessons gathered from the craft of building and sharing on the web.</p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons {"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--sm)"}}} -->
			<div class="wp-block-buttons"><!-- wp:button {"textColor":"neutral-0","backgroundColor":"primary"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-neutral-0-color has-text-color has-background wp-element-button" href="#latest">Read the latest</a></div>
				<!-- /wp:button -->
				<!-- wp:button {"className":"is-style-outline"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/about/">About the author</a></div>
				<!-- /wp:button --></div>
			<!-- /wp:buttons -->
			<!-- wp:social-links {"iconColor":"primary","iconColorValue":"#1f3a93","className":"is-style-logos-only","style":{"spacing":{"blockGap":"var(--wp--preset--spacing--sm)","margin":{"top":"var(--wp--preset--spacing--md)"}}}} -->
			<ul class="wp-block-social-links has-icon-color is-style-logos-only" style="margin-top:var(--wp--preset--spacing--md)"><!-- wp:social-link {"service":"twitter"} /--><!-- wp:social-link {"service":"github"} /--><!-- wp:social-link {"service":"linkedin"} /--></ul>
			<!-- /wp:social-links --></div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"999px"},"shadow":"var(--wp--preset--shadow--soft)"}} -->
			<figure class="wp-block-image size-large has-custom-border has-custom-shadow" style="border-radius:999px"><img src="https://via.placeholder.com/640x640.png" alt="Portrait"/></figure>
			<!-- /wp:image --></div>
		<!-- /wp:column --></div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
