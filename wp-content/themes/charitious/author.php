<?php
/**
 * author.php
 *
 * The template for displaying author archive pages.
 */
?>

<?php get_header(); ?>

<div class="blog" role="main">
    <?php get_template_part('template-parts/header/content', 'blog-header')?>
    <section id="main-container" class="blog main-container" role="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <?php if (have_posts()) : the_post(); ?>
                        <header class="xs-page-header">
                            <h2>
                                <?php printf(esc_html__('All posts by %s.', 'charitious'), get_the_author()); ?>
                            </h2>

                            <?php
                            // If the author bio exists, display it.
                            if (get_the_author_meta('description')) {
                                echo '<p>' . the_author_meta('description') . '</p>';
                            }
                            ?>

                            <?php rewind_posts(); ?>
                        </header>

                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('template-parts/post/content', get_post_format()); ?>
                        <?php endwhile; ?>

                        <?php charitious_paging_nav(); ?>
                    <?php else : ?>
                        <?php get_template_part('template-parts/post/content', 'none'); ?>
                    <?php endif; ?>
                </div> <!-- end main-content -->

                <?php get_sidebar(); ?>
            </div>
        </div> 
    </div> 
</div> <!-- end main-content -->
<?php get_footer(); ?>