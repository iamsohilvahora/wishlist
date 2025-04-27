<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Slider_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-slider';
    }

    public function get_title() {
        return __( 'Charitious Slider', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' => __('Charitious Slider', 'charitious'),
            ]
        );


        //add repeater 

        $this->add_control(

            'style', 
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Style', 'charitious'),
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1', 'charitious'),
                    'style2' => __('Style 2', 'charitious'),
                    'style3' => __('Style 3', 'charitious'),
                    'style4' => __('Style 4', 'charitious'),
                    'style5' => __('Style 5', 'charitious'),
                ],
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => __( 'Container Width', 'charitious' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['%' ],
                'selectors' => [
                    '{{WRAPPER}} .charitious-welcome-container' => 'width: {{SIZE}}%;',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'charitious'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'welcome_logo',
            [
                'label' => __('Welcome Logo', 'charitious'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'default'   => __('Add Title', 'charitious'),
            ]
        );

        $repeater->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'charitious'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'charitious'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'btn_label_one',
            [
                'label' => __('Button Label', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   => __('VIEW COLLECTION', 'charitious'),
            ]
        );
        
        $repeater->add_control(
            'btn_link_one',
            [
                'label' => __( 'Link', 'charitious' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __('http://your-link.com','charitious' ),
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_control(
            'btn_label_two',
            [
                'label' => __('Button Label', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   => __('CATEGORIES', 'charitious'),
            ]
        );

        $repeater->add_control(
            'btn_link_two',
            [
                'label' => __( 'Link', 'charitious' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __('http://your-link.com','charitious' ),
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_control(
            'text_align',
            [
                'label' => __( 'Text Align', 'charitious' ),
                'type' => Controls_Manager::SELECT,
                'default'   => 'mx-auto',
                'options' => [
                    'mx-auto' => __('Center', 'charitious'),
                    '' => __('Left', 'charitious'),
                ],
            ]      
        );

        $this->add_control(
            'sliders',
            [
                'type'   => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),

                'default' => [
                    [
                        'title' => __('Add Title', 'charitious'),
                        'sub_title' => __('Add Sub Title', 'charitious'),
                        'description' => __('Allow our team of beauty specialists to help you prepare for your wedding and enhance your special.', 'charitious'),
                        'btn_label_one' => __('Learn More', 'charitious'),
                        'btn_label_two' => __('Learn More', 'charitious'),
                        'text_align' => 'mx-auto',
                    ],

                    [
                        'title' => __('Add Title', 'charitious'),
                        'sub_title' => __('Add Sub Title', 'charitious'),
                        'description' => __('Allow our team of beauty specialists to help you prepare for your wedding and enhance your special.', 'charitious'),
                        'btn_label_one' => __('Learn More', 'charitious'),
                        'btn_label_two' => __('Learn More', 'charitious'),
                        'text_align' => 'mx-auto',
                        
                    ],

                    [
                        'title' => __('Add Title', 'charitious'),
                        'sub_title' => __('Add Sub Title', 'charitious'),
                        'description' => __('Allow our team of beauty specialists to help you prepare for your wedding and enhance your special.', 'charitious'),
                        'btn_label_one' => __('Learn More', 'charitious'),
                        'btn_label_two' => __('Learn More', 'charitious'),
                        'text_align' => 'mx-auto',
                        
                    ],
                ],

                'title_field' => '{{{ title }}}',
                'condition' => [
                    'style'   =>  ['style1','style2','style3','style4', 'style5'],
                ],
            ]
        );

        $this->add_control(
          'images',
          [
            'label'         => esc_html__( 'Images', 'charitious' ),
            'type'          => Controls_Manager::GALLERY,
            'condition'     =>  [
                'style' =>  ['style3']
            ],
        ]
    );

        $this->end_controls_section();

        //Title Style

        $this->start_controls_section(
            'section_title_style',
            [
                'label'     => __( 'Title', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .charitious-welcome-wraper h2' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .xs-welcome-wraper h2' => 'color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Typography', 'charitious' ),
                'selector' => '{{WRAPPER}} .xs-welcome-wraper h2',
            ]
        );

        $this->add_control(
            'margin_bottom',
            [
                'label' => __( 'Margin Bottom', 'charitious' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .xs-welcome-wraper h2' => 'margin-bottom: {{SIZE}}px;',
                ],
                'condition' => [
                    'style'   =>  ['style1'],
                ],
            ]
        );

        $this->add_control(
            'bg_main_color',
            [
                'label'     => __( 'Background Color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .owl-stage-outer:before' => '    background-color: {{VALUE}};',
                ],
                'condition' => [
                    'style' => ['style3']
                ],
            ]
        );

        $this->end_controls_section();

        //Sub Title Style

        $this->start_controls_section(
            'section_sub_style',
            [
                'label'     => __( 'Sub Title', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label' => __( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-welcome-wraper h3' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .charitious-welcome-wraper h3' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .xs-welcome-wraper .xs-sub-title' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .xs-welcome-wraper .xs-slider-subtitle' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'label' => __( 'Typography', 'charitious' ),
                'selector' => '{{WRAPPER}} .charitious-welcome-wraper h3, {{WRAPPER}} .charitious-welcome-wraper h3, {{WRAPPER}} .xs-welcome-wraper .xs-sub-title, {{WRAPPER}} .xs-welcome-wraper .xs-slider-subtitle',
            ]
        );

        $this->end_controls_section();

        //Decription Style

        $this->start_controls_section(
            'section_desc_style',
            [
                'label'     => __( 'Description', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => __( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .charitious-welcome-wraper p' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .xs-slider-description' => 'color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => __( 'Typography', 'charitious' ),
                'selector' => '{{WRAPPER}} .charitious-welcome-wraper p, {{WRAPPER}} .xs-welcome-wraper p',
            ]
        );

        $this->end_controls_section();

        //Button Style One
        $this->start_controls_section(
            'section_btn_style',
            [
                'label'     => __( 'Button One', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => __( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-danger' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-primary' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_hover_color',
            [
                'label' => __( 'Hover Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-danger:hover' => 'color: {{VALUE}}!important;',
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-primary' => 'color: {{VALUE}}!important;',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => __( 'Background Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                 '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-danger' => 'background-color: {{VALUE}} !important;',
                 '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-primary' => 'background-color: {{VALUE}} !important;',
             ],
         ]
     );
        $this->add_control(
            'btn_bg_hover_color',
            [
                'label' => __( 'Background Hover Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                  '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-danger:hover:before' => 'background-color: {{VALUE}} !important;',
                  '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-danger:hover:after' => 'background-color: {{VALUE}} !important;',
                  '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-primary:hover:after' => 'background-color: {{VALUE}} !important;',
                  '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-primary:hover:before' => 'background-color: {{VALUE}} !important;',
              ],
          ]
      );
        $this->add_control(
            'btn_bg_outline_color',
            [
                'label' => __( 'Border Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-primary' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'btn_bg_outline_hover_color',
            [
                'label' => __( 'Border Hover Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-primary:hover' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

         //Button Style Two
        $this->start_controls_section(
            'section_btn_two_style',
            [
                'label'     => __( 'Button Two', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btn_two_color',
            [
                'label' => __( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-danger ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-primary ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_two_hover_color',
            [
                'label' => __( 'Hover Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-danger:hover' => 'color: {{VALUE}}!important;',
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-primary:hover' => 'color: {{VALUE}}!important;',
                ],
            ]
        );

        $this->add_control(
            'btn_two_bg_color',
            [
                'label' => __( 'Background Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                 '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-danger' => 'background-color: {{VALUE}} !important;',
                 '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-primary' => 'background-color: {{VALUE}} !important;',
             ],
         ]
     );
        $this->add_control(
            'btn_two_bg_hover_color',
            [
                'label' => __( 'Background Hover Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-outline-danger:hover, {{WRAPPER}} .xs-banner-slider .active .xs-welcome-wraper .xs-btn-wraper a:last-child:hover:before, {{WRAPPER}} .xs-banner-slider .active .xs-welcome-wraper .xs-btn-wraper a:last-child:hover:after' => 'background-color: {{VALUE}} !important; border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .xs-banner-slider .xs-welcome-wraper .xs-btn-wraper .btn-primary:hover, {{WRAPPER}} .xs-banner-slider .active .xs-welcome-wraper .xs-btn-wraper a:last-child:hover:before, {{WRAPPER}} .xs-banner-slider .active .xs-welcome-wraper .xs-btn-wraper a:last-child:hover:after' => 'background-color: {{VALUE}} !important; border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        //Title Style

        $this->start_controls_section(
            'section_overlay_style',
            [
                'label'     => __( 'Overlay', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'slider_overlay_color',
            [
                'label'     => __( 'Overlay Color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .charitious-black-gradient-overlay:before' => 'background-image: -webkit-linear-gradient( 175deg, rgba(236,85,152,0) 0%, {{VALUE}} 24%, {{VALUE}} 46%, {{VALUE}} 100%)',
                    '{{WRAPPER}} .xs-black-overlay' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_array_color',
            [
                'label'     => __( 'Arrows', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'style_tabs'
        );
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => __( 'Normal', 'charitious' ),
            ]
        );
        $this->add_control(
            'slider_arrow_color',
            [
                'label'     => __( 'Arrow Color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xs-round-nav' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'array_background_color',
                'label' => __( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .xs-round-nav',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => __( 'Hover', 'charitious' ),
            ]
        );

        $this->add_control(
            'slider_arrow_color_hv',
            [
                'label'     => __( 'Arrow Color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xs-round-nav:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'array_background_color_hv',
                'label' => __( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .xs-round-nav:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'slider_content_margin',
            [
                'label'     => __( 'Content Margin', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'margin',
            [
                'label' => __( 'Margin', 'charitious' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .xs-welcome-wraper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings();

        $sliders = $settings['sliders'];

        $images = $settings['images'];

        $style = $settings['style'];
        

        switch ($style) {
            case 'style1':
            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/slider/style1.php';
            break;
            
            case 'style2':
            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/slider/style2.php';
            break;

            case 'style3':
            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/slider/style3.php';
            break;

            case 'style4':
            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/slider/style4.php';
            break;
            
            case 'style5':
            require CHARITIOUS_SHORTCODE_DIR_STYLE . '/slider/style5.php';
            break;
            
        }

    }

    protected function content_template() { }
}
?>