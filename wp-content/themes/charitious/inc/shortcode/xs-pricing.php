<?PHP

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Pricing_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-pricing';
    }

    public function get_title() {
        return esc_html__( 'Charitious Pricing', 'charitious' );
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
                'label' =>esc_html__('Charitious Pricing', 'charitious'),
            ]
        );


        //add repeater 

        $this->add_control(
            'title',
            [
                'label' =>esc_html__( 'Label', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'default' =>esc_html__( 'Basic ', 'charitious' ),
                'placeholder' =>esc_html__( 'Basic', 'charitious' ),
            ]
        );

        $this->add_control(
            'price',
            [
                'label' =>esc_html__( 'Price', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'default' =>esc_html__( '$90 ', 'charitious' ),
                'placeholder' =>esc_html__( '$90', 'charitious' ),
            ]
        );

        $this->add_control(
            'period',
            [
                'label' =>esc_html__( 'Period', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'default' =>esc_html__( 'mo ', 'charitious' ),
                'placeholder' =>esc_html__( 'mo', 'charitious' ),
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' =>esc_html__( 'Button Label', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'default' =>esc_html__( 'Choose A Plan', 'charitious' ),
                'placeholder' =>esc_html__( 'Choose A Plan', 'charitious' ),
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
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' =>esc_html__( 'Background Image', 'charitious' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater_rep = new Repeater();

        $repeater_rep->add_control(
            'icon',
            [
                'label'         => esc_html__( 'List Icon', 'charitious' ),
                'type'          => Controls_Manager::ICON,
                'default'       =>  'fa fa-check',
                'label_block' => true,
            ]
        );

        $repeater_rep->add_control(
            'label',
            [
                'label' =>esc_html__( 'Facility Label', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'default' =>esc_html__( 'Pediaric Facilities ', 'charitious' ),
                'placeholder' =>esc_html__( 'Pediaric Facilities', 'charitious' ),
            ]
        );

        $repeater_rep->add_control(
            'unchecked',
            [
                'label' =>esc_html__( 'Availability.', 'charitious' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' =>esc_html__( 'On', 'charitious' ),
                'label_off' =>esc_html__( 'Off', 'charitious' ),
            ]
        );

        $this->add_control(
            'facilities',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater_rep->get_controls(),
                'default' => [
                    [
                        'portfolio_image' => Utils::get_placeholder_image_src(),
                        
                    ],
                    
                ],
                
            ]
        );

        $this->end_controls_section();


        //Title Style

        $this->start_controls_section(
            'section_title_style',
            [
                'label'     => __( 'Color', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'primary_color',
            [
                'label'     => __( 'Primary Color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .xs-pricing-title' => '    color: {{VALUE}};',
                    '{{WRAPPER}} .xs-list li i' => '    color: {{VALUE}};',
                    '{{WRAPPER}} .xs-single-pricing-table .btn' => '    background-color: {{VALUE}};',
                    '{{WRAPPER}} .xs-pricing-header::before' => '    background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'charitious' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .xs-list li' => 'color: {{VALUE}} !important;'
                ],
            ]
        );
        $this->add_control(
            'bg_opacity',
            [
                'label' => __( 'Header Background Opacity', 'charitious' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => 0.8,
                'selectors' => [
                    '{{WRAPPER}} .xs-pricing-header::before' => '    opacity: {{VALUE}};',
                ],
            ]
        );



        $this->end_controls_section();
    }


    protected function render( ) {
        $settings = $this->get_settings();
        $title = $settings['title'];
        $price = $settings['price'];
        $period = $settings['period'];
        $bg_image = $settings['bg_image'];
        $facilities = $settings['facilities'];
        $btn_text = $settings['btn_text'];
        $btn_link = (! empty( $settings['btn_link']['url'])) ? $settings['btn_link']['url'] : '';
        $btn_target = ( $settings['btn_link']['is_external']) ? '_blank' : '_self';
        ?>

        <div class="xs-single-pricing-table">
            <div class="xs-pricing-header" style="background-image:url(<?php echo esc_url($bg_image['url']);?>)">
                <h2>
                    <?php echo esc_html($price);?><sub>/<?php echo esc_html($period);?></sub>
                </h2>
            </div>
            <div class="xs-pricing-content">
                <h2 class="xs-pricing-title"><?php echo esc_html($title);?></h2>
                <ul class="xs-list">
                    <?php
                    foreach($facilities as $facility_item):
                        $icon = $facility_item['icon'];
                        $facility = $facility_item['label'];
                        $unchecked = $facility_item['unchecked'];
                        if(isset($image['url']) && !empty($image['url'])){
                            $image = $image['url'];
                        }
                        ?>
                        <?php if($unchecked == 'yes'){  ?>
                            <li class="unchecked"><i class="<?php echo esc_html($icon); ?>"></i><del><?php echo esc_html($facility); ?></del></li>
                        <?php }else{ ?>
                            <li><i class="<?php echo esc_html($icon); ?>"></i><?php echo esc_html($facility); ?></li>
                        <?php } ?>
                    <?php endforeach; ?>

                </ul>
                <a href="<?php echo esc_url( $btn_link ); ?>" target="<?php echo esc_attr( $btn_target ); ?>" class="btn btn-primary">
                    <?php echo esc_html( $btn_text ); ?>
                </a>
            </div>
        </div>

        <?php
    }

    protected function content_template() { }
}