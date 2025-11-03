<?php
/**
 * Title: Latest posts list
 * Slug: custom-theme-2/latest-posts-list
 * Categories: acme-blog
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--md)"}}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":2,"fontSize":"h4"} -->
	<h2 class="wp-block-heading has-h4-font-size">Fresh takes</h2>
	<!-- /wp:heading -->
	<!-- wp:query {"queryId":21,"query":{"perPage":5,"postType":"post","order":"desc","orderBy":"date"},"displayLayout":{"type":"list"}} -->
	<div class="wp-block-query"><!-- wp:post-template -->
		<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--xs)","padding":{"bottom":"var(--wp--preset--spacing--sm)"}},"border":{"bottom":{"color":"var(--wp--preset--color--neutral-10)","width":"1px"}}}} -->
		<div class="wp-block-group" style="padding-bottom:var(--wp--preset--spacing--sm)"><!-- wp:post-title {"isLink":true,"fontSize":"h5"} /-->
			<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
			<div class="wp-block-group"><!-- wp:post-date {"fontSize":"small"} /-->
				<!-- wp:shortcode -->[acme_reading_time]<!-- /wp:shortcode -->
				<!-- wp:post-terms {"term":"category","fontSize":"small"} /--></div>
			<!-- /wp:group -->
			<!-- wp:post-excerpt {"moreText":"Read"} /--></div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p>Nothing here yet. Keep writing.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
