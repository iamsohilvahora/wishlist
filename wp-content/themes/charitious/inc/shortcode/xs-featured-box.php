<?php

namespace Elementor;

if ( !defined( 'ABSPATH' ) )
	exit;

class Xs_Featured_Widget extends Widget_Base {

	public function get_name() {
		return 'xs-featured-box';
	}

	public function get_title() {
		return esc_html__( 'Charitious Featured Box', 'charitious' );
	}

	public function get_icon() {
		return 'eicon-post-info';
	}

	public function get_categories() {
		return [ 'charitious-elements' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_tab', [
				'label' =>esc_html__( 'Charitious Featured Box', 'charitious' ),
			]
		);

        $this->add_control(
            'style',
            [
                'label'     => esc_html__( 'Select Box Style', 'charitious' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'style1',
                'options'   => [
                    'style1'     => esc_html__( 'Style One', 'charitious' ),
                    'style2'     => esc_html__( 'Style Two', 'charitious' ),
                    'style3'     => esc_html__( 'Style Three', 'charitious' ),
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
			'sub_title', [
				'label'			 =>esc_html__( 'Sub Title', 'charitious' ),
				'type'			 => Controls_Manager::TEXTAREA,
				'label_block'	 => true,
				'placeholder'	 =>esc_html__( 'Description', 'charitious' ),
				'default'		 =>esc_html__( 'Start fundraising in minutes.No goal requirements, no deadlines.', 'charitious' ),
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
            'custom_icon',
            [
                'label' => __( 'Use Custom Icon.', 'charitious' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'charitious' ),
                'label_off' => __( 'Hide', 'charitious' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'icon_class', [
                'label'			 =>esc_html__( 'Custom Icon Class', 'charitious' ),
                'type'			 => Controls_Manager::TEXT,
                'placeholder'	 =>esc_html__( 'Add title', 'charitious' ),
                'default'		 =>'icon-donation_2 d-flex',
                'condition'	 => [
                    'custom_icon' => 'yes',
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
				'condition'	 => [
					'custom_icon' => '',
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
		$this->add_control(
            'background_images',
            [
                'label' =>esc_html__( 'Background Image', 'charitious' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
                'condition'	 => [
                    'style' => 'style3',
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



        $this->add_control(
            'show_read_more',
            [
                'label' => __( 'Show Read More.', 'charitious' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'charitious' ),
                'label_off' => __( 'Hide', 'charitious' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
		);
        $this->add_control(
            'btn_text',
            [
                'label' =>esc_html__( 'Button Label', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'default' =>esc_html__( 'Learn more ', 'charitious' ),
                'placeholder' =>esc_html__( 'Learn more ', 'charitious' ),
                'condition'	 => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' =>esc_html__( 'Button Link', 'charitious' ),
                'type' => Controls_Manager::URL,
                'placeholder' =>esc_html__('http://your-link.com','charitious' ),
                'default' => [
                    'url' => '#',
                ],
                'condition'	 => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

		$this->add_responsive_control(
			'content_align', [
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
				],
				'default'		 => '',
				'prefix_class' => 'charitious%s-align-',
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
					'{{WRAPPER}} .xs-service-promo h5' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xs-single-media h5' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .xs-service-promo h5'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-media h5'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
			'name'		 => 'title_typography',
			'selector'	 => '{{WRAPPER}} .xs-service-promo h5, {{WRAPPER}} .xs-single-media h5',
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
					'{{WRAPPER}} .xs-service-promo p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xs-single-media p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
			'name'		 => 'subtitle_typography',
			'selector'	 => '{{WRAPPER}} .xs-service-promo p, {{WRAPPER}} .xs-single-media p',
			]
		);

		$this->end_controls_section();



        //Background Style Section
        $this->start_controls_section(
            'section_background_style', [
                'label'	 =>esc_html__( 'Background', 'charitious' ),
                'tab'	 => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .xs-service-promo, {{WRAPPER}} .xs-single-media',
            ]
        );
        $this->add_control(
            'show_promo_overlay',
            [
                'label' => __( 'Show Overlay', 'charitious' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'charitious' ),
                'label_off' => __( 'Hide', 'charitious' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'promo_overlay', [
                'label'		 =>esc_html__( 'Overlay Color', 'charitious' ),
                'type'		 => Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .xs-service-promo-overlay' => 'background-color: {{VALUE}};',
                ],
                'condition'	 => [
                    'show_promo_overlay' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'box_padding', [
                'label'			 =>esc_html__( 'Padding Box', 'charitious' ),
                'type'			 => Controls_Manager::SLIDER,
                'default'		 => [
                    'size' => '',
                ],
                'range'			 => [
                    'px' => [
                        'min'	 => 0,
                        'step'	 => 1,
                    ],
                ],
                'size_units'	 => ['px'],
                'selectors'		 => [
                    '{{WRAPPER}} .xs-service-promo'	=> 'padding: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .xs-single-media'	=> 'padding: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();



        //Border style section

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
					'{{WRAPPER}} .xs-service-promo'	=> 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-media'	=> 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color', [
				'label'		 =>esc_html__( 'color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-service-promo' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .xs-single-media' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_hover_color', [
				'label'		 =>esc_html__( 'Hover color', 'charitious' ),
				'type'		 => Controls_Manager::COLOR,
				'selectors'	 => [
					'{{WRAPPER}} .xs-service-promo:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .xs-single-media' => 'border-color: {{VALUE}};',
				],
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
					'{{WRAPPER}} .xs-service-promo span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xs-single-media span' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .xs-service-promo span'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-service-promo img'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-media span'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xs-single-media img'	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
			'name'		 => 'icon_typography',
			'selector'	 => '{{WRAPPER}} .xs-service-promo span, {{WRAPPER}} .xs-single-media span',
			'condition'	 => [
					'use' => 'icon',
				],
			]
		);
        $this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
		$style_image = $settings[ 'background_images' ];
		$style = $settings[ 'style' ];
		$title = $settings[ 'title_text' ];
		$use = $settings[ 'use' ];
		$sub_title = $settings[ 'sub_title' ];
		$show_promo_overlay = $settings[ 'show_promo_overlay' ];

		$show_read_more = $settings[ 'show_read_more' ];
        $btn_text = $settings['btn_text'];

        $btn_link = (! empty( $settings['btn_link']['url'])) ? $settings['btn_link']['url'] : '';

        $btn_target = ( $settings['btn_link']['is_external']) ? '_blank' : '_self';


        $custom_icon = $settings[ 'custom_icon' ];

        if($custom_icon == 'yes'):
            $icon = $settings[ 'icon_class' ];
        else:
            $icon = $settings[ 'icon' ];
        endif;

	?>


        <?php if($style == 'style1'): ?>
            <div class="xs-service-promo">
                <?php if($use == 'image'): ?>
                    <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings); ?>
                <?php else: ?>
                    <span class="<?php echo esc_attr($icon); ?>"></span>
                <?php endif; ?>
                <?php if(!empty($title)): ?>
                    <h5><?php echo wp_kses( $title, array('br' => array()) ); ?></h5>
                <?php endif; ?>
                <?php if(!empty($sub_title)):?>
                    <p><?php echo esc_html($sub_title) ?></p>
                <?php endif; ?>
                <?php if(($show_promo_overlay == 'yes')):?>
                    <div class="xs-service-promo-overlay"></div>
                <?php endif; ?>
            </div>
        <?php elseif($style == 'style2') : ?>
            <div class="media xs-single-media">
                <?php if($use == 'image'): ?>
                    <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings); ?>
                <?php else: ?>
                    <span class="<?php echo esc_attr($icon); ?>"></span>
                <?php endif; ?>
                <div class="media-body">
                    <?php if(!empty($title)): ?>
                        <h5><?php echo wp_kses( $title, array('br' => array()) ); ?></h5>
                    <?php endif; ?>
                    <?php if(!empty($sub_title)):?>
                        <p><?php echo esc_html($sub_title) ?></p>
                    <?php endif; ?>
                    <?php if(($show_read_more == 'yes')):?>
                        <a href="<?php echo esc_url( $btn_link ); ?>" target="<?php echo esc_html( $btn_target ); ?>">
                            <i class="fa fa-play"></i> <?php echo esc_html( $btn_text ); ?>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        <?php else: ?>
            <div class="xs-service-promo xs-featured-box-style-3">
                <?php if(!empty($style_image)) :  ?>
                <div class="background-image"><?php echo wp_get_attachment_image($style_image['id'], 'full'); ?></div>
                <?php endif; ?>
                <div class="xs-featured-box-icon-style-3">
                    <?php if($use == 'image'): ?>
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings); ?>
                    <?php else: ?>
                        <span class="<?php echo esc_attr($icon); ?>"></span>
                    <?php endif; ?>
                </div>
                <?php if(!empty($title)): ?>
                    <h5><?php echo wp_kses( $title, array('br' => array()) ); ?></h5>
                <?php endif; ?>
                <?php if(!empty($sub_title)):?>
                    <p><?php echo esc_html($sub_title) ?></p>
                <?php endif; ?>
                <?php if(($show_read_more == 'yes')):?>
                    <a href="<?php echo esc_url( $btn_link ); ?>" class="btn-learn-more btn-show-on-hover">
                         <?php echo esc_html( $btn_text ); ?>
                    </a>
                <?php endif; ?>
                <?php if(($show_promo_overlay == 'yes')):?>
                    <div class="xs-service-promo-overlay"></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
	<?php
	}

	protected function content_template() {
		
	}
}
