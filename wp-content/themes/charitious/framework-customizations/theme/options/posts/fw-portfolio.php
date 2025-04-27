<?php

if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'side' => array(
		'title'		 => __( 'Last Update date', 'charitious' ),
		'type'		 => 'box',
		'priority'	 => 'high',
		'options'	 => array(
			'portfolio_title'	 => array(
				'type'	 => 'text',
				'value'	 => 'About Portfolio',
				'label'	 => false,
				'desc'	 => __( 'Portfolio Title', 'charitious' ),
			),
			'skill_group'		 => array(
				'type'		 => 'group',
				'attr'		 => array( 'class' => 'xs-group xs-posts-options' ),
				'options'	 => array(
					'html_label'	 => array(
						'type'	 => 'html',
						'value'	 => '',
						'label'	 => __( 'Skill', 'charitious' ),
						'html'	 => '',
					),
					'skill_title'	 => array(
						'type'	 => 'text',
						'value'	 => 'Used Skills',
						'label'	 => false,
						'html'	 => '',
						'desc'	 => __( 'Skill Title', 'charitious' ),
					),
					'skill_info'	 => array(
						'type'	 => 'text',
						'value'	 => 'HTML5, CSS3, jQuery, Ruby & Rails',
						'label'	 => false,
						'html'	 => '',
						'desc'	 => __( 'Skill Info', 'charitious' ),
					),
				),
			),
			'clients_group'		 => array(
				'type'		 => 'group',
				'attr'		 => array( 'class' => 'xs-group xs-posts-options' ),
				'options'	 => array(
					'html_label'	 => array(
						'type'	 => 'html',
						'value'	 => '',
						'label'	 => __( 'Clients', 'charitious' ),
						'html'	 => '',
					),
					'clients_title'	 => array(
						'type'	 => 'text',
						'value'	 => 'Clients',
						'label'	 => false,
						'desc'	 => __( 'Clients Title', 'charitious' ),
					),
					'clients_info'	 => array(
						'type'	 => 'text',
						'value'	 => 'BizCraft Incorporatin Ltd.',
						'label'	 => false,
						'desc'	 => __( 'Clients Info', 'charitious' ),
					),
				),
			),
			'button_group'		 => array(
				'type'		 => 'group',
				'attr'		 => array( 'class' => 'xs-group xs-posts-options' ),
				'options'	 => array(
					'html_label'	 => array(
						'type'	 => 'html',
						'value'	 => '',
						'label'	 => __( 'Button', 'charitious' ),
						'html'	 => '',
					),
					'button_title'	 => array(
						'type'	 => 'short-text',
						'value'	 => 'Project Link',
						'label'	 => false,
						'desc'	 => __( 'Text', 'charitious' ),
					),
					'button_link'	 => array(
						'type'	 => 'text',
						'value'	 => '#',
						'label'	 => false,
						'desc'	 => __( 'Link', 'charitious' ),
					),
					'button_target'	 => array(
						'type'			 => 'switch',
						'value'			 => '_self',
						'label'			 => false,
						'desc'			 => __( 'Link Target', 'charitious' ),
						'left-choice'	 => array(
							'value'	 => '_blank',
							'label'	 => __( 'blank', 'charitious' ),
						),
						'right-choice'	 => array(
							'value'	 => '_self',
							'label'	 => __( 'self', 'charitious' ),
						),
					),
				),
			),
		),
	),
);
