<?php
/**
 * Template Name: Test Categories Debug
 * 
 * This template displays all categories for debugging.
 */

get_header();
?>

<main style="padding: 3rem; max-width: 800px; margin: 0 auto;">
	<h1>Category Debug Page</h1>
	
	<h2>All Categories (hide_empty = false)</h2>
	<?php
	$all_categories = get_categories( array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false,
	) );
	
	echo '<p><strong>Total found: ' . count($all_categories) . '</strong></p>';
	echo '<ul style="line-height: 2;">';
	foreach ( $all_categories as $cat ) {
		echo '<li>';
		echo '<strong>' . esc_html( $cat->name ) . '</strong> ';
		echo '(ID: ' . $cat->term_id . ', ';
		echo 'Slug: <code>' . $cat->slug . '</code>, ';
		echo 'Posts: ' . $cat->count . ')';
		echo '</li>';
	}
	echo '</ul>';
	?>
	
	<hr style="margin: 2rem 0;">
	
	<h2>Categories with Posts (hide_empty = true)</h2>
	<?php
	$categories_with_posts = get_categories( array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true,
	) );
	
	echo '<p><strong>Total found: ' . count($categories_with_posts) . '</strong></p>';
	echo '<ul style="line-height: 2;">';
	foreach ( $categories_with_posts as $cat ) {
		echo '<li>';
		echo '<strong>' . esc_html( $cat->name ) . '</strong> ';
		echo '(ID: ' . $cat->term_id . ', ';
		echo 'Slug: <code>' . $cat->slug . '</code>, ';
		echo 'Posts: ' . $cat->count . ')';
		echo '</li>';
	}
	echo '</ul>';
	?>
	
	<hr style="margin: 2rem 0;">
	
	<h2>What Should Appear in Menu</h2>
	<?php
	$menu_categories = get_categories( array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false,
	) );
	
	echo '<p>Menu items:</p>';
	echo '<ul style="line-height: 2;">';
	echo '<li><strong>All</strong> (Home link)</li>';
	
	foreach ( $menu_categories as $category ) {
		// Skip Uncategorized if it has no posts (same logic as pattern)
		if ( $category->slug === 'uncategorized' && $category->count === 0 ) {
			echo '<li style="color: #999;"><s>' . esc_html( $category->name ) . '</s> (skipped - uncategorized with 0 posts)</li>';
			continue;
		}
		
		echo '<li><strong>' . esc_html( $category->name ) . '</strong> ';
		echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">View →</a>';
		echo '</li>';
	}
	echo '</ul>';
	?>
	
	<hr style="margin: 2rem 0;">
	
	<h2>How to Fix</h2>
	<ol style="line-height: 2;">
		<li>If you see "Fashion" listed above, go to <strong>Posts → Categories</strong></li>
		<li>Make sure the category name is spelled correctly</li>
		<li>Clear browser cache (Ctrl+Shift+R / Cmd+Shift+R)</li>
		<li>View page source and search for "DEBUG: Found" to see raw output</li>
		<li>If still not showing, the pattern file might be cached by WordPress</li>
	</ol>
	
	<hr style="margin: 2rem 0;">
	
	<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">← Back to Home</a></p>
</main>

<?php
get_footer();
?>
