<?php
/**
 * Title: About the author card
 * Slug: custom-theme-2/about-author
 * Categories: acme-author
 */
?>
<!-- wp:group {"className":"acme-author-card","style":{"spacing":{"blockGap":"var(--wp--preset--spacing--md)","padding":{"top":"var(--wp--preset--spacing--md)","right":"var(--wp--preset--spacing--md)","bottom":"var(--wp--preset--spacing--md)","left":"var(--wp--preset--spacing--md)"}},"border":{"width":"1px","color":"var(--wp--preset--color--neutral-10)","radius":"var(--acme-border-radius-lg)"},"shadow":"var(--wp--preset--shadow--soft)"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group acme-author-card" style="border-color:var(--wp--preset--color--neutral-10);border-radius:var(--acme-border-radius-lg);border-width:1px;padding-top:var(--wp--preset--spacing--md);padding-right:var(--wp--preset--spacing--md);padding-bottom:var(--wp--preset--spacing--md);padding-left:var(--wp--preset--spacing--md)">
	<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--md)"}}} -->
	<div class="wp-block-group"><!-- wp:avatar {"size":96,"className":"acme-author-card__avatar"} /-->
		<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
		<div class="wp-block-group"><!-- wp:post-author-name {"fontSize":"h5"} /-->
			<!-- wp:post-author-biography /--></div>
		<!-- /wp:group -->
		<!-- wp:social-links {"iconColor":"neutral-80","iconColorValue":"#393e4a","className":"is-style-pill-shape","style":{"spacing":{"blockGap":"0.5rem"}}} -->
		<ul class="wp-block-social-links has-icon-color is-style-pill-shape"><!-- wp:social-link {"service":"twitter"} /--><!-- wp:social-link {"service":"github"} /--><!-- wp:social-link {"service":"linkedin"} /--></ul>
		<!-- /wp:social-links -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
