<?php
/**
 * Fallback template.
 *
 * @package Custom_Theme_2
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;

while ( have_posts() ) {
	the_post();
	the_content();
}
