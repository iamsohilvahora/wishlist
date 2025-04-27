<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Funfacts_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-funfacts';
    }

    public function get_title() {
        return __( 'Charitious Funfacts', 'charitious' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return [ 'charitious-elements' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' => __('Charitious Funfacts', 'charitious'),
            ]
        );

        
        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'charitious'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'number_count',
            [

                'label' => __('Number Count', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   => '200',
            ]
        );


        $repeater->add_control(
            'duration',
            [

                'label' => __('Duration', 'charitious'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   => '3500',
            ]
        );


        $this->add_control(
            'funfacts',
            [
                'label' => __( 'Funfact', 'charitious' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                
                
                'default' => [
                    [
                        'title' => __('Add Title', 'charitious'),
                        'number_count' => __('Add Number Count', 'charitious'),
                        'duration' => __('Add Counter Duration', 'charitious'),
                    ],
                    [
                        'title' => __('Add Title', 'charitious'),
                        'number_count' => __('Add Number Count', 'charitious'),
                        'duration' => __('Add Counter Duration', 'charitious'),
                    ],
                    [
                        'title' => __('Add Title', 'charitious'),
                        'number_count' => __('Add Number Count', 'charitious'),
                        'duration' => __('Add Counter Duration', 'charitious'),
                    ],
                ],
                
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

    }

    protected function render( ) {
        $settings = $this->get_settings();

        $funfacts = $settings['funfacts'];

        if(is_array($funfacts) && !empty($funfacts)): ?>
            <ul class="xs-funfact-list">
                <?php foreach($funfacts as $funfact): ?>
                    <li>
                        <p>
                            <span class="number-percentage-count number-percentage" data-value="<?php echo esc_html( $funfact['number_count'] ); ?>" data-animation-duration="<?php echo esc_html( $funfact['duration'] ); ?>">0</span><sup> + </sup>
                        </p>
                        <span><?php echo esc_html( $funfact['title'] ); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif;

    }

    protected function content_template() { }
}
?>