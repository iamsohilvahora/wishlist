<?php
/**
 * content.php
 *
 * The default template for displaying content.
 */
?>


<div class="post">
	<!-- post image start -->
	<?php if ( has_post_thumbnail() && !post_password_required() ) : ?>
		<div class="entry-thumbnail post-media post-image">
            <?php
			echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'full', false, array(
				'alt' => get_the_title()
			));
            ?>
		</div>
	<?php endif; ?>

	<div class="post-body clearfix">
		<div class="post-content-right">
			<div class="entry-header">
				<?php charitious_post_meta(); ?>

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

				<div class="entry-content">
					<?php charitious_content_read_more( '35' ); ?>
				</div>
                <div class="post-footer">
                    <a href="<?php echo get_the_permalink() ?>" class="xs-cp-btn btn btn-primary"><?php echo esc_html__( 'Continue Reading', 'charitious' ); ?></a>
                </div>
			</div><!-- header end -->
		</div><!-- Post content right -->
	</div><!-- post-body end -->

</div><!-- post end -->