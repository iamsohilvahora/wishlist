<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class XS_Volunteer_Area_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-volunteer-area';
    }

    public function get_title() {
        return esc_html__( 'Charitious Volunteer Area', 'charitious' );
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
                'label' =>esc_html__('Charitious Volunteer Area', 'charitious'),
            ]
        );


        //add repeater

        $this->add_control(
            'title',
            [
                'label' =>esc_html__( 'Title', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' =>esc_html__('We Need Volunteer in Asia','charitious' ),

            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' =>esc_html__( 'Button', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' =>esc_html__('Become a volunteer','charitious' ),

            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' =>esc_html__( 'Link', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' =>esc_html__('http://your-link.com','charitious' ),

            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'volunteer_image',
            [
                'label'         => esc_html__( 'Images', 'charitious' ),
                'type'          => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'volunteer_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'volunteer_image' => Utils::get_placeholder_image_src(),
                        
                    ],
                ], 
            ]
        );
        
        $this->end_controls_section();
        //  Style section
        $this->start_controls_section(
            'section_Background_style', [
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
                'selector' => '{{WRAPPER}} .voulnteer-area-section',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style', [
                'label'	 =>esc_html__( 'Content', 'charitious' ),
                'tab'	 => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_bg',
                'label' => __( 'Content Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .volunteer-content',
            ]
        );

        $this->add_control(
            'text_color', [
                'label'		 =>esc_html__( 'Color', 'charitious' ),
                'type'		 => Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .volunteer-content h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'		 => 'text_typography',
                'selector'	 => '{{WRAPPER}} .volunteer-content h2'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style', [
                'label'	 =>esc_html__( 'Button', 'charitious' ),
                'tab'	 => Controls_Manager::TAB_STYLE,
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
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => __( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .voulnteer-area-section .btn-danger',
            ]
        );
        $this->add_control(
            'button_text_color', [
                'label'		 =>esc_html__( 'color', 'charitious' ),
                'type'		 => Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .voulnteer-area-section .btn-danger' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'		 => 'button_typography',
                'selector'	 => '{{WRAPPER}} .voulnteer-area-section .btn-danger',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => __( 'Hover', 'charitious' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hv_background',
                'label' => __( 'Background', 'charitious' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .voulnteer-area-section .btn.btn-danger:hover',
            ]
        );
        $this->add_control(
            'button_text_hv_color', [
                'label'		 =>esc_html__( 'color', 'charitious' ),
                'type'		 => Controls_Manager::COLOR,
                'selectors'	 => [
                    '{{WRAPPER}} .voulnteer-area-section .btn-danger:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'		 => 'button_hv_typography',
                'selector'	 => '{{WRAPPER}} .voulnteer-area-section .btn-danger:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render( ) {
        $settings = $this->get_settings();

        $title = $settings['title'];
        $btn_text = $settings['btn_text'];
        $link = $settings['btn_link'];
        $volunteer_list = $settings['volunteer_list'];
        ?>

        <section class="voulnteer-area-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 ml-auto">
                        <div class="volunteer-content">
                            <h2><?php echo esc_html($title);?></h2>
                            <div class="xs-btn-wraper">
                                <a href="<?php echo esc_url($link);?>" class="btn btn-danger left"><span class="badge"><i class="icon-user2"></i></span><?php echo esc_html($btn_text);?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="volunteer-area">
                <?php 
                
                $i = 1;
                foreach($volunteer_list as $list):
                    
                    if($i == 1){ $class = 'one';}elseif($i == 2){$class = 'two';}elseif($i == 3){$class = 'three';}elseif($i == 4){$class = 'four';}elseif($i == 5){$class = 'five';}elseif($i == 6){$class = 'six';}elseif($i == 7){$class = 'seven';}elseif($i == 8){$class = 'eight';}elseif($i == 9){$class = 'nine';}elseif($i == 10){$class = 'ten';}else{ $class = 'one';}
                    ?>
                        <?php echo wp_get_attachment_image($list['volunteer_image']['id'], 'full', false, array(
                          'class'  => 'volunteer ' . esc_attr($class),
                          'alt'    => esc_attr__('volunteer','charitious')
				        )); ?>
                    <?php $i++; endforeach;?>
                </div>
            </section>
            <?php

        }

        protected function content_template() { }
    }