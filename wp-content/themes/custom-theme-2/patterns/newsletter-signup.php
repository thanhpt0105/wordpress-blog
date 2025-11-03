<?php
/**
 * Title: Newsletter signup
 * Slug: custom-theme-2/newsletter-signup
 * Categories: acme-utility
 */
?>
<!-- wp:group {"className":"newsletter-grid","style":{"spacing":{"blockGap":"var(--wp--preset--spacing--sm)","padding":{"top":"var(--wp--preset--spacing--lg)","right":"var(--wp--preset--spacing--lg)","bottom":"var(--wp--preset--spacing--lg)","left":"var(--wp--preset--spacing--lg)"}},"border":{"width":"1px","color":"var(--wp--preset--color--neutral-10)","radius":"var(--acme-border-radius-lg)"},"backgroundColor":"neutral-5"}} -->
<div class="wp-block-group newsletter-grid has-neutral-5-background-color has-background" style="border-color:var(--wp--preset--color--neutral-10);border-radius:var(--acme-border-radius-lg);border-width:1px;padding-top:var(--wp--preset--spacing--lg);padding-right:var(--wp--preset--spacing--lg);padding-bottom:var(--wp--preset--spacing--lg);padding-left:var(--wp--preset--spacing--lg)">
	<!-- wp:heading {"level":3,"fontSize":"h4"} -->
	<h3 class="wp-block-heading has-h4-font-size">Subscribe for new essays</h3>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size">One thoughtful email every other week. No spam, unsubscribe anytime.</p>
	<!-- /wp:paragraph -->
	<!-- wp:html -->
	<form action="#" method="post" class="newsletter-form" novalidate>
		<label class="acme-sr-only" for="newsletter-email">Email address</label>
		<input type="email" id="newsletter-email" name="email" placeholder="you@example.com" required />
		<button type="submit">Join the list</button>
	</form>
	<!-- /wp:html -->
	<!-- wp:paragraph {"fontSize":"caption"} -->
	<p class="has-caption-font-size">Compatible with Mailchimp, ConvertKit, Jetpack, and native WP forms.</p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
