<?php
/**
 * User avatar helpers.
 *
 * @package Custom_Theme_3
 */

if (!defined('ABSPATH')) {
	exit;
}

function acme_get_user_avatar_url($user_id) {
	$upload_id = get_user_meta($user_id, 'acme_user_avatar_id', true);
	if ($upload_id) {
		$image = wp_get_attachment_image_url($upload_id, 'thumbnail');
		if ($image) {
			return $image;
		}
	}

	if (function_exists('nextend_social_login')) {
		$provider_avatar = get_user_meta($user_id, 'nsl_user_avatar', true);
		if (!empty($provider_avatar)) {
			if (is_array($provider_avatar) && !empty($provider_avatar['original'])) {
				return esc_url_raw($provider_avatar['original']);
			}

			if (is_string($provider_avatar)) {
				return esc_url_raw($provider_avatar);
			}
		}
	}

	$google_photo = get_user_meta($user_id, 'google_user_avatar', true);
	if (!empty($google_photo)) {
		return esc_url_raw($google_photo);
	}

	if (defined('CUSTOM_USER_DEFAULT_AVATAR_URL')) {
		return esc_url_raw(CUSTOM_USER_DEFAULT_AVATAR_URL);
	}

	return '';
}

function acme_get_avatar($avatar, $id_or_email, $size, $default, $alt, $args) {
	$user = false;

	if (is_numeric($id_or_email)) {
		$user = get_user_by('id', (int) $id_or_email);
	} elseif (is_object($id_or_email) && !empty($id_or_email->user_id)) {
		$user = get_user_by('id', (int) $id_or_email->user_id);
	} elseif (is_string($id_or_email)) {
		$user = get_user_by('email', $id_or_email);
	}

	if (!$user) {
		return $avatar;
	}

	$override = acme_get_user_avatar_url($user->ID);
	if (!$override) {
		return $avatar;
	}

	$size    = !empty($args['height']) ? (int) $args['height'] : (int) $size;
	$classes = array('acme-avatar');

	if (!empty($args['class'])) {
		$classes = array_merge($classes, explode(' ', $args['class']));
	}

	$classes = array_map('sanitize_html_class', $classes);
	$classes = implode(' ', array_filter($classes));

	$alt = esc_attr($alt ?: get_the_author_meta('display_name', $user->ID));

	return sprintf(
		'<img src="%1$s" alt="%2$s" class="%3$s" width="%4$d" height="%4$d" loading="lazy" decoding="async" />',
		esc_url($override),
		$alt,
		esc_attr($classes),
		(int) $size
	);
}
add_filter('get_avatar', 'acme_get_avatar', 10, 6);

function acme_avatar_profile_fields($user) {
	$avatar_id = get_user_meta($user->ID, 'acme_user_avatar_id', true);
	$avatar_url = '';

	if ($avatar_id) {
		$avatar_url = wp_get_attachment_image_url((int) $avatar_id, 'thumbnail');
	} elseif (function_exists('nextend_social_login')) {
		$provider = get_user_meta($user->ID, 'nsl_user_avatar', true);
		if (is_array($provider) && !empty($provider['original'])) {
			$avatar_url = esc_url($provider['original']);
		} elseif (is_string($provider)) {
			$avatar_url = esc_url($provider);
		}
	}
	?>
	<h2><?php esc_html_e('Profile Picture', 'acme'); ?></h2>
	<table class="form-table" role="presentation">
		<tr>
			<th><label for="acme-user-avatar"><?php esc_html_e('Avatar', 'acme'); ?></label></th>
			<td>
				<div id="acme-user-avatar-preview" style="margin-bottom:10px;">
					<?php if ($avatar_url) : ?>
						<img src="<?php echo esc_url($avatar_url); ?>" alt="<?php esc_attr_e('Current avatar', 'acme'); ?>" width="96" height="96" style="border-radius:50%;" />
					<?php else : ?>
						<span><?php esc_html_e('No avatar selected yet.', 'acme'); ?></span>
					<?php endif; ?>
				</div>
				<input type="hidden" name="acme_user_avatar_id" id="acme-user-avatar-id" value="<?php echo esc_attr($avatar_id); ?>" />
				<button type="button" class="button" id="acme-upload-avatar"><?php esc_html_e('Choose avatar', 'acme'); ?></button>
				<button type="button" class="button button-secondary" id="acme-remove-avatar" <?php disabled(!$avatar_id); ?>><?php esc_html_e('Remove', 'acme'); ?></button>
				<p class="description"><?php esc_html_e('Upload a square image. PNG or JPG recommended.', 'acme'); ?></p>
			</td>
		</tr>
	</table>
	<?php
}
add_action('show_user_profile', 'acme_avatar_profile_fields');
add_action('edit_user_profile', 'acme_avatar_profile_fields');

function acme_avatar_save_profile_fields($user_id) {
	if (!current_user_can('upload_files')) {
		return;
	}

	if (isset($_POST['acme_user_avatar_id'])) {
		$attachment_id = (int) $_POST['acme_user_avatar_id'];

		if ($attachment_id > 0) {
			update_user_meta($user_id, 'acme_user_avatar_id', $attachment_id);
		} else {
			delete_user_meta($user_id, 'acme_user_avatar_id');
		}
	}
}
add_action('personal_options_update', 'acme_avatar_save_profile_fields');
add_action('edit_user_profile_update', 'acme_avatar_save_profile_fields');

function acme_avatar_admin_assets($hook) {
	if (!in_array($hook, array('profile.php', 'user-edit.php'), true)) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script(
		'acme-avatar',
		get_theme_file_uri('assets/js/avatar.js'),
		array('jquery'),
		filemtime(get_theme_file_path('assets/js/avatar.js')),
		true
	);
}
add_action('admin_enqueue_scripts', 'acme_avatar_admin_assets');
