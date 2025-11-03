<?php
/**
 * Title: Series index loop
 * Slug: custom-theme-2/series-index
 * Categories: acme-blog
 * Description: Highlight a series by tag and show navigation between entries.
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--md)"}}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":2,"fontSize":"h4"} -->
	<h2 class="wp-block-heading has-h4-font-size">Series spotlight</h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size">Update the tag slug in the block sidebar to match your series.</p>
	<!-- /wp:paragraph -->
	<!-- wp:query {"queryId":30,"query":{"perPage":6,"postType":"post","order":"asc","orderBy":"date","taxQuery":[{"taxonomy":"post_tag","field":"slug","terms":["series"]}]},"displayLayout":{"type":"list"}} -->
	<div class="wp-block-query"><!-- wp:post-template -->
		<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"0.35rem"},"border":{"bottom":{"color":"var(--wp--preset--color--neutral-10)","width":"1px"}},"spacing":{"padding":{"bottom":"var(--wp--preset--spacing--sm)"}}}} -->
		<div class="wp-block-group" style="padding-bottom:var(--wp--preset--spacing--sm)"><!-- wp:post-title {"isLink":true,"fontSize":"h5"} /-->
			<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
			<div class="wp-block-group"><!-- wp:post-date {"fontSize":"small"} /-->
				<!-- wp:post-excerpt {"moreText":"Read part","fontSize":"small"} /--></div>
			<!-- /wp:group --></div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p>Add posts tagged with your series to populate this section.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
