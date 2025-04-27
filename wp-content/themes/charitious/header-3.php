<?php

$logo = charitious_option('site_logo');
$custom_logo = charitious_meta_option(get_the_ID(), 'custom_logo');

$site_logo = ( ( is_array($custom_logo) && $custom_logo['url'] != '' ) ? wp_get_attachment_image($custom_logo['attachment_id'], 'full', false, array(
    'alt' => 'custom-logo '.get_bloginfo('name')) ) : ( !empty($logo) ? wp_get_attachment_image(attachment_url_to_postid($logo), 'full', false, array( 
        'alt' => 'main-logo '.get_bloginfo('name'))) : '<img class="img-responsive" 
        width="120" height="60" src="'. CHARITIOUS_IMAGES . '/logo.png' .'" alt="'.get_bloginfo( 'name' ).'">' ) );

?>
<?php $header_social_links = charitious_option('social_links'); ?>
<?php $show_topbar = charitious_option('show_topbar'); ?>
<?php $top_bar_email = charitious_option('top_bar_email'); ?>
<?php $top_bar_email_icon = charitious_option('top_bar_email_icon'); ?>
<?php $top_bar_phone		 = charitious_option( 'top_bar_phone'); ?>
<?php $top_bar_phone_icon		 = charitious_option( 'top_bar_phone_icon'); ?>
<?php
    $show_search_icon		 = charitious_option( 'show_search_icon');
    $show_search_icon_class = ($show_search_icon == 1) ? 'col-md-8' : 'col-md-9';
?>

<?php if($show_topbar): ?>
<div class="xs-top-bar top-bar-second">
    <div class="container clearfix">


            <ul class="xs-top-social">
                <?php if($header_social_links) {
                    foreach($header_social_links as $social){
                        ?><li><a href="<?php echo esc_url($social['social_url']); ?>"><i class="<?php echo esc_attr($social['social_icon']); ?>"></i></a></li><?php
                    }
                } ?>
            </ul>


            <?php if ( $top_bar_phone != '' ) { ?>
                <span class="top-bar-info"><i class="<?php echo esc_attr( $top_bar_phone_icon ); ?>"></i><?php echo esc_attr( $top_bar_phone ); ?></span>
            <?php } ?>

            <?php if ( $top_bar_email != '' ) { ?>
                <a href="mailto:<?php echo sanitize_email( $top_bar_email ); ?>" class="xs-top-bar-mail"><span class="<?php echo esc_attr( $top_bar_email_icon ); ?>"></span> <?php echo sanitize_email( $top_bar_email ); ?></a>
            <?php } ?>


    </div>
</div>
<?php endif; ?>
<header class="xs-header xs-fullWidth xs-header-3">
    <div class="container">
        <nav class="xs-menus">
            <div class="nav-header">
                <div class="nav-toggle"></div>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="xs-nav-logo">
                    <?php echo $site_logo; ?>
                </a>
            </div>
            <div class="nav-menus-wrapper row">
                <div class="xs-logo-wraper col-lg-3">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-brand">
                      <?php echo $site_logo; ?>
                    </a>
                </div>
                <div class="<?php echo esc_attr($show_search_icon_class)?>">
                    <?php get_template_part( 'template-parts/navigation/primary', 'nav' ); ?>
                </div>
                <?php if($show_search_icon == 1) : ?>
                <div class="col-md-1">
					<div class="navSearch-group">
						<a href="#" class="navsearch-button"><i class="fa fa-search"></i></a>
						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="navsearch-form">
							<input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php echo esc_attr__( 'Search', 'charitious' ); ?>" />
						</form>
					</div>
				</div>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>