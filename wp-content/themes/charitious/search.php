<?php
/**
 * search.php
 *
 * The template for displaying search results.
 */
get_header();
?>

	<?php get_template_part( 'template-parts/header/content', 'search-header' ) ?>
    <section id="main-container" class="blog main-container" role="main">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/post/content', get_post_format() );
						endwhile;
						charitious_paging_nav();
					else :
						get_template_part( 'template-parts/post/content', 'none' );
					endif;
					?>
                </div><!-- Content Col end -->

                <?php get_sidebar(); ?>
            </div><!-- Main row end -->

        </div><!-- Container end -->
    </section><!-- Main container end -->
<?php get_footer(); ?>