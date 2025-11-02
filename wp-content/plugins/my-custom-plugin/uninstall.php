<?php
// This file is executed when the plugin is uninstalled.
// Perform cleanup tasks such as removing custom database tables or options.

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Example: Delete custom options
delete_option('my_custom_plugin_option');

// Example: Drop custom database tables
global $wpdb;
$table_name = $wpdb->prefix . 'my_custom_table';
$wpdb->query("DROP TABLE IF EXISTS $table_name");
?>