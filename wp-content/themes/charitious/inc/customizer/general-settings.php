<?php
$fields[] = array(
	'type'        => 'image',
	'settings'    => 'site_logo',
	'label'       => esc_html__( 'Logo', 'charitious' ),
    'section'     => 'general_section',
);
$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'show_preloader',
    'label'       => esc_html__( 'Show Preloader', 'charitious' ),
    'section'     => 'general_section',
    'default'     => '',
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'charitious' ),
        'off' => esc_attr__( 'Disable', 'charitious' ),
    ),
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'map_api',
    'label'       => esc_html__( 'Google Map API Key', 'charitious' ),
    'section'     => 'general_section',

    'default'     =>  'AIzaSyCy7becgYuLwns3uumNm6WdBYkBpLfy44k',
    'description'        =>  '<a href="https://support.xpeedstudio.com/knowledgebase/how-to-create-map-api-key/" target="_blank">How to get API Key</a>'
);

$fields[] = array(

    'type'        => 'repeater',
    'label'       => esc_attr__( 'Social Control', 'charitious' ),
    'section'     => 'general_section',
    'priority'    => 10,
    'row_label' => array(
        'type' => 'text',
        'value' => esc_attr__('Social Profile', 'charitious' ),
    ),
    'settings'    => 'social_links',
    'default'     => array(
        array(
            'social_icon' => '',
            'social_url'  => '',
        ),
    ),
    'fields' => array(
        'social_icon' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Social Icon', 'charitious' ),
            'default'     => '',
        ),
        'social_url' => array(
            'type'        => 'text',
            'label'       => esc_attr__( 'Social URL', 'charitious' ),
            'default'     => '',
        ),

    )
);