<?php
// Enqueue styles and scripts
function my_custom_theme_enqueue_scripts() {
    wp_enqueue_style(
        'my-custom-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap',
        array(),
        null
    );
    wp_enqueue_style('my-custom-theme-style', get_stylesheet_uri());
    // Add additional styles or scripts here
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_scripts');

// Theme support features
function my_custom_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-custom-theme'),
    ));
}
add_action('after_setup_theme', 'my_custom_theme_setup');

// Custom excerpt length
function my_custom_excerpt_length($length) {
    return 20; // Change this number to set the excerpt length
}
add_filter('excerpt_length', 'my_custom_excerpt_length');

// Register widget area
function my_custom_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'my-custom-theme'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'my_custom_theme_widgets_init');
?>
