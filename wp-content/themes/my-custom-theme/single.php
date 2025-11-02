<?php
get_header(); ?>

<main id="main" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                        <span class="byline"> by <?php the_author(); ?></span>
                    </div>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php
                    // Display tags and categories
                    the_tags('<span class="tags-links">Tags: ', ', ', '</span>');
                    ?>
                </footer>
            </article>

            <?php
            // Comments template
            if (comments_open() || get_comments_number()) {
                comments_template();
            }

            // Related posts (optional)
            $related_posts = get_posts(array(
                'category__in' => wp_get_post_categories(get_the_ID()),
                'post__not_in' => array(get_the_ID()),
                'posts_per_page' => 3,
            ));

            if ($related_posts) : ?>
                <aside class="related-posts">
                    <h2>Related Posts</h2>
                    <ul>
                        <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </aside>
                <?php wp_reset_postdata();
            endif;

        endwhile;
    else :
        get_template_part('template-parts/content', 'none');
    endif; ?>
</main>

<?php
get_footer(); ?>