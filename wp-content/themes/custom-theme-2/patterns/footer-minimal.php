<?php
/**
 * Title: Footer minimal
 * Slug: custom-theme-2/footer-minimal
 * Categories: acme-utility
 */
?>
<!-- wp:group {"tagName":"footer","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var(--wp--preset--spacing--lg)","bottom":"var(--wp--preset--spacing--lg)"},"blockGap":"var(--wp--preset--spacing--sm)"},"border":{"top":{"width":"1px","color":"var(--wp--preset--color--neutral-10)"}}}} -->
<footer class="wp-block-group">
	<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group"><!-- wp:site-title {"level":0,"isLink":false"} /-->
		<!-- wp:paragraph {"fontSize":"small"} -->
		<p class="has-small-font-size">&copy; [acme_year]</p>
		<!-- /wp:paragraph --></div>
	<!-- /wp:group -->
	<!-- wp:social-links {"className":"is-style-logos-only"} -->
	<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"service":"twitter"} /--><!-- wp:social-link {"service":"github"} /--><!-- wp:social-link {"service":"linkedin"} /--></ul>
	<!-- /wp:social-links -->
</footer>
<!-- /wp:group -->
