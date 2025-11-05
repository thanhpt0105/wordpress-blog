<?php
/**
 * Title: Category Menu
 * Slug: custom-theme-3/category-menu
 * Categories: acme-layouts
 * Description: Horizontal category navigation strip for the header.
 */
?>
<!-- wp:group {"align":"wide","className":"site-header__categories","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center","orientation":"horizontal"},"style":{"spacing":{"padding":{"top":"0.5rem","bottom":"0.5rem"}}}} -->
<div class="wp-block-group alignwide site-header__categories">
	<!-- wp:shortcode -->
	[acme_category_menu]
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
