<?php
/**
 * Title: Gallery with lightbox
 * Slug: custom-theme-2/gallery-lightbox
 * Categories: acme-blog
 */
?>
<!-- wp:group {"className":"acme-gallery-lightbox","layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--sm)"}}} -->
<div class="wp-block-group acme-gallery-lightbox">
	<!-- wp:heading {"level":3,"fontSize":"h4"} -->
	<h3 class="wp-block-heading has-h4-font-size">In the studio</h3>
	<!-- /wp:heading -->
	<!-- wp:gallery {"columns":3,"linkTo":"media"} -->
	<figure class="wp-block-gallery has-nested-images columns-3 is-cropped"><!-- wp:image {"sizeSlug":"large","linkDestination":"media"} -->
		<figure class="wp-block-image size-large"><a href="https://via.placeholder.com/1600x900.png" data-acme-lightbox><img src="https://via.placeholder.com/800x450.png" alt="Workspace"/></a><figcaption>Workspace</figcaption></figure>
		<!-- /wp:image -->
		<!-- wp:image {"sizeSlug":"large","linkDestination":"media"} -->
		<figure class="wp-block-image size-large"><a href="https://via.placeholder.com/1600x900.png?text=Detail" data-acme-lightbox><img src="https://via.placeholder.com/800x450.png?text=Detail" alt="Details"/></a><figcaption>Details</figcaption></figure>
		<!-- /wp:image -->
		<!-- wp:image {"sizeSlug":"large","linkDestination":"media"} -->
		<figure class="wp-block-image size-large"><a href="https://via.placeholder.com/1600x900.png?text=Process" data-acme-lightbox><img src="https://via.placeholder.com/800x450.png?text=Process" alt="Process"/></a><figcaption>Process</figcaption></figure>
		<!-- /wp:image --></figure>
	<!-- /wp:gallery -->
</div>
<!-- /wp:group -->
