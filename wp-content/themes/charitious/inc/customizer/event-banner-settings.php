<?php 
$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'event_show_breadcrumb',
    'label'       => esc_html__( 'Show Breadcrumb', 'charitious' ),
    'section'     => 'event_banner_section',
    'default'     => false,
    'choices'     => array(
        true  => esc_attr__( 'Enable', 'charitious' ),
        false => esc_attr__( 'Disable', 'charitious' ),
    ),
);

$fields[] = array(
        'type'        => 'image',
        'settings'    => 'event_banner_img',
        'label'       => esc_html__( 'Banner Image', 'charitious' ),
        'section'     => 'event_banner_section',
        'default'     => '', 
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'event_banner_title',
    'label'       => esc_html__( 'Event Banner Title', 'charitious' ),
    'section'     => 'event_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-event h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'event_banner_subtitle',
    'label'       => esc_html__( 'Banner Sub Title', 'charitious' ),
    'section'     => 'event_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-event h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);