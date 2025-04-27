<?php
/**
 * index.php
 *
 * The main template file.
 */
get_header();

get_template_part( 'template-parts/header/content', 'blog-header' );


$sidebar = charitious_option('blog_sidebar', 3);

$col = 'col-md-8';

if($sidebar == 1 ){
    $col =  'col-md-12' ;
}

$left_sidebar = 'row';
if($sidebar == 2){
    $left_sidebar =  'row flex-row-reverse';
}

?>
<section id="main-container" class="blog main-container" role="main">
	<div class="container">
		<div class="<?php echo esc_attr($left_sidebar); ?>">

			<div class="<?php echo esc_attr($col); ?>">
				<!-- 1st post start -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
					<?php endwhile; ?>
					<?php charitious_paging_nav(); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/post/content', 'none' ); ?>
				<?php endif; ?>

			</div><!-- Content Col end -->

			<?php
                if($sidebar != 1 ){
                get_sidebar(); }
            ?>
		</div><!-- Main row end -->

	</div><!-- Container end -->
</section><!-- Main container end -->

<?php get_footer(); ?>

