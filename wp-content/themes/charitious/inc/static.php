<?php

if ( !defined( 'ABSPATH' ) )
	die( 'Direct access forbidden.' );
/**
 * Enqueue all theme scripts and styles
 */

  /** --------------------------------------
 * ** REGISTERING THEME ASSETS
 * ** ------------------------------------ */
/**
 * Enqueue styles.
 */
if ( !is_admin() ) {
    wp_enqueue_style( 'charitious-style_sans', 'https://fonts.googleapis.com/css?family=Open+Sans:700|Yantramanav&display=swap', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'charitious-fonts', charitious_google_fonts_url(), null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'bootstrap', CHARITIOUS_CSS . '/bootstrap.min.css', null, CHARITIOUS_VERSION );
    wp_style_add_data( 'bootstrap', 'rtl', 'replace' );
	wp_enqueue_style( 'charitious-xs-main', CHARITIOUS_CSS . '/xs_main.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'charitious-custom-blog', CHARITIOUS_CSS . '/blog-style.css', null, CHARITIOUS_VERSION );
    wp_style_add_data( 'charitious-custom-blog', 'rtl', 'replace' );
    wp_enqueue_style( 'font-awesome', CHARITIOUS_CSS . '/font-awesome.min.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'charitious-xsIcon', CHARITIOUS_CSS . '/xsIcon.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'isotope', CHARITIOUS_CSS . '/isotope.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'magnific-popup', CHARITIOUS_CSS . '/magnific-popup.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'owl-carousel', CHARITIOUS_CSS . '/owl.carousel.min.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'owl-theme-default', CHARITIOUS_CSS . '/owl.theme.default.min.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'animate', CHARITIOUS_CSS . '/animate.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'navigation', CHARITIOUS_CSS . '/navigation.min.css', null, CHARITIOUS_VERSION );
	wp_enqueue_style( 'magnific-popup', CHARITIOUS_CSS . '/magnific-popup.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'charitious-style', CHARITIOUS_CSS . '/style.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'charitious-gutenberg-custom', CHARITIOUS_CSS . '/gutenberg-custom.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'fundraising', CHARITIOUS_CSS . '/fundraising.css', null, CHARITIOUS_VERSION );
    wp_style_add_data( 'charitious-style', 'rtl', 'replace' );
    wp_enqueue_style( 'charitious-custom', CHARITIOUS_CSS . '/custom.css', null, CHARITIOUS_VERSION );
    wp_style_add_data( 'charitious-custom', 'rtl', 'replace' );
	wp_enqueue_style( 'charitious-responsive', CHARITIOUS_CSS . '/responsive.css', null, CHARITIOUS_VERSION );
}



/**
 * Enqueue scripts.
 */
if ( !is_admin() ) {

	wp_enqueue_script( 'navigation', CHARITIOUS_SCRIPTS . '/navigation.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
	//Bootstrap Main JS
	wp_enqueue_script( 'Popper', CHARITIOUS_SCRIPTS . '/Popper.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
	
    
    if ( is_rtl() ) {
        wp_enqueue_script( 'bootstrap', CHARITIOUS_SCRIPTS . '/bootstrap.min-rtl.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
    } else {
        wp_enqueue_script( 'bootstrap', CHARITIOUS_SCRIPTS . '/bootstrap.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
    }
	
    wp_enqueue_script( 'isotope-pkgd', CHARITIOUS_SCRIPTS . '/isotope.pkgd.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
	wp_enqueue_script( 'jquery-magnific-popup', CHARITIOUS_SCRIPTS . '/jquery.magnific-popup.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
	wp_enqueue_script( 'owl-carousel', CHARITIOUS_SCRIPTS . '/owl.carousel.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
    wp_enqueue_script( 'jquery-waypoints', CHARITIOUS_SCRIPTS . '/jquery.waypoints.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
    wp_enqueue_script( 'jquery-countdown', CHARITIOUS_SCRIPTS . '/jquery.countdown.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
    wp_enqueue_script( 'spectragram', CHARITIOUS_SCRIPTS . '/spectragram.min.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
    wp_enqueue_script( 'TimeCircles', CHARITIOUS_SCRIPTS . '/TimeCircles.js', array( 'jquery' ), CHARITIOUS_VERSION, true );
    wp_enqueue_script( 'picchart', CHARITIOUS_SCRIPTS . '/piechart.js', array( 'jquery' ), CHARITIOUS_VERSION, true );



    $map_api_code	 = charitious_option( 'map_api', charitious_defaults( 'map_api' ) );
    $api_key		 = ($map_api_code != '') ? '?key=' . $map_api_code : '';

    if(!empty($api_key)){
        wp_enqueue_script( 'map-googleapis', 'https://maps.googleapis.com/maps/api/js' . $api_key, array( 'jquery' ), '', TRUE );
    }
	wp_enqueue_script( 'charitious-main', CHARITIOUS_SCRIPTS . '/main.js', array( 'jquery', 'wp-i18n'), the_date(), true );

    // Make countdown text translatable

    $countdown_translation_array = [
        'days' => esc_html__( 'Days', 'charitious' ),
        'hours' => esc_html__( 'Hours', 'charitious' ),
        'minutes' => esc_html__( 'Minutes', 'charitious' ),
        'seconds' => esc_html__( 'Seconds', 'charitious' ),
    ];

    wp_localize_script( 'charitious-main', 'countdown_variable', $countdown_translation_array );


    // Load WordPress Comment js
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}


