<?php

$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'show_footer_widget',
    'label'       =>esc_html__( 'Show Footer Widget', 'charitious' ),
    'section'     => 'footer_section',
    'default'     => false,
    'choices'     => array(
        true  => esc_attr__( 'Show', 'charitious' ),
        false => esc_attr__( 'Hide', 'charitious' ),
    ),
);

$fields[] = array(
    'type'        => 'select',
    'settings'    => 'footer_style',
    'label'       => esc_html__( 'Footer style', 'charitious' ),
    'section'     => 'footer_section',
    'default'     => '4',
    'choices'     => array(
        '3' => esc_attr__( '1', 'charitious' ),
        '4' => esc_attr__( '2', 'charitious' ),
    ),
    'required'      => array(
        array(
            'setting'   => 'show_footer_widget',
            'operator'  => '==',
            'value'     => true
        )
    ),
);

$fields[] = array(
    'type'        => 'select',
    'settings'    => 'footer_widget_layout',
    'label'       => esc_html__( 'Number of Footer Widgets', 'charitious' ),
    'section'     => 'footer_section',
    'default'     => '4',
    'choices'     => array(
        '1' => esc_attr__( '1', 'charitious' ),
        '2' => esc_attr__( '2', 'charitious' ),
        '3' => esc_attr__( '3', 'charitious' ),
        '4' => esc_attr__( '4', 'charitious' ),
        '5' => esc_attr__( '5', 'charitious' ),
        '6' => esc_attr__( '6', 'charitious' ),
    ),
    'required'      => array(
        array(
            'setting'   => 'show_footer_widget',
            'operator'  => '==',
            'value'     => true
        )
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'footer_bg_color',
    'label'       => esc_html__( 'Background Color', 'charitious' ),
    'section'     => 'footer_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.xs-footer-section',
            'property'	=> 'background-color',
        ),
    ),
);

$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'hide_footer_bg_map',
    'label'       =>esc_html__( 'Hide Background Map', 'charitious' ),
    'section'     => 'footer_section',
    'default'     => true,
    'choices'     => array(
        true  => esc_attr__( 'Show', 'charitious' ),
        false => esc_attr__( 'Hide', 'charitious' ),
    ),
);
$fields[] = array(
    'type'        => 'color',
    'settings'    => 'widget_title_color',
    'label'       => esc_html__( 'Widget Title Color', 'charitious' ),
    'section'     => 'footer_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.footer-widget .widget-title',
            'property'	=> 'color',
        ),
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'footer_text_color',
    'label'       => esc_html__( 'Footer text color', 'charitious' ),
    'section'     => 'footer_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.footer-widget .xs-info-list .media-body',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-recent-post-widget .post-info .entry-title a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-widget p',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-copyright-text p',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .footer-widget p',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .xs-copyright-text p',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .xs-info-list li',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .xs-info-list a',
            'property'	=> 'color',
        ),
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'footer_link_color',
    'label'       => esc_html__( 'Footer link color', 'charitious' ),
    'section'     => 'footer_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.footer-widget .menu a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-footer-menu li a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .xs-footer-list a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .menu a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .xs-footer-menu li a',
            'property'	=> 'color',
        ),
    ),
);
$fields[] = array(
    'type'        => 'color',
    'settings'    => 'footer_link_hovercolor',
    'label'       => esc_html__( 'Footer link Hover color', 'charitious' ),
    'section'     => 'footer_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.footer-widget .menu a:hover',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-footer-menu li a:hover',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .xs-footer-list a:hover',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .menu a:hover',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.footer-v3 .xs-footer-menu li a:hover',
            'property'	=> 'color',
        ),
    ),
);

$fields[] = array(
    'type'        => 'custom',
    'settings' => 'custom_title_transparent',
    'label'       => '',
    'section'     => 'footer_section',
    'default'     => '<div class="xs-title-divider">'.esc_html__("Copyright Section","charitious").'</div>',
);


$fields[]= array(
    'type'        => 'textarea',
    'settings'    => 'copyright_text',
    'label'       => esc_html__( 'Copyright text', 'charitious' ),
    'section'     => 'footer_section',
    'transport'   => 'postMessage',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-footer-bottom .charitious-copyright-text p',
            'function' => 'html'
        ),
    ),
    'default'     => esc_html__( 'Copyrights By Xpeedstudio - 2021', 'charitious' ),
);