<?php
/**
 * Title: Call to Action
 * Slug: custom-theme-3/call-to-action
 * Categories: acme-cta
 */
?>
<!-- wp:cover {"overlayColor":"accent","isDark":false,"minHeight":360,"style":{"border":{"radius":"36px"},"color":{"duotone":["#0b3d0a","#ffffff"]}}} -->
<div class="wp-block-cover is-light" style="border-radius:36px;min-height:360px"><span aria-hidden="true" class="wp-block-cover__background has-accent-background-color has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:group {"layout":{"type":"constrained","justifyContent":"center"},"style":{"spacing":{"blockGap":"1rem"},"typography":{"textAlign":"center"}}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"2.4rem","lineHeight":"1.3","color":{"text":"var:preset|color|background"}}}} -->
		<h2 class="wp-block-heading has-text-align-center" style="color:var(--wp--preset--color--background);font-size:2.4rem;line-height:1.3"><?php echo esc_html__( 'Ready to publish your next idea?', 'acme' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.05rem","color":{"text":"var:preset|color|background"}}}} -->
		<p class="has-text-align-center" style="color:var(--wp--preset--color--background);font-size:1.05rem"><?php echo esc_html__( 'Use this space to pitch your newsletter, services, or flagship project.', 'acme' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons">
			<!-- wp:button {"backgroundColor":"background","textColor":"accent","style":{"spacing":{"padding":{"top":"0.85rem","bottom":"0.85rem","left":"2rem","right":"2rem"}}}} -->
			<div class="wp-block-button"><a class="wp-block-button__link has-background-background-color has-text-color has-background" href="#"><?php echo esc_html__( 'Start publishing', 'acme' ); ?></a></div>
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div></div>
<!-- /wp:cover -->
