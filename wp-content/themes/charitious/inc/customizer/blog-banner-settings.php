<?php 
$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'blog_show_breadcrumb',
    'label'       => esc_html__( 'Show Breadcrumb', 'charitious' ),
    'section'     => 'blog_banner_section',
    'default'     => false,
    'choices'     => array(
        true  => esc_attr__( 'Enable', 'charitious' ),
        false => esc_attr__( 'Disable', 'charitious' ),
    ),
);

$fields[] = array(
        'type'        => 'image',
        'settings'    => 'blog_banner_img',
        'label'       => esc_html__( 'Banner Image', 'charitious' ),
        'section'     => 'blog_banner_section',
        'default'     => '',
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'blog_banner_title',
    'label'       => esc_html__( 'Blog Banner Title', 'charitious' ),
    'section'     => 'blog_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-blog h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'blog_banner_subtitle',
    'label'       => esc_html__( 'Banner Sub Title', 'charitious' ),
    'section'     => 'blog_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-blog h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);


 
$fields[] = array(
        'type'        => 'image',
        'settings'    => 'single_banner_img',
        'label'       => esc_html__( 'Blog Details Banner Image', 'charitious' ),
        'section'     => 'blog_banner_section',
        'default'     => '',
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'single_banner_title',
    'label'       => esc_html__( 'Blog Details Banner Title', 'charitious' ),
    'section'     => 'blog_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-blog h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'single_banner_subtitle',
    'label'       => esc_html__( 'Blog Details Banner Sub Title', 'charitious' ),
    'section'     => 'blog_banner_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-blog h2',
            'function' => 'html'
        ),
    ),
    'default'     => '',
);
