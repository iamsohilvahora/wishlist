<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Image_Box_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-image-box';
    }

    public function get_title() {
        return esc_html__( 'Charitious Image Box', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-image-rollover';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' =>esc_html__('Charitious Image Box', 'charitious'),
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
            ]
        );

        $this->add_control(
            'title',
            [
                'label' =>esc_html__( 'Title', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' =>esc_html__( 'Add title', 'charitious' ),
                'default' =>esc_html__( 'Add Title', 'charitious' ),
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' =>esc_html__( 'Sub Title', 'charitious' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' =>esc_html__( 'When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries', 'charitious' ),
                
            ]
        );

        $this->end_controls_section();

        /**
		 *
		 *Title Style
		 *
		*/

        $this->start_controls_section(
			'section_title_tab',
			[
				'label' =>esc_html__( 'Title', 'charitious' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' =>esc_html__( 'Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xs-single-causes h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' =>esc_html__( 'Hover Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xs-single-causes h2:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' =>esc_html__( 'Typography', 'charitious' ),
				'selector' => '{{WRAPPER}} .xs-single-causes h2',
			]
		);

		$this->end_controls_section();


		/**
		 *
		 *Sub Title Style
		 *
		*/

        $this->start_controls_section(
			'section_sub_title_tab',
			[
				'label' =>esc_html__( 'Sub Title', 'charitious' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label' =>esc_html__( 'Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xs-single-causes p ' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sub_hover_title_color',
			[
				'label' =>esc_html__( 'Hover Color', 'charitious' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .xs-single-causes p:hover ' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_title_typography',
				'label' =>esc_html__( 'Typography', 'charitious' ),
				'selector' => '{{WRAPPER}} .xs-single-causes p',
			]
		);

		$this->end_controls_section();

        
    }

    protected function render( ) {
    	
        $settings = $this->get_settings();
        $image = $settings['image'];
        $title = $settings['title'];
        $sub_title = $settings['sub_title'];
        ?>
        <div class="xs-single-causes">
			<?php if ( !empty($image['url']) ){
				echo wp_get_attachment_image($image['id'], 'full', false, array(
					'alt' => esc_attr__('img','charitious')
				));
			} ?>
            <div class="xs-causes-footer">
                <h2 class="color-light-red"><?php echo esc_html( $title ); ?></h2>
                <p><?php echo esc_html( $sub_title ); ?></p>
            </div>
        </div>

        <?php
    }



    protected function content_template() { }
}