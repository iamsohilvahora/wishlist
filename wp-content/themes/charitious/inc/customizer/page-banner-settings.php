<?php
$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'page_show_breadcrumb',
    'label'       => esc_html__( 'Show Breadcrumb', 'charitious' ),
    'section'     => 'page_banner_section',
    'default'     => false,
    'choices'     => array(
        true  => esc_attr__( 'Enable', 'charitious' ),
        false => esc_attr__( 'Disable', 'charitious' ),
    ),
);
 
$fields[] = array(
        'type'        => 'image',
        'settings'    => 'page_banner_img',
        'label'       => esc_html__( 'Banner Image', 'charitious' ),
        'section'     => 'page_banner_section',
        'default'     => '',
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'page_banner_title',
    'label'       => esc_html__( 'Heading Title', 'charitious' ),
    'section'     => 'page_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-bolog h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'page_banner_subtitle',
    'label'       => esc_html__( 'Heading Sub Title', 'charitious' ),
    'section'     => 'page_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-bolog h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);
