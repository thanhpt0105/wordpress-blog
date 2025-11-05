<?php
/**
 * Title: Category Menu
 * Slug: personal-blog/category-menu-updated
 * Categories: personalblog-layouts
 * Description: Horizontal category navigation strip for the header.
 */
?>
<!-- wp:group {"align":"wide","className":"site-header__categories","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"0.5rem","bottom":"0.5rem"}}}} -->
<div class="wp-block-group alignwide site-header__categories">
	<!-- wp:html -->
	<?php
	$categories = get_categories( array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false, // Show all categories, even without posts
	) );
	
	// Debug output (only visible in HTML source)
	echo '<!-- DEBUG: Found ' . count($categories) . ' categories -->';
	foreach ( $categories as $cat ) {
		echo '<!-- Category: ' . esc_html( $cat->name ) . ' (slug: ' . $cat->slug . ', count: ' . $cat->count . ') -->';
	}
	
	if ( ! empty( $categories ) ) {
		echo '<ul class="site-header__category-list">';
		
		foreach ( $categories as $category ) {
			// Skip Uncategorized if it has no posts
			if ( $category->slug === 'uncategorized' && $category->count === 0 ) {
				continue;
			}
			
			$current = is_category( $category->term_id ) ? 'current-cat' : '';
			printf(
				'<li class="%s"><a href="%s">%s</a></li>',
				esc_attr( $current ),
				esc_url( get_category_link( $category->term_id ) ),
				esc_html( $category->name )
			);
		}
		
		echo '</ul>';
	}
	?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
