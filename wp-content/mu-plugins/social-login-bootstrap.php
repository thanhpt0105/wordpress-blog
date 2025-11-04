<?php
/**
 * Plugin Name: Social Login Bootstrap
 * Description: Boots Nextend Social Login with environment-based Google and Facebook credentials.
 */

if (!defined('ABSPATH')) {
    return;
}

$nsl_main = WP_PLUGIN_DIR . '/nextend-facebook-connect/nextend-facebook-connect.php';

if (!file_exists($nsl_main)) {
    return;
}

require_once $nsl_main;

/**
 * Retrieve the first non-empty value from the supplied constant/env candidates.
 *
 * @param array $candidates
 * @return string
 */
function social_login_get_config_value(array $candidates) {
    foreach ($candidates as $candidate) {
        if (defined($candidate)) {
            $value = constant($candidate);
            if (is_string($value)) {
                $value = trim($value);
            }
            if (!empty($value)) {
                return (string) $value;
            }
        }
    }

    foreach ($candidates as $candidate) {
        $value = getenv($candidate);
        if ($value === false && isset($_ENV[$candidate])) {
            $value = $_ENV[$candidate];
        }
        if ($value !== false && $value !== null) {
            $value = is_string($value) ? trim($value) : $value;
            if ($value !== '') {
                return (string) $value;
            }
        }
    }

    return '';
}

/**
 * Ensure Facebook credentials are available through the constants the plugin expects.
 */
add_action('plugins_loaded', function () {
    $facebookAppId = social_login_get_config_value(array(
        'NEXTEND_FB_APP_ID',
        'SOCIAL_LOGIN_FACEBOOK_APP_ID',
        'FACEBOOK_APP_ID',
    ));

    if ($facebookAppId && !defined('NEXTEND_FB_APP_ID')) {
        define('NEXTEND_FB_APP_ID', $facebookAppId);
    }

    $facebookAppSecret = social_login_get_config_value(array(
        'NEXTEND_FB_APP_SECRET',
        'SOCIAL_LOGIN_FACEBOOK_APP_SECRET',
        'FACEBOOK_APP_SECRET',
    ));

    if ($facebookAppSecret && !defined('NEXTEND_FB_APP_SECRET')) {
        define('NEXTEND_FB_APP_SECRET', $facebookAppSecret);
    }
});

/**
 * Filter the global Nextend Social Login settings to enable providers based on configuration.
 *
 * @param array $settings
 * @return array
 */
function social_login_finalize_global_settings(array $settings) {
    $enabledProviders = isset($settings['enabled']) && is_array($settings['enabled']) ? $settings['enabled'] : array();

    $googleConfigured = social_login_has_google_credentials();
    $facebookConfigured = social_login_has_facebook_credentials();

    if ($googleConfigured) {
        $enabledProviders[] = 'google';
    } else {
        $enabledProviders = array_diff($enabledProviders, array('google'));
    }

    if ($facebookConfigured) {
        $enabledProviders[] = 'facebook';
    } else {
        $enabledProviders = array_diff($enabledProviders, array('facebook'));
    }

    $settings['enabled'] = array_values(array_unique($enabledProviders));
    $settings['show_login_form'] = 'show';
    $settings['login_form_layout'] = $settings['login_form_layout'] ?? 'below';
    $settings['login_form_button_style'] = $settings['login_form_button_style'] ?? 'default';

    return $settings;
}
add_filter('nsl_finalize_settings_nextend_social_login', 'social_login_finalize_global_settings');

/**
 * Apply Google credentials pulled from environment/constant configuration.
 *
 * @param array $settings
 * @return array
 */
function social_login_finalize_google_settings(array $settings) {
    $clientId = social_login_get_config_value(array(
        'SOCIAL_LOGIN_GOOGLE_CLIENT_ID',
        'GOOGLE_OAUTH_CLIENT_ID',
        'GOOGLE_CLIENT_ID',
    ));

    $clientSecret = social_login_get_config_value(array(
        'SOCIAL_LOGIN_GOOGLE_CLIENT_SECRET',
        'GOOGLE_OAUTH_CLIENT_SECRET',
        'GOOGLE_CLIENT_SECRET',
    ));

    if ($clientId) {
        $settings['client_id'] = $clientId;
    }
    if ($clientSecret) {
        $settings['client_secret'] = $clientSecret;
    }

    if ($clientId && $clientSecret) {
        $settings['tested'] = '1';
        $settings['settings_saved'] = '1';
    } else {
        $settings['tested'] = '0';
    }

    return $settings;
}
add_filter('nsl_finalize_settings_nsl_google', 'social_login_finalize_google_settings');

/**
 * Apply Facebook credentials pulled from environment/constant configuration.
 *
 * @param array $settings
 * @return array
 */
function social_login_finalize_facebook_settings(array $settings) {
    $appId = social_login_get_config_value(array(
        'NEXTEND_FB_APP_ID',
        'SOCIAL_LOGIN_FACEBOOK_APP_ID',
        'FACEBOOK_APP_ID',
    ));

    $appSecret = social_login_get_config_value(array(
        'NEXTEND_FB_APP_SECRET',
        'SOCIAL_LOGIN_FACEBOOK_APP_SECRET',
        'FACEBOOK_APP_SECRET',
    ));

    if ($appId) {
        $settings['appid'] = $appId;
    }
    if ($appSecret) {
        $settings['secret'] = $appSecret;
    }

    if ($appId && $appSecret) {
        $settings['tested'] = '1';
        $settings['settings_saved'] = '1';
    } else {
        $settings['tested'] = '0';
    }

    return $settings;
}
add_filter('nsl_finalize_settings_nsl_facebook', 'social_login_finalize_facebook_settings');

/**
 * Determine whether Google credentials are configured.
 *
 * @return bool
 */
function social_login_has_google_credentials() {
    return (bool) (social_login_get_config_value(array(
        'SOCIAL_LOGIN_GOOGLE_CLIENT_ID',
        'GOOGLE_OAUTH_CLIENT_ID',
        'GOOGLE_CLIENT_ID',
    )) && social_login_get_config_value(array(
        'SOCIAL_LOGIN_GOOGLE_CLIENT_SECRET',
        'GOOGLE_OAUTH_CLIENT_SECRET',
        'GOOGLE_CLIENT_SECRET',
    )));
}

/**
 * Determine whether Facebook credentials are configured.
 *
 * @return bool
 */
function social_login_has_facebook_credentials() {
    return (bool) (social_login_get_config_value(array(
        'NEXTEND_FB_APP_ID',
        'SOCIAL_LOGIN_FACEBOOK_APP_ID',
        'FACEBOOK_APP_ID',
    )) && social_login_get_config_value(array(
        'NEXTEND_FB_APP_SECRET',
        'SOCIAL_LOGIN_FACEBOOK_APP_SECRET',
        'FACEBOOK_APP_SECRET',
    )));
}
