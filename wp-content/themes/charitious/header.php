<?php
/**
 * header.php
 *
 * The header for the theme.
 */
?>
<!DOCTYPE html>
<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
		<?php if( defined('FW')){ 
            $loader = charitious_option( 'show_preloader' );
			if ( $loader) {?>
        <div id="preloader">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
            
        </div>
        <?php
         } }

        $header_layout = charitious_option('header_layout');

        if ( defined( 'FW' ) ) {
            $navigation_style	 = fw_get_db_post_option( get_the_ID(), 'navigation_style' );
            if( $navigation_style != '' && $navigation_style != 5) {
                $header_layout =  $navigation_style;
            }
        }

        get_header( $header_layout );
        ?>