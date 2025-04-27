<?php
/**
 * single.php
 *
 * The template for displaying single posts.
 */


get_header(); 

get_template_part( 'template-parts/header/content', 'page-header' ) ?>

<div class="main-content"  role="main">
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>

    </div> <!-- end main-content -->
</div>
<?php get_footer(); ?>