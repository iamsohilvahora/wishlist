<?php if ( !defined( 'FW' ) ) {	die( 'Forbidden' ); }

$options = array(
	'_post_meta' => array(
		'title'		 => __( 'Post Settings', 'charitious' ),
		'type'		 => 'box',
		'priority'	 => 'high',
		'options'	 => array(
			'header_title'	 => array(
				'type'	 => 'text',
				'label'	 => esc_html__( 'Banner title', 'charitious' ),
				'desc'	 => esc_html__( 'Add your post hero title', 'charitious' ),
			),
			'header_subtitle'	 => array(
				'type'	 => 'text',
				'label'	 => esc_html__( 'Banner sub title', 'charitious' ),
				'desc'	 => esc_html__( 'Add your post hero sub title', 'charitious' ),
			),
			'header_image'	 => array(
				'label'	 => esc_html__( ' Banner Image', 'charitious' ),
				'desc'	 => esc_html__( 'Upload a post header image', 'charitious' ),
				'help'	 => esc_html__( "This default header image will be used for all your post.", 'charitious' ),
				'type'	 => 'upload'
			),
		),
	),
);
