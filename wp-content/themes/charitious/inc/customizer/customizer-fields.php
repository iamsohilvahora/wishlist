<?php
/**
 *	Customizer General Settings
 *	styles for logo/title - sizing, spacing ...
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Fields{

	/**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     */
    
	public static $_instance;

	/**
     * Load Construct
     * 
     * @since 1.0.0
     */

	public function __construct(){
		$this->xs_customizer_init();
	}

	/**
     * Customizer field Initialization
     *
     * @since 1.0.0
     *
     */

	public function xs_customizer_init(){
		add_filter( 'kirki/fields', array($this,'charitious_general_setting') );
	}

	public function charitious_general_setting( $fields ){

		require CHARITIOUS_CUSTOMIZER_DIR . 'general-settings.php' ;
		require CHARITIOUS_CUSTOMIZER_DIR . 'nav-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'blog-banner-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'blog-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'event-banner-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'blog-single-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'page-banner-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'page-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'shop-setting.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'footer-settings.php' ;
        require CHARITIOUS_CUSTOMIZER_DIR . 'style-settings.php' ;

        if(defined('WFP_FUNDRAISING_VERSION')) {
            require CHARITIOUS_CUSTOMIZER_DIR . 'wp-fundraising-donation.php' ;
        }

		return $fields;
	}

	public static function xs_get_instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Xs_Fields();
        }
        return self::$_instance;
    }
}
$Xs_Fields = Xs_Fields::xs_get_instance();