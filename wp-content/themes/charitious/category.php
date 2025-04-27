<?php
/**
 * category.php
 *
 * The template for displaying category pages.
 */
?>

<?php get_header(); ?>

    <?php get_template_part('template-parts/header/content', 'blog-header')?>
    <section id="main-container" class="blog main-container" role="main">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php if (have_posts()) : ?>
                        <header class="xs-page-header">
                            <h2>
                                <?php
                                printf(esc_html__('Category Archives for %s', 'charitious'), single_cat_title('', false));
                                ?>
                            </h2>

                            <?php
                            // Show an optional category description.
                            if (category_description()) {
                                echo '<p>' . category_description() . '</p>';
                            }
                            ?>
                        </header>

                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('template-parts/post/content', get_post_format()); ?>
                        <?php endwhile; ?>

                        <?php charitious_paging_nav(); ?>
                    <?php else : ?>
                        <?php get_template_part('template-parts/post/content', 'none'); ?>
                    <?php endif; ?>
                </div><!-- Content Col end -->

                <?php get_sidebar(); ?>
            </div><!-- Main row end -->

        </div><!-- Container end -->
    </section><!-- Main container end -->
<?php get_footer(); ?>