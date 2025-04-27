<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package xs
 */
/**
 * ----------------------------------------------------------------------------------------
 * 6.0 - Display navigation to the next/previous set of posts.
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists( 'charitious_post_nav' ) ) :

	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function charitious_post_nav() {
// Don't print empty markup if there's nowhere to navigate.

		$next_post	 = get_next_post();
		$pre_post	 = get_previous_post();
		if ( !$next_post && !$pre_post ) {
			return;
		}

		echo '<nav class="post-navigation clearfix mrtb-40">';


		echo '<div class="post-previous">';
		if ( !empty( $pre_post ) ):
			?>
			<a href="<?php echo get_the_permalink( $pre_post->ID ); ?>">
				<h3><?php echo get_the_title( $pre_post->ID ) ?></h3>
				<span><i class="fa fa-long-arrow-left"></i><?php esc_html_e( 'Previous Post', 'charitious' ) ?></span>
			</a>

			<?php
		endif;
		echo '</div>';
		echo '<div class="post-next">';

		if ( !empty( $next_post ) ):
			?>
			<a href="<?php echo get_the_permalink( $next_post->ID ); ?>">
				<h3><?php echo get_the_title( $next_post->ID ) ?></h3>

				<span><?php esc_html_e( 'Next Post', 'charitious' ) ?> <i class="fa fa-long-arrow-right"></i></span>
			</a>

			<?php
		endif;
		echo '</nav>';
		echo '</nav>';
	}

endif;


/**
 * ----------------------------------------------------------------------------------------
 *  - Display meta information for a specific post.
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists( 'charitious_post_meta' ) ) {

	function charitious_post_meta() {


		echo '<div class="post-meta">';
		if ( get_post_type() === 'post' ) {
			// If the post is sticky, mark it.
			if ( is_sticky() ) {
				echo '<span class="meta-featured-post sticky"> <i class="fa fa-thumb-tack"></i> ' . esc_html__( 'Sticky', 'charitious' ) . ' </span>';
			}
			
			// Get the post author.

			printf(
			'<span class="meta-author post-author">%1$s<a href="%2$s" rel="author">' . esc_html__( 'By ', 'charitious' ) . '%3$s</a></span>', '<i class="icon icon icon-user2"></i>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author()
			);
			echo '<span class="post-comment"><i class="icon icon-calendar"></i>';
			echo get_the_date();
			echo '</span>';
			// Comments link.
			if ( comments_open() ) :
				echo '<span class="post-comment"><i class="icon icon-comment"></i>';
				comments_popup_link( esc_html__( '0', 'charitious' ), esc_html__( '0', 'charitious' ), esc_html__( '%', 'charitious' ) );
				echo '</span>';
			endif;
			// The categories.

			$category_list = get_the_category_list( ', ' );
			if ( $category_list ) {
				echo '<span class="meta-categories post-cat"><i class="icon icon-folder"></i>' . $category_list . '</span>';
			}

			if ( is_single() ) {
				// Edit link.
				if ( is_user_logged_in() ) {
					edit_post_link( esc_html__( 'Edit', 'charitious' ), '<span class="meta-edit">', '</span>' );
				}
			}
		}
		echo '</div>';
	}

	if ( !function_exists( 'charitious_post_meta_left' ) ) {

		function charitious_post_meta_left() {

			echo '<div class="post-meta-left pull-left text-center"><div class="entry-meta">';
			if ( get_post_type() === 'post' ) {


			// Edit link.
				if ( is_user_logged_in() ) {
					echo '<div>';
					edit_post_link( esc_html__( 'Edit', 'charitious' ), '<span class="meta-edit">', '</span>' );
					echo '</div>';
				}
			}
			echo '</div></div>';
		}

	}
}


if ( !function_exists( 'charitious_post_meta_date' ) ) {

	function charitious_post_meta_date() {
		if ( get_post_type() === 'post' ) {

			echo '<span class="post-meta-date meta-date"><span class="day">' . get_the_date( 'm' ) . '</span>' . get_the_date( 'M' ) . '</span>';
		}
	}

}

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package xs
 */
