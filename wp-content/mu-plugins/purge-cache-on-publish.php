<?php
/**
 * Plugin Name: Cache Purge on Publish
 * Description: Flush GoDaddy caching layers whenever content is published.
 */

if (!defined('ABSPATH')) {
	return;
}

add_action('transition_post_status', function ($new_status, $old_status, $post) {
	if ($new_status !== 'publish' || $old_status === 'publish' || wp_is_post_revision($post)) {
		return;
	}

	if (class_exists('\WPaaS\Cache')) {
		\WPaaS\Cache::purge_all();
	} else {
		do_action('gd_system_purge_cache');
	}

	if (function_exists('wp_cache_flush')) {
		wp_cache_flush();
	}

	if (function_exists('wp_remote_get')) {
		wp_remote_get(add_query_arg('cachebust', time(), home_url('/')));
	}
}, 10, 3);
