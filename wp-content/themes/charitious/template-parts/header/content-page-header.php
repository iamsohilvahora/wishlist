<?php
/**
 * Blog Header
 *
 */

$bg_image	 = $heading	 = $overlay	 = '';
$page_banner_title	 = $page_banner_subtitle	 = '';

$global_page_show_breadcrumb = charitious_option('page_show_breadcrumb');
$global_page_banner_img = charitious_option('page_banner_img');
$global_page_banner_title = charitious_option('page_banner_title', charitious_defaults('page_banner_title'));
$global_page_banner_subtitle = charitious_option('page_banner_subtitle', charitious_defaults('page_banner_subtitle'));


if ( defined( 'FW' ) ) {

    //Page settings
    $page_banner_title	 = fw_get_db_post_option( get_the_ID(), 'header_title' );
    $page_banner_subtitle	 = fw_get_db_post_option( get_the_ID(), 'header_subtitle' );
    $header_image	 = fw_get_db_post_option( get_the_ID(), 'header_image' );
    $page_show_breadcrumb	 = fw_get_db_post_option( get_the_ID(), 'show_breadcrumb' );

}
if(isset($header_image['url']) && $header_image['url'] !=''){
    $bg_image = 'style="background: url(' . $header_image['url'] . ')"';
}elseif ( $global_page_banner_img != '' ) {
    $bg_image = 'style="background: url(' . $global_page_banner_img . ')"';
}else{
    $bg_image = 'style="background: url(' . CHARITIOUS_IMAGES_URI.'/backgrounds/blog-bg.jpg)"';
}


if($page_banner_title != ''){
    $page_banner_title = $page_banner_title;
}elseif($global_page_banner_title != ''){
    $page_banner_title = $global_page_banner_title;
}else{
    $page_banner_title = get_the_title();
}

if($page_banner_subtitle != ''){
    $page_banner_subtitle = $page_banner_subtitle;
}elseif($global_page_banner_subtitle != ''){
    $page_banner_subtitle = $global_page_banner_subtitle;
}else{
    $page_banner_subtitle = '';
}
if($global_page_show_breadcrumb == 'true'){
	    $page_show_breadcrumb = $global_page_show_breadcrumb;

}else{
	    $page_show_breadcrumb = $page_show_breadcrumb;
}
?>

<section class="xs-banner-inner-section parallax-window" <?php echo wp_kses_post( $bg_image ); ?>>
    <div class="xs-black-overlay"></div>
    <div class="container">
        <div class="color-white xs-inner-banner-content">
            <h1 class="xs-ch__title"><?php echo esc_html( $page_banner_title ); ?></h1>
            <?php if($page_banner_subtitle != ''){ ?><p><?php echo esc_html( $page_banner_subtitle ); ?></p><?php } ?>
            <?php if ($page_show_breadcrumb ): ?>
                <?php echo charitious_get_breadcrumbs(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>

