<?php

namespace Elementor;

if ( !defined( 'ABSPATH' ) )
	exit;

class Xs_Funfact_Widget extends Widget_Base {

	public function get_name() {
		return 'xs-funfact';
	}

	public function get_title() {
		return esc_html__( 'Charitious Funfact', 'charitious' );
	}

	public function get_icon() {
		return 'eicon-parallax';
	}

	public function get_categories() {
		return [ 'charitious-elements' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_tab', [
				'label' =>esc_html__( 'Charitious Funfact', 'charitious' ),
			]
		);
        $this->add_control(
            'style', [
                'type'		 => Controls_Manager::SELECT,
                'label'		 =>esc_html__( 'Choose Style', 'charitious' ),
                'default'	 => 'style1',
                'label_block'	 => true,
                'options'	 => [
                    'style1' =>esc_html__( 'Style One', 'charitious' ),
                    'style2' =>esc_html__( 'Style Two', 'charitious' ),
                ],
            ]
        );

		$this->add_control(
			'title_text', [
				'label'			 =>esc_html__( 'Title', 'charitious' ),
				'type'			 => Controls_Manager::TEXT,
				'label_block'	 => true,
				'placeholder'	 =>esc_html__( 'Add title', 'charitious' ),
				'default'		 =>esc_html__( 'Add Title', 'charitious' ),
			]
		);

		$this->add_control(
			'number_count', [
				'label'			 =>esc_html__( 'Number Count', 'charitious' ),
				'type'			 => Controls_Manager::TEXTAREA,
				'label_block'	 => true,
				'placeholder'	 =>esc_html__( 'Number Count', 'charitious' ),
				'default'		 =>'110',
			]
		);
        $this->add_control(
            'scale', [
                'label'			 =>esc_html__( 'Scale', 'charitious' ),
                'type'			 => Controls_Manager::TEXT,
                'label_block'	 => true,
                'placeholder'	 =>esc_html__( 'Add Scale', 'charitious' ),
                'default'		 =>'',
            ]
        );
		$this->add_control(

            'use', [
                'type' => Controls_Manager::SELECT,
                'label' =>esc_html__('Choose Style', 'charitious'),
                'default' => 'icon',
                'options' => [
                    'icon' =>esc_html__('Icon', 'charitious'),
                    'image' =>esc_html__('Image', 'charitious'),
                ],
            ]
        );


        $this->add_control(
            'icon', [
                'label'			 =>esc_html__( 'Icon Class', 'charitious' ),
                'type'			 => Controls_Manager::TEXT,
                'label_block'	 => true,
                'placeholder'	 =>esc_html__( 'Add icon class', 'charitious' ),
                'default'		 =>esc_html__( 'd-flex icon-children', 'charitious' ),
                'condition'	 => [
                    'use' => 'icon',
                ],
            ]
        );

		$this->add_control(
            'image',
            [
                'label' =>esc_html__( 'Image', 'charitious' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
                'condition'	 => [
					'use' => 'image',
				],
            ]
        );

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'default' => 'thumbnail',
				'condition'	 => [
					'use' => 'image',
				],
			]
		);

		$this->end_controls_section();


        //Title Style Section
		$this->start_controls_section(
			'section_title_style', [
				'label'	 =>esc_html__( 'Title', 'charitious' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color', [
				'label'		 =>esc_html__( 'Color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-single-funFact-v3 small' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xs-single-funFact small' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'title_margin_bottom', [
				'label'			 =>esc_html__( 'Margin Bottom', 'charitious' ),
				'type'			 => Controls_Manager::SLIDER,
				'default'		 => [
					'size' => '',
				],
				'range'			 => [
					'px' => [
						'min'	 => 0,
						'step'	 => 5,
					],
				],
				'size_units'	 => ['px'],
				'selectors'		 => [
					'{{WRAPPER}} .xs-single-funFact-v3 small'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-funFact small'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
            'title_display', [
                'type'		 => Controls_Manager::SELECT,
                'label'		 =>esc_html__( 'Title Display Property', 'charitious' ),
                'default'	 => 'inline-block',
                'label_block'	 => true,
                'options'	 => [
                    'inline-block' =>esc_html__( 'Inline Block', 'charitious' ),
                    'block' =>esc_html__( 'Block', 'charitious' ),
                ],
                'selectors'	 => [
                    '{{WRAPPER}} .xs-single-funFact.funFact-v2 small' => 'display: {{VALUE}};',
                    '{{WRAPPER}} xs-single-funFact-v3 small' => 'display: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'		 => 'title_typography',
                'selector'		 =>  '{{WRAPPER}} .xs-single-funFact small, {{WRAPPER}} .xs-single-funFact-v3 small',
            ]
        );

		$this->end_controls_section();

		//Number Count Style Section
		$this->start_controls_section(
			'section_number_count_style', [
				'label'	 =>esc_html__( 'Number Count', 'charitious' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_count_color', [
				'label'		 =>esc_html__( 'color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'default'    =>'#000000', 
				'selectors'	 => [
					'{{WRAPPER}} .number-percentage-count' => 'color: {{VALUE}};',
					'{{WRAPPER}} .unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
                'name'		 => 'number_count_typography',
                'selector'	 => '{{WRAPPER}} .unit, {{WRAPPER}} .number-percentage-count',
			]
		);

		$this->end_controls_section();


		//Icon Style Section
		$this->start_controls_section(
			'section_icon_style', [
				'label'	 =>esc_html__( 'Icon/Image', 'charitious' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color', [
				'label'		 =>esc_html__( 'Color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-single-funFact-v3 .funfact-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xs-single-funFact .funfact-icon' => 'color: {{VALUE}};'
				],
				'condition'	 => [
					'use' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_margin_bottom', [
				'label'			 =>esc_html__( 'Margin Bottom', 'charitious' ),
				'type'			 => Controls_Manager::SLIDER,
				'default'		 => [
					'size' => '',
				],
				'range'			 => [
					'px' => [
						'min'	 => 0,
						'step'	 => 5,
					],
				],
				'size_units'	 => ['px'],
				'selectors'		 => [
					'{{WRAPPER}} .xs-single-funFact-v3 span'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-funFact-v3 img'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-funFact span'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-funFact img'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
			'name'		 => 'icon_typography',
			'selector'	 => '{{WRAPPER}} .xs-single-funFact-v3 span, {{WRAPPER}} .xs-single-funFact span',
			'condition'	 => [
					'use' => 'icon',
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings();
		$title = $settings[ 'title_text' ];
		$use = $settings[ 'use' ];
		$number_count = $settings[ 'number_count' ];
        $style = $settings[ 'style' ];
        $scale = $settings[ 'scale' ];
        switch ( $style ) {
            case 'style1':
                require CHARITIOUS_SHORTCODE_DIR_STYLE . '/funfact/style1.php';
                break;

            case 'style2':
                require CHARITIOUS_SHORTCODE_DIR_STYLE . '/funfact/style2.php';
                break;

        }

	}

	protected function content_template() {
		
	}
}
