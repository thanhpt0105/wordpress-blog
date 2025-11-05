<?php
/**
 * Title: Post Grid
 * Slug: personal-blog/post-grid
 * Categories: personalblog-layouts
 * Keywords: grid, posts, cards
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"2rem"}}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":2,"fontSize":"xl"} -->
	<h2 class="wp-block-heading has-xl-font-size"><?php echo esc_html__( 'Featured reads', 'personalblog' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":6,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","sticky":"exclude"},"displayLayout":{"type":"grid","columnCount":3}} -->
	<div class="wp-block-query">
		<!-- wp:post-template -->
		<!-- wp:group {"style":{"spacing":{"blockGap":"1rem"},"border":{"radius":"24px"},"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"backgroundColor":"surface","className":"personalblog-post-card"} -->
		<div class="wp-block-group personalblog-post-card has-surface-background-color has-background" style="border-radius:24px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem">
			<!-- wp:post-featured-image {"isLink":true,"style":{"border":{"radius":"18px"},"spacing":{"margin":{"bottom":"1rem"}}}} /-->
			<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"lg"} /-->
			<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"0.5rem"},"typography":{"fontSize":"0.85rem"}},"className":"personalblog-post-card__meta"} -->
			<div class="wp-block-group personalblog-post-card__meta">
				<!-- wp:post-date {"format":"M j"} /-->
				<!-- wp:shortcode -->
				[personalblog_estimated_reading_time]
				<!-- /wp:shortcode -->
			</div>
			<!-- /wp:group -->
			<!-- wp:post-excerpt {"moreText":"Continue reading"} /-->
		</div>
		<!-- /wp:group -->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
