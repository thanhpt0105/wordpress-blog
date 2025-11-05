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
	
	// Determine which category should be highlighted
	$current_category_id = 0;
	
	if ( is_category() ) {
		// On category archive page
		$current_category_id = get_queried_object_id();
	} elseif ( is_single() && get_post_type() === 'post' ) {
		// On single post page - get the first category
		$post_categories = get_the_category();
		if ( ! empty( $post_categories ) ) {
			$current_category_id = $post_categories[0]->term_id;
		}
	}
	
	// Debug output (only visible in HTML source)
	echo '<!-- DEBUG: Found ' . count($categories) . ' categories -->';
	echo '<!-- DEBUG: Current category ID: ' . $current_category_id . ' -->';
	foreach ( $categories as $cat ) {
		echo '<!-- Category: ' . esc_html( $cat->name ) . ' (slug: ' . $cat->slug . ', count: ' . $cat->count . ', id: ' . $cat->term_id . ') -->';
	}
	
	if ( ! empty( $categories ) ) {
		echo '<ul class="site-header__category-list">';
		
		foreach ( $categories as $category ) {
			// Skip Uncategorized if it has no posts
			if ( $category->slug === 'uncategorized' && $category->count === 0 ) {
				continue;
			}
			
			$current = ( $current_category_id === $category->term_id ) ? 'current-cat' : '';
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
