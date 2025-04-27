<?php

if ( !defined( 'ABSPATH' ) )
	die( 'Direct access forbidden.' );



return array(
	/**
	 * Array for demos
	 */
	'plugins'			 => array(
		array(
			'name'		 => esc_html__( 'Unyson', 'charitious' ),
			'slug'		 => 'unyson',
			'required'	 => true,
		),
		array(
			'name'		 => esc_html__( 'Elementor', 'charitious' ),
			'slug'		 => 'elementor',
			'required'	 => true,
		),
		array(
			'name'		 => esc_html__( 'Kirki', 'charitious' ),
			'slug'		 => 'kirki',
			'required'	 => true,
		),
        array(
            'name'		 => esc_html__( 'WooCommerce', 'charitious' ),
            'slug'		 => 'woocommerce',
            'required'	 => true,
        ),
		array(
			'name'		 => esc_html__( 'Charitious Assistance', 'charitious' ),
			'slug'		 => 'charitious-assistance',
			'required'	 => true,
			'source'	 =>  CHARITIOUS_REMOTE_URL . '/charitious-assistance.zip' ,
		), 
		array(
			'name'		 => esc_html__( 'WP MailChimp', 'charitious' ),
			'slug'		 => 'wp-mailchimp',
			'required'	 => true,
			'source'	 =>  CHARITIOUS_REMOTE_URL . '/wp-mailchimp.zip' ,
		),
		array(
			'name'		 => esc_html__( 'WP Fundraising Donation and Crowdfunding Platform', 'charitious' ),
			'slug'		 => 'wp-fundraising-donation',
			'required'	 => true,
		),
        array(
            'name'		 => esc_html__( 'Mtform', 'charitious' ),
            'slug'		 => 'metform',
            'required'	 => true,
        ),
	),
	'theme_id'			 => 'charitious',
	'child_theme_source' => CHARITIOUS_REMOTE_URL . '/charitious-child.zip',
	'has_demo_content'	 => true
);
