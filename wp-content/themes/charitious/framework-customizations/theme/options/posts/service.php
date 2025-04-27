<?php

if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'side' => array(
		'title'		 => __( 'Page Settings', 'charitious' ),
		'type'		 => 'box',
		'priority'	 => 'high',
		'options'	 => array(
			'header_title'	 => array(
				'type'	 => 'text',
				'label'	 => esc_html__( 'Banner title', 'charitious' ),
				'desc'	 => esc_html__( 'Add your Service hero title', 'charitious' ),
				'value'	 => esc_html__( 'Our Services', 'charitious' ),
			),
			'header_image'	 => array(
				'label'	 => esc_html__( ' Banner Image', 'charitious' ),
				'desc'	 => esc_html__( 'Upload a Page header image', 'charitious' ),
				'help'	 => esc_html__( "This default header image will be used for all your Service.", 'charitious' ),
				'type'	 => 'upload'
			),
			'service_icon'			 => array(
				'type'	 => 'new-icon',
				'label'	 => esc_html__( 'Side Icon', 'charitious' ),
				'value'	 => esc_html__( 'icon icon-pie-chart2', 'charitious' ),
			),
		),
	),
);
