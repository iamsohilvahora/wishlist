<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_wp_fundraising_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-charitious-campaign-list';
    }

    public function get_title() {
        return esc_html__( 'Charitious Campaign List', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-meetup';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }


    // get query categories
    public function get_category(){
        $taxonomy	 = 'wfp-categories';
        $query_args = [
            'taxonomy'      => ['wfp-categories'], // taxonomy name
            'orderby'       => 'name',
            'order'         => 'DESC',
            'hide_empty'    => true,
            'number'        => 6
        ];


        $terms = get_terms( $query_args );


        $options = [];
        $count = count($terms);
        if($count > 0):
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        endif;
        return $options;
    }

    protected function register_controls() {

        // content of listing
        $this->start_controls_section(
            'wfp_fundraising_content',
            array(
                'label' => esc_html__( 'Content', 'charitious' ),
            )
        );

        // headding layout option
        $this->add_control(
            'wfp_fundraising_content__layout_options',
            [
                'label' => __( 'Layout Options', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'wfp_fundraising_content__layout_style',
            [
                'label' => esc_html__( 'Layout Style', 'charitious' ),
                'type' =>  Controls_Manager::SELECT,
                'default' => 'wfp-layout-grid',
                'options' => [
                    'wfp-layout-list'  => esc_html__( 'List', 'charitious' ),
                    'wfp-layout-grid' => esc_html__( 'Grid', 'charitious' ),
                    'wfp-layout-masonary' => esc_html__( 'Masonary', 'charitious' ),
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_content__column_grid',
            [
                'label' => esc_html__( 'Columns Grid', 'charitious' ),
                'type' =>  Controls_Manager::SELECT,
                'default' => 'xs-col-lg-4',
                'options' => [
                    'xs-col-lg-6'  => esc_html__( '2 Columns', 'charitious' ),
                    'xs-col-lg-4' => esc_html__( '3 Columns', 'charitious' ),
                    'xs-col-lg-3' => esc_html__( '4 Columns', 'charitious' ),
                ],
                'condition' => ['wfp_fundraising_content__layout_style!' => 'wfp-layout-list'],
            ]
        );

        // headding query option
        $this->add_control(
            'wfp_fundraising_content__query_options',
            [
                'label' => __( 'Query Options', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'wfp_fundraising_content__categories',
            [
                'label' => __( 'Select Categories', 'charitious' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block'=>true,
                'options' => $this->get_category(),
                'default' => [ ],
            ]
        );


        $this->add_control(
            'wfp_fundraising_content__orderby',
            [
                'label' => esc_html__( 'Order By', 'charitious' ),
                'type' =>  Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'name'  => esc_html__( 'Name', 'charitious' ),
                    'post_date' => esc_html__( 'Date', 'charitious' ),
                    'rand' => esc_html__( 'Rand', 'charitious' ),
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_content__show_post',
            [
                'label'         => esc_html__('Show Per Page', 'charitious'),
                'type'          => Controls_Manager::NUMBER,
                'default' 		=> 9,
                'min' 			=> 1,
                'max' 			=> 100,
                'step' 			=> 1,

            ]
        );

        $this->add_control(
            'wfp_fundraising_content__order',
            [
                'label' => esc_html__( 'Order', 'charitious' ),
                'type' =>  Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC'  => esc_html__( 'ASC', 'charitious' ),
                    'DESC' => esc_html__( 'DESC', 'charitious' ),
                ],
            ]
        );
        // headding display option
        $this->add_control(
            'wfp_fundraising_content__display_options',
            [
                'label' => __( 'Display Options', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'wfp_fundraising_content_raised_sytle',
            [
                'label' => esc_html__( 'Goal progress  style', 'charitious' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'progressbar',
                'options' => [
                    'pie_bar'  => esc_html__( 'Pie bar', 'charitious' ),
                    'progressbar' => esc_html__( 'Progressbar', 'charitious' ),
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_content__featured_enable',
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
            'wfp_fundraising_content__title_enable',
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
            'wfp_fundraising_content__title_limit',
            [
                'label'         => esc_html__('Title Limit', 'charitious'),
                'type'          => Controls_Manager::NUMBER,
                'default' 		=> 40,
                'min' 			=> 1,
                'max' 			=> 150,
                'step' 			=> 1,
                'condition' => ['wfp_fundraising_content__title_enable' => 'Yes'],
            ]
        );

        $this->add_control(
            'wfp_fundraising_content__excerpt_enable',
            [
                'label' => esc_html__( 'Show Excerpt', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'charitious' ),
                'label_off' => esc_html__( 'Hide', 'charitious' ),
                'return_value' => 'Yes',
                'default' => 'Yes',
            ]
        );
        $this->add_control(
            'wfp_fundraising_content__excerpt_limit',
            [
                'label'         => esc_html__('Excerpt Limit', 'charitious'),
                'type'          => Controls_Manager::NUMBER,
                'default' 		=> 60,
                'min' 			=> 1,
                'max' 			=> 200,
                'step' 			=> 1,
                'condition' => ['wfp_fundraising_content__excerpt_enable' => 'Yes'],
            ]
        );
        $this->add_control(
            'wfp_fundraising_content__category_enable',
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
            'wfp_fundraising_content__goal_enable',
            [
                'label' => esc_html__( 'Show Goal', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'charitious' ),
                'label_off' => esc_html__( 'Hide', 'charitious' ),
                'return_value' => 'Yes',
                'default' => 'Yes',
            ]
        );
        $this->add_control(
            'wfp_fundraising_content__user_enable',
            [
                'label' => esc_html__( 'Show Author Info', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'charitious' ),
                'label_off' => esc_html__( 'Hide', 'charitious' ),
                'return_value' => 'Yes',
                'default' => 'Yes',
            ]
        );
        // default title
        $this->add_control(
            'wfp_fundraising_content__default_title_options',
            [
                'label' => esc_html__( 'Default Title', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition' => ['wfp_fundraising_content__goal_enable' => 'Yes'],
            ]
        );
        $this->add_control(
            'wfp_fundraising_goal_title',
            [
                'label' => esc_html__( 'Goal', 'charitious' ),
                'type' =>Controls_Manager::TEXT,
                'default' => esc_html__( 'Goal', 'charitious' ),
                'placeholder' => esc_html__( 'Goal', 'charitious' ),
                'condition' => ['wfp_fundraising_content__goal_enable' => 'Yes'],
            ]
        );
        $this->add_control(
            'wfp_fundraising_goal_title_icon',
            [
                'label' => esc_html__( 'Icon', 'charitious' ),
                'type' => Controls_Manager::ICONS,
                'default' => [],
                'condition' => ['wfp_fundraising_content__goal_enable' => 'Yes'],
            ]
        );
        $this->add_control(
            'wfp_fundraising_raised_title_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['wfp_fundraising_content__goal_enable' => 'Yes'],
            ]
        );

        $this->add_control(
            'wfp_fundraising_raised_title',
            [
                'label' => esc_html__( 'Raised', 'charitious' ),
                'type' =>Controls_Manager::TEXT,
                'default' => esc_html__( 'Raised', 'charitious' ),
                'placeholder' => esc_html__( 'Raised', 'charitious' ),
                'condition' => ['wfp_fundraising_content__goal_enable' => 'Yes'],
            ]
        );
        $this->add_control(
            'wfp_fundraising_raised_title_icon',
            [
                'label' => esc_html__( 'Icon', 'charitious' ),
                'type' => Controls_Manager::ICONS,
                'default' => [],
                'condition' => ['wfp_fundraising_content__goal_enable' => 'Yes'],
            ]
        );

        $this->end_controls_section();

        // style of global
        $this->start_controls_section(
            'wfp_fundraising_style_global',
            array(
                'label' => esc_html__( 'Global', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'wfp_fundraising_style_global__border',
                'label'     => esc_html__( 'Border', 'charitious' ),
                'selector'  => '{{WRAPPER}} .wfp-list-campaign .campaign-blog',
            ]
        );


        $this->add_responsive_control(
            'wfp_fundraising_style_global__border_radius',
            [
                'label'     => esc_html__( 'Border radius', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_global__box_shadow',
                'selector'  => '{{WRAPPER}} .wfp-list-campaign .campaign-blog',
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_global__padding',
            [
                'label'     => esc_html__( 'Padding', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wfp_fundraising_style_global__margin',
            [
                'label'     => esc_html__( 'Margin', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'wfp_fundraising_style_global__background',
                'label' => esc_html__( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', ],
                'selector' => '{{WRAPPER}} .wfp-list-campaign .campaign-blog',
                'exclude' => [
                    'image'
                ]
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_global__alignment',
            [
                'label'    => esc_html__( 'Alignment', 'charitious' ),
                'type'     => Controls_Manager::CHOOSE,
                'options'  => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'charitious' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'charitious' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'charitious' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'  => 'left',
                'selectors'=> [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents ' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();


        // style of featured information
        $this->start_controls_section(
            'wfp_fundraising_style_featured',
            array(
                'label' => esc_html__( 'Featured ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content__featured_enable' => 'Yes'],
            )
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'wfp_fundraising_style_featured__border',
                'label'     => esc_html__( 'Border', 'charitious' ),
                'selector'  => '{{WRAPPER}} .wfp-list-campaign .campaign-blog  .wfp-feature-video, {{WRAPPER}} .wfp-list-campaign .campaign-blog  .wfp-post-image',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_featured__box_shadow',
                'selector'  => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-feature-video, {{WRAPPER}} .wfp-list-campaign .campaign-blog  .wfp-post-image',
            ]
        );

        $this->end_controls_section();
        // style of title
        $this->start_controls_section(
            'wfp_fundraising_style_title',
            array(
                'label' => esc_html__( 'Title', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content__title_enable' => 'Yes'],
            )
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_title__typography',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--title__link',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_title__color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--title__link' => 'color: {{VALUE}}',
                ],
            ]
        );
        // text shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_title__box_shadow',
                'selector'  => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--title__link',
            ]
        );


        $this->end_controls_section();

        // style of excerpt
        $this->start_controls_section(
            'wfp_fundraising_style_excerpt',
            array(
                'label' => esc_html__( 'Excerpt ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content__excerpt_enable' => 'Yes'],
            )
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_excerpt__typography',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--short-description',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_excerpt__color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--short-description' => 'color: {{VALUE}}',
                ],
            ]
        );
        // text shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_excerpt__box_shadow',
                'selector'  => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--short-description',
            ]
        );

        $this->end_controls_section();

        // style of categories
        $this->start_controls_section(
            'wfp_fundraising_style_categories',
            array(
                'label' => esc_html__( 'Categories ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content__category_enable' => 'Yes'],
            )
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_categories__typography',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--cat__link',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_categories__color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--cat__link' => 'color: {{VALUE}}',
                ],
            ]
        );
        // text shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(), [
                'name'      => 'wfp_fundraising_style_categories__box_shadow',
                'selector'  => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content--cat__link',
            ]
        );

        $this->end_controls_section();

        // style of Goal
        $this->start_controls_section(
            'wfp_fundraising_style_goal',
            array(
                'label' => esc_html__( 'Goal ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content__goal_enable' => 'Yes'],
            )
        );

        $this->add_control(
            'wfp_fundraising_style_gola__currency_headding',
            [
                'label' => __( 'Text', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_gola__currency_typography',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .wfp-currency-symbol, {{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .raised',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_gola__currency_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .wfp-currency-symbol,  {{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .raised' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_gola__amount_headding',
            [
                'label' => __( 'Number', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_gola__amount_typography',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .donate-percentage, {{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress strong, {{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .wfp-goal-sp',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_gola__amount_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .donate-percentage, {{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress strong, {{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfdp-donate-goal-progress .wfp-goal-sp' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_bar_time_left',
            [
                'label' => __( 'Time Left', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_bar_time_left_typo',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content .number_donation_count',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_bar_time_left_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content .number_donation_count' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wfp_fundraising_style_bar_time_left_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .wfp-campaign-content .number_donation_count .wfp-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_gola__bar_headding',
            [
                'label' => __( 'Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_gola__visible_bar_headding',
            [
                'label' => __( 'Visible Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'wfp_fundraising_style_gola__bar_visible_background',
                'label' => esc_html__( 'Visible Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', ],
                'selector' => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfdp-progress-bar .xs-progress-bar, {{WRAPPER}} .wfp-round-bar .wfp-round-bar-data',
                'exclude' => [
                    'image'
                ]
            ]
        );


        $this->add_control(
            'wfp_fundraising_style_gola__disable_bar_headding',
            [
                'label' => __( 'Disable Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'wfp_fundraising_style_gola__bar_disable_background',
                'label' => esc_html__( 'Disable Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', ],
                'selector' => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfdp-progress-bar .xs-progress',
                'exclude' => [
                    'image'
                ]
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_gola__global_bar_headding',
            [
                'label' => __( 'Global Bar', 'charitious' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_gola__global_bar_border_radius',
            [
                'label'     => esc_html__( 'Border radius', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfdp-progress-bar .xs-progress, {{WRAPPER}} .wfp-list-campaign .campaign-blog .wfdp-progress-bar .xs-progress-bar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_gola__global_bar_height',
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
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfdp-progress-bar .xs-progress' => 'height: {{SIZE}}{{UNIT}};',
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


        // style of author information
        $this->start_controls_section(
            'wfp_fundraising_style_author',
            array(
                'label' => esc_html__( 'Author ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content__user_enable' => 'Yes'],
            )
        );

        $this->add_control(
            'wfp_fundraising_style_author__headding',
            [
                'label' => __( 'Photos', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_responsive_control(
            'wfp_fundraising_style_author__photos_border_radius',
            [
                'label'     => esc_html__( 'Border radius', 'charitious' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-campign-user .profile-image > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_author__photos_width',
            [
                'label' => __( 'Size', 'charitious' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-campign-user .profile-image > img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_author__headding_title',
            [
                'label' => __( 'Title', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_author__title_typography',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .profile-info .display-name',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_author__title_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .profile-info .display-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wfp_fundraising_style_author__headding_name',
            [
                'label' => __( 'Name', 'charitious' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        // typography
        $this->add_group_control(
             Group_Control_Typography::get_type(), [
                'name'       => 'wfp_fundraising_style_author__name_typography',
                'selector'   => '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .profile-info .display-name .display-name__author',
            ]
        );

        // color
        $this->add_control(
            'wfp_fundraising_style_author__name_color',
            [
                'label' => esc_html__( 'Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .wfp-list-campaign .campaign-blog .wfp-compaign-contents .profile-info .display-name .display-name__author' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // style of author information
        $this->start_controls_section(
            'wfp_fundraising_style_pie',
            array(
                'label' => esc_html__( 'Pie ', 'charitious' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['wfp_fundraising_content_raised_sytle' => 'pie_bar'],
            )
        );
        // color
        $this->add_control(
            'wfp_fundraising_style_border_color',
            [
                'label' => esc_html__( 'Highlight border color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

            ]
        );

        $this->add_control(
            'wfp_fundraising_style_trackcolor',
            [
                'label' => esc_html__( 'Track color', 'charitious' ),
                'type' => Controls_Manager::COLOR,

            ]
        );
        $this->end_controls_section();
    }

    protected function render( ) {
        $settings = $this->get_settings();
        extract($settings);

        include(CHARITIOUS_SHORTCODE_DIR_STYLE.'/xs-wp-fundraising/country-info.php' );
        /*currency information*/
        $metaGeneralKey = 'wfp_general_options_data';
        $getMetaGeneralOp = get_option( $metaGeneralKey );
        $getMetaGeneral = isset($getMetaGeneralOp['options']) ? $getMetaGeneralOp['options'] : [];

        $defaultCurrencyInfo = isset($getMetaGeneral['currency']['name']) ? $getMetaGeneral['currency']['name'] : 'US-USD';
        $explCurr = explode('-', $defaultCurrencyInfo);
        $currCode = isset($explCurr[1]) ? $explCurr[1] : 'USD';
        $symbols = isset($countryList[current($explCurr)]['currency']['symbol']) ? $countryList[current($explCurr)]['currency']['symbol'] : '';
        $symbols = strlen($symbols) > 0 ? $symbols : $currCode;

        $defaultUse_space = isset($getMetaGeneral['currency']['use_space']) ? $getMetaGeneral['currency']['use_space'] : 'off';

        // main campaign page
        include( CHARITIOUS_SHORTCODE_DIR_STYLE.'/xs-wp-fundraising/campaign.php' );


    }

    protected function content_template() { }
}