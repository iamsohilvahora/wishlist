<?php
$fields[] = array(
    'type'        => 'select',
    'settings'    => 'shop_sidebar',
    'label'       => esc_html__( 'Shop Sidebar Position', 'charitious' ),
    'section'     => 'shop_section',
    'default'     => '1',
    'choices'     => array(
        '1'      => esc_html__('Full Width','charitious'),
        '2'      => esc_html__('Left Sidebar','charitious'),
        '3'      => esc_html__('Right Sidebar','charitious'),
    ),
);
$fields[] = array(
    'type'        => 'select',
    'settings'    => 'shop_grid_column',
    'label'       => esc_html__( 'Grid Per Row', 'charitious' ),
    'section'     => 'shop_section',
    'default'     => '4',
    'choices'     => array(
        '6'     => esc_html__( '2 Column', 'charitious' ),
        '4'     => esc_html__( '3 Column', 'charitious' ),
    ),
    'required'      => array(
        array(
            'setting'   => 'shop_sidebar',
            'operator'  => '==',
            'value'     => 1
        )
    ),
);
$fields[] = array(
    'type'        => 'image',
    'settings'    => 'shop_header_image',
    'label'       => esc_html__( 'Banner Image', 'charitious' ),
    'section'     => 'shop_section',
    'default'     => '',
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'shop_heading_title',
    'label'       => esc_html__( 'Heading Title', 'charitious' ),
    'section'     => 'shop_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.shop-title',
            'function' => 'html'
        ),
    ),
    'default'     => esc_html__( 'Shopping Now', 'charitious' ),
);
