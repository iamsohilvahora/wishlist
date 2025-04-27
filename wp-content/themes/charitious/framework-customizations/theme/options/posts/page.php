<?php

if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}
include_once get_template_directory() . '/inc/includes/demo-page-meta.php';
$options = array(
	'_page_meta' => array(
		'title'		 => __( 'Page Settings', 'charitious' ),
		'type'		 => 'box',
		'priority'	 => 'high',
		'options'	 => array(
			'show_breadcrumb'	 => array(
                'type'  => 'switch',
                'value' => false,
                'label' => __('Show Breadcrumb', 'charitious'),
                'left-choice' => array(
                    'value' => false,
                    'label' => __('Hide', 'charitious'),
                ),
                'right-choice' => array(
                    'value' => true,
                    'label' => __('Show', 'charitious'),
                ),
            ),
			'header_title'	 => array(
				'type'	 => 'text',
				'label'	 => esc_html__( 'Banner title', 'charitious' ),
				'desc'	 => esc_html__( 'Add your Page hero title', 'charitious' ),
			),
			'header_subtitle'	 => array(
				'type'	 => 'text',
				'label'	 => esc_html__( 'Banner subtitle', 'charitious' ),
				'desc'	 => esc_html__( 'Add your Page hero subtitle', 'charitious' ),
			),
			'header_image'	 => array(
				'label'	 => esc_html__( ' Banner Image', 'charitious' ),
				'desc'	 => esc_html__( 'Upload a Page header image', 'charitious' ),
				'help'	 => esc_html__( "This default header image.", 'charitious' ),
				'type'	 => 'upload'
			),
		),
	),
);
$options['_page_meta']['options'] = array_merge($options['_page_meta']['options'], get_meta_page_feild(true));