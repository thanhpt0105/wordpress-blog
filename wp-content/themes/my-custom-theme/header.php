<?php
/**
 * Theme Header
 *
 * Displays the <head> section, site branding, navigation, and hero banner.
 *
 * @package My_Custom_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="site-header__inner">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            }
            ?>
            <div class="site-branding__text">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
                <?php
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) :
                    ?>
                    <p class="site-description"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <nav class="category-nav" aria-label="<?php esc_attr_e('Blog categories', 'my-custom-theme'); ?>">
            <ul>
                <?php
                $categories = get_categories(array(
                    'hide_empty' => false,
                    'orderby'    => 'name',
                ));

                if (!empty($categories)) :
                    foreach ($categories as $category) :
                        ?>
                        <li>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </li>
                        <?php
                    endforeach;
                else :
                    ?>
                    <li class="category-nav__empty"><?php esc_html_e('Add a category to build your menu', 'my-custom-theme'); ?></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <?php
    $featured_category = null;
    if (!empty($categories)) {
        $featured_category = $categories[0];
    }
    ?>
    <div class="hero">
        <div class="hero__inner">
            <p class="hero__greeting"><?php esc_html_e('Hello lovely!', 'my-custom-theme'); ?></p>
            <h2 class="hero__headline"><?php esc_html_e('Welcome to your happy place on the web', 'my-custom-theme'); ?></h2>
            <p class="hero__text">
                <?php
                if ($description) {
                    echo esc_html($description);
                } else {
                    esc_html_e('Stories, inspiration, and everyday magic curated just for you.', 'my-custom-theme');
                }
                ?>
            </p>
            <?php if ($featured_category) : ?>
                <a class="hero__cta" href="<?php echo esc_url(get_category_link($featured_category->term_id)); ?>">
                    <?php
                    printf(
                        /* translators: %s is the category name. */
                        esc_html__('Explore %s', 'my-custom-theme'),
                        esc_html($featured_category->name)
                    );
                    ?>
                </a>
            <?php else : ?>
                <a class="hero__cta" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php esc_html_e('Start exploring', 'my-custom-theme'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<div id="content" class="site-content">
