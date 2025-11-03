<?php
/**
 * Title: Author Bio Card
 * Slug: custom-theme-3/author-bio
 * Categories: acme-media
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"className":"acme-author-card","style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem","left":"2rem","right":"2rem"},"blockGap":"1.5rem"}}} -->
<div class="wp-block-group acme-author-card">
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"1.5rem"}}} -->
	<div class="wp-block-group">
		<!-- wp:avatar {"size":96,"style":{"border":{"radius":"999px"}}} /-->

		<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
		<div class="wp-block-group">
			<!-- wp:heading {"level":3,"fontSize":"lg"} -->
			<h3 class="wp-block-heading has-lg-font-size"><?php echo esc_html__( 'Hi, I’m Alex', 'acme' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"fontSize":"md"} -->
			<p class="has-md-font-size"><?php echo esc_html__( 'Writer, product person, long-form enthusiast. Weekly essays on craft, clarity, and living with more intention.', 'acme' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"0.75rem"}}} -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"accent","textColor":"background"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-accent-background-color has-background-color has-text-color has-background" href="#"><?php echo esc_html__( 'Follow', 'acme' ); ?></a></div>
				<!-- /wp:button -->
				<!-- wp:button {"className":"is-style-outline"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php echo esc_html__( 'Latest posts', 'acme' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
