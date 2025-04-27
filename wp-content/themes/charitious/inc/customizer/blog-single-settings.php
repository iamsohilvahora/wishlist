<?php
$fields[] = array(
    'type'        => 'select',
    'settings'    => 'blog_single_sidebar',
    'label'       => esc_html__( 'Blog Sidebar Position', 'charitious' ),
    'section'     => 'blog_single_section',
    'default'     => '3',
    'choices'     => array(
      '1'      => esc_attr__('Full Width','charitious'),
      '2'      => esc_attr__('Left Sidebar','charitious'),
      '3'      => esc_attr__('Right Sidebar','charitious'),
    ),
);

$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'show_social',
    'label'       => esc_html__( 'Show Social', 'charitious' ),
    'section'     => 'blog_single_section',
    'default'     => '',
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'charitious' ),
        'off' => esc_attr__( 'Disable', 'charitious' ),
    ),
);

$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'show_related',
    'label'       => esc_html__( 'Show Related Posts', 'charitious' ),
    'section'     => 'blog_single_section',
    'default'     => '1',
    'choices'     => array(
        'on'  => esc_attr__( 'Enable', 'charitious' ),
        'off' => esc_attr__( 'Disable', 'charitious' ),
    ),
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'related_title',
    'label'       => esc_html__( 'Related Section Title', 'charitious' ),
    'section'     => 'blog_single_section',
    'transport'   => 'auto',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-footer-bottom .charitious-copyright-text p',
            'function' => 'html'
        ),
    ),
    'default'     => esc_html__( 'From the Journal', 'charitious' ),
);