<?PHP

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Countdown_Timer_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-countdown-timer';
    }

    public function get_title() {
        return esc_html__( 'Charitious Countdown Timer', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_tab',
            [
                'label' =>esc_html__('Charitious Countdown Timer', 'charitious'),
            ]
        );

        $this->add_control(
            'countdown-time',
            [
                'name' => 'label',
                'label' =>esc_html__( 'Label', 'charitious' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->end_controls_section();
    }


    protected function render( ) {
        $settings = $this->get_settings();
        $countdown = $settings['countdown-time'];
        ?>
            <div class="circle-timer">
                <div class="someTimer" 
                data-date-day="<?php esc_html_e('DAYS','charitious');?>" 
                data-date-hour="<?php esc_html_e('HOURS','charitious');?>" 
                data-date-minute="<?php esc_html_e('MINUTES','charitious');?>" 
                data-date-second="<?php esc_html_e('SECONDS','charitious');?>" 
                data-date="<?php echo esc_attr($countdown);?>"></div>
            </div>
        <?php
    }

    protected function content_template() { }
}