/**
 * ----------------------------------------------------------------------------------------
 * 6.0 - Display navigation to the next/previous set of posts.
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists( 'charitious_paging_nav' ) ) {

	function charitious_paging_nav() {


		if ( is_singular() )
			return;

		global $wp_query;

		/** Stop execution if there's only 1 page */
		if ( $wp_query->max_num_pages <= 1 )
			return;


        $paged = 1;
        if ( get_query_var('paged') ) $paged = get_query_var('paged');
        if ( get_query_var('page') ) $paged = get_query_var('page');


		$max	 = intval( $wp_query->max_num_pages );

		/** 	Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;

		/** 	Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<ul class="pagination justify-content-center xs-pagination">' . "\n";

		/** 	Previous Post Link */
		if ( get_previous_posts_link() )
			printf( '<li class="page-item">%s</li>' . "\n", get_previous_posts_link( '<span class="fa fa-angle-left"></span>' ) );

		/** 	Link to first page, plus ellipses if necessary */
		if ( !in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="page-link active"' : 'class="page-link"';

			printf( '<li class="page-item"><a %s href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

			if ( !in_array( 2, $links ) )
				echo '<li class="page-item">…</li>';
		}

		/** 	Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="page-link active"' : 'class="page-link"';
			printf( '<li class="page-item"><a %s href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}

		/** 	Link to last page, plus ellipses if necessary */
		if ( !in_array( $max, $links ) ) {
			if ( !in_array( $max - 1, $links ) )
				echo '<li class="page-item">…</li>' . "\n";

			$class = $paged == $max ? ' class="page-link active"' : 'class="page-link"';
			printf( '<li class="page-item"><a %s href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}

		/** 	Next Post Link */
		if ( get_next_posts_link() )
			printf( '<li class="page-item">%s</li>' . "\n", get_next_posts_link( '<i class="fa fa-angle-right"></i>' ) );

		echo '</ul>' . "\n";
	}

}
/**
 * Single post footer.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package xs
 */
/**
 * ----------------------------------------------------------------------------------------
 * 7.0 - footer tags with social share
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists( 'charitious_single_post_footer' ) ) {

	function charitious_single_post_footer() {
        $show_social = charitious_option('show_social');
        $tag_list = get_the_tag_list( '', ' ' );
        if ( $tag_list || $show_social):

		?>

        <?php $xs_width = (class_exists('Xs_Main') && ($show_social)) ? 'w-50' : 'w-100'?>
		<?php
		echo '<div class="xs-post-footer xs-padding-40 xs-border clearfix">' . "\n";


		if ( $tag_list ) {
			echo '<div class="post-tags '.esc_attr($xs_width).'">' . "\n";
			echo ' <h5 class="xs-post-sub-heading">' . esc_html__( 'Tags: ', 'charitious' ) . '</h5>' . "\n";
			echo '<div class="xs-blog-post-tag">';
			echo charitious_kses( $tag_list );
			echo '</div></div>' . "\n";
		}
		?>
        <?php
        if(class_exists('Xs_Main') && ($show_social) ):
            $Xs_Main = Xs_Main::xs_get_instance();
            $Xs_Main->get_social_share();
        endif;
        ?>
		<?php
		echo '</div>' . "\n";

        endif;
	}

}

function charitious_xs_comment_style( $comment, $args, $depth ) {
	if ( 'div' === $args[ 'style' ] ) {
		$tag		 = 'div';
		$add_below	 = 'comment';
	} else {
		$tag		 = 'li ';
		$add_below	 = 'div-comment';
	}
	?>

	<<?php
	echo charitious_kses( $tag );
	comment_class( empty( $args[ 'has_children' ] ) ? '' : 'parent'  );
	?> id="comment-<?php comment_ID() ?>"><?php if ( 'div' != $args[ 'style' ] ) { ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php }
	?>	
		<div class="meta-data clearfix">
            <div class="comment-author">
                <?php
                if ( $args[ 'avatar_size' ] != 0 ) {
                    echo get_avatar( $comment, $args[ 'avatar_size' ], '', '', array( 'class' => 'avatar comment-avatar pull-left' ) );
                }
                ?>
                <?php
                printf( charitious_kses( '<b>%s</b>', 'charitious' ), get_comment_author_link() );
                ?>
                <div class="pull-right">
                    <?php edit_comment_link( esc_html__( '(Edit)', 'charitious' ), '  ', '' ); ?>
                </div>
            </div>
            <div class="comment-metadata">
                <?php
                printf(
                    __( '<time datetime="2018-08-17T04:24:26+00:00">%1$s</time>', 'charitious' ), get_comment_date()
                );
                ?>
            </div>



		</div>


    <div class="comment-content">
        <?php comment_text(); ?>
    </div>


    <div class="reply">
        <?php
        comment_reply_link(
            array_merge(
                $args, array(
                'add_below'	 => $add_below,
                'depth'		 => $depth,
                'max_depth'	 => $args[ 'max_depth' ]
            ) ) );
        ?>
    </div>


		<?php if ( 'div' != $args[ 'style' ] ) : ?>
		</div><?php
	endif;
}

function charitious_link_pages() {
	$args = array(
		'before'			 => '<div class="page-links"><span class="page-link-text">' . esc_html__( 'More pages: ', 'charitious' ) . '</span>',
		'after'				 => '</div>',
		'link_before'		 => '<span class="page-link">',
		'link_after'		 => '</span>',
		'next_or_number'	 => 'number',
		'separator'			 => ' ',
		'nextpagelink'		 => esc_html__( 'Next ', 'charitious' ) . '<I class="fa fa-angle-right"></i>',
		'previouspagelink'	 => '<I class="fa fa-angle-left"></i>' . esc_html__( ' Previous', 'charitious' ),
	);
	wp_link_pages( $args );
}
