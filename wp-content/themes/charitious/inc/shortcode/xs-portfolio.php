<?PHP

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Xs_Portfolio_Widget extends Widget_Base {

    public function get_name() {
        return 'xs-portfolio';
    }

    public function get_title() {
        return esc_html__( 'Charitious Portfolio Gallery', 'charitious' );
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
                'label' =>esc_html__('Charitious Portfolio Gallery', 'charitious'),
            ]
        );



        
        $repeater = new Repeater();

        $repeater->add_control(
            'portfolio_image',

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
            'width',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Choose Style', 'charitious'),
                'default' => 'xs-portfolio-grid-item-w1',
                'options' => [
                    'xs-portfolio-grid-item-w1' => __('Column 1', 'charitious'),
                    'xs-portfolio-grid-item-w2' => __('Columns 2', 'charitious'),
                    'xs-portfolio-grid-item-w3' => __('Columns 3', 'charitious'),
                ],
            ]
        );

        $this->add_control(
            'portfolio_gallery',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'portfolio_image' => Utils::get_placeholder_image_src(),
                    ],
                    
                ],
                
            ]
        );

        $this->end_controls_section();
    }


    protected function render( ) {
        $settings = $this->get_settings();
        $portfolio_gallery = $settings['portfolio_gallery'];
        ?>

        <div class="xs-portfolio-grid">
            <?php
            foreach($portfolio_gallery as $logo_partners):
                $image = $logo_partners['portfolio_image'];
                $width = $logo_partners['width'];
               
                ?>
                <div class="xs-portfolio-grid-item <?php echo esc_attr($width); ?>">
                    <a href="<?php echo esc_url($image['url']); ?>" class="xs-single-portfolio-item xs-image-popup">
                        <?php
                                if(isset($image['url']) && !empty($image['url'])){
                                    echo wp_get_attachment_image($image['id'], 'full', false, array(
                                        'alt' => esc_attr__('Portfolio','charitious')
                                ));
                            }
                         ?>
                        <div class="xs-portfolio-content">
                            <span class="icon-plus-button"></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function content_template() { }
}