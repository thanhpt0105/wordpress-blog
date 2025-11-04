<?php
/**
 * Template Name: Login Page
 *
 * Displays a branded login experience with social login buttons.
 */

get_header();
?>

<main id="primary" class="site-main login-page">
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="page-content">
        <?php if (is_user_logged_in()) : ?>
            <p><?php esc_html_e('You are already signed in.', 'my-custom-theme'); ?></p>
            <p><a class="button" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Sign out', 'my-custom-theme'); ?></a></p>
        <?php else : ?>
            <?php
            wp_login_form(array(
                'label_username' => __('Email or Username', 'my-custom-theme'),
                'label_password' => __('Password', 'my-custom-theme'),
                'label_log_in'   => __('Sign in', 'my-custom-theme'),
                'remember'       => true,
            ));

            if (shortcode_exists('nextend_social_login')) {
                echo '<div class="social-login-buttons">';
                echo do_shortcode('[nextend_social_login providers="google,facebook" redirect="current" login="Continue with %s" register="Sign up with %s"]');
                echo '</div>';
            }
            ?>
            <p class="lost-password">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Forgot your password?', 'my-custom-theme'); ?></a>
            </p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
