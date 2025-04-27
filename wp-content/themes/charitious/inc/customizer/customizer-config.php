<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}


Kirki::add_config( 'charitious_customizer', array(
	'capability'  => 'edit_theme_options',
	'option_type' => 'theme_mod',
) );


function charitious_customizer_sections($wp_customize){
    $wp_customize->add_panel( 'theme_option', array(
        'priority'    => 10,
        'title'       => esc_attr__( 'Theme Options', 'charitious' ),
    ) );

	$wp_customize->add_section( 'general_section', array(
		'title'			=> esc_html__( 'General Settings', 'charitious' ),
		'priority'		=> 1,
		'description'	=> esc_html__( 'to change logo,favicon etc', 'charitious' ),
        'panel'          => 'theme_option',
	) );

	$wp_customize->add_section( 'nav_section', array(
		'title'			=> esc_html__( 'Navigation Settings', 'charitious' ),
		'priority'		=> 2,
		'description'	=> esc_html__( 'Setting Your Menu', 'charitious' ),
        'panel'          => 'theme_option',
	) );

	$wp_customize->add_section( 'page_section', array(
        'title'			=> esc_html__( 'Page Settings', 'charitious' ),
        'priority'		=> 3,
        'description'	=> esc_html__( 'Setting Your Page', 'charitious' ),
        'panel'          => 'theme_option',
    ) );
    $wp_customize->add_section( 'blog_section', array(
        'title'         => esc_html__( 'Blog Settings', 'charitious' ),
        'priority'      => 4,
        'description'   => esc_html__( 'Setting Your Blog ', 'charitious' ),
        'panel'          => 'theme_option',
    ) );
    $wp_customize->add_section( 'blog_banner_section', array(
        'title'         => esc_html__( 'Blog Banner Settings', 'charitious' ),
        'priority'      => 4,
        'description'   => esc_html__( 'Setting Your Blog Banner', 'charitious' ),
        'panel'          => 'theme_option',
    ) );

    $wp_customize->add_section( 'blog_single_section', array(
        'title'         => esc_html__( 'Single Blog Settings', 'charitious' ),
        'priority'      => 5,
        'description'   => esc_html__( 'Setting Your Singel Blog', 'charitious' ),
        'panel'          => 'theme_option',
    ) );

    $wp_customize->add_section( 'page_banner_section', array(
        'title'         => esc_html__( 'Page Banner Settings', 'charitious' ),
        'priority'      => 4,
        'description'   => esc_html__( 'Setting Your Page Banner', 'charitious' ),
        'panel'          => 'theme_option',
    ) );
    $wp_customize->add_section( 'event_banner_section', array(
        'title'         => esc_html__( 'Event Banner Settings', 'charitious' ),
        'priority'      => 4,
        'description'   => esc_html__( 'Setting Your Event Banner', 'charitious' ),
        'panel'          => 'theme_option',
    ) );
    $wp_customize->add_section( 'wp_fundraising_section', array(
        'title'         => esc_html__( 'Wp Fundraising', 'charitious' ),
        'priority'      => 4,
        'description'   => esc_html__( 'Setting Your Event Banner', 'charitious' ),
        'panel'          => 'theme_option',
    ) );

    $wp_customize->add_section( 'shop_section', array(
        'title'         => esc_html__( 'Shop Settings', 'charitious' ),
        'priority'      => 5,
        'description'   => esc_html__( 'Setting Your Shop page', 'charitious' ),
        'panel'          => 'theme_option',
    ) );

    $wp_customize->add_section( 'footer_section', array(
        'title'			=> esc_html__( 'Footer Settings', 'charitious' ),
        'priority'		=> 6,
        'description'	=> esc_html__( 'Setting Your Footer', 'charitious' ),
        'panel'          => 'theme_option',
    ) );

    $wp_customize->add_section( 'styling_section', array(
        'title'			=> esc_html__( 'Styling Settings', 'charitious' ),
        'priority'		=> 6,
        'description'	=> esc_html__( 'Setting Your font', 'charitious' ),
        'panel'          => 'theme_option',
    ) );
}

add_action( 'customize_register', 'charitious_customizer_sections' );

require CHARITIOUS_CUSTOMIZER_DIR . 'customizer-fields.php' ;
