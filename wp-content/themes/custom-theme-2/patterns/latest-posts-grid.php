<?php
/**
 * Title: Latest posts grid
 * Slug: custom-theme-2/latest-posts-grid
 * Categories: acme-blog
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--lg)"}}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":2,"fontSize":"h3"} -->
	<h2 class="wp-block-heading has-h3-font-size">Latest from the blog</h2>
	<!-- /wp:heading -->
	<!-- wp:query {"queryId":20,"query":{"perPage":6,"postType":"post","order":"desc","orderBy":"date"},"displayLayout":{"type":"grid","columns":3}} -->
	<div class="wp-block-query"><!-- wp:post-template -->
		<!-- wp:group {"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--sm)"},"border":{"radius":"var(--acme-border-radius)"},"shadow":"var(--wp--preset--shadow--soft)","padding":{"top":"var(--wp--preset--spacing--sm)","right":"var(--wp--preset--spacing--sm)","bottom":"var(--wp--preset--spacing--sm)","left":"var(--wp--preset--spacing--sm)"}},"layout":{"type":"flex","orientation":"vertical"}} -->
		<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--sm);padding-right:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--sm)"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","style":{"border":{"radius":"var(--acme-border-radius-lg)"}}} /-->
			<!-- wp:post-title {"isLink":true,"fontSize":"h4"} /-->
			<!-- wp:post-excerpt {"moreText":"Read"} /-->
			<!-- wp:post-date {"fontSize":"small"} /--></div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p>No posts yet.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
