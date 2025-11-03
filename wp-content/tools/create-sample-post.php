<?php
/**
 * Helper script to seed a sample blog post with a featured image.
 *
 * Usage inside container:
 *   php /var/www/html/wp-content/tools/create-sample-post.php
 */

require dirname(__DIR__) . '/../wp-load.php';

if (!function_exists('wp_insert_post')) {
    fwrite(STDERR, "WordPress not bootstrapped.\n");
    exit(1);
}

require_once ABSPATH . 'wp-admin/includes/taxonomy.php';

$title = 'Dreamy Escape to Lavender Fields';
$slug  = sanitize_title($title);

$existing = get_page_by_path($slug, OBJECT, 'post');
if ($existing) {
    fwrite(STDOUT, "Sample post already exists (ID {$existing->ID}).\n");
    exit(0);
}

$category_name = 'Lavender Dreams';
$category_slug = sanitize_title($category_name);
$category      = get_category_by_slug($category_slug);

if (!$category) {
    $category_id = wp_insert_category(array(
        'cat_name'             => $category_name,
        'category_nicename'    => $category_slug,
        'category_description' => 'Soft, serene travel stories bathed in pastel sunsets.',
    ));
} else {
    $category_id = $category->term_id;
}

$content = <<<HTML
<p>Close your eyes and imagine the gentle rustle of lavender swaying in the Provençal breeze. This dreamy escape is my favorite ritual for finding calm in the middle of a busy week.</p>
<p>From the pastel sunrise over the fields to the cozy wicker picnic under the cypress trees, every moment feels like stepping into a watercolor. If you go, don’t forget a silk scarf, your favorite journal, and enough time to simply breathe.</p>
<p>Here are a few highlights from the trip:</p>
<ul>
    <li>Sipping honeyed lavender tea at a farmhouse veranda.</li>
    <li>Sketching the sunset shades that melted into mauve clouds.</li>
    <li>Dancing barefoot between the rows while the air smelled of rain and bloom.</li>
</ul>
<p>Would you wander here with me next summer?</p>
HTML;

$post_id = wp_insert_post(array(
    'post_title'   => $title,
    'post_name'    => $slug,
    'post_content' => $content,
    'post_status'  => 'publish',
    'post_author'  => 1,
    'post_category'=> array($category_id),
));

if (is_wp_error($post_id)) {
    fwrite(STDERR, "Post creation failed: " . $post_id->get_error_message() . "\n");
    exit(1);
}

$image_path = dirname(__DIR__) . '/uploads/dreamy-escape.jpg';

if (!file_exists($image_path)) {
    fwrite(STDERR, "Image not found at {$image_path}. Post created without thumbnail.\n");
    exit(0);
}

require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$image_data = file_get_contents($image_path);
$upload     = wp_upload_bits(basename($image_path), null, $image_data);

if ($upload['error']) {
    fwrite(STDERR, "Image upload failed: {$upload['error']}\n");
    exit(1);
}

$attachment_id = wp_insert_attachment(array(
    'post_mime_type' => 'image/jpeg',
    'post_title'     => 'Dreamy Escape Cover',
    'post_content'   => '',
    'post_status'    => 'inherit',
    'guid'           => $upload['url'],
), $upload['file'], $post_id);

if (is_wp_error($attachment_id)) {
    fwrite(STDERR, "Attachment creation failed: " . $attachment_id->get_error_message() . "\n");
    exit(1);
}

$metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
wp_update_attachment_metadata($attachment_id, $metadata);
set_post_thumbnail($post_id, $attachment_id);

fwrite(STDOUT, "Sample post created (ID {$post_id}) with thumbnail {$attachment_id}.\n");
