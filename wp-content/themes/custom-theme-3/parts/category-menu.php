<?php
/**
 * Title: Category Menu PHP
 * Slug: custom-theme-3/category-menu-php
 * Description: Dynamic category menu
 */

$categories = acme_get_categories_with_posts();

if ( empty( $categories ) ) {
	return;
}

$current_cat_id = 0;
if ( is_category() ) {
	$current_cat_id = get_queried_object_id();
} elseif ( is_single() ) {
	$post_categories = get_the_category();
	if ( ! empty( $post_categories ) ) {
		$current_cat_id = $post_categories[0]->term_id;
	}
}
?>
<div class="wp-block-group alignwide site-header__categories is-horizontal is-content-justification-center is-layout-flex">
	<ul class="site-header__category-list">
		<?php foreach ( $categories as $category ) : ?>
			<li class="<?php echo ( $current_cat_id === $category->term_id ) ? 'current-cat' : ''; ?>">
				<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
					<?php echo esc_html( $category->name ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
