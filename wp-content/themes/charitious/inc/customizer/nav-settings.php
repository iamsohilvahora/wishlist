<?php
$fields[]= array(
    'type'        => 'radio-image',
    'settings'    => 'header_layout',
    'label'       => esc_html__( 'Header Layout', 'charitious' ),
    'section'     => 'nav_section',
    'default'     => '1',
    'choices'     => array(
        '1'   => get_template_directory_uri() . '/assets/images/header/header_1.png',
        '2' => get_template_directory_uri() . '/assets/images/header/header_2.png',
        '3' => get_template_directory_uri() . '/assets/images/header/header_3.png',
        '4' => get_template_directory_uri() . '/assets/images/header/header_4.png',
    ),
);

$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'show_topbar',
    'label'       => esc_html__( 'Show Top Bar', 'charitious' ),
    'section'     => 'nav_section',
    'default'     => false,
    'choices'     => array(
        true  => esc_attr__( 'Enable', 'charitious' ),
        false => esc_attr__( 'Disable', 'charitious' ),
    ),
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'top_bar_email',
    'label'       =>esc_html__( 'Top Bar Email', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'default'     => esc_html__( 'infp@example.com', 'charitious' ),
    'required'      => array(
        array(
            'setting'   => 'show_topbar',
            'operator'  => '==',
            'value'     => true,
        ),
    ),
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'top_bar_email_icon',
    'label'       =>esc_html__( 'Top Bar Email Icon', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'default'     => esc_attr( 'icon icon-envelope'),
    'required'      => array(
        array(
            'setting'   => 'show_topbar',
            'operator'  => '==',
            'value'     => true,
        ),
    ),
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'top_bar_phone',
    'label'       =>esc_html__( 'Top Bar Phone', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'default'     => '',
    'required'      => array(
        array(
            'setting'   => 'show_topbar',
            'operator'  => '==',
            'value'     => true,
        ),
    ),
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'top_bar_phone_icon',
    'label'       =>esc_html__( 'Top Bar Phone Icon', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'default'     => esc_attr( 'icon icon-phone-call'),
    'required'      => array(
        array(
            'setting'   => 'show_topbar',
            'operator'  => '==',
            'value'     => true,
        ),
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'nav_top_color',
    'label'       => esc_html__( 'Topbar Color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'required'      => array(
        array(
            'setting'   => 'show_topbar',
            'operator'  => '==',
            'value'     => true,
        ),
    ),
    'output'      => array(
        array(
            'element' 	=> '.xs-top-bar',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-top-bar-info li a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-social-list li a',
            'property'	=> 'color',
        ),
    ),
);
$fields[] = array(
    'type'        => 'color',
    'settings'    => 'nav_top_bg_color',
    'label'       => esc_html__( 'Topbar Background Color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'required'      => array(
        array(
            'setting'   => 'show_topbar',
            'operator'  => '==',
            'value'     => true,
        ),
    ),
    'output'      => array(
        array(
            'element' 	=> '.xs-top-bar.top-bar-second',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-box .xs-top-bar',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-top-bar.top-bar-second::before',
            'property'	=> 'border-right-color',
        ),
        array(
            'element' 	=> '.xs-top-bar.top-bar-second:after',
            'property'	=> 'border-left-color',
        ),
        array(
            'element' 	=> '.xs-top-bar.top-bar-second:before, .xs-top-bar.top-bar-second:after',
            'property'	=> 'border-top-color',
        ),
    ),
);


$fields[] = array(
    'type'        => 'color',
    'settings'    => 'menu_color',
    'label'       => esc_html__( 'Menu Color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.xs-menus .nav-menu > li > a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-single-wishList',
            'property'	=> 'color',
        ),
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'menu_hover_color',
    'label'       => esc_html__( 'Menu Hover Color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.xs-menus .nav-menu > li > a:hover',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-single-wishList:hover',
            'property'	=> 'color',
        ),
    ),
);
$fields[] = array(
    'type'        => 'color',
    'settings'    => 'sub_menu_color',
    'label'       => esc_html__( 'Sub Menu Color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.xs-menus .nav-menu > :not(.megamenu) .nav-dropdown li a',
            'property'	=> 'color',
        ),
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'sub_menu_hover_color',
    'label'       => esc_html__( 'Sub Menu Hover Color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.xs-menus .nav-menu > :not(.megamenu) .nav-dropdown li a:hover',
            'property'	=> 'color',
        ),
    ),
);

$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'show_donate_btn',
    'label'       => esc_html__( 'Show Donate Button', 'charitious' ),
    'section'     => 'nav_section',
    'default'     => false,
    'choices'     => array(
        true  => esc_attr__( 'Show', 'charitious' ),
        false => esc_attr__( 'Hide', 'charitious' ),
    ),
);

$fields[] = array(
    'type'        => 'text',
    'settings'    => 'donate_button_text',
    'default'     => esc_html__('Donate Now','charitious'),
    'label'       => esc_html__( 'Donate button text', 'charitious' ),
    'section'     => 'nav_section',
);
$fields[] = array(
    'type'        => 'text',
    'settings'    => 'donate_button_link',
    'label'       => esc_html__( 'Donate button link', 'charitious' ),
    'section'     => 'nav_section',
);
$fields[]= array(
    'type'        => 'switch',
    'settings'    => 'show_search_icon',
    'label'       => esc_html__( 'Show Menu search', 'charitious' ),
    'section'     => 'nav_section',
    'default'     => false,
    'choices'     => array(
        true  => esc_attr__( 'Show', 'charitious' ),
        false => esc_attr__( 'Hide', 'charitious' ),
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'search_icon_color',
    'label'       => esc_html__( 'Search Icon color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.navSearch-group > a',
            'property'	=> 'color',
        ),
    ),
);
$fields[] = array(
    'type'        => 'color',
    'settings'    => 'search_icon_bg_color',
    'label'       => esc_html__( 'Search Icon Background color', 'charitious' ),
    'section'     => 'nav_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.navSearch-group > a',
            'property'	=> 'background-color',
        ),
    ),
);