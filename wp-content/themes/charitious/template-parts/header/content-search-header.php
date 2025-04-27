<?php
/**
 * Blog Header
 *
 */

$blog_show_breadcrumb = charitious_option('blog_show_breadcrumb');
$page_banner_img = charitious_option('page_banner_img');

if ( $page_banner_img != null ) {
    $bg_image = 'style="background: url(' . $page_banner_img . ')"';
} else{
    $bg_image = 'style="background: url(' . CHARITIOUS_IMAGES_URI.'/backgrounds/blog-bg.jpg)"';
}

?>

<section class="xs-banner-inner-section parallax-window" <?php echo wp_kses_post( $bg_image ); ?>>
    <div class="xs-black-overlay"></div>
    <div class="container">
        <div class="color-white xs-inner-banner-content">
            <h2><?php printf(esc_html__('Search Results for: %s', 'charitious'), get_search_query()); ?></h2>
            <?php if ($blog_show_breadcrumb ): ?>
                <?php echo charitious_get_breadcrumbs(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
