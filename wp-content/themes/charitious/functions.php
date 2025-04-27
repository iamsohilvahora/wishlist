<?php

/**
 * functions.php
 *
 * The theme's functions and definitions.
 */
/**
 * 1.0 - Define constants. Current Version number & Theme Name.
 */
define( 'CHARITIOUS_THEME', 'Charitious WordPress Theme' );
define( 'CHARITIOUS_VERSION', '3.4' );

define( 'CHARITIOUS_THEMEROOT', get_template_directory_uri() );
define( 'CHARITIOUS_THEMEROOT_DIR', get_parent_theme_file_path() );
define( 'CHARITIOUS_IMAGES', CHARITIOUS_THEMEROOT . '/assets/images' );
define( 'CHARITIOUS_IMAGES_DIR', CHARITIOUS_THEMEROOT_DIR . '/assets/images' );
define( 'CHARITIOUS_IMAGES_URI', CHARITIOUS_THEMEROOT . '/assets/images' );
define( 'CHARITIOUS_CSS', CHARITIOUS_THEMEROOT . '/assets/css' );
define( 'CHARITIOUS_CSS_DIR', CHARITIOUS_THEMEROOT_DIR . '/assets/css' );
define( 'CHARITIOUS_SCRIPTS', CHARITIOUS_THEMEROOT . '/assets/js' );
define( 'CHARITIOUS_SCRIPTS_DIR', CHARITIOUS_THEMEROOT_DIR . '/assets/js' );
define( 'CHARITIOUS_PHPSCRIPTS', CHARITIOUS_THEMEROOT . '/assets/php' );
define( 'CHARITIOUS_PHPSCRIPTS_DIR', CHARITIOUS_THEMEROOT_DIR . '/assets/php' );
define( 'CHARITIOUS_INC', CHARITIOUS_THEMEROOT_DIR . '/inc' );
define( 'CHARITIOUS_CUSTOMIZER_DIR', CHARITIOUS_INC . '/customizer/' );
define( 'CHARITIOUS_SHORTCODE_DIR', CHARITIOUS_INC . '/shortcode/' );
define( 'CHARITIOUS_SHORTCODE_DIR_STYLE', CHARITIOUS_INC . '/shortcode/style' );
define( 'CHARITIOUS_REMOTE_CONTENT', esc_url( 'https://wp.xpeedstudio.com/demo-content/charitious' ) );
define( 'CHARITIOUS_REMOTE_URL', esc_url( 'https://wp.xpeedstudio.com/demo-content/charitious/plugins' ) );
define( 'CHARITIOUS_PLUGINS_DIR', CHARITIOUS_INC . '/includes/plugins' );
define( 'CHARITIOUS_UNYSON_URL', esc_url( 'https://demo.xpeedstudio.com/global-plugin' ) );






/**
 * ----------------------------------------------------------------------------------------
 * 3.0 - Set up the content width value based on the theme's design.
 * ----------------------------------------------------------------------------------------
 */
if ( !isset( $content_width ) ) {
	$content_width = 800;
}



/**
 * ----------------------------------------------------------------------------------------
 * 4.0 - Set up theme default and register various supported features.
 * ----------------------------------------------------------------------------------------
 */
if ( !function_exists( 'charitious_setup' ) ) {

	function charitious_setup() {
		/**
		 * Make the theme available for translation.
		 */
		load_theme_textdomain( 'hostinza', get_template_directory() . '/languages' );
		$locale		 = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";

		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}

		/**
		 * Add support for post formats.
		 */
		add_theme_support( 'post-formats', array()
		);

		/**
		 * Add support for automatic feed links.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add support for post thumbnails.
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 750, 465, array( 'center', 'center' ) ); // Hard crop center center
        add_image_size('fundraising_single_thum', 600, 400);


		/**
		 *
		 * woocommerce
		 *
		 */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		/**
		 * Register nav menus.
		 */
		register_nav_menus(
		array(
			'primary'		 => esc_html__( 'Primary Menu', 'charitious' ),
			'footer_menu'	 => esc_html__( 'Footer Menu', 'charitious' ),
		)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
		add_theme_support( 'align-wide' );
	}

	add_action( 'after_setup_theme', 'charitious_setup' );
}

/**
 * ----------------------------------------------------------------------------------------
 * 7.0 - theme INC.
 * ----------------------------------------------------------------------------------------
 */
include_once get_template_directory() . '/inc/init.php';

if ( class_exists( 'WP_FundRaising' ) ) {
	add_action( 'wf_wc_before_main_loop', 'charitious_before_single_shop' );

	function charitious_before_single_shop() {
		get_template_part( 'template-parts/header/content', 'shop-header' );
	}

}

add_filter( 'wp_nav_menu', 'new_submenu_class' );

function new_submenu_class( $menu ) {
	$menu = preg_replace( '/ class="sub-menu"/', '/ class="nav-dropdown sub-menu" /', $menu );
	return $menu;
}

add_action( 'admin_menu', 'charitious_remove_theme_settings', 999 );

function charitious_remove_theme_settings() {
	remove_submenu_page( 'themes.php', 'fw-settings' );
}

add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form' );
//remove_filter( 'woocommerce_coupons_enabled', 'WP_FundRaising::wf_wc_coupon_disable' );



// Add this to your theme functions.php file. Change sidebar id to your primary sidebar id.
function charitious_body_classes( $classes ) {

    if ( is_active_sidebar( 'sidebar-1' ) || ( class_exists( 'Woocommerce' ) && ! is_woocommerce() ) || class_exists( 'Woocommerce' ) && is_woocommerce() && is_active_sidebar( 'shop-sidebar' ) ) {
        $classes[] = 'sidebar-active';
    }else{
        $classes[] = 'sidebar-inactive';
    }
    return $classes;
}
add_filter( 'body_class','charitious_body_classes' );

//add_action('enqueue_block_editor_assets', 'charitious_action_enqueue_block_editor_assets' );
//function charitious_action_enqueue_block_editor_assets() {
//    wp_enqueue_style( 'charitious-gutenberg-editor-customizer-styles', CHARITIOUS_CSS . '/gutenberg-editor.css', null, CHARITIOUS_VERSION );
//}


add_action('enqueue_block_editor_assets', 'charitious_action_enqueue_block_editor_assets' );
function charitious_action_enqueue_block_editor_assets() {
    wp_enqueue_style( 'exhibz-fonts', charitious_google_fonts_url(['Poppins:400,500,600,700,800,900']), null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'exhibz-gutenberg-editor-font-awesome-styles', CHARITIOUS_CSS . '/font-awesome.min.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'exhibz-gutenberg-editor-customizer-styles', CHARITIOUS_CSS . '/gutenberg-editor-custom.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'exhibz-gutenberg-editor-styles', CHARITIOUS_CSS . '/gutenberg-custom.css', null, CHARITIOUS_VERSION );
    wp_enqueue_style( 'exhibz-gutenberg-blog-styles', CHARITIOUS_CSS . '/blog.css', null, CHARITIOUS_VERSION );
}

