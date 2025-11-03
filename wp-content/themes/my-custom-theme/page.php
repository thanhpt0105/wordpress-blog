<?php
/**
 * Page Template
 *
 * Renders static pages with the dreamy styling.
 *
 * @package My_Custom_Theme
 */

get_header();
?>

<div class="content-layout content-layout--single">
    <main id="primary" class="site-main">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'my-custom-theme'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>

                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile;
        endif;
        ?>
    </main>
</div>

<?php
get_footer();
