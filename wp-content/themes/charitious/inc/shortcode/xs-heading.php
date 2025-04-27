<?php

namespace Elementor;

if ( !defined( 'ABSPATH' ) )
	exit;

class Xs_Heading_Widget extends Widget_Base {

	public function get_name() {
		return 'xs-heading';
	}

	public function get_title() {
		return esc_html__( 'Charitious Heading', 'charitious' );
	}

	public function get_icon() {
		return 'eicon-heading';
	}

	public function get_categories() {
		return [ 'charitious-elements' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_tab', [
				'label' =>esc_html__( 'Charitious Heading', 'charitious' ),
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
					'style3' =>esc_html__( 'Style Three', 'charitious' ),
					'style4' =>esc_html__( 'Style Four', 'charitious' ),
					'style5' =>esc_html__( 'Style Five', 'charitious' ),
					'style6' =>esc_html__( 'Style Six', 'charitious' ),
				],
			]
		);

		$this->add_control(
			'title_text', [
				'label'			 =>esc_html__( 'Heading Title', 'charitious' ),
				'type'			 => Controls_Manager::TEXT,
				'label_block'	 => true,
				'placeholder'	 =>esc_html__( 'Add title', 'charitious' ),
				'default'		 =>esc_html__( 'Add Title', 'charitious' ),
			]
		);
        $this->add_control(
            'title_sub_text', [
                'label'			 =>esc_html__( 'Sub Heading', 'charitious' ),
                'type'			 => Controls_Manager::TEXT,
                'label_block'	 => true,
                'placeholder'	 =>esc_html__( 'Add Sub Heading', 'charitious' ),
                'default'		 =>esc_html__( 'Add Sub Heading', 'charitious' ),
                'condition'      => [
                    'style' => 'style6',
                ],
            ]
        );

        $this->add_control(
            'show_separator',
            [
                'label' => __( 'Show Separator', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __( 'Show', 'charitious' ),
                'label_off' => __( 'Hide', 'charitious' ),
                'return_value' => 'yes',
            ]
        );

		$this->add_control(
			'sub_title', [
				'label'			 =>esc_html__( 'Heading Sub Title', 'charitious' ),
				'type'			 => Controls_Manager::TEXTAREA,
				'label_block'	 => true,
				'placeholder'	 =>esc_html__( 'Description', 'charitious' ),
				'default'		 =>esc_html__( 'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly.', 'charitious' ),
			]
		);
        $this->add_control(
            'show_water_mark',
            [
                'label' => __( 'Show Water Mark', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __( 'Show', 'charitious' ),
                'label_off' => __( 'Hide', 'charitious' ),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'water_title', [
                'label'			 =>esc_html__( 'Water Mark Text', 'charitious' ),
                'type'			 => Controls_Manager::TEXT,
                'label_block'	 => true,
                'placeholder'	 =>esc_html__( 'Add title', 'charitious' ),
                'default'		 =>esc_html__( 'Add Title', 'charitious' ),
                'condition'      => [
                    'show_water_mark' => 'yes',
                ],
            ]
        );

		$this->add_responsive_control(
			'title_align', [
				'label'			 =>esc_html__( 'Alignment', 'charitious' ),
				'type'			 => Controls_Manager::CHOOSE,
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

		//Title Style Section
		$this->start_controls_section(
			'section_title_style', [
				'label'	 =>esc_html__( 'Title', 'charitious' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color', [
				'label'		 =>esc_html__( 'Title color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-heading .xs-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .event-heading .xs-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_span_color', [
				'label'		 =>esc_html__( 'Title span tag color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-heading .xs-title span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .event-heading .xs-title span' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .xs-heading .xs-title'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .event-heading .xs-title'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
			'name'		 => 'title_typography',
			'selector'   => '{{WRAPPER}} .xs-heading .xs-title, {{WRAPPER}} .event-heading .xs-title',
			]
		);

		$this->end_controls_section();

		//Subtitle Style Section
		$this->start_controls_section(
			'section_subtitle_style', [
				'label'	 =>esc_html__( 'Sub Title', 'charitious' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subtitle_color', [
				'label'		 =>esc_html__( 'color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-heading .xs-subtitle' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xs-heading .xs-line-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xs-heading p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
			'name'		 => 'subtitle_typography',
			'selector'	 => '{{WRAPPER}} .xs-heading .xs-subtitle, {{WRAPPER}} .xs-heading .xs-line-title, {{WRAPPER}} .xs-heading p',
		  ]
		);

		$this->end_controls_section();
        $this->start_controls_section(
            'section_sub_headding_style', [
                'label'	 =>esc_html__( 'Sub Heading ', 'charitious' ),
                'tab'	 => Controls_Manager::TAB_STYLE,
                'condition'      => [
                    'style' => 'style6',
                ],
            ]
        );
        $this->add_control(
            'sub_heading_color', [
                'label'		 =>esc_html__( 'color', 'charitious' ),
                'type'		 => Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .event-heading .xs-sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'		 => 'sub_headding_typography',
                'selector'	 => '{{WRAPPER}} .event-heading .xs-sub-title',
            ]
        );
        $this->add_control(
            'sep_color', [
                'label'		 =>esc_html__( 'Separetor Color', 'charitious' ),
                'type'		 => Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .border-animation' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

		//Separator Style Section
		$this->start_controls_section(
			'section_separator_style', [
				'label'	 =>esc_html__( 'Separator', 'charitious' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
                'condition'      => [
                    'style' => 'style3',
                ],
			]
		);

		$this->add_control(
			'separator_bg_color', [
				'label'		 =>esc_html__( 'Background color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-separetor.bg-bondiBlue' => 'background-color: {{VALUE}};',
				],
			]
		);
        $this->add_control(
            'separator_height', [
                'label'			 =>esc_html__( 'Height', 'charitious' ),
                'type'			 => Controls_Manager::SLIDER,
                'default'		 => [
                    'size' => '3',
                ],
                'range'			 => [
                    'px' => [
                        'min'	 => 1,
                        'step'	 => 1,
                    ],
                ],
                'size_units'	 => ['px'],
                'selectors'		 => [
                    '{{WRAPPER}} .xs-separetor.bg-bondiBlue'	=> 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'separator_width', [
                'label'			 =>esc_html__( 'Width', 'charitious' ),
                'type'			 => Controls_Manager::SLIDER,
                'default'		 => [
                    'size' => '100',
                ],
                'range'			 => [
                    'px' => [
                        'min'	 => 1,
                        'step'	 => 1,
                    ],
                ],
                'size_units'	 => ['px'],
                'selectors'		 => [
                    '{{WRAPPER}} .xs-separetor.bg-bondiBlue'	=> 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_border_style', [
				'label'	 =>esc_html__( 'Border', 'charitious' ),
				'tab'	 => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border_width', [
				'label'			 =>esc_html__( 'Border Width', 'charitious' ),
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
					'{{WRAPPER}} .xs-heading .xs-separetor'	=> 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_margin_bottom', [
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
					'{{WRAPPER}} .xs-heading .xs-separetor'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color', [
				'label'		 =>esc_html__( 'color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-heading .xs-separetor' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$style = $settings[ 'style' ];
		$title = $settings[ 'title_text' ];
		$sub_headding = $settings[ 'title_sub_text' ];
		$sub_title = $settings[ 'sub_title' ];
        $water_title = $settings['water_title'];
        $show_separator = $settings['show_separator'];
        $show_water_mark = $settings['show_water_mark'];
        if($show_water_mark):
            $water_title = $water_title;
        else:
            $water_title = '';
        endif;


		switch ( $style ) {
			case 'style1':
				require CHARITIOUS_SHORTCODE_DIR_STYLE . '/heading/style1.php';
				break;

            case 'style2':
                require CHARITIOUS_SHORTCODE_DIR_STYLE . '/heading/style2.php';
                break;

            case 'style3':
                require CHARITIOUS_SHORTCODE_DIR_STYLE . '/heading/style3.php';
                break;

            case 'style4':
                require CHARITIOUS_SHORTCODE_DIR_STYLE . '/heading/style4.php';
                break;

            case 'style5':
                require CHARITIOUS_SHORTCODE_DIR_STYLE . '/heading/style5.php';
                break;

            case 'style6':
                require CHARITIOUS_SHORTCODE_DIR_STYLE . '/heading/style6.php';
                break;
		}
	}

	protected function content_template() {
		
	}
}