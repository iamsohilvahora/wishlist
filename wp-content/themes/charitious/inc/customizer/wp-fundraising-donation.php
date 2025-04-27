<?php


$fields[] = array(
    'type'        => 'image',
    'settings'    => 'wp_fundraising_banner',
    'label'       => esc_html__( 'Banner Image', 'charitious' ),
    'section'     => 'wp_fundraising_section',
    'default'     => '',
);
$fields[] = array(
    'type'        => 'color',
    'settings'    => 'wp_fundraising_banner_overly',
    'label'       => __( 'Banner Overly Color', 'charitious' ),
    'section'     => 'wp_fundraising_section',
    'default'     => '',
    'choices'     => [
        'alpha' => true,
    ],
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'wp_fund_raised',
    'label'       => esc_html__( 'Fund Raised', 'charitious' ),
    'section'     => 'wp_fundraising_section',
    'transport'   => 'auto',
    'js_vars'     => array(
        array(
            'element'  => '.xs-after-goel span',
            'function' => 'html'
        ),
    ),
    'default'     => 'Fund Raised',
);
$fields[]= array(
    'type'        => 'text',
    'settings'    => 'wp_fund_backers',
    'label'       => esc_html__( 'Backers', 'charitious' ),
    'section'     => 'wp_fundraising_section',
    'transport'   => 'auto',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-footer-bottom .charitious-copyright-text p',
            'function' => 'html'
        ),
    ),
    'default'     => 'Backers',
);

$fields[]= array(
    'type'        => 'text',
    'settings'    => 'wp_fund_buttn_label',
    'label'       => esc_html__( 'Button label', 'charitious' ),
    'section'     => 'wp_fundraising_section',
    'transport'   => 'auto',
    'js_vars'     => array(
        array(
            'element'  => '.charitious-footer-bottom .charitious-copyright-text p',
            'function' => 'html'
        ),
    ),
    'default'     => 'Continue',
);