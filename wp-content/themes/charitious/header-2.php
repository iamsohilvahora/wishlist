<?php

$show_donate_btn = charitious_option('show_donate_btn', charitious_defaults('show_donate_btn'));

$logo = charitious_option('site_logo');
$custom_logo = charitious_meta_option(get_the_ID(), 'custom_logo');

$site_logo = ( ( is_array($custom_logo) && $custom_logo['url'] != '' ) ? wp_get_attachment_image($custom_logo['attachment_id'], 'full', false, array(
    'alt' => 'custom-logo '.get_bloginfo('name')) ) : ( !empty($logo) ? wp_get_attachment_image(attachment_url_to_postid($logo), 'full', false, array( 
        'alt' => 'main-logo '.get_bloginfo('name'))) : '<img class="img-responsive" 
        width="120" height="60" src="'. CHARITIOUS_IMAGES . '/logo.png' .'" alt="'.get_bloginfo( 'name' ).'">' ) );

$show_topbar = charitious_option( 'show_topbar',charitious_defaults('show_topbar') );

?>
<header class="xs-header header-transparent xs-box">
    <div class="container">
        <nav class="xs-menus">
            <?php get_template_part( 'template-parts/navigation/nav', 'top' ); ?>
            <div class="nav-header clearfix">
                <div class="nav-toggle"></div>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="xs-nav-logo">
                    <?php echo $site_logo; ?>
                </a>
            </div>
            <div class="nav-menus-wrapper row">
                <div class="xs-logo-wraper col-lg-2 col-xl-2 xs-padding-0">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-brand">
                      <?php echo $site_logo; ?>
                    </a>
                </div>
                <div class="col-lg-10 col-xl-<?php echo esc_html($show_donate_btn ? '7' : '10'); ?>">
                    <?php get_template_part( 'template-parts/navigation/primary', 'nav' ); ?>
                </div>
                <?php if($show_donate_btn): ?>
                    <div class="xs-navs-button d-flex-center-end col-lg-3 col-xl-3 d-block d-lg-none d-xl-block">
                        <?php get_template_part( 'template-parts/navigation/donate', 'button' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
