<?php
/**
 * tag.php
 *
 * The template for displaying tag pages.
 */

get_header(); ?>

<div class="blog" role="main">
    <?php get_template_part('template-parts/header/content', 'blog-header')?>
    <div class="main-content blog-wrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <?php if (have_posts()) : ?>
                        <header class="xs-page-header">
                            <h2>
                                <?php
                                printf(esc_html__('Tag Archives for %s', 'charitious'), single_tag_title('', false));
                                ?>
                            </h2>

                            <?php
                            // Show an optional tag description.
                            if (tag_description()) {
                                echo '<p>' . tag_description() . '</p>';
                            }
                            ?>
                        </header>
                        <?php while (have_posts()) : the_post(); 
						get_template_part('template-parts/post/content', get_post_format()); 
						endwhile; 
						charitious_paging_nav();
						else : 
							get_template_part('template-parts/post/content', 'none'); 
						endif; ?>
                </div> <!-- end main-content -->
                <?php get_sidebar(); ?>
            </div>
        </div> 
    </div> 
</div> <!-- end main-content -->
<?php get_footer(); ?>