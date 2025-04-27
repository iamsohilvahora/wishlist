<?php

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'primary_color',
    'label'       => esc_html__( 'Primary Color', 'charitious' ),
    'section'     => 'styling_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '#preloader',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-top-bar .btn.btn-info',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-single-event .xs-event-content .btn',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.box-header .nav-menu > li > a::before',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.box-header .nav-menu > li > a::before, .box-header .nav-menu > li > a::after',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.navSearch-group > a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.nav-menus-wrapper .xs-btn-wraper .btn-primary',
            'property'	=> 'background-color',
        ),
        array(       
            'element' 	=> '.xs-header .nav-menu .nav-submenu li.current-menu-item > a::before, .xs-header .nav-menu .nav-submenu li.current-menu-item > a::after',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.xs-header .nav-menu li.current-menu-item > a::before',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.xs-round-nav',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.journal-v2 .entry-meta .date',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.footer-v4 .xs-back-to-top',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-footer-section .xs-newsletter-form [type=submit]',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-footer-section .xs-newsletter-form input:not([type=submit])',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.xs-skill-bar .xs-skill-track, .xs-skill-bar-v2 .xs-skill-track, .xs-skill-bar-v3 .xs-skill-track',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-skill-bar .xs-skill-track p, .xs-skill-bar-v2 .xs-skill-track p, .xs-skill-bar-v3 .xs-skill-track p',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-simple-tag li a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> 'blockquote:before',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-event-content a:not(.btn)',
            'property'	=> 'color',
        ),

        array(
            'element' 	=> '.xs-single-journal .entry-header span a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-event-schedule h5',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-serachForm input[type="submit"]',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.sidebar .widget-title',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.xs-pagination li a:hover, .xs-pagination li a.active',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.post-navigation h3',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.post-navigation i',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.post-navigation span:hover, .post-navigation h3:hover',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-nav-pills li a:hover, .xs-nav-pills li a.active',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.xs-nav-pills li a:hover, .xs-nav-pills li a.active',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.wpcf7-form-control.btn-success',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-square-nav',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-blog-post-comment .comment-respond .comment-form input[type="submit"]',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.footer-v4 .xs-copyright-text p a',
            'property'	=> 'color',
        ),
        
        array(
            'element' 	=> '.xs-copyright-text p a',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-horizontal-tabs .nav-tabs .nav-item .nav-link.active',
            'property'	=> 'border-top-color',
        ),
        array(
            'element' 	=> '.xs-unorder-list.green-icon li:before',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-unorder-list li:before',
            'property'	=> 'color',
        ),
        array(
            'element' 	=> '.xs-breadcumb li',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-serachForm input[type="submit"]',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-header .nav-menu li.current-menu-item > a::before, .xs-header .nav-menu li.current-menu-item > a::after',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.xs-back-to-top',
            'property'	=> 'border-color',
        ),
        array(
            'element' 	=> '.wfp-view .xs-btn.submit-btn, .wfp-view .wfp-tab > li > a::before',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.wfp-view .wfp-tab > li.active > a, .wfp-pledge-count.goal-count, .wfp-view .wfp-tab > li.active > a',
            'property'	=> 'color',
        ),
    ),
);

$fields[] = array(
    'type'        => 'color',
    'settings'    => 'secondary_color',
    'label'       => esc_html__( 'Secondary Color', 'charitious' ),
    'section'     => 'styling_section',
    'transport'   => 'auto',
    'output'      => array(
        array(
            'element' 	=> '.xs-evnet-meta-date',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-countdown-timer.timer-style-2',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.xs-blog-post-details .post-meta-date',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.entry-content blockquote, .xs-countdown-timer-v2 .timer-count',
            'property'	=> 'background-color',
        ),
        array(
            'element' 	=> '.wfp-view .wfp-tab > li > a, .wfp-goal-wraper .wfp-pledge-count, .timer-text',
            'property'	=> 'color',
        ),


    ),
);
$fields[] = array(
    'type'        => 'typography',
    'settings'    => 'body_font',
    'label'       => esc_html__( 'Body Font', 'charitious' ),
    'section'     => 'styling_section',
    'default'     => array(
        'font-family'    => 'Poppins',
        'variant'        => 'regular',
        'font-size'      => '14px',
        'font-weight'      => '400',
        'line-height'    => '1.857',
        'color'          => '#626c84',
        'background-color'          => '#FFFFFF'
    ),
    'output'      => array(
        array(
            'element' => 'body',
        ),
    ),
);
$fields[] = array(
    'type'        => 'typography',
    'settings'    => 'heading_font',
    'label'       => esc_html__( 'Heading Font', 'charitious' ),
    'section'     => 'styling_section',
    'default'     => array(
        'font-family'    => 'Poppins',
        'variant'        => 'regular',
    ),
    'output'      => array(
        array(
            'element' => 'h1',
        ),
        array(
            'element' => 'h2',
        ),
        array(
            'element' => 'h3',
        ),
        array(
            'element' => 'h4',
        ),
        array(
            'element' => 'h5',
        ),
        array(
            'element' => 'h6',
        ),
    ),
);
