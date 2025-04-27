<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_wp_fundraising_donate_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-charitious-donate-button';
    }

    public function get_title() {
        return esc_html__( 'Charitious donate button', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-meetup';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }


    // get query post query
    public function get_post(){

        $args['post_status'] = 	'publish';
        $args['post_type'] = \WfpFundraising\Apps\Content::post_type();
        $args['meta_query'] = [
            'relation' => 'AND',
            array(
                'key' => 'wfp_founding_form_format_type',
                'value' => 'donation',
                'compare' => '='
            ),
        ];

        $posts = get_posts($args);
        $options = [];
        $count = count($posts);
        if($count > 0):
            foreach ($posts as $post) {
                $options[$post->ID] = $post->post_title;
            }
        endif;

        return $options;
    }

    protected function register_controls() {

        // content of listing
        $this->start_controls_section(
            'wfp_fundraising_donate_content',
            array(
                'label' => esc_html__( 'Content', 'charitious' ),
            )
        );

        // headding query option
        $this->add_control(
            'wfp_fundraising_donate_content__query_options',
            [
                'label' => __( 'Query Options', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'wfp_fundraising_donate_content__select_post',
            [
                'label' => __( 'Select Donate', 'charitious' ),
                'type' => Controls_Manager::SELECT,
                'multiple' => false,
                'options' => $this->get_post(),
                'default' =>  0,
            ]
        );

        // headding query option
        $this->add_control(
            'wfp_fundraising_donate_content__display_options',
            [
                'label' => __( 'Display Options', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'wfp_fundraising_donate_content__form_style',
            [
                'label' => esc_html__( 'From Style', 'charitious' ),
                'type' =>  Controls_Manager::SELECT,
                'default' => 'only_button',
                'options' => [
                    'all_fields'  => esc_html__( 'All Fields', 'charitious' ),
                    'only_button' => esc_html__( 'Only Button', 'charitious' ),
                ],

            ]
        );
        $this->add_control(
            'wfp_fundraising_donate_content__modal_status',
            [
                'label' => esc_html__( 'Show Modal', 'charitious' ),
                'type' =>  Controls_Manager::SELECT,
                'default' => 'Yes',
                'options' => [
                    'Yes'  => esc_html__( 'Yes', 'charitious' ),
                    'No' => esc_html__( 'No', 'charitious' ),
                ],
                'condition' => ['wfp_fundraising_donate_content__form_style' => 'only_button'],
            ]
        );

        $this->add_control(
            'wfp_fundraising_content_donate__title_enable',
            [
                'label' => esc_html__( 'Show Title', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'charitious' ),
                'label_off' => esc_html__( 'Hide', 'charitious' ),
                'return_value' => 'Yes',
                'default' => 'Yes',
            ]
        );

        $this->add_control(
            'wfp_fundraising_content_donate__featured_enable',
            [
                'label' => esc_html__( 'Show Featured', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'charitious' ),
                'label_off' => esc_html__( 'Hide', 'charitious' ),
                'return_value' => 'Yes',
                'default' => 'Yes',
            ]
        );
        $this->add_control(
            'wfp_fundraising_content_donate__category_enable',
            [
                'label' => esc_html__( 'Show Category', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'charitious' ),
                'label_off' => esc_html__( 'Hide', 'charitious' ),
                'return_value' => 'Yes',
                'default' => 'Yes',
            ]
        );

        $this->add_control(
            'wfp_fundraising_content_donate__goal_enable',
            [
                'label' => esc_html__( 'Show Goal', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'charitious' ),
                'label_off' => esc_html__( 'Hide', 'charitious' ),
                'return_value' => 'Yes',
                'default' => 'Yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'wfp_fundraising_style_donate_title',
            array(
                'label' => esc_html__( 'Title', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content_donate__title_enable' => 'Yes'],
            )
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_title__typography',
                'selector'   => '{{WRAPPER}} .wfdp-donation-form  .wfp-post-title',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_donate_title__color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .wfp-post-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        // text shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_donate_title__box_shadow',
                'selector'  => '{{WRAPPER}} .wfdp-donation-form  .wfp-post-title',
            ]
        );

        $this->end_controls_section();

        // style of categories
        $this->start_controls_section(
            'wfp_fundraising_style_donate_categories',
            array(
                'label' => esc_html__( 'Categories ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content_donate__category_enable' => 'Yes'],
            )
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_categories__typography',
                'selector'   => '{{WRAPPER}} .wfdp-donation-form  .wfp-header-cat .wfp-header-cat--link',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_donate_categories__color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .wfp-header-cat .wfp-header-cat--link' => 'color: {{VALUE}}',
                ],
            ]
        );
        // text shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_donate_categories__box_shadow',
                'selector'  => '{{WRAPPER}} .wfdp-donation-form  .wfp-header-cat .wfp-header-cat--link',
            ]
        );

        $this->end_controls_section();


        // style of Goal
        $this->start_controls_section(
            'wfp_fundraising_style_donate_goal',
            array(
                'label' => esc_html__( 'Goal ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content_donate__goal_enable' => 'Yes'],
            )
        );

        $this->add_control(
            'wfp_fundraising_style_donate_gola__currency_headding',
            [
                'label' => __( 'Text', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_gola__currency_typography',
                'selector'   => '{{WRAPPER}} .wfdp-donation-form  .wfdp-donate-goal-progress .wfp-currency-symbol, {{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress .raised',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_donate_gola__currency_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress .wfp-currency-symbol,  {{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress .raised' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_gola__amount_headding',
            [
                'label' => __( 'Number', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_gola__amount_typography',
                'selector'   => '{{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress .donate-percentage, {{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress strong, {{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress .wfp-goal-sp',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_donate_gola__amount_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress .donate-percentage, {{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress strong, {{WRAPPER}} .wfdp-donation-form .wfdp-donate-goal-progress .wfp-goal-sp' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_gola__bar_headding',
            [
                'label' => __( 'Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_gola__visible_bar_headding',
            [
                'label' => __( 'Visible Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'wfp_fundraising_style_donate_gola__bar_visible_background',
                'label' => esc_html__( 'Visible Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', ],
                'selector' => '{{WRAPPER}} .wfdp-donation-form .wfdp-progress-bar .xs-progress-bar, {{WRAPPER}} .wfp-round-bar .wfp-round-bar-data',
                'exclude' => [
                    'image'
                ]
            ]
        );


        $this->add_control(
            'wfp_fundraising_style_donate_gola__disable_bar_headding',
            [
                'label' => __( 'Disable Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'wfp_fundraising_style_donate_gola__bar_disable_background',
                'label' => esc_html__( 'Disable Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', ],
                'selector' => '{{WRAPPER}} .wfdp-donation-form .wfdp-progress-bar .xs-progress',
                'exclude' => [
                    'image'
                ]
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_gola_donate__global_bar_headding',
            [
                'label' => __( 'Global Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_gola_donate__global_bar_border_radius',
            [
                'label'     => esc_html__( 'Border radius', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form .wfdp-progress-bar .xs-progress' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_gola_donate__global_bar_height',
            [
                'label' => __( 'Bar Height', 'charitious' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form .wfdp-progress-bar .xs-progress' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_global_bar_count',
            [
                'label' => __( 'Bar Count Size', 'charitious' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .wfp-round-bar .wfp-round-bar-data' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_global_bar_count_typo',
                'label' => __( 'Bar Count Typography', 'charitious' ),
                'selector'   => '{{WRAPPER}} .wfp-round-bar .wfp-round-bar-data',
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_global_bar_count_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-round-bar .wfp-round-bar-data' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();



        // style of button
        $this->start_controls_section(
            'wfp_fundraising_style_donate_button',
            array(
                'label' => esc_html__( 'Button ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_button__typo',
                'selector'   => '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn',
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_donate_button__padding',
            [
                'label'     => esc_html__( 'Padding', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_donate_button__margin',
            [
                'label'     => esc_html__( 'Margin', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // Updated code

        $this->start_controls_tabs( 'xs_tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' =>esc_html__( 'Normal', 'charitious' ),
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label' =>esc_html__( 'Text Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'btn_tab_button_hover',
            [
                'label' =>esc_html__( 'Hover', 'charitious' ),
            ]
        );

        $this->add_control(
            'btn_hover_color',
            [
                'label' =>esc_html__( 'Text Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_hover',
                'label' => __( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        // color

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'wfp_fundraising_style_donate_button__border',
                'label'     => esc_html__( 'Border', 'charitious' ),
                'selector'  => '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn',
            ]
        );
        // border radius
        $this->add_responsive_control(
            'wfp_fundraising_style_donate_button__border_radius',
            [
                'label'     => esc_html__( 'Border radius', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_donate_button__box_shadow',
                'selector'  => '{{WRAPPER}} .wfdp-donation-form  .xs-btn.submit-btn',
            ]
        );

        $this->end_controls_section();

        // style of input filed
        $this->start_controls_section(
            'wfp_fundraising_style_donate_input',
            array(
                'label' => esc_html__( 'Input ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'wfp_fundraising_style_donate_input_headding_1',
            [
                'label' => __( 'Input', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_input_typo',
                'selector'   => '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol',
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_input_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'wfp_fundraising_style_donate_input_bg_color',
                'label' => esc_html__( 'Background Color', 'charitious' ),
                'types' => [ 'classic', 'gradient', ],
                'selector' => '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol',
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_donate_input_padding',
            [
                'label'     => esc_html__( 'Padding', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_donate_input_margin',
            [
                'label'     => esc_html__( 'Margin', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'wfp_fundraising_style_donate_input_border',
                'label'     => esc_html__( 'Border', 'charitious' ),
                'selector'  => '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol',
            ]
        );

        // border radius
        $this->add_responsive_control(
            'wfp_fundraising_style_donate_input_border_radius',
            [
                'label'     => esc_html__( 'Border radius', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_donate_input_box_shadow',
                'selector'  => '{{WRAPPER}} .wfp-donation-form-wraper .wfdp-donation-input-form .regular-text, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-field, {{WRAPPER}} .wfdp-donationForm .wfdp-donation-input-form .xs-donate-field-wrap .xs-money-symbol',
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_radio',
            [
                'label' => __( 'Radio Input', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_radio_normal_color',
            [
                'label' => esc_html__( 'Radio Normal Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-radio-input-style-2 .xs_radio_filed[type=radio]' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_radio_active_color',
            [
                'label' => esc_html__( 'Radio Active Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-radio-input-style-2 .xs_radio_filed[type=radio]:checked' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wfp-radio-input-style-2 .xs_radio_filed[type=radio]:checked::before'  => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_input_label',
            [
                'label' => __( 'Label', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_input_label__typography',
                'selector'   => '{{WRAPPER}} .wfdp-donation-form  .wfdp-donation-input-form label, .wfp-payment-method-acc-details--title, .wfp-payment-method-acc-details--description, {{WRAPPER}} .wfp-payment-method-acc-details--title',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_donate_input_label__color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .wfdp-donation-input-form label, .wfp-payment-method-acc-details--title, .wfp-payment-method-acc-details--description, {{WRAPPER}} .wfp-payment-method-acc-details--title' => 'color: {{VALUE}}',
                ],
            ]
        );
        // text shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_donate_input_label__box_shadow',
                'selector'  => '{{WRAPPER}} .wfdp-donation-form  .wfdp-donation-input-form label, .wfp-payment-method-acc-details--title, .wfp-payment-method-acc-details--description, {{WRAPPER}} .wfp-payment-method-acc-details--title',
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_donate_input_headding',
            [
                'label' => __( 'Headding', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_donate_input_headding__typography',
                'selector'   => '{{WRAPPER}} .wfdp-donation-form  .wfdp-input-payment-field span, {{WRAPPER}} .wfdp-donation-form .wfp-payment-method-title, {{WRAPPER}} .wfdp-donation-form .wfp-payment-method-acc-details',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_donate_input_headding__color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfdp-donation-form  .wfdp-input-payment-field span, {{WRAPPER}} .wfdp-donation-form .wfp-payment-method-title, {{WRAPPER}} .wfdp-donation-form .wfp-payment-method-acc-details' => 'color: {{VALUE}}',
                ],
            ]
        );
        // text shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_donate_input_headding__box_shadow',
                'selector'  => '{{WRAPPER}} .wfdp-donation-form  .wfdp-input-payment-field span,  {{WRAPPER}} .wfdp-donation-form .wfp-payment-method-title, {{WRAPPER}} .wfdp-donation-form .wfp-payment-method-acc-details',
            ]
        );
        $this->end_controls_section();
    }

    protected function render( ) {

        $settings = $this->get_settings_for_display();
        extract($settings);
        if( empty($wfp_fundraising_donate_content__select_post) ){
            echo  __('Select any Donation from Dropdown.', 'charitious');
            return '';
        }
        $post = get_post( $wfp_fundraising_donate_content__select_post );
        if( is_object($post)){

            $arrayPayment = xs_payment_services();

            $metaKey = 'wfp_form_options_meta_data';
            $metaDataJson = get_post_meta( $post->ID, $metaKey, false );
            $getMetaData = json_decode(json_encode(end($metaDataJson)));

            // get option for payment gateways
            $optinsKey = 'wfp_payment_options_data';
            $getOptionsData = get_option( $optinsKey );
            $gateWaysData = isset($getOptionsData['gateways']) ? $getOptionsData['gateways'] : [];

            $atts = [];
            $atts['form-style'] = $wfp_fundraising_donate_content__form_style;
            $atts['modal'] = $wfp_fundraising_donate_content__modal_status;
            $atts['format-style'] = '';
            $atts['featured'] = $wfp_fundraising_content_donate__featured_enable;
            $atts['category'] = $wfp_fundraising_content_donate__category_enable;
            $atts['goal'] = $wfp_fundraising_content_donate__goal_enable;
            $atts['title'] = $wfp_fundraising_content_donate__title_enable;
            ?>
            <div class="xs-donation" >
        <?php

            include( CHARITIOUS_SHORTCODE_DIR_STYLE.'/xs-wp-donate/donation-display-form.php' );

        }else{
            echo esc_html__('Please select any donate.', 'charitious');
        }
       ?>
        </div>
      <?php

    }

    protected function content_template() { }
}