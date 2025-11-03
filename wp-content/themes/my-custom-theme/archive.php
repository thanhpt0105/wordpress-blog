<?php
/**
 * Archive Template
 *
 * Handles category, tag, author, and date archives using the post card layout.
 *
 * @package My_Custom_Theme
 */

get_header();
?>

<div class="content-layout">
    <main id="primary" class="site-main">
        <header class="archive-header">
            <h1 class="archive-title"><?php the_archive_title(); ?></h1>
            <?php
            $archive_description = get_the_archive_description();
            if ($archive_description) :
                ?>
                <div class="archive-description"><?php echo wp_kses_post($archive_description); ?></div>
            <?php endif; ?>
        </header>

        <?php if (have_posts()) : ?>
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
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
                        <h2 class="post-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
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
                <?php esc_html_e('This space is waiting for your next story.', 'my-custom-theme'); ?>
            </p>
        <?php endif; ?>
    </main>

    <aside class="site-sidebar">
        <?php if (is_active_sidebar('sidebar-1')) : ?>
            <?php dynamic_sidebar('sidebar-1'); ?>
        <?php else : ?>
            <section class="widget about-widget">
                <h2 class="widget-title"><?php esc_html_e('About the author', 'my-custom-theme'); ?></h2>
                <p><?php esc_html_e('Share a little about yourself here to greet new readers.', 'my-custom-theme'); ?></p>
            </section>
        <?php endif; ?>
    </aside>
</div>

<?php
get_footer();
