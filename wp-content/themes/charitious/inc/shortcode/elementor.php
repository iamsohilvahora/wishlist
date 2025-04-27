<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Shortcode{

	/**
     * Holds the class object.
     *
     * @since 1.0
     *
     */
	public static $_instance;

	/**
     * Load Construct
     * 
     * @since 1.0
     */

	public function __construct(){

		add_action('elementor/init', array($this, 'xs_elementor_init'));
        add_action('elementor/controls/controls_registered', array( $this, 'xs_icon_pack' ), 11 );
        add_action('elementor/widgets/widgets_registered', array($this, 'xs_shortcode_elements'));
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_enqueue_styles' ) );
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_enqueue_scripts' ) );
        add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'preview_enqueue_scripts' ) );

	}


    /**
     * Enqueue Scripts
     *
     * @return void
     */
    
     public function enqueue_scripts() {
         wp_enqueue_script( 'xs-main-elementor', CHARITIOUS_SCRIPTS  . '/elementor.js',array( 'jquery', 'elementor-frontend' ), CHARITIOUS_VERSION, true );
     }

    /**
     * Enqueue Scripts
     *
     * @return void
     */

     public function editor_enqueue_scripts() {
         
     }

    /**
     * Enqueue editor styles
     *
     * @return void
     */

    public function editor_enqueue_styles() {
        wp_enqueue_style( 'xs-icon-elementor', CHARITIOUS_CSS.'/iconfont.css',null, CHARITIOUS_VERSION );

    }

    /**
     * Preview Enqueue Scripts
     *
     * @return void
     */

    public function preview_enqueue_scripts() {
    }
	/**
     * Elementor Initialization
     *
     * @since 1.0
     *
     */

    public function xs_elementor_init(){
        \Elementor\Plugin::$instance->elements_manager->add_category(
            'charitious-elements',
            [
                'title' =>esc_html__( 'Charitious', 'charitious' ),
                'icon' => 'fa fa-plug',
            ],
            1
        );
    }

    /**
     * Extend Icon pack core controls.
     *
     * @param  object $controls_manager Controls manager instance.
     * @return void
     */

    public function xs_icon_pack( $controls_manager ) {

        require_once CHARITIOUS_SHORTCODE_DIR. 'controls/xs-icon.php';

        $controls = array(
            $controls_manager::ICON => 'Xs_Icon_Controler',
        );

        foreach ( $controls as $control_id => $class_name ) {
            $controls_manager->unregister_control( $control_id );
            $controls_manager->register_control( $control_id, new $class_name() );
        }

    }

    /**
     * Multiselect Control.
     *
     * @param  object $controls_manager Controls manager instance.
     * @return void
     */

    public function xs_multiselect_options( $controls_manager ) {

        require_once CHARITIOUS_SHORTCODE_DIR. 'controls/xs-multiselect.php';

        $controls = array(
            $controls_manager::SELECT => 'Xs_Multiselect_Controler',
        );

        foreach ( $controls as $control_id => $class_name ) {
            $controls_manager->unregister_control( $control_id );
            $controls_manager->register_control( $control_id, new $class_name() );
        }

    }

    public function xs_shortcode_elements($widgets_manager){
        // require_once CHARITIOUS_SHORTCODE_DIR.'xs-map.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-heading.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-funfact.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-funfacts.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-campaigns.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-button.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-partner.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-featured-box.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-event.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-blog.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-team.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-slider.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-video.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-intro-video.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-image-box.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-faqs.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-portfolio.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-pricing.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-gallery.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-contact-info.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-products.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-countdown-timer.php';
        require_once CHARITIOUS_SHORTCODE_DIR.'xs-volunteer-area.php';

        if(defined('WFP_FUNDRAISING_VERSION')) {
            require_once CHARITIOUS_SHORTCODE_DIR.'xs-wp-fundraising.php';
            require_once CHARITIOUS_SHORTCODE_DIR.'xs-wp-donate.php';
        }

        // $widgets_manager->register_widget_type(new Elementor\Xs_Maps_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Heading_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Funfact_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Funfacts_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Campaigns_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Button_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Partner_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Featured_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Event_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Post_Widget());
        $widgets_manager->register_widget_type(new Elementor\XS_Team_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Slider_Widget());
        $widgets_manager->register_widget_type(new Elementor\XS_Intro_Video_Widget());
        $widgets_manager->register_widget_type(new Elementor\XS_Video_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Image_Box_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_FAQs_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Portfolio_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Pricing_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Gallery_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Contact_Info_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Products_Widget());
        $widgets_manager->register_widget_type(new Elementor\Xs_Countdown_Timer_Widget());
        $widgets_manager->register_widget_type(new Elementor\XS_Volunteer_Area_Widget());

        if(defined('WFP_FUNDRAISING_VERSION')) {
            $widgets_manager->register_widget_type(new Elementor\Xs_wp_fundraising_Widget());
            $widgets_manager->register_widget_type(new Elementor\Xs_wp_fundraising_donate_Widget());
        }
    }
    
	public static function xs_get_instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Xs_Shortcode();
        }
        return self::$_instance;
    }

}
$Xs_Shortcode = Xs_Shortcode::xs_get_instance();