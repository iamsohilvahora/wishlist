<?php
/**
 * single.php
 *
 * The template for displaying single posts.
 */

get_header();

get_template_part( 'template-parts/header/content', 'blog-header' );
$show_related = charitious_option('show_related');
$sidebar = charitious_option('blog_single_sidebar');
$related_title = charitious_option('related_title');
$column = ($sidebar == 1 || !is_active_sidebar('sidebar-1')) ? 'col-md-12' : 'col-md-8 col-sm-12';
?>


<div id="main-container" class="main-container blog" role="main">
    <div class="sections">
        <div class="container">
			<div class="row">
				<?php if($sidebar == 2){
					get_sidebar();
				} ?>
				<div class="<?php echo esc_attr($column); ?>">
					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', 'single' );

						charitious_post_nav();
                        $categories = get_the_category();
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile;
					?>
				</div>

				<?php if($sidebar == 3){
					get_sidebar();
				} ?>
			</div>
        </div>
    </div>
</div>
<?php if(class_exists('Xs_Main') && $show_related): ?>
    <section class="xs-section-padding bg-gray related">
        <div class="container">
            <div class="xs-heading row xs-mb-60">
                <div class="col-md-9 col-xl-9">
                    <h2 class="xs-title"><?php echo esc_html($related_title);?></h2>
                </div>
            </div>
            <?php
            $Xs_Main = Xs_Main::xs_get_instance();
            $Xs_Main->get_related_post($categories[0]->term_id, 3,4);
            ?>
        </div>
    </section>
<?php endif; ?>
<?php get_footer(); ?>