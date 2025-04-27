<?PHP

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Contact_Info_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-contact-info';
    }

    public function get_title() {
        return esc_html__( 'Charitious Contact Info', 'charitious' );
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
                'label' =>esc_html__('Charitious Contact Info', 'charitious'),
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
            ]
        );
        $this->add_control(
            'address', [
                'label'          =>esc_html__( 'Map Address', 'charitious' ),
                'type'           => Controls_Manager::TEXT,
                'label_block'    => true,
                'placeholder'    =>esc_html__( 'Dhaka', 'charitious' ),
                'default'        =>esc_html__( 'Dhaka', 'charitious' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon',
            [
                'label'         => esc_html__( 'List Icon', 'charitious' ),
                'type'          => Controls_Manager::ICON,
                'default'       =>  'fa fa-envelope-o',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'label',

            [
                'label' =>esc_html__( 'Label', 'charitious' ),
                'type' => Controls_Manager::TEXT,
                'default' =>esc_html__( 'name@yourdomain.com ', 'charitious' ),
                'placeholder' =>esc_html__( 'Pediaric Facilities', 'charitious' ),
            ]
        );

        $this->add_control(
            'infos',
            [
                'label' => __( 'Item List', 'charitious' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'label' => __( 'name@yourdomain.com', 'charitious' ),

                    ],
                    
                ],
                'title_field' => '{{{ label }}}',
            ]
        );

        $this->end_controls_section();


        //Title Style

        $this->start_controls_section(
            'section_address_style',
            [
                'label'     => __( 'Color', 'charitious' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => __( 'Icon Color', 'charitious' ),
                'type'      => Controls_Manager::COLOR,
                'default' => '#3ac798',
                'selectors' => [
                    '{{WRAPPER}} .xs-contact-details ul.xs-unorder-list li i' => '    color: {{VALUE}};',
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
                    '{{WRAPPER}} .xs-contact-details ul.xs-unorder-list li' => '    color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }


    protected function render( ) {
        $settings = $this->get_settings();
        $image = $settings['image'];
        $address = $settings['address'];
        $infos = $settings['infos'];
        $rand_id = charitious_rand_str(10);
        ?>

        <div class="xs-contact-details">
            <div class="xs-widnow-wraper">
                <?php if( !empty($image['url']) ) : ?>
                    <div class="xs-window-top">
                        <?php echo wp_get_attachment_image($image['id'], 'full', false, array(
                            'alt' => esc_attr__('info img','charitious')
                           ));
                        ?>
                    </div>
                <?php endif; ?>
                <div class="xs-window-back">
                    <div id="<?php echo esc_attr($rand_id);?>" title="<?php echo esc_attr($address);?>" class="xs-map xs-multiple-map"></div>
                </div>
                <div class="xs-window-nav">
                    <a href="#" class="xs-window-opener">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
            <ul class="xs-unorder-list">
                <?php
                foreach($infos as $info):
                    $icon = $info['icon'];
                    $label = $info['label'];
                    ?>
                    <li><i class="<?php echo esc_html($icon); ?>"></i><?php echo esc_html($label); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

    protected function content_template() { }
}