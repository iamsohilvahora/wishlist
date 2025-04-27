<?PHP

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Partner_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-partner';
    }

    public function get_title() {
        return esc_html__( 'Charitious Brand Logo', 'charitious' );
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
                'label' =>esc_html__('Charitious Brand Logo', 'charitious'),
            ]
        );


        //New code added here
        $repeater = new Repeater();

        $repeater->add_control(
            'partner_image',
            [
                'label'         => esc_html__( 'Images', 'charitious' ),
                'type'          => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],

                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'btn_link',
            [
                'label' =>esc_html__( 'Link', 'charitious' ),
                'type' => Controls_Manager::URL,
                'placeholder' =>esc_html__('http://your-link.com','charitious' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'logo_partner',
            [

                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [  

                        'partner_image' => Utils::get_placeholder_image_src(),
                        'btn_link'  => '#',
                    ],
                    
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render( ) {
        $settings = $this->get_settings();
        $logo_partner = $settings['logo_partner'];
        ?>

        <ul class="fundpress-partners">
            <?php
            foreach($logo_partner as $logo_partners):
                $btn_link = (! empty( $logo_partners['btn_link']['url'])) ? $logo_partners['btn_link']['url'] : '';
                $btn_target = ( $logo_partners['btn_link']['is_external']) ? '_blank' : '_self';
                $image = $logo_partners['partner_image'];
                ?>
                <li><a href="<?php echo esc_url( $btn_link ); ?>" target="<?php echo esc_html( $btn_target ); ?>" >
                <?php if ( !empty($image['url']) ){
				echo wp_get_attachment_image($image['id'], 'full', false, array(
					'alt' => esc_attr__('img','charitious')
				));
			  } ?>
                </a></li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    protected function content_template() { }
}