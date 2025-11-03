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
    wp_enqueue_script(
        'my-custom-theme-responsive',
        get_template_directory_uri() . '/assets/js/responsive.js',
        array(),
        null,
        true
    );
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

    register_widget('My_Custom_Theme_Instagram_Widget');
}
add_action('widgets_init', 'my_custom_theme_widgets_init');

class My_Custom_Theme_Instagram_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'my_custom_theme_instagram',
            __('Instagram Faves', 'my-custom-theme'),
            array(
                'description' => __('Showcase a curated Instagram call-to-action with custom copy.', 'my-custom-theme'),
            )
        );
    }

    public function widget($args, $instance) {
        $title       = isset($instance['title']) ? $instance['title'] : __('Instagram Faves', 'my-custom-theme');
        $description = isset($instance['description']) ? $instance['description'] : __('Embed your feed or add pretty snapshots here.', 'my-custom-theme');
        $profile_url = isset($instance['profile_url']) ? $instance['profile_url'] : '';
        $button_text = isset($instance['button_text']) ? $instance['button_text'] : __('Follow along', 'my-custom-theme');

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        if (!empty($description)) {
            echo '<p class="instagram-widget__text">' . wp_kses_post($description) . '</p>';
        }

        if (!empty($profile_url)) {
            echo '<a class="instagram-widget__link" href="' . esc_url($profile_url) . '" target="_blank" rel="noopener">';
            echo esc_html($button_text);
            echo '</a>';
        }

        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title']       = sanitize_text_field($new_instance['title'] ?? '');
        $instance['description'] = wp_kses_post($new_instance['description'] ?? '');
        $instance['profile_url'] = esc_url_raw($new_instance['profile_url'] ?? '');
        $instance['button_text'] = sanitize_text_field($new_instance['button_text'] ?? __('Follow along', 'my-custom-theme'));

        return $instance;
    }

    public function form($instance) {
        $defaults = array(
            'title'       => __('Instagram Faves', 'my-custom-theme'),
            'description' => __('Embed your feed or add pretty snapshots here.', 'my-custom-theme'),
            'profile_url' => 'https://www.instagram.com/yourprofile/',
            'button_text' => __('Follow along', 'my-custom-theme'),
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'my-custom-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description:', 'my-custom-theme'); ?></label>
            <textarea class="widefat" rows="4" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_textarea($instance['description']); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('profile_url')); ?>"><?php esc_html_e('Instagram URL:', 'my-custom-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('profile_url')); ?>" name="<?php echo esc_attr($this->get_field_name('profile_url')); ?>" type="url" value="<?php echo esc_attr($instance['profile_url']); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>"><?php esc_html_e('Button text:', 'my-custom-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>" type="text" value="<?php echo esc_attr($instance['button_text']); ?>">
        </p>
        <?php
    }
}

function my_custom_theme_seed_instagram_widget() {
    if (get_option('my_custom_theme_instagram_seeded')) {
        return;
    }

    $sidebars_widgets = get_option('sidebars_widgets', array());
    $sidebar_widgets  = $sidebars_widgets['sidebar-1'] ?? array();

    if (!empty($sidebar_widgets)) {
        update_option('my_custom_theme_instagram_seeded', 1);
        return;
    }

    $widget_instances = get_option('widget_my_custom_theme_instagram', array());
    $next_id          = 1;

    if (!empty($widget_instances)) {
        foreach ($widget_instances as $key => $value) {
            if (is_numeric($key)) {
                $next_id = max($next_id, (int) $key + 1);
            }
        }
    }

    $widget_instances[$next_id] = array(
        'title'       => __('Instagram Faves', 'my-custom-theme'),
        'description' => __('Bring a slice of your feed here with your own embed or curated snapshots.', 'my-custom-theme'),
        'profile_url' => 'https://www.instagram.com/yourprofile/',
        'button_text' => __('Follow along', 'my-custom-theme'),
    );
    $widget_instances['_multiwidget'] = 1;

    $sidebars_widgets['sidebar-1'][] = 'my_custom_theme_instagram-' . $next_id;

    update_option('widget_my_custom_theme_instagram', $widget_instances);
    update_option('sidebars_widgets', $sidebars_widgets);
    update_option('my_custom_theme_instagram_seeded', 1);
}
add_action('after_setup_theme', 'my_custom_theme_seed_instagram_widget');
?>
