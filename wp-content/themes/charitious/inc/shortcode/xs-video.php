<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class XS_Video_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-video';
    }

    public function get_title() {
        return esc_html__( 'charitious Video Box', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' =>esc_html__('charitious Video Box', 'charitious'),
            ]
        );

        $this->add_control(

            'style', [
                'type' => Controls_Manager::SELECT,
                'label' =>esc_html__('Choose Style', 'charitious'),
                'default' => 'style1',
                'options' => [
                    'style1' =>esc_html__('With Thumbnail Image', 'charitious'),
                    'style2' =>esc_html__('Without Thumbnail Image', 'charitious'),
                ],
            ]
        );

        $this->add_control(
			'video_link',
			[
				'label' =>esc_html__( 'Link', 'charitious' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' =>esc_html__('http://your-link.com','charitious' ),

			]
		);

		$this->add_control(
			'image',
			[
				'label' =>esc_html__( 'Thumbnail Image', 'charitious' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
                'condition' =>  [
                    'style' => 'style1',
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'label' =>esc_html__( 'Image Size', 'charitious' ),
                'default' => 'full',
                'condition' =>  [
                    'style' => 'style1',
                ],
            ]
        );
        $this->add_control(
            'xs_max_width',
            [
                'label' =>esc_html__( 'Image Max Width', 'charitious' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '42',
                ],
                'range' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 10,
                ],
                'size_units' => [ '%'],

                'selectors'	=>	[
                    '{{WRAPPER}} .fundpress-popup-image' => 'max-width: {{SIZE}}%;',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_align',
            [
                'label' =>esc_html__( 'Alignment', 'charitious' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' =>esc_html__( 'Left', 'charitious' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' =>esc_html__( 'Center', 'charitious' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' =>esc_html__( 'Right', 'charitious' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default' => '',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(

        	'style_tab',
        	[
        		'label'	=>	__( 'Style', 'charitious' ),
        		'tab' 	=> Controls_Manager::TAB_STYLE,
        	]
        );

        $this->add_control(
        	'border',
        	[
        		'label'	=>	__('Show Border','charitious'),
        		'type'	=> Controls_Manager::SWITCHER,
        		'default' => 'no',
				'label_on' =>esc_html__( 'Yes', 'charitious' ),
				'label_off' =>esc_html__( 'No', 'charitious' ),

        	]

        );

	    $this->add_control(
		    'border_width',
		    [
		        'label' =>esc_html__( 'Border Width', 'charitious' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => '1',
		        ],
		        'range' => [
		                'min' => 1,
		                'max' => 100,
		                'step' => 1,
		        ],
		        'size_units' => [ 'px'],
		        'condition'	=>	[
        			'border'	=> 'yes',
        		],
		        'selectors'	=>	[
        			'{{WRAPPER}} a.xs-video-popup' => 'border: {{SIZE}}px solid;',
        		],
                'condition' =>  [
                    'border' => 'yes',
                ],
		    ]
		);

        $this->add_control(
        	'border_color',
        	[
        		'label'	=>	__('Border Color','charitious'),
        		'type'	=> Controls_Manager::COLOR,
        		'selectors'	=>	[
        			'{{WRAPPER}} a.xs-video-popup' => 'border-color: {{VALUE}};',
        		],
        		'condition'	=>	[
        			'border'	=> 'yes',
        		],
        	]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__('Button BG Color','charitious'),
                'type'  => Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} a.xs-video-popup' => 'background-color: {{VALUE}} !important;'
                ],
                
            ]
        );

        $this->add_control(
            'btn_icon_color',
            [
                'label' => esc_html__('Icon Color','charitious'),
                'type'  => Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} a.xs-video-popup i' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render( ) {
        $settings = $this->get_settings();

        $style = $settings['style'];

        $video_link = $settings['video_link'];
        ?>

        <div class="xs-video-popup-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 content-center">
                        <div class="xs-video-popup-wraper">
                            <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings); ?>
                            <div class="xs-video-popup-content">
                                <a href="<?php echo esc_url( $video_link ); ?>" class="xs-video-popup xs-round-btn">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php

    }

    protected function content_template() { }
}