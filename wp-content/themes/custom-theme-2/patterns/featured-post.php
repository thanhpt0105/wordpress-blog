<?php
/**
 * Title: Featured post spotlight
 * Slug: custom-theme-2/featured-post
 * Categories: acme-blog
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--lg)","padding":{"top":"var(--wp--preset--spacing--lg)","bottom":"var(--wp--preset--spacing--lg)","left":"var(--wp--preset--spacing--lg)","right":"var(--wp--preset--spacing--lg)"}},"border":{"radius":"var(--acme-border-radius-lg)"},"shadow":"var(--wp--preset--shadow--soft)"},"backgroundColor":"neutral-0"} -->
<div class="wp-block-group has-neutral-0-background-color has-background" style="border-radius:var(--acme-border-radius-lg);padding-top:var(--wp--preset--spacing--lg);padding-right:var(--wp--preset--spacing--lg);padding-bottom:var(--wp--preset--spacing--lg);padding-left:var(--wp--preset--spacing--lg)">
	<!-- wp:heading {"level":2,"fontSize":"h3"} -->
	<h2 class="wp-block-heading has-h3-font-size">Featured read</h2>
	<!-- /wp:heading -->
	<!-- wp:query {"queryId":10,"query":{"perPage":1,"postType":"post","sticky":"only"},"displayLayout":{"type":"list"}} -->
	<div class="wp-block-query"><!-- wp:post-template -->
		<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--sm)"}}} -->
		<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"border":{"radius":"var(--acme-border-radius-lg)"}}} /-->
			<!-- wp:post-title {"isLink":true,"fontSize":"h2"} /-->
			<!-- wp:post-excerpt {"moreText":"Read now"} /-->
			<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"flex-start"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--xs)"}}} -->
			<div class="wp-block-group"><!-- wp:post-date {"fontSize":"small"} /-->
				<!-- wp:shortcode -->[acme_reading_time]<!-- /wp:shortcode --></div>
			<!-- /wp:group --></div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph {"fontSize":"small"} -->
		<p class="has-small-font-size">Mark a post as sticky and it will surface here.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
