<?php
/**
 * Page Header
 *
 */

$header_title = charitious_option('shop_heading_title', charitious_defaults('shop_heading_title'));
$banner = charitious_option('shop_header_image', '');
$show_breadcrumb = charitious_option('shop_show_breadcrumb', charitious_defaults('shop_show_breadcrumb'));
if(empty($banner)){
    $banner = CHARITIOUS_IMAGES_URI.'/backgrounds/blog-bg.jpg';
}
if(is_single()){
    $header_title = get_the_title();
}

$bg_image = 'style="background: url(' . $banner . ')"';

?>
<section class="xs-banner-inner-section parallax-window" <?php echo wp_kses_post( $bg_image ); ?>>
<div class="xs-black-overlay"></div>
    <div class="container">
        <div class="color-white xs-inner-banner-content">
            <h2><?php echo esc_html($header_title); ?></h2>
            <?php if ($show_breadcrumb ): ?>
            <?php echo charitious_get_breadcrumbs(); ?>
            <?php  endif; ?>
        </div>
    </div>
</section>
