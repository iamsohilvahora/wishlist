<?php
/**
 * Template Name: woocommerce with sidebar
 *
 * The template for displaying all pages.
 */
?>

<?php get_header(); ?>
<?php
get_template_part( 'template-parts/header/content', 'page-header' );
?>
<div class="main-content full-iwdth-page"  role="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<!-- Article content -->
						<div class="entry-content">
							<?php the_content(); ?>
						</div> <!-- end entry-content -->

						<!-- Article footer -->
						<footer class="entry-footer">
							<?php
							if ( is_user_logged_in() ) {
								echo '<p>';
								edit_post_link( esc_html__( 'Edit', 'charitious' ), '<span class="meta-edit">', '</span>' );
								echo '</p>';
							}
							?>
						</footer> <!-- end entry-footer -->
					</article>


				<?php endwhile; ?>
            </div> <!-- end main-content -->
        </div>
    </div>
</div> 
<?php get_footer(); ?>