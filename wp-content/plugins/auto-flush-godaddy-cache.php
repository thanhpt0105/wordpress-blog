<?php
/**
 * Plugin Name: Auto Flush GoDaddy Cache
 * Plugin URI: https://github.com/thanhpt0105/wordpress-blog
 * Description: Automatically flushes GoDaddy cache when creating/editing posts, categories, or during deployment. Works with GoDaddy's built-in cache system.
 * Version: 1.0.0
 * Author: Personal Blog Theme
 * License: GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flush GoDaddy cache using their native function.
 * 
 * GoDaddy provides several cache flush methods:
 * 1. ban_url() - Flush specific URL
 * 2. flush_cache() - Flush entire site cache
 */
function flush_godaddy_cache( $urls = array() ) {
	$flushed = false;
	
	// Method 1: Use GoDaddy's native flush function if available
	if ( class_exists( 'GD_Cache' ) && method_exists( 'GD_Cache', 'ban' ) ) {
		if ( ! empty( $urls ) ) {
			foreach ( $urls as $url ) {
				GD_Cache::ban( $url );
			}
		} else {
			// Flush entire cache
			GD_Cache::ban( home_url() );
		}
		$flushed = true;
	}
	
	// Method 2: Try the global ban_url function (older GoDaddy sites)
	if ( ! $flushed && function_exists( 'ban_url' ) ) {
		if ( ! empty( $urls ) ) {
			foreach ( $urls as $url ) {
				ban_url( $url );
			}
		} else {
			ban_url( home_url() );
		}
		$flushed = true;
	}
	
	// Method 3: Try WP-CLI if available (for SSH deployments)
	if ( ! $flushed && defined( 'WP_CLI' ) && WP_CLI ) {
		WP_CLI::runcommand( 'cache flush' );
		$flushed = true;
	}
	
	// Method 4: Use WordPress transient deletion as fallback
	if ( ! $flushed ) {
		wp_cache_flush();
		delete_transient( 'godaddy_cache_timestamp' );
		$flushed = true;
	}
	
	// Log the action for debugging
	if ( $flushed && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'GoDaddy cache flushed: ' . ( empty( $urls ) ? 'all' : implode( ', ', $urls ) ) );
	}
	
	return $flushed;
}

/**
 * Flush cache when a post is published or updated.
 */
function flush_godaddy_cache_on_post_save( $post_id, $post ) {
	// Skip autosave, revisions, and drafts
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( $post->post_status !== 'publish' ) {
		return;
	}
	
	// Flush cache for:
	// 1. The post itself
	// 2. Homepage (shows latest posts)
	// 3. Category archives
	// 4. Archive pages
	$urls_to_flush = array(
		get_permalink( $post_id ),  // Post URL
		home_url(),                  // Homepage
	);
	
	// Add category URLs
	$categories = get_the_category( $post_id );
	foreach ( $categories as $category ) {
		$urls_to_flush[] = get_category_link( $category->term_id );
	}
	
	// Add archive URLs
	$urls_to_flush[] = get_post_type_archive_link( $post->post_type );
	
	flush_godaddy_cache( $urls_to_flush );
}
add_action( 'save_post', 'flush_godaddy_cache_on_post_save', 10, 2 );

/**
 * Flush cache when a category is created, edited, or deleted.
 */
function flush_godaddy_cache_on_category_change( $term_id, $tt_id = null, $taxonomy = null ) {
	// Only handle category changes
	if ( $taxonomy && $taxonomy !== 'category' ) {
		return;
	}
	
	$urls_to_flush = array(
		home_url(),  // Homepage shows category menu
	);
	
	// Add the specific category URL
	if ( $term_id ) {
		$category_url = get_category_link( $term_id );
		if ( $category_url ) {
			$urls_to_flush[] = $category_url;
		}
	}
	
	flush_godaddy_cache( $urls_to_flush );
	
	// Also clear the category menu cache
	if ( function_exists( 'personalblog_clear_category_menu_cache' ) ) {
		personalblog_clear_category_menu_cache();
	}
}
add_action( 'created_category', 'flush_godaddy_cache_on_category_change', 10, 3 );
add_action( 'edited_category', 'flush_godaddy_cache_on_category_change', 10, 3 );
add_action( 'delete_category', 'flush_godaddy_cache_on_category_change', 10, 3 );

/**
 * Flush cache when switching themes.
 */
function flush_godaddy_cache_on_theme_switch() {
	flush_godaddy_cache();  // Flush entire cache
}
add_action( 'switch_theme', 'flush_godaddy_cache_on_theme_switch' );

/**
 * Add "Flush GoDaddy Cache" button to admin bar.
 */
function add_flush_cache_admin_bar_button( $wp_admin_bar ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	$wp_admin_bar->add_node( array(
		'id'    => 'flush-godaddy-cache',
		'title' => '🔄 Flush Cache',
		'href'  => wp_nonce_url( admin_url( 'admin-post.php?action=flush_godaddy_cache' ), 'flush_godaddy_cache' ),
	) );
}
add_action( 'admin_bar_menu', 'add_flush_cache_admin_bar_button', 999 );

/**
 * Handle manual cache flush request.
 */
function handle_flush_godaddy_cache_request() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}
	
	check_admin_referer( 'flush_godaddy_cache' );
	
	flush_godaddy_cache();
	
	wp_safe_redirect( wp_get_referer() );
	exit;
}
add_action( 'admin_post_flush_godaddy_cache', 'handle_flush_godaddy_cache_request' );

/**
 * Show admin notice when cache is flushed.
 */
function show_cache_flushed_notice() {
	if ( isset( $_GET['cache_flushed'] ) ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p><strong>GoDaddy Cache Flushed:</strong> All cached pages have been cleared.</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'show_cache_flushed_notice' );

/**
 * Add meta box to post editor for manual cache flush.
 */
function add_flush_cache_meta_box() {
	$post_types = get_post_types( array( 'public' => true ) );
	foreach ( $post_types as $post_type ) {
		add_meta_box(
			'flush_cache_meta_box',
			'🔄 Cache Control',
			'render_flush_cache_meta_box',
			$post_type,
			'side',
			'low'
		);
	}
}
add_action( 'add_meta_boxes', 'add_flush_cache_meta_box' );

/**
 * Render the cache flush meta box.
 */
function render_flush_cache_meta_box( $post ) {
	?>
	<p>Cache will be automatically flushed when you publish or update this post.</p>
	<p>
		<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=flush_godaddy_cache' ), 'flush_godaddy_cache' ) ); ?>" 
		   class="button button-secondary">
			Flush All Cache Now
		</a>
	</p>
	<hr>
	<p><small>Automatically flushes:</small></p>
	<ul style="font-size: 11px; margin-left: 15px;">
		<li>✅ This post URL</li>
		<li>✅ Homepage</li>
		<li>✅ Category archives</li>
		<li>✅ Post type archives</li>
	</ul>
	<?php
}

/**
 * Display status in plugin row.
 */
function show_plugin_status( $plugin_meta, $plugin_file ) {
	if ( strpos( $plugin_file, 'auto-flush-godaddy-cache.php' ) !== false ) {
		$has_gd_cache = class_exists( 'GD_Cache' ) || function_exists( 'ban_url' );
		$status = $has_gd_cache 
			? '<span style="color: green;">✅ GoDaddy cache system detected</span>' 
			: '<span style="color: orange;">⚠️ GoDaddy cache system not found (fallback mode)</span>';
		$plugin_meta[] = $status;
	}
	return $plugin_meta;
}
add_filter( 'plugin_row_meta', 'show_plugin_status', 10, 2 );
