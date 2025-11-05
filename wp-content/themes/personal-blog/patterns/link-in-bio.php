<?php
/**
 * Title: Link in Bio
 * Slug: personal-blog/link-in-bio
 * Categories: personalblog-layouts
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem","left":"3rem","right":"3rem"},"blockGap":"1.25rem"},"border":{"radius":"30px"},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"backgroundColor":"surface"} -->
<div class="wp-block-group has-surface-background-color has-background" style="border-radius:30px;padding-top:3rem;padding-right:3rem;padding-bottom:3rem;padding-left:3rem">
	<!-- wp:avatar {"size":80,"align":"center","style":{"border":{"radius":"999px"}}} /-->
	<!-- wp:heading {"textAlign":"center","level":3,"fontSize":"lg"} -->
	<h3 class="wp-block-heading has-text-align-center has-lg-font-size"><?php echo esc_html__( 'Alex Rivers', 'personalblog' ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center"><?php echo esc_html__( 'Writer · Product thinker · Always prototyping', 'personalblog' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:social-links {"iconColor":"foreground","iconColorValue":"#111111","size":"has-normal-icon-size","layout":{"type":"flex","justifyContent":"center"}} -->
	<ul class="wp-block-social-links has-normal-icon-size has-icon-color">
		<!-- wp:social-link {"url":"#","service":"instagram"} /-->
		<!-- wp:social-link {"url":"#","service":"twitter"} /-->
		<!-- wp:social-link {"url":"#","service":"linkedin"} /-->
	</ul>
	<!-- /wp:social-links -->
	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"0.75rem"}}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"width":100,"backgroundColor":"accent","textColor":"background"} -->
		<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link has-accent-background-color has-background-color has-text-color has-background" href="#"><?php echo esc_html__( 'Read the latest essay', 'personalblog' ); ?></a></div>
		<!-- /wp:button -->
		<!-- wp:button {"width":100,"className":"is-style-outline"} -->
		<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php echo esc_html__( 'Subscribe to the newsletter', 'personalblog' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
