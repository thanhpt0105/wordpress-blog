<?php
/**
 * Main template file
 *
 * @package My_Custom_Theme
 */

get_header();

$highlight_categories = get_categories(array(
    'hide_empty' => false,
    'number'     => 3,
    'orderby'    => 'count',
    'order'      => 'DESC',
));
?>

<div class="content-layout">
    <main id="primary" class="site-main">
        <?php if (!empty($highlight_categories)) : ?>
            <section class="category-highlights">
                <h2><?php esc_html_e('Choose Your Vibe', 'my-custom-theme'); ?></h2>
                <div class="category-grid">
                    <?php foreach ($highlight_categories as $category) : ?>
                        <article class="category-card">
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <h3><?php echo esc_html($category->name); ?></h3>
                                <p>
                                    <?php
                                    if ($category->description) {
                                        echo esc_html(wp_trim_words($category->description, 16));
                                    } else {
                                        printf(
                                            /* translators: %s is the category name. */
                                            esc_html__('Discover the latest in %s.', 'my-custom-theme'),
                                            esc_html(strtolower($category->name))
                                        );
                                    }
                                    ?>
                                </p>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="recent-posts">
            <h2><?php esc_html_e('Fresh Stories', 'my-custom-theme'); ?></h2>

            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    $has_thumbnail = has_post_thumbnail();
                    $card_classes = $has_thumbnail
                        ? array('post-card', 'post-card--with-thumb')
                        : array('post-card', 'post-card--no-thumb');
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class($card_classes); ?>>
                        <?php if ($has_thumbnail) : ?>
                            <a class="post-card__thumb" href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large'); ?>
                            </a>
                        <?php endif; ?>
                        <div class="post-card__content">
                            <div class="post-card__meta">
                                <span class="post-card__date"><?php echo esc_html(get_the_date()); ?></span>
                                <?php
                                $category_list = get_the_category_list(', ');
                                if ($category_list) :
                                    ?>
                                    <span class="post-card__categories"><?php echo wp_kses_post($category_list); ?></span>
                                <?php endif; ?>
                            </div>
                            <h3 class="post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="post-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                            <a class="post-card__read-more" href="<?php the_permalink(); ?>">
                                <?php esc_html_e('Keep reading', 'my-custom-theme'); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>

                <div class="pagination">
                    <?php the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('&laquo; Newer', 'my-custom-theme'),
                        'next_text' => __('Older &raquo;', 'my-custom-theme'),
                    )); ?>
                </div>

            <?php else : ?>
                <p class="no-posts">
                    <?php esc_html_e('No posts yet, but your story is just getting started.', 'my-custom-theme'); ?>
                </p>
            <?php endif; ?>
        </section>
    </main>

    <aside class="site-sidebar" data-collapsible="sidebar">
        <button
            class="pill-toggle sidebar-toggle"
            type="button"
            aria-expanded="false"
            aria-controls="sidebar-widgets"
            data-label-closed="<?php esc_attr_e('Show sidebar goodies', 'my-custom-theme'); ?>"
            data-label-open="<?php esc_attr_e('Hide sidebar goodies', 'my-custom-theme'); ?>"
        >
            <span class="pill-toggle__icon" aria-hidden="true"></span>
            <span class="pill-toggle__label sidebar-toggle__label"><?php esc_html_e('Show sidebar goodies', 'my-custom-theme'); ?></span>
        </button>
        <div id="sidebar-widgets" class="sidebar-widgets" hidden>
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <?php dynamic_sidebar('sidebar-1'); ?>
            <?php else : ?>
                <section class="widget about-widget">
                    <h2 class="widget-title"><?php esc_html_e('Hi, I\'m [Your Name]!', 'my-custom-theme'); ?></h2>
                    <p><?php esc_html_e('Sharing dreamy adventures, style musings, and little joys from everyday life.', 'my-custom-theme'); ?></p>
                </section>
                <section class="widget instagram-widget">
                    <h2 class="widget-title"><?php esc_html_e('Instagram Faves', 'my-custom-theme'); ?></h2>
                    <p><?php esc_html_e('Embed your feed or add pretty snapshots here.', 'my-custom-theme'); ?></p>
                </section>
                <section class="widget newsletter-widget">
                    <h2 class="widget-title"><?php esc_html_e('Stay in the Loop', 'my-custom-theme'); ?></h2>
                    <p><?php esc_html_e('Invite readers to join your newsletter for weekly inspiration.', 'my-custom-theme'); ?></p>
                </section>
            <?php endif; ?>
        </div>
    </aside>
</div>

<?php
get_footer();
