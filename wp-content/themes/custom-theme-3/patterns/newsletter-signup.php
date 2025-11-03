<?php
/**
 * Title: Newsletter Signup
 * Slug: custom-theme-3/newsletter-signup
 * Categories: acme-cta
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"3.5rem","bottom":"3.5rem","left":"3rem","right":"3rem"},"blockGap":"1.5rem"},"border":{"radius":"32px"}},"backgroundColor":"surface"} -->
<div class="wp-block-group has-surface-background-color has-background" style="border-radius:32px;padding-top:3.5rem;padding-right:3rem;padding-bottom:3.5rem;padding-left:3rem">
	<!-- wp:heading {"textAlign":"center","fontSize":"xl"} -->
	<h2 class="wp-block-heading has-text-align-center has-xl-font-size"><?php echo esc_html__( 'Join 12,000+ readers getting one slow email a week.', 'acme' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","fontSize":"md"} -->
	<p class="has-text-align-center has-md-font-size"><?php echo esc_html__( 'Thoughtful essays, zero spam. Unsubscribe anytime.', 'acme' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<form class="acme-newsletter-form" action="#" method="post">
		<label class="screen-reader-text" for="acme-newsletter-email"><?php echo esc_html__( 'Email', 'acme' ); ?></label>
		<input type="email" id="acme-newsletter-email" name="email" placeholder="<?php echo esc_attr__( 'your@email.com', 'acme' ); ?>" required />
		<button type="submit"><?php echo esc_html__( 'Subscribe', 'acme' ); ?></button>
	</form>
	<!-- /wp:html -->

	<!-- wp:paragraph {"align":"center","fontSize":"xs","style":{"color":{"text":"var:preset|color|muted"}}} -->
	<p class="has-text-align-center has-text-color has-xs-font-size" style="color:var(--wp--preset--color--muted)"><?php echo esc_html__( 'We respect your privacy. No ads, no noise.', 'acme' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
