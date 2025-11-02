<?php
/**
 * Plugin Name: My Custom Plugin
 * Description: A custom plugin to add additional functionality to the WordPress blog.
 * Version: 1.0
 * Author: Your Name
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Function to register a custom post type
function my_custom_plugin_register_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Custom Posts',
        'supports' => array('title', 'editor', 'thumbnail'),
    );
    register_post_type('custom_post', $args);
}
add_action('init', 'my_custom_plugin_register_post_type');

// Function to create a shortcode
function my_custom_plugin_shortcode() {
    return '<div class="my-custom-shortcode">Hello, this is my custom shortcode!</div>';
}
add_shortcode('my_shortcode', 'my_custom_plugin_shortcode');

// Function to enqueue scripts and styles
function my_custom_plugin_enqueue_scripts() {
    wp_enqueue_style('my-custom-plugin-style', plugins_url('style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'my_custom_plugin_enqueue_scripts');
?>