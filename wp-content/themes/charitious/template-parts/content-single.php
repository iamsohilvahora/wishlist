<?php
/**
 * content.php
 *
 * The default template for displaying content.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content post-single xs-blog-post-details' ); ?>>

	<?php if ( has_post_thumbnail() && !post_password_required() ) : ?>
		<div class="entry-thumbnail post-media post-image">
            <?php
			echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'full', false, array(
				'alt' => get_the_title()
			));
            ?>
            <?php
            charitious_post_meta_date();
            ?>
		</div>
	<?php endif; ?>
	<div class="post-body clearfix">

		<!-- Article header -->
		<header class="entry-header clearfix">
			<?php charitious_post_meta(); ?>
			<!-- <h1 class="entry-title xs-post-entry-title">
				<?php the_title(); ?>
			</h1> -->
		</header><!-- header end -->

		<!-- Article content -->
		<div class="entry-content">
			<?php
			if ( is_search() ) {
				the_excerpt();
			} else {
				the_content( esc_html__( 'Continue reading &rarr;', 'charitious' ) );

				charitious_link_pages();
			}
			?>
		</div> <!-- end entry-content -->
		<?php //charitious_single_post_footer
		charitious_single_post_footer();
		?>
    </div> <!-- end post-body -->

</article>