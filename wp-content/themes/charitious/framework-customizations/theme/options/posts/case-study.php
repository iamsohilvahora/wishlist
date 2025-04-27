<?php if ( !defined( 'FW' ) ) { die( 'Forbidden' ); }

$options = array(
	'normal' => array(
		'title'		 => __( 'Extra Case Study Settings', 'charitious' ),
		'type'		 => 'box',
		'priority'	 => 'default',
		'options'	 => array(
			'header_title'	 => array(
				'type'	 => 'textarea',
				'label'	 => esc_html__( 'Banner title', 'charitious' ),
				'desc'	 => esc_html__( 'Add your Service hero title', 'charitious' ),
			),
			'header_image'	 => array(
				'label'	 => esc_html__( ' Banner Image', 'charitious' ),
				'desc'	 => esc_html__( 'Upload a Page header image', 'charitious' ),
				'help'	 => esc_html__( "This default header image will be used for all your Service.", 'charitious' ),
				'type'	 => 'upload'
			),
		
		),
	),
	'side' => array(
		'title'		 => __( 'Page Settings', 'charitious' ),
		'type'		 => 'box',
		'priority'	 => 'default',
		'options'	 => array(
			'header_title'	 => array(
				'type'	 => 'text',
				'label'	 => esc_html__( 'Banner title', 'charitious' ),
				'desc'	 => esc_html__( 'Add your Service hero title', 'charitious' ),
			),
			'header_image'	 => array(
				'label'	 => esc_html__( ' Banner Image', 'charitious' ),
				'desc'	 => esc_html__( 'Upload a Page header image', 'charitious' ),
				'help'	 => esc_html__( "This default header image will be used for all your Service.", 'charitious' ),
				'type'	 => 'upload'
			),
		
		),
	),

);
