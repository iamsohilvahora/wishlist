<?php
/**
 * Blog Header
 *
 */
$header_image	 		= '';
$heading	 			= '';
$overlay	 			= '';
$header_icons 			= '';
$page_banner_title		= '';
$page_banner_subtitle	= '';
$blog_banner_img 		= '';
$bg_image 				= '';

if ( is_singular( 'event' ) ):
	$blog_show_breadcrumb		 = charitious_option( 'event_show_breadcrumb' );
	$event_banner_img			 = charitious_option( 'event_banner_img' );
	$global_page_banner_title	 = charitious_option( 'event_banner_title' );
	$global_page_banner_subtitle = charitious_option( 'event_banner_subtitle' );
	if ( $event_banner_img != null ):
		$bg_image = 'style="background: url(' . $event_banner_img . ')"';
	endif;
elseif ( is_single() ):
	$blog_show_breadcrumb		 = charitious_option( 'blog_show_breadcrumb' );
	$blog_banner_img			 = charitious_option( 'single_banner_img' );
	$global_page_banner_title	 = charitious_option( 'single_banner_title' );
	$global_page_banner_subtitle = charitious_option( 'single_banner_subtitle' );

else:
	$blog_show_breadcrumb		 = charitious_option( 'blog_show_breadcrumb' );
	$blog_banner_img			 = charitious_option( 'blog_banner_img' );
	$global_page_banner_title	 = charitious_option( 'blog_banner_title' );
	$global_page_banner_subtitle = charitious_option( 'blog_banner_subtitle' );

endif; 

if ( defined( 'FW' ) ) {

	//Page settings
	$page_banner_title		 = fw_get_db_post_option( get_the_ID(), 'header_title' );
	$page_banner_subtitle	 = fw_get_db_post_option( get_the_ID(), 'header_subtitle' );
	$header_image			 = fw_get_db_post_option( get_the_ID(), 'header_image' );
}
if ( !is_singular( 'event' ) ) {
	if ( is_single() ) {
		
		if ( $header_image != '' ) {
			$bg_image = 'style="background: url(' . $header_image[ 'url' ] . ')"';
		} else {
			$bg_image = 'style="background: url(' . CHARITIOUS_IMAGES_URI . '/backgrounds/blog-bg.jpg)"';
		}
	} elseif ( $blog_banner_img != '' ) {

		$bg_image = 'style="background: url(' . $blog_banner_img . ')"';
	} else {
		$bg_image = 'style="background: url(' . CHARITIOUS_IMAGES_URI . '/backgrounds/blog-bg.jpg)"';
	}
}
if ( $page_banner_title != '' ) {
	$page_banner_title = $page_banner_title;
} elseif ( $global_page_banner_title != '' ) {
	$page_banner_title = $global_page_banner_title;
} else {
	if ( is_single() ) {
		$page_banner_title = get_the_title();
	} else {
		$page_banner_title = '';
	}
}

if ( $page_banner_subtitle != '' ) {
	$page_banner_subtitle = $page_banner_subtitle;
} elseif ( $global_page_banner_subtitle != '' ) {
	$page_banner_subtitle = $global_page_banner_subtitle;
} else {
	$page_banner_subtitle = '';
}

?>

<section class="xs-banner-inner-section parallax-window" <?php echo wp_kses_post( $bg_image ); ?>>
	<div class="xs-black-overlay"></div>
	<div class="container">
		<div class="color-white xs-inner-banner-content">
			<h1 class="xs-ch__title">
				<?php if ($page_banner_title == ''){
						echo 'Charitious';
					} else {
						echo  esc_html( $page_banner_title );
					}
				 ?>
			</h1>
			<?php if ( $page_banner_subtitle != '' ) { ?><p><?php echo esc_html( $page_banner_subtitle ); ?></p><?php } ?>
			<?php if ( $blog_show_breadcrumb ): ?>
				<?php echo charitious_get_breadcrumbs(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>


