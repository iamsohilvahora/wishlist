<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Team_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-team';
    }

    public function get_title() {
        return esc_html__( 'Charitious Team', 'charitious' );
    }

    public function get_icon() {
        return 'fa fa-user-o';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Charitious Team', 'charitious'),
            ]
        );

        //add repeater 
        
        $this->add_control(

            'member_name', 
            [

                'label' =>esc_html__('Team Member', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   =>esc_html__('Team Member', 'charitious'),
                
            ]
        );

        $this->add_control(

            'member_position', 
            [

                'label' =>esc_html__('Position', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   =>esc_html__('CEO', 'charitious'),
                
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
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Social Icon ', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_attr('fa fa-facebook'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'url',
            [
                'label' => esc_html__('Social URL', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_url('#'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'socials',
            [
             
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'separator' => 'before',
                'default' => [
                    [

                        'icon' => esc_attr('fa fa-facebook'),
                        'url' => esc_url('#'),

                    ],
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'label' =>esc_html__( 'Image Size', 'charitious' ),
                'default' => 'full',
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label'     =>esc_html__( 'Team Style', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        /**
         *
         * Normal Style
         *
         */

        $this->add_control(
            'member_name_color',
            [
                'label'     =>esc_html__( 'Name color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xs-team-content h4' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'member_pos_color',
            [
                'label'     =>esc_html__( 'Possition color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xs-team-content small' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'fill_color',
            [
                'label'     =>esc_html__( 'Fill color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xs-team-content .fill-color' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render( ) {

        $settings = $this->get_settings();
        $member_name = $settings['member_name'];
        $member_position = $settings['member_position'];
        $socials = $settings['socials'];
        ?>

        <div class="xs-single-team">
            <div class="image">
                <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings); ?>
                <div class="hover-content">
                    <?php if (!empty($socials)): ?>
                        <ul class="xs-social-list-v2">
                            <?php foreach ($socials as $social): ?>
                                <li><a href="<?php echo esc_url($social['url']);?>"><i class="<?php echo esc_attr($social['icon']);?>"></i></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            <div class="xs-team-content">
                <h4><?php echo esc_html( $member_name ); ?></h4>
                <small><?php echo esc_html( $member_position ); ?></small>
                <svg class="xs-svgs" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 270 138">
                    <path class="fill-color" d="M375,3294H645v128a10,10,0,0,1-10,10l-250-20a10,10,0,0,1-10-10V3294Z" transform="translate(-375 -3294)"/>
                </svg>
            </div>
        </div>

        <?php

    }

    protected function content_template() { }
}