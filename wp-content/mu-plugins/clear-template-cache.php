<?php
/**
 * Plugin Name: Clear Template Cache on Activation
 * Description: Clears WordPress block template cache when this file changes
 * Version: 1.0.0
 */

// Clear the block template cache
function acme_clear_block_template_cache() {
	// Clear transients related to block templates
	global $wpdb;
	
	// Delete all transients related to templates
	$wpdb->query(
		"DELETE FROM {$wpdb->options} 
		WHERE option_name LIKE '_transient_wp_theme_files_%' 
		OR option_name LIKE '_transient_timeout_wp_theme_files_%'
		OR option_name LIKE '_transient_get_block_templates_%'
		OR option_name LIKE '_transient_timeout_get_block_templates_%'"
	);
	
	// Clear the theme file cache
	if ( function_exists( 'wp_cache_flush' ) ) {
		wp_cache_flush();
	}
	
	// Clear the rewrite rules cache
	flush_rewrite_rules();
}

// Run on admin init to clear cache when admin visits
add_action( 'admin_init', 'acme_clear_block_template_cache', 1 );

// Also provide a way to clear cache via query parameter for deployments
add_action( 'init', function() {
	if ( isset( $_GET['clear_template_cache'] ) && current_user_can( 'manage_options' ) ) {
		acme_clear_block_template_cache();
		wp_die( 'Template cache cleared! <a href="' . home_url() . '">View Site</a>' );
	}
} );
