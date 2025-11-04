<?php
/**
 * Plugin Name: Cache Purge on Publish
 * Description: Flush GoDaddy caching layers whenever content is published.
 */

if (!defined('ABSPATH')) {
	return;
}

function acme_prime_cache_urls(array $urls) {
	foreach ($urls as $url) {
		if (!$url) {
			continue;
		}

		wp_remote_get(add_query_arg('_cache_prime', time(), $url), array(
			'timeout'  => 3,
			'blocking' => false,
		));
	}
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
		$urls = array(
			home_url('/'),
			get_permalink($post),
		);

		$terms = get_the_terms($post, 'category');
		if (!is_wp_error($terms) && $terms) {
			foreach ($terms as $term) {
				$term_link = get_term_link($term);
				if (!is_wp_error($term_link)) {
					$urls[] = $term_link;
				}
			}
		}

		acme_prime_cache_urls(array_unique(array_filter($urls)));
	}
}, 10, 3);
