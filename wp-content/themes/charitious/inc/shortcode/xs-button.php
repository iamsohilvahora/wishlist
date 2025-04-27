<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Button_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-button';
    }

    public function get_title() {
        return esc_html__( 'Charitious Button', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' =>esc_html__('Charitious Button', 'charitious'),
            ]
        );
        $this->add_control(
            'style', [
                'type'		 => Controls_Manager::SELECT,
                'label'		 =>esc_html__( 'Choose Style', 'charitious' ),
                'default'	 => 'style1',
                'label_block'	 => true,
                'options'	 => [
                    'style1' =>esc_html__( 'Primary Button', 'charitious' ),
                    'style2' =>esc_html__( 'Secondary Button', 'charitious' ),
                ],
            ]
        );
        $this->add_control(
			'btn_text',
			[
				'label' =>esc_html__( 'Label', 'charitious' ),
				'type' => Controls_Manager::TEXT,
				'default' =>esc_html__( 'Learn more ', 'charitious' ),
				'placeholder' =>esc_html__( 'Learn more ', 'charitious' ),
			]
		);

		$this->add_control(
			'btn_link',
			[
				'label' =>esc_html__( 'Link', 'charitious' ),
				'type' => Controls_Manager::URL,
				'placeholder' =>esc_html__('http://your-link.com','charitious' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' =>esc_html__( 'Icon', 'charitious' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' =>esc_html__( 'Icon Position', 'charitious' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' =>esc_html__( 'Before', 'charitious' ),
					'right' =>esc_html__( 'After', 'charitious' ),
				],
				'condition' => [
					'icon!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'btn_align',
			[
				'label' =>esc_html__( 'Alignment', 'charitious' ),
				'type' => Controls_Manager::CHOOSE,
				'options'		 => [

					'left'		 => [
						'title'	 =>esc_html__( 'Left', 'charitious' ),
						'icon'	 => 'fa fa-align-left',
					],
					'center'	 => [
						'title'	 =>esc_html__( 'Center', 'charitious' ),
						'icon'	 => 'fa fa-align-center',
					],
					'right'		 => [
						'title'	 =>esc_html__( 'Right', 'charitious' ),
						'icon'	 => 'fa fa-align-right',
					],
					'justify'	 => [
						'title'	 =>esc_html__( 'Justified', 'charitious' ),
						'icon'	 => 'fa fa-align-justify',
					],
				],
				'default'		 => '',
				'prefix_class' => 'elementor%s-align-',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' =>esc_html__( 'Button Style', 'charitious' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label' =>esc_html__( 'Border Radius', 'charitious' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'default' => [
					'top' => 40,
					'right' => 40,
					'bottom' => 40 ,
					'left' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .xs-cp-btn' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' =>esc_html__( 'Padding', 'charitious' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.xs-cp-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' =>esc_html__( 'Typography', 'charitious' ),
				'selector' => '{{WRAPPER}} a.xs-cp-btn',
			]
		);

		$this->start_controls_tabs( 'xs_tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' =>esc_html__( 'Normal', 'charitious' ),
			]
		);

		$this->add_control(
			'',
			[
				'label' =>esc_html__( 'Text Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.xs-cp-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label' =>esc_html__( 'Background Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.xs-cp-btn' => 'background-color: {{VALUE}};',
				],
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
					'{{WRAPPER}} a.xs-cp-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bg_hover_color',
			[
				'label' =>esc_html__( 'Background Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .xs-cp-btn:before' => 'border-bottom: 100px solid {{VALUE}};',
					'{{WRAPPER}} .xs-cp-btn:after' => 'border-top: 100px solid {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_border_color',
			[
				'label' =>esc_html__( 'Border Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.xs-cp-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'box_shadow_style',
			[
				'label' =>esc_html__( 'Box Shadow Style', 'charitious' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'btn_box_shadow_dimensions',
			[
				'label' => _x( 'Dimensions', 'Border Control', 'charitious' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} a.btn' => 'box-shadow: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} var(--box-shadow-color);',
				],
			]
		);
		$this->add_control(
			'btn_box_shadow_color',
			[
				'label' =>esc_html__( 'Box Shadow Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.btn' => '--box-shadow-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

    }

    protected function render( ) {
        $settings = $this->get_settings();

        $btn_text = $settings['btn_text'];
        $btn_alignment = $settings['btn_align'];

		$btn_link = (! empty( $settings['btn_link']['url'])) ? $settings['btn_link']['url'] : '';
		
		$btn_target = ( $settings['btn_link']['is_external']) ? '_blank' : '_self';
		$style = $settings['style'];
		if($style == 'style1'):
            $btn = 'btn-primary';
        else:
            $btn = 'btn-secondary btn-color-alt';
        endif;
        ?>
        
        <a href="<?php echo esc_url( $btn_link ); ?>" target="<?php echo esc_attr( $btn_target ); ?>" class="xs-cp-btn btn <?php echo esc_attr($btn);?>">
            <span class="badge"><i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i></span> <?php echo esc_html( $btn_text ); ?>
        </a>

        <?php
    }

    protected function content_template() { }
